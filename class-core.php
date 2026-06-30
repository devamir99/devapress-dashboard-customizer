<?php
if (!defined('ABSPATH')) exit;

/**
 * Class Devapress_Core
 *
 * Core loader for the Devapress Customizer plugin.
 * Handles:
 * - Loading admin and frontend modules
 * - Registering hooks for settings page, media uploader, and login customizer
 */
class Devapress_Core {

    /**
     * Initialize plugin
     *
     * Loads all required modules and registers hooks.
     */
    public function init() {
        // Load required modules
        $this->includes();

        // Register WordPress hooks
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
        add_action('login_enqueue_scripts', [$this, 'enqueue_login_assets']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_wp_media']);
    }

    /**
     * Load admin and frontend modules
     *
     * This includes settings, preview, panels, dashboard, and login customizers.
     */
    private function includes() {
        // -----------------------------
        // Admin Modules
        // -----------------------------
        require_once DEVAPRESS_PLUGIN_DIR . 'includes/admin/class-admin-menu.php';
        require_once DEVAPRESS_PLUGIN_DIR . 'includes/admin/class-admin-settings.php';
        require_once DEVAPRESS_PLUGIN_DIR . 'includes/admin/class-admin-preview.php';
        require_once DEVAPRESS_PLUGIN_DIR . 'includes/admin/class-admin-panels.php';

        // WordPress core files for media handling
        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';

        // -----------------------------
        // Frontend Modules
        // -----------------------------
        require_once DEVAPRESS_PLUGIN_DIR . 'includes/frontend/class-dashboard-customizer.php';
        require_once DEVAPRESS_PLUGIN_DIR . 'includes/frontend/class-login-customizer.php';

        // Initialize Settings and Customizers if classes exist
        if (class_exists('Devapress_Admin_Settings')) {
            new Devapress_Admin_Settings();
        }

        if (class_exists('Devapress_Dashboard_Customizer')) {
            new Devapress_Dashboard_Customizer();
        }

        if (class_exists('Devapress_Login_Customizer')) {
            new Devapress_Login_Customizer();
        }
    }

    /**
     * Add Devapress Customizer menu to WordPress admin
     */
    public function add_admin_menu() {
        if (class_exists('Devapress_Admin_Menu')) {
            $menu = new Devapress_Admin_Menu();
            $menu->register_menu();
        }
    }

    /**
     * Enqueue admin CSS and JS assets
     *
     * @param string $hook Current admin page hook (optional)
     */
    public function enqueue_admin_assets() {
        wp_enqueue_style(
            'devapress-admin-css',
            DEVAPRESS_CSS_URL . 'admin.css',
            [],
            '1.0'
        );

        wp_enqueue_script(
            'devapress-admin-js',
            DEVAPRESS_JS_URL . 'admin.js',
            ['jquery'],
            '1.0',
            true
        );
    }

    /**
     * Enqueue WordPress media uploader on plugin settings page
     *
     * @param string $hook Current admin page hook
     */
    public function enqueue_wp_media($hook) {
        if ($hook === 'settings_page_devapress-customizer') {
            wp_enqueue_media();
        }
    }

    /**
     * Enqueue login page CSS and JS
     *
     * This method loads custom login styles and scripts for the plugin.
     */
    public function enqueue_login_assets() {
        wp_enqueue_style(
            'devapress-login-css',
            DEVAPRESS_CSS_URL . 'login.css',
            [],
            '1.0'
        );

        wp_enqueue_script(
            'devapress-login-js',
            DEVAPRESS_JS_URL . 'login.js',
            ['jquery'],
            '1.0',
            true
        );
    }

}
