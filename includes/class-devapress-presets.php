<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Static preset definitions for dashboard menu and login page styles.
 */
class Devapress_Presets {

    /**
     * @return array<string, array<string, mixed>>
     */
    public static function dashboard_presets() {
        return [
            'minimal-dark' => [
                'label'       => 'مینیمال تیره',
                'description' => 'نزدیک به ظاهر پیش‌فرض وردپرس با تیره‌بندی حرفه‌ای',
                'menu_color'            => '#1d2327',
                'menu_hover_color'      => '#2c3338',
                'menu_active_color'     => '#2271b1',
                'font_color'            => '#f0f0f1',
                'font_color_hover'      => '#72aee6',
                'font_color_active'     => '#ffffff',
                'icon_color'            => '#a7aaad',
                'icon_hover_color'      => '#72aee6',
                'icon_active_color'     => '#ffffff',
                'font_size'             => '14',
                'apply_font_globally'   => false,
            ],
            'ocean-blue' => [
                'label'       => 'اقیانوس آبی',
                'description' => 'منوی تیره با accent آبی برای ظاهری مدرن',
                'menu_color'            => '#0a2540',
                'menu_hover_color'      => '#133e6b',
                'menu_active_color'     => '#1e88e5',
                'font_color'            => '#e3f2fd',
                'font_color_hover'      => '#90caf9',
                'font_color_active'     => '#ffffff',
                'icon_color'            => '#90caf9',
                'icon_hover_color'      => '#42a5f5',
                'icon_active_color'     => '#ffffff',
                'font_size'             => '14',
                'apply_font_globally'   => false,
            ],
            'warm-light' => [
                'label'       => 'روشن گرم',
                'description' => 'سایدبار روشن و مینیمال، مناسب محیط‌های روشن',
                'menu_color'            => '#f8f9fa',
                'menu_hover_color'      => '#e9ecef',
                'menu_active_color'     => '#dee2e6',
                'font_color'            => '#212529',
                'font_color_hover'      => '#0d6efd',
                'font_color_active'     => '#0d6efd',
                'icon_color'            => '#6c757d',
                'icon_hover_color'      => '#0d6efd',
                'icon_active_color'     => '#0d6efd',
                'font_size'             => '14',
                'apply_font_globally'   => false,
            ],
        ];
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public static function login_presets() {
        return [
            'glass-modern' => [
                'label'       => 'شیشه‌ای مدرن',
                'description' => 'گرادیانت بنفش با فرم شیشه‌ای و افکت blur',
                'bg_gradient_enable'    => true,
                'bg_gradient_color1'    => '#667eea',
                'bg_gradient_color2'    => '#764ba2',
                'bg_gradient_type'      => 'linear',
                'bg_gradient_opacity'   => '100',
                'bg_color'              => '',
                'bg_size'               => 'cover',
                'login_form_glass'      => true,
                'login_form_bg'         => '#ffffff',
                'login_form_bg2'        => '',
                'login_form_radius'     => '16',
                'login_input_radius'    => '8',
                'login_btn_bg'          => '#667eea',
                'login_btn_color'       => '#ffffff',
                'login_btn_radius'      => '8',
                'login_btn_hover_bg'    => '#5a6fd6',
                'login_btn_hover_color' => '#ffffff',
                'login_label_color'     => '#ffffff',
            ],
            'classic-clean' => [
                'label'       => 'کلاسیک ساده',
                'description' => 'پس‌زمینه خاکستری روشن با فرم سفید استاندارد',
                'bg_gradient_enable'    => false,
                'bg_gradient_color1'    => '',
                'bg_gradient_color2'    => '',
                'bg_gradient_type'      => 'linear',
                'bg_gradient_opacity'   => '100',
                'bg_color'              => '#f0f0f1',
                'bg_size'               => 'cover',
                'login_form_glass'      => false,
                'login_form_bg'         => '#ffffff',
                'login_form_bg2'        => '',
                'login_form_radius'     => '4',
                'login_input_radius'    => '4',
                'login_btn_bg'          => '#2271b1',
                'login_btn_color'       => '#ffffff',
                'login_btn_radius'      => '4',
                'login_btn_hover_bg'    => '#135e96',
                'login_btn_hover_color' => '#ffffff',
                'login_label_color'     => '#3c434a',
            ],
            'gradient-bold' => [
                'label'       => 'گرادیانت جسور',
                'description' => 'پس‌زمینه صورتی-قرمز با دکمه برجسته',
                'bg_gradient_enable'    => true,
                'bg_gradient_color1'    => '#f093fb',
                'bg_gradient_color2'    => '#f5576c',
                'bg_gradient_type'      => 'linear',
                'bg_gradient_opacity'   => '100',
                'bg_color'              => '',
                'bg_size'               => 'cover',
                'login_form_glass'      => false,
                'login_form_bg'         => '#ffffff',
                'login_form_bg2'        => '#fff5f7',
                'login_form_radius'     => '12',
                'login_input_radius'    => '6',
                'login_btn_bg'          => '#f5576c',
                'login_btn_color'       => '#ffffff',
                'login_btn_radius'      => '8',
                'login_btn_hover_bg'    => '#e0455a',
                'login_btn_hover_color' => '#ffffff',
                'login_label_color'     => '#333333',
            ],
        ];
    }

    /**
     * @param string $section  dashboard|login
     * @param string $preset_id
     * @return array<string, mixed>|null
     */
    public static function get($section, $preset_id) {
        $presets = $section === 'login'
            ? self::login_presets()
            : self::dashboard_presets();

        return $presets[$preset_id] ?? null;
    }

    /**
     * @param string $section dashboard|login
     * @return array<string, array<string, mixed>>
     */
    public static function list_for_section($section) {
        return $section === 'login'
            ? self::login_presets()
            : self::dashboard_presets();
    }
}
