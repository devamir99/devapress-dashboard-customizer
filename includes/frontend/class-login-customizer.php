<?php
if (!defined('ABSPATH')) exit;

class Devapress_Login_Customizer {

    public function __construct() {
        add_action('login_enqueue_scripts', [$this, 'apply_login_customizations']);
    }


    public function apply_login_customizations() {
        $bg_id              = get_option('devapress_bg_login_file', '');
        $bg_url             = $bg_id ? wp_get_attachment_url($bg_id) : '';
        $bg_color           = get_option('devapress_bg_login_color', '');
        $logo_id            = get_option('devapress_login_logo', '');
        $logo_url           = $logo_id ? wp_get_attachment_url($logo_id) : '';
        $grad_color1        = get_option('devapress_bg_login_gradient_color1', '');
        $grad_color2        = get_option('devapress_bg_login_gradient_color2', '');
        $grad_type          = get_option('devapress_bg_login_gradient_type', 'linear');
        $bg_size            = get_option('devapress_bg_login_size', 'cover');
        $gradient_enable    = get_option('devapress_bg_login_gradient_enable', '1');
        $grad_opacity       = get_option('devapress_bg_login_gradient_opacity', '100'); // پیش‌فرض 100%
        $opacity            = $grad_opacity / 100; // تبدیل به 0 تا 1 برای CSS
        $color1             = $this->hex2rgba($grad_color1, $opacity);
        $color2             = $this->hex2rgba($grad_color2, $opacity);
        $glass              = get_option('devapress_login_form_glass', 0);
        $form_bg            = get_option('devapress_login_form_bg', '#ffffff');
        $form_bg2           = get_option('devapress_login_form_bg2', ''); // رنگ دوم
        list($r, $g, $b)    = sscanf($form_bg, "#%02x%02x%02x");
        $form_radius        = get_option('devapress_login_form_radius', '8'); // پیش‌فرض 8px
        $input_radius       = get_option('devapress_login_input_radius', '6');
        $btn_bg             = get_option('devapress_login_btn_bg', '#2271b1');
        $btn_color          = get_option('devapress_login_btn_color', '#ffffff');
        $btn_radius         = get_option('devapress_login_btn_radius', '4');
        $btn_hover_bg       = get_option('devapress_login_btn_hover_bg', '#1a5a91');
        $btn_hover_color    = get_option('devapress_login_btn_hover_color', '#ffffff');
        $label_color        = get_option('devapress_login_label_color', '#333333');



        echo "<style>";


        // لوگو
        if ($logo_url) {
            echo ".login h1 a {
            background-image: url('{$logo_url}') !important;
            width: auto;
            height: 80px;
            background-size: contain;
        }";
        }

        $background_layers = [];

        if ($bg_url) {
            $background_layers[] = "url('{$bg_url}') no-repeat center center / {$bg_size}";
        }

        // gradient یا رنگ روی تصویر (شفاف)
        if ( $gradient_enable === '1' && $grad_color1 && $grad_color2) {


            if ($grad_type === 'linear') {
                $gradient_css = "linear-gradient(135deg, {$color1}, {$color2})";
            } elseif ($grad_type === 'radial') {
                $gradient_css = "radial-gradient(circle, {$color1}, {$color2})";
            } elseif ($grad_type === 'conic') {
                $gradient_css = "conic-gradient(from 0deg, {$color1}, {$color2})";
            }

            array_unshift($background_layers, $gradient_css);
        } elseif ($bg_color) {
            array_unshift($background_layers, $bg_color ); // نصف شفاف
        }

        if (!empty($background_layers)) {
            $background_css = implode(", ", $background_layers);
            echo "body.login { background: {$background_css} !important; }";
        }


        if ($glass) {
            echo "
        form#loginform {
            background: rgba($r, $g, $b, 0.2) !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px);
            border-radius: 15px !important;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1) !important;
        }
        ";
        } else {
            if ($form_bg2) {
                echo "form#loginform {
            background: linear-gradient(135deg, {$form_bg}, {$form_bg2}) !important;
        }";
            } else {
                echo "form#loginform {
            background-color: {$form_bg} !important;
        }";
            }
        }

        if ( $form_radius || $input_radius ) {
            echo "
            form#loginform {
                border-radius: {$form_radius}px !important;
            }
            form#loginform input[type='text'],
            form#loginform input[type='password'],
            form#loginform input[type='checkbox']
             {
                border-radius: {$input_radius}px !important;
            }
            ";
        }


        if ( $btn_color || $btn_radius || $btn_hover_bg  || $btn_hover_color) {
            echo "
            form#loginform input[type='submit'] {
                background-color: {$btn_bg} !important;
                color: {$btn_color} !important;
                border-radius: {$btn_radius}px !important;
            }
            #loginform input[type=submit]:hover {
                background-color: {$btn_hover_bg} !important;
                color: {$btn_hover_color} !important;
            }
        ";
        }

        if ( $label_color ){
            echo "
            body.login label , body.login a {
                color: {$label_color} !important;
            }
        ";
            }




        echo "</style>";
    }

    public function hex2rgba($color, $opacity = 1) {
        $color = str_replace('#', '', $color);
        if (strlen($color) == 6) {
            $hex = str_split($color, 2);
            $r = hexdec($hex[0]);
            $g = hexdec($hex[1]);
            $b = hexdec($hex[2]);
            return "rgba($r, $g, $b, $opacity)";
        }
        return $color;
    }


}






