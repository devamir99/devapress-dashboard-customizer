<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Export and import plugin settings as JSON.
 */
class Devapress_Export_Import {

    const EXPORT_SCHEMA = 'devapress-export';
    const EXPORT_VERSION = 1;

    public function __construct() {
        add_action('admin_post_devapress_export_settings', [$this, 'handle_export']);
        add_action('admin_init', [$this, 'handle_import']);
        add_action('admin_init', [$this, 'handle_demo_import']);
    }

    public function handle_export() {
        if (!current_user_can('manage_options')) {
            wp_die(esc_html__('Unauthorized', 'devapress-customizer'));
        }

        check_admin_referer('devapress_export_settings');

        $package = self::build_export_package();
        $json    = wp_json_encode($package, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $filename = 'devapress-settings-' . gmdate('Y-m-d-His') . '.json';

        header('Content-Type: application/json; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . strlen($json));
        echo $json; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        exit;
    }

    public function handle_import() {
        if (
            empty($_POST['devapress_import_action']) ||
            $_POST['devapress_import_action'] !== 'upload' ||
            empty($_FILES['devapress_import_file']['name'])
        ) {
            return;
        }

        if (!current_user_can('manage_options')) {
            return;
        }

        check_admin_referer('devapress_import_settings');

        $raw = file_get_contents($_FILES['devapress_import_file']['tmp_name']); // phpcs:ignore
        $data = json_decode($raw, true);

        $import_media = !empty($_POST['devapress_import_media']);

        $result = self::import_package($data, ['import_media' => $import_media]);

        $arg = $result['success'] ? 'imported' : 'import-error';
        wp_safe_redirect(Devapress_Settings::admin_url([
            $arg => '1',
            'msg'  => rawurlencode($result['message']),
        ]));
        exit;
    }

    public function handle_demo_import() {
        if (empty($_GET['devapress_demo']) || empty($_GET['page']) || $_GET['page'] !== 'devapress-customizer') {
            return;
        }

        if (!current_user_can('manage_options')) {
            return;
        }

        check_admin_referer('devapress_import_demo');

        $demo_id = sanitize_key($_GET['devapress_demo']);
        $path    = DEVAPRESS_PLUGIN_DIR . 'assets/demo/' . $demo_id . '.json';

        if (!file_exists($path)) {
            wp_safe_redirect(Devapress_Settings::admin_url(['import-error' => '1', 'msg' => rawurlencode('فایل دمو یافت نشد.')]));
            exit;
        }

        $raw  = file_get_contents($path); // phpcs:ignore
        $data = json_decode($raw, true);
        $result = self::import_package($data, ['import_media' => false]);

        $arg = $result['success'] ? 'imported' : 'import-error';
        wp_safe_redirect(Devapress_Settings::admin_url([
            $arg => '1',
            'msg'  => rawurlencode($result['message']),
        ]));
        exit;
    }

    /**
     * @return array<string, mixed>
     */
    public static function build_export_package() {
        $settings = Devapress_Settings::get_all();
        $login    = $settings['login'] ?? [];

        return [
            'schema'         => self::EXPORT_SCHEMA,
            'export_version' => self::EXPORT_VERSION,
            'plugin_version' => DEVAPRESS_VERSION,
            'exported_at'    => gmdate('c'),
            'site_url'       => home_url(),
            'settings'       => $settings,
            'media_urls'     => [
                'font_file' => $settings['dashboard']['font_file'] ?? '',
                'bg_image'  => !empty($login['bg_image_id']) ? wp_get_attachment_url((int) $login['bg_image_id']) : '',
                'logo'      => !empty($login['logo_id']) ? wp_get_attachment_url((int) $login['logo_id']) : '',
            ],
        ];
    }

    /**
     * @param array<string, mixed>|null $data
     * @param array<string, mixed>      $options
     * @return array{success: bool, message: string}
     */
    public static function import_package($data, $options = []) {
        if (!is_array($data) || empty($data['settings']) || !is_array($data['settings'])) {
            return ['success' => false, 'message' => 'فایل JSON نامعتبر است.'];
        }

        if (!empty($data['schema']) && $data['schema'] !== self::EXPORT_SCHEMA) {
            return ['success' => false, 'message' => 'فرمت export شناخته نشد.'];
        }

        $import_media = !empty($options['import_media']);
        $media_urls   = $data['media_urls'] ?? [];
        $settings_in  = $data['settings'];

        if ($import_media && !empty($media_urls['font_file'])) {
            $settings_in['dashboard']['font_file'] = esc_url_raw($media_urls['font_file']);
        }

        $sanitized = Devapress_Settings::sanitize($settings_in);

        if ($import_media) {
            if (!empty($media_urls['bg_image'])) {
                $id = self::sideload_image($media_urls['bg_image']);
                if ($id) {
                    $sanitized['login']['bg_image_id'] = $id;
                }
            }
            if (!empty($media_urls['logo'])) {
                $id = self::sideload_image($media_urls['logo']);
                if ($id) {
                    $sanitized['login']['logo_id'] = $id;
                }
            }
        }

        update_option(Devapress_Settings::OPTION_KEY, $sanitized);

        return ['success' => true, 'message' => 'تنظیمات با موفقیت وارد شد.'];
    }

    /**
     * @return array<string, string>
     */
    public static function demo_presets() {
        return [
            'demo-minimal' => 'دمو مینیمال (تیره + کلاسیک)',
            'demo-modern'  => 'دمو مدرن (آبی + شیشه‌ای)',
            'demo-bold'    => 'دمو جسور (روشن + گرادیانت)',
        ];
    }

    /**
     * @param string $url
     */
    private static function sideload_image($url) {
        if (!function_exists('media_sideload_image')) {
            require_once ABSPATH . 'wp-admin/includes/media.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/image.php';
        }

        $url = esc_url_raw($url);
        if (!$url) {
            return 0;
        }

        $id = media_sideload_image($url, 0, null, 'id');
        if (is_wp_error($id)) {
            return 0;
        }

        return (int) $id;
    }
}
