<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Core loader for the Devapress Customizer plugin.
 */
class Devapress_Core {

    public function init() {
        $this->includes();

        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_wp_media']);

        Devapress_Settings::maybe_migrate();
    }

    private function includes() {
        require_once DEVAPRESS_PLUGIN_DIR . 'includes/class-devapress-presets.php';
        require_once DEVAPRESS_PLUGIN_DIR . 'includes/class-devapress-settings.php';
        require_once DEVAPRESS_PLUGIN_DIR . 'includes/class-devapress-css-builder.php';

        require_once DEVAPRESS_PLUGIN_DIR . 'includes/admin/class-admin-menu.php';
        require_once DEVAPRESS_PLUGIN_DIR . 'includes/admin/class-admin-settings.php';
        require_once DEVAPRESS_PLUGIN_DIR . 'includes/admin/class-admin-preview.php';
        require_once DEVAPRESS_PLUGIN_DIR . 'includes/admin/class-admin-export-import.php';

        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';

        require_once DEVAPRESS_PLUGIN_DIR . 'includes/frontend/class-dashboard-customizer.php';
        require_once DEVAPRESS_PLUGIN_DIR . 'includes/frontend/class-login-customizer.php';

        if (class_exists('Devapress_Admin_Settings')) {
            new Devapress_Admin_Settings();
        }

        if (class_exists('Devapress_Admin_Preview')) {
            new Devapress_Admin_Preview();
        }

        if (class_exists('Devapress_Export_Import')) {
            new Devapress_Export_Import();
        }

        if (class_exists('Devapress_Dashboard_Customizer')) {
            new Devapress_Dashboard_Customizer();
        }

        if (class_exists('Devapress_Login_Customizer')) {
            new Devapress_Login_Customizer();
        }
    }

    public function add_admin_menu() {
        if (class_exists('Devapress_Admin_Menu')) {
            $menu = new Devapress_Admin_Menu();
            $menu->register_menu();
        }
    }

    public function enqueue_admin_assets($hook) {
        if ($hook !== 'settings_page_devapress-customizer') {
            return;
        }

        wp_enqueue_style(
            'devapress-admin-css',
            DEVAPRESS_CSS_URL . 'admin.css',
            [],
            DEVAPRESS_VERSION
        );

        wp_enqueue_script(
            'devapress-admin-js',
            DEVAPRESS_JS_URL . 'admin.js',
            ['jquery'],
            DEVAPRESS_VERSION,
            true
        );

        wp_enqueue_script(
            'devapress-preview-js',
            DEVAPRESS_JS_URL . 'preview.js',
            ['jquery', 'devapress-admin-js'],
            DEVAPRESS_VERSION,
            true
        );

        $dashboard_presets = Devapress_Presets::dashboard_presets();
        $login_presets     = Devapress_Presets::login_presets();

        foreach ($dashboard_presets as $id => $preset) {
            unset($dashboard_presets[$id]['label'], $dashboard_presets[$id]['description']);
        }
        foreach ($login_presets as $id => $preset) {
            unset($login_presets[$id]['label'], $login_presets[$id]['description']);
        }

        wp_localize_script('devapress-preview-js', 'devapressPreview', [
            'ajaxUrl'          => admin_url('admin-ajax.php'),
            'nonce'            => Devapress_Admin_Preview::preview_nonce(),
            'loginPreviewUrl'  => Devapress_Admin_Preview::login_preview_url(),
            'loginUrl'         => wp_login_url(),
            'dashboardPresets' => $dashboard_presets,
            'loginPresets'     => $login_presets,
        ]);
    }

    public function enqueue_wp_media($hook) {
        if ($hook === 'settings_page_devapress-customizer') {
            wp_enqueue_media();
        }
    }
}
