<?php
if (!defined('ABSPATH')) {
    exit;
}

class Devapress_Login_Customizer {

    public function __construct() {
        add_action('login_enqueue_scripts', [$this, 'apply_login_customizations'], 20);
        add_filter('login_body_class', [$this, 'add_body_class']);
        add_action('login_enqueue_scripts', [$this, 'enqueue_base_styles'], 10);
    }

    public function add_body_class($classes) {
        if (Devapress_Settings::is_active('login')) {
            $classes[] = 'devapress-customized';
        }
        return $classes;
    }

    public function enqueue_base_styles() {
        if (!Devapress_Settings::is_active('login')) {
            return;
        }

        wp_enqueue_style(
            'devapress-login-css',
            DEVAPRESS_CSS_URL . 'login.css',
            [],
            DEVAPRESS_VERSION
        );
    }

    public function apply_login_customizations() {
        if (!Devapress_Settings::is_active('login')) {
            return;
        }

        $settings = Devapress_Settings::get_resolved('login');
        if (empty($settings)) {
            return;
        }

        wp_register_style('devapress-login-custom', false);
        wp_enqueue_style('devapress-login-custom');

        $css = $this->build_login_css($settings);
        if ($css) {
            wp_add_inline_style('devapress-login-custom', $css);
        }
    }

    /**
     * @param array<string, mixed> $settings
     */
    private function build_login_css($settings) {
        $css = '';

        $logo_id  = $settings['logo_id'] ?? '';
        $logo_url = $logo_id ? wp_get_attachment_url($logo_id) : '';
        if ($logo_url) {
            $css .= ".login.devapress-customized h1 a {
                background-image: url('{$logo_url}') !important;
                width: auto;
                height: 80px;
                background-size: contain;
            }";
        }

        $bg_id  = $settings['bg_image_id'] ?? '';
        $bg_url = $bg_id ? wp_get_attachment_url($bg_id) : '';
        $bg_size = esc_attr($settings['bg_size'] ?? 'cover');

        $grad_color1      = $settings['bg_gradient_color1'] ?? '';
        $grad_color2      = $settings['bg_gradient_color2'] ?? '';
        $grad_type        = $settings['bg_gradient_type'] ?? 'linear';
        $gradient_enable  = !empty($settings['bg_gradient_enable']);
        $grad_opacity     = isset($settings['bg_gradient_opacity']) ? (int) $settings['bg_gradient_opacity'] : 100;
        $opacity          = max(0, min(1, $grad_opacity / 100));
        $color1           = $this->hex2rgba($grad_color1, $opacity);
        $color2           = $this->hex2rgba($grad_color2, $opacity);
        $bg_color         = $settings['bg_color'] ?? '';

        $background_layers = [];

        if ($bg_url) {
            $background_layers[] = "url('{$bg_url}') no-repeat center center / {$bg_size}";
        }

        if ($gradient_enable && $grad_color1 && $grad_color2) {
            if ($grad_type === 'radial') {
                $gradient_css = "radial-gradient(circle, {$color1}, {$color2})";
            } elseif ($grad_type === 'conic') {
                $gradient_css = "conic-gradient(from 0deg, {$color1}, {$color2})";
            } else {
                $gradient_css = "linear-gradient(135deg, {$color1}, {$color2})";
            }
            array_unshift($background_layers, $gradient_css);
        } elseif ($bg_color) {
            array_unshift($background_layers, esc_attr($bg_color));
        }

        if (!empty($background_layers)) {
            $background_css = implode(', ', $background_layers);
            $css .= "body.login.devapress-customized { background: {$background_css} !important; }";
        }

        $glass       = !empty($settings['login_form_glass']);
        $form_bg     = $settings['login_form_bg'] ?? '#ffffff';
        $form_bg2    = $settings['login_form_bg2'] ?? '';
        $form_radius = esc_attr($settings['login_form_radius'] ?? '8');
        $input_radius = esc_attr($settings['login_input_radius'] ?? '6');
        list($r, $g, $b) = sscanf($form_bg, '#%02x%02x%02x') ?: [255, 255, 255];

        if ($glass) {
            $css .= "
                body.login.devapress-customized form#loginform {
                    background: rgba({$r}, {$g}, {$b}, 0.25) !important;
                    backdrop-filter: blur(12px);
                    -webkit-backdrop-filter: blur(12px);
                    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
                }
            ";
        } elseif ($form_bg2) {
            $css .= "body.login.devapress-customized form#loginform {
                background: linear-gradient(135deg, {$form_bg}, {$form_bg2}) !important;
            }";
        } else {
            $css .= "body.login.devapress-customized form#loginform {
                background-color: {$form_bg} !important;
            }";
        }

        $css .= "
            body.login.devapress-customized form#loginform {
                border-radius: {$form_radius}px;
            }
            body.login.devapress-customized form#loginform input[type='text'],
            body.login.devapress-customized form#loginform input[type='password'] {
                border-radius: {$input_radius}px;
            }
        ";

        $btn_bg          = esc_attr($settings['login_btn_bg'] ?? '#2271b1');
        $btn_color       = esc_attr($settings['login_btn_color'] ?? '#ffffff');
        $btn_radius      = esc_attr($settings['login_btn_radius'] ?? '4');
        $btn_hover_bg    = esc_attr($settings['login_btn_hover_bg'] ?? '#135e96');
        $btn_hover_color = esc_attr($settings['login_btn_hover_color'] ?? '#ffffff');
        $label_color     = esc_attr($settings['login_label_color'] ?? '#3c434a');

        $css .= "
            body.login.devapress-customized form#loginform input[type='submit'] {
                background-color: {$btn_bg};
                color: {$btn_color};
                border-radius: {$btn_radius}px;
                border: none;
            }
            body.login.devapress-customized form#loginform input[type='submit']:hover {
                background-color: {$btn_hover_bg};
                color: {$btn_hover_color};
            }
            body.login.devapress-customized label,
            body.login.devapress-customized #nav a,
            body.login.devapress-customized #backtoblog a {
                color: {$label_color};
            }
        ";

        return $css;
    }

    public function hex2rgba($color, $opacity = 1) {
        $color = str_replace('#', '', (string) $color);
        if (strlen($color) === 6) {
            $hex = str_split($color, 2);
            $r   = hexdec($hex[0]);
            $g   = hexdec($hex[1]);
            $b   = hexdec($hex[2]);
            return "rgba({$r}, {$g}, {$b}, {$opacity})";
        }
        return $color;
    }
}
