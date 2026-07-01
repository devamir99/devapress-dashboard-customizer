<?php
if (!defined('ABSPATH')) {
    exit;
}

class Devapress_Dashboard_Customizer {

    public function __construct() {
        add_action('admin_enqueue_scripts', [$this, 'apply_dashboard_customizations'], 20);
        add_action('login_enqueue_scripts', [$this, 'apply_login_font'], 20);
        add_filter('admin_body_class', [$this, 'add_body_class']);
    }

    public function add_body_class($classes) {
        if (Devapress_Settings::is_active('dashboard')) {
            $classes .= ' devapress-customized';
        }
        return $classes;
    }

    public function apply_dashboard_customizations() {
        if (!Devapress_Settings::is_active('dashboard')) {
            return;
        }

        $settings = Devapress_Settings::get_resolved('dashboard');
        if (empty($settings)) {
            return;
        }

        wp_register_style('devapress-dashboard', false);
        wp_enqueue_style('devapress-dashboard');

        $css = self::compile_font_face($settings);
        $css .= self::compile_dashboard_css($settings);

        if ($css) {
            wp_add_inline_style('devapress-dashboard', $css);
        }
    }

    public function apply_login_font() {
        if (!Devapress_Settings::is_active('login') && !Devapress_Settings::is_active('dashboard')) {
            return;
        }

        $dashboard = Devapress_Settings::get_all()['dashboard'] ?? [];
        if (empty($dashboard['login_font_enable'])) {
            return;
        }

        $settings = Devapress_Settings::get_resolved('dashboard');
        if (empty($settings)) {
            return;
        }

        wp_register_style('devapress-login-font', false);
        wp_enqueue_style('devapress-login-font');

        $font_name = self::resolve_font_name($settings);
        $font_size = $settings['font_size'] ?? '14';

        $css = self::compile_font_face($settings, 'DevapressLoginFont');
        $css .= "
            body.login.devapress-customized #login,
            body.login.devapress-customized #loginform,
            body.login.devapress-customized #loginform input,
            body.login.devapress-customized #loginform label,
            body.login.devapress-customized #nav,
            body.login.devapress-customized #backtoblog,
            body.login.devapress-customized h1 a {
                font-family: '{$font_name}', sans-serif;
                font-size: {$font_size}px;
            }
        ";

        wp_add_inline_style('devapress-login-font', $css);
    }

    /**
     * @param array<string, mixed> $settings
     */
    public static function compile_font_face($settings, $fallback_name = 'DevapressCustomFont') {
        $font_file_url = $settings['font_file'] ?? '';
        if (!$font_file_url) {
            return '';
        }

        $font_name = 'DevapressCustomFont';
        $ext       = pathinfo($font_file_url, PATHINFO_EXTENSION);
        $format    = self::get_font_format($ext);

        return "
            @font-face {
                font-family: '{$font_name}';
                src: url('{$font_file_url}') format('{$format}');
                font-weight: normal;
                font-style: normal;
            }
        ";
    }

    /**
     * @param array<string, mixed> $settings
     */
    public static function compile_dashboard_css($settings) {
        $font_name              = self::resolve_font_name($settings);
        $font_size              = esc_attr($settings['font_size'] ?? '14');
        $font_color             = esc_attr($settings['font_color'] ?? '#f0f0f1');
        $font_color_hover       = esc_attr($settings['font_color_hover'] ?? '#72aee6');
        $font_color_active      = esc_attr($settings['font_color_active'] ?? '#ffffff');
        $icon_color             = esc_attr($settings['icon_color'] ?? '#a7aaad');
        $icon_color_hover       = esc_attr($settings['icon_hover_color'] ?? '#72aee6');
        $icon_color_active      = esc_attr($settings['icon_active_color'] ?? '#ffffff');
        $background_menu_color  = esc_attr($settings['menu_color'] ?? '#1d2327');
        $background_menu_hover  = esc_attr($settings['menu_hover_color'] ?? '#2c3338');
        $background_menu_active = esc_attr($settings['menu_active_color'] ?? '#2271b1');
        $apply_globally         = !empty($settings['apply_font_globally']);

        $font_selectors = '#adminmenu, #adminmenu *';
        if ($apply_globally) {
            $font_selectors = '.wrap, #adminmenu, #adminmenu *, h1, #submit, .button';
        }

        return "
            {$font_selectors} {
                font-family: '{$font_name}', sans-serif;
                font-size: {$font_size}px;
            }
            #adminmenu li.menu-top > a,
            #adminmenu li a {
                color: {$font_color};
            }
            #adminmenu li.menu-top > a:hover,
            #adminmenu li a:hover {
                color: {$font_color_hover};
            }
            #adminmenu li.menu-top.current > a,
            #adminmenu li.menu-top.wp-has-current-submenu > a,
            #adminmenu .wp-submenu li.current a {
                color: {$font_color_active};
            }
            #adminmenu .wp-menu-image:before {
                color: {$icon_color};
            }
            #adminmenu li.menu-top:hover .wp-menu-image:before {
                color: {$icon_color_hover};
            }
            #adminmenu li.menu-top.current .wp-menu-image:before,
            #adminmenu li.menu-top.wp-has-current-submenu .wp-menu-image:before {
                color: {$icon_color_active};
            }
            #adminmenu,
            #adminmenuback,
            #adminmenuwrap,
            #adminmenu .wp-submenu {
                background: {$background_menu_color};
            }
            #adminmenu li.menu-top:hover,
            #adminmenu li.menu-top.menu-top-hover > a,
            #adminmenu .wp-submenu li a:hover,
            #adminmenu li.wp-has-submenu.opensub > a {
                background-color: {$background_menu_hover};
            }
            #adminmenu li.menu-top.current > a,
            #adminmenu li.menu-top.wp-has-current-submenu > a,
            #adminmenu .wp-submenu li.current a {
                background-color: {$background_menu_active};
            }
        ";
    }

    /**
     * @param array<string, mixed> $settings
     */
    private static function resolve_font_name($settings) {
        if (!empty($settings['font_file'])) {
            return 'DevapressCustomFont';
        }
        return 'sans-serif';
    }

    private static function get_font_format($ext) {
        switch (strtolower($ext)) {
            case 'woff2':
                return 'woff2';
            case 'woff':
                return 'woff';
            case 'otf':
                return 'opentype';
            default:
                return 'truetype';
        }
    }
}
