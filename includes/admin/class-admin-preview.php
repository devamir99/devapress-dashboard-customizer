<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Admin live preview: AJAX transient storage + login preview frame.
 */
class Devapress_Admin_Preview {

    const TRANSIENT_TTL = 600;

    public function __construct() {
        add_action('wp_ajax_devapress_save_preview', [$this, 'ajax_save_preview']);
        add_action('wp_ajax_devapress_render_login_preview', [$this, 'render_login_preview']);
    }

    public static function preview_nonce() {
        return wp_create_nonce('devapress_live_preview');
    }

    public static function login_preview_url() {
        return add_query_arg(
            [
                'action'   => 'devapress_render_login_preview',
                'nonce'    => self::preview_nonce(),
                'user_id'  => get_current_user_id(),
            ],
            admin_url('admin-ajax.php')
        );
    }

    /**
     * @return string
     */
    private static function transient_key() {
        return 'devapress_preview_' . get_current_user_id();
    }

    public function ajax_save_preview() {
        check_ajax_referer('devapress_live_preview', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error(['message' => 'Forbidden'], 403);
        }

        $raw = isset($_POST['preview']) ? wp_unslash($_POST['preview']) : '';
        $data = json_decode($raw, true);

        if (!is_array($data)) {
            wp_send_json_error(['message' => 'Invalid data']);
        }

        set_transient(self::transient_key(), $data, self::TRANSIENT_TTL);
        wp_send_json_success(['saved' => true]);
    }

    public function render_login_preview() {
        if (!current_user_can('manage_options')) {
            wp_die(esc_html__('Unauthorized', 'devapress-customizer'));
        }

        check_ajax_referer('devapress_live_preview', 'nonce');

        $data = get_transient(self::transient_key());
        if (!is_array($data)) {
            $data = Devapress_Settings::get_resolved('login');
        }

        $css = Devapress_Css_Builder::login($data);

        header('Content-Type: text/html; charset=utf-8');
        header('X-Robots-Tag: noindex');

        $logo_url = '';
        if (!empty($data['logo_id'])) {
            $logo_url = wp_get_attachment_url((int) $data['logo_id']);
        }

        include DEVAPRESS_PLUGIN_DIR . 'views/preview/login-frame.php';
        exit;
    }

    /**
     * @param string $section dashboard|login
     * @param string $preset_id
     * @return array<string, mixed>
     */
    public static function preset_values_for_js($section, $preset_id) {
        if ($preset_id === 'none') {
            return [];
        }
        $preset = Devapress_Presets::get($section, $preset_id);
        if (!$preset) {
            return [];
        }
        unset($preset['label'], $preset['description']);
        return $preset;
    }
}
