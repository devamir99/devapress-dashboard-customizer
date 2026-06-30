<?php
    if (!defined('ABSPATH')) exit;

class Devapress_Dashboard_Customizer
{

    public function __construct()
    {
        // اعمال تغییرات روی داشبورد
        add_action('admin_enqueue_scripts', [$this, 'apply_dashboard_customizations'], 20);

        // اعمال تغییرات روی صفحه لاگین
        add_action('login_enqueue_scripts', [$this, 'apply_login_customizations'], 20);

//        add_action('wp_enqueue_scripts', [$this, 'apply_frontend_customizations'], 20);

    }
    public function apply_dashboard_customizations()
    {
        $custom_css = '';

        // تنظیمات فونت
        $available_fonts = [
            'vazir'     => DEVAPRESS_FONTS_URL . '/Badr/Font/badr.com.woff',
            'shabnam'   => DEVAPRESS_FONTS_URL . '/IranNastaliq.ttf',
            'iransans'  => DEVAPRESS_FONTS_URL . '/IRANSans.ttf',
            'tahoma'    => DEVAPRESS_FONTS_URL . '/Tahoma.ttf',
        ];

        $font_file_url = get_option('devapress_font_file', '');
        if ($font_file_url) {
            $font_name = 'DevapressCustomFont';
        } else {
            $font_key = get_option('devapress_font', '');
            if ($font_key && isset($available_fonts[$font_key])) {
                $font_file_url = $available_fonts[$font_key];
                $font_name = ucfirst($font_key);
            } else {
                $font_file_url = '';
                $font_name = 'sans-serif';
            }
        }

        // @font-face
        if ($font_file_url) {
            $ext = pathinfo($font_file_url, PATHINFO_EXTENSION);
            $format = $this->get_font_format($ext);
            $custom_css .= "
                @font-face {
                    font-family: '{$font_name}';
                    src: url('{$font_file_url}') format('{$format}');
                    font-weight: normal;
                    font-style: normal;
                }";
        }

        // سایر تنظیمات
        $font_size = get_option('devapress_font_size', '14');
        $font_color = get_option('devapress_font_color', '#000000');
        $font_color_hover = get_option('devapress_font_color_hover', '#2271b1');
        $font_color_active = get_option('devapress_font_color_active', '#2271b1');
        $icon_color = get_option('devapress_icon_color', '#9ca2a7');
        $icon_color_hover = get_option('devapress_icon_hover_color', '#9ca2a7');
        $background_menu_color = get_option('devapress_menu_color', '#1d2327');
        $background_menu_hover_color = get_option('devapress_menu_hover_color', '#1d2327');
        $background_menu_active_color = get_option('devapress_menu_active_color', '#9ca2a7');
        $icon_color_active = get_option('devapress_icon_active_color', '#9ca2a7');
        $apply_globally = get_option('devapress_apply_font_globally', 0);

        $custom_css .= "
        .wrap, #adminmenu, #adminmenu * ,h1 ,#submit{
            font-family: '{$font_name}', sans-serif !important;
            font-size: {$font_size}px !important;
        }
        #adminmenu li.menu-top > a, #adminmenu li a {
            color: {$font_color} !important;
        }
        #adminmenu li.menu-top > a:hover, #adminmenu li a:hover {
            color: {$font_color_hover} !important;
        }
        #adminmenu li.menu-top.current > a,
        #adminmenu li.menu-top.wp-has-current-submenu > a ,
        #adminmenu .wp-submenu li.current a {
            color: {$font_color_active} !important;
        }
        #adminmenu .wp-menu-image:before { color: {$icon_color} !important; }
        #adminmenu li.menu-top:hover .wp-menu-image:before { color: {$icon_color_hover} !important; }
        #adminmenu li.menu-top.current .wp-menu-image:before,
        #adminmenu li.menu-top.wp-has-current-submenu .wp-menu-image:before ,
        #adminmenu .wp-submenu li.current .wp-menu-image:before {
            color: {$icon_color_active} !important;
        }
        #adminmenu,
        #adminmenuback,
        #adminmenuwrap ,
        #adminmenu .wp-submenu{
            background: {$background_menu_color} !important;
        }
        #adminmenu li.menu-top:hover,
        #adminmenu li.menu-top.menu-top-hover > a,
        #adminmenu .wp-submenu li a:hover,
        #adminmenu li.wp-has-submenu.opensub > a{
            background-color: $background_menu_hover_color !important;
        }
        #adminmenu li.menu-top.current > a,
        #adminmenu li.menu-top.wp-has-current-submenu > a ,
        #adminmenu .wp-submenu li.current a{
            background-color: $background_menu_active_color !important;
        }
        ";

        $selectors = '#adminmenu, #adminmenu *';
        if ($apply_globally) {
            $selectors = '.wrap, #adminmenu, #adminmenu *, h1, #submit';
        }
        

        $custom_css .= "
        {$selectors} {
                font-family: '{$font_name}', sans-serif !important;
                font-size: {$font_size}px !important;
                
            }
        ";

        if ($custom_css) {
            wp_add_inline_style('devapress-admin-css', $custom_css);
        }

    }
    public function apply_login_customizations() {
        $login_font_enable = get_option('devapress_login_font_enable', '0');
        if (!$login_font_enable) return;

        $font_file_url = get_option('devapress_font_file', '');
        $available_fonts = [
            'vazir' => DEVAPRESS_FONTS_URL . '/Badr/Font/badr.com.woff',
            'shabnam' => DEVAPRESS_FONTS_URL . '/IranNastaliq.ttf',
            'iransans' => DEVAPRESS_FONTS_URL . '/IRANSans.ttf',
            'tahoma' => DEVAPRESS_FONTS_URL . '/Tahoma.ttf',
        ];
        $font_key = get_option('devapress_font', '');

        if ($font_file_url) {
            $font_name = 'DevapressLoginFont';
        } elseif ($font_key && isset($available_fonts[$font_key])) {
            $font_file_url = $available_fonts[$font_key];
            $font_name = ucfirst($font_key);
        } else {
            $font_name = 'sans-serif';
        }

        $font_size = get_option('devapress_font_size', '14');

        $css = '';
        if ($font_file_url) {
            $ext = pathinfo($font_file_url, PATHINFO_EXTENSION);
            $format = $this->get_font_format($ext);
            $css .= "
        @font-face {
            font-family: '{$font_name}';
            src: url('{$font_file_url}') format('{$format}');
            font-weight: normal;
            font-style: normal;
        }";
        }

        $css .= "
            body.login #login,
            body.login #loginform,
            body.login #loginform input,
            body.login #loginform label,
            body.login #nav,
            body.login #backtoblog,
            body.login h1 a {
                font-family: '{$font_name}', sans-serif !important;
                font-size: {$font_size}px !important;
            }
        ";



        wp_add_inline_style('login', $css);
    }
    private function get_font_format($ext)
    {
        switch (strtolower($ext)) {
            case 'woff2':
                return 'woff2';
            case 'woff':
                return 'woff';
            case 'ttf':
                return 'truetype';
            case 'otf':
                return 'opentype';
            default:
                return 'truetype';
        }
    }

}






