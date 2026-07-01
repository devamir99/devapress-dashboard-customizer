<?php
if (!defined('ABSPATH')) {
    exit;
}

class Devapress_Admin_Settings {

    public function __construct() {
        add_action('admin_init', [$this, 'register_settings']);
        add_action('admin_init', [$this, 'handle_resets']);
    }

    public function register_settings() {
        register_setting(
            'devapress_settings_group',
            Devapress_Settings::OPTION_KEY,
            [
                'type'              => 'array',
                'sanitize_callback' => [Devapress_Settings::class, 'sanitize'],
                'default'           => Devapress_Settings::defaults(),
            ]
        );
    }

    public function handle_resets() {
        if (empty($_GET['page']) || $_GET['page'] !== 'devapress-customizer') {
            return;
        }

        $actions = [
            'reset_devapress_dashboard' => 'dashboard',
            'reset_devapress_login'     => 'login',
            'reset_devapress_all'       => 'all',
        ];

        if (empty($_GET['action']) || !isset($actions[$_GET['action']])) {
            return;
        }

        $nonce_action = 'devapress_reset_' . ($actions[$_GET['action']] === 'all' ? 'all' : $actions[$_GET['action']]);
        check_admin_referer($nonce_action);

        if ($_GET['action'] === 'reset_devapress_all') {
            update_option(Devapress_Settings::OPTION_KEY, Devapress_Settings::defaults());
            wp_safe_redirect(Devapress_Settings::admin_url(['reset' => 'all']));
            exit;
        }

        $section = $actions[$_GET['action']];
        Devapress_Settings::reset_section($section);
        wp_safe_redirect(Devapress_Settings::admin_url(['reset' => $section]));
        exit;
    }
}
