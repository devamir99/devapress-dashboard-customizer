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
                'label'       => 'دو قسمتی مدرن',
                'description' => 'فرم سمت چپ — پنل گرادیانت/تصویر سمت راست',
                'login_layout'          => 'split',
                'split_panel_position'  => 'right',
                'split_form_bg'         => '#f8fafc',
                'bg_gradient_enable'    => true,
                'bg_gradient_color1'    => '#6366f1',
                'bg_gradient_color2'    => '#a855f7',
                'bg_gradient_type'      => 'linear',
                'bg_gradient_opacity'   => '100',
                'bg_color'              => '#6366f1',
                'bg_size'               => 'cover',
                'login_form_glass'      => false,
                'login_form_bg'         => '#ffffff',
                'login_form_bg2'        => '',
                'login_form_radius'     => '16',
                'login_input_radius'    => '10',
                'login_btn_bg'          => '#6366f1',
                'login_btn_color'       => '#ffffff',
                'login_btn_radius'      => '10',
                'login_btn_hover_bg'    => '#4f46e5',
                'login_btn_hover_color' => '#ffffff',
                'login_label_color'     => '#334155',
            ],
            'classic-clean' => [
                'label'       => 'کلاسیک وسط‌چین',
                'description' => 'کارت ورود در مرکز — مناسب سایت‌های سازمانی',
                'login_layout'          => 'center',
                'split_panel_position'  => 'right',
                'split_form_bg'         => '#f1f5f9',
                'bg_gradient_enable'    => true,
                'bg_gradient_color1'    => '#2563eb',
                'bg_gradient_color2'    => '#64748b',
                'bg_gradient_type'      => 'linear',
                'bg_gradient_opacity'   => '100',
                'bg_color'              => '#f1f5f9',
                'bg_size'               => 'cover',
                'login_form_glass'      => false,
                'login_form_bg'         => '#ffffff',
                'login_form_bg2'        => '',
                'login_form_radius'     => '12',
                'login_input_radius'    => '8',
                'login_btn_bg'          => '#2563eb',
                'login_btn_color'       => '#ffffff',
                'login_btn_radius'      => '8',
                'login_btn_hover_bg'    => '#1d4ed8',
                'login_btn_hover_color' => '#ffffff',
                'login_label_color'     => '#475569',
            ],
            'gradient-bold' => [
                'label'       => 'تمام‌صفحه سینمایی',
                'description' => 'پس‌زمینه تمام‌صفحه — فرم شناور وسط با سایه عمیق',
                'login_layout'          => 'fullscreen',
                'split_panel_position'  => 'right',
                'split_form_bg'         => '#ffffff',
                'bg_gradient_enable'    => true,
                'bg_gradient_color1'    => '#7c3aed',
                'bg_gradient_color2'    => '#ec4899',
                'bg_gradient_type'      => 'linear',
                'bg_gradient_opacity'   => '100',
                'bg_color'              => '',
                'bg_size'               => 'cover',
                'login_form_glass'      => false,
                'login_form_bg'         => '#ffffff',
                'login_form_bg2'        => '',
                'login_form_radius'     => '20',
                'login_input_radius'    => '10',
                'login_btn_bg'          => '#ec4899',
                'login_btn_color'       => '#ffffff',
                'login_btn_radius'      => '10',
                'login_btn_hover_bg'    => '#db2777',
                'login_btn_hover_color' => '#ffffff',
                'login_label_color'     => '#334155',
                'fullscreen_overlay'    => '50',
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
