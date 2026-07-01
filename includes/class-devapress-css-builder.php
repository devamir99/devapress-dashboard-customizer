<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Shared CSS builders for frontend and admin preview.
 */
class Devapress_Css_Builder {

    /**
     * @param array<string, mixed> $settings
     */
    public static function login($settings) {
        if (empty($settings)) {
            return '';
        }
        return Devapress_Login_Customizer::compile_login_css($settings);
    }

    /**
     * @param array<string, mixed> $settings
     */
    public static function dashboard($settings) {
        if (empty($settings)) {
            return '';
        }
        return Devapress_Dashboard_Customizer::compile_font_face($settings)
            . Devapress_Dashboard_Customizer::compile_dashboard_css($settings);
    }
}
