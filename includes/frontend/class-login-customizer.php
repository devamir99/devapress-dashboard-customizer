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
        if (!Devapress_Settings::is_active('login')) {
            return $classes;
        }

        $classes[] = 'devapress-customized';

        $settings = Devapress_Settings::get_resolved('login');
        $layout   = sanitize_html_class($settings['login_layout'] ?? 'center');
        if (in_array($layout, ['center', 'split', 'fullscreen'], true)) {
            $classes[] = 'devapress-layout-' . $layout;
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

        $css = self::compile_login_css($settings);
        if ($css) {
            wp_add_inline_style('devapress-login-custom', $css);
        }
    }

    /**
     * @param array<string, mixed> $settings
     */
    public static function compile_login_css($settings) {
        $layout = $settings['login_layout'] ?? 'center';

        $css  = self::compile_layout_css($settings, $layout);
        $css .= self::compile_component_css($settings, $layout);

        return $css;
    }

    /**
     * Physical left/right sides — independent of document RTL direction.
     *
     * @return array{form: string, panel: string}
     */
    private static function split_sides($settings) {
        $panel_on_right = ($settings['split_panel_position'] ?? 'right') !== 'left';

        return [
            'form'  => $panel_on_right ? 'left' : 'right',
            'panel' => $panel_on_right ? 'right' : 'left',
        ];
    }

    /**
     * @param array<string, mixed> $settings
     */
    private static function compile_layout_css($settings, $layout) {
        $bg_id   = $settings['bg_image_id'] ?? '';
        $bg_url  = $bg_id ? wp_get_attachment_url((int) $bg_id) : '';
        $bg_size = esc_attr($settings['bg_size'] ?? 'cover');

        $panel_bg     = self::build_panel_background($settings, $bg_url, $bg_size);
        $form_side_bg = esc_attr($settings['split_form_bg'] ?? $settings['bg_color'] ?? '#f0f0f1');

        if ($layout === 'split') {
            $sides = self::split_sides($settings);

            return "
                body.login.devapress-layout-split {
                    min-height: 100vh !important;
                    margin: 0 !important;
                    padding: 0 !important;
                    background: {$form_side_bg} !important;
                    position: relative !important;
                    overflow-x: hidden !important;
                }
                body.login.devapress-layout-split::before {
                    content: '' !important;
                    position: fixed !important;
                    top: 0 !important;
                    {$sides['panel']}: 0 !important;
                    width: 50% !important;
                    height: 100% !important;
                    background: {$panel_bg} !important;
                    background-size: cover !important;
                    background-position: center !important;
                    z-index: 0 !important;
                }
                body.login.devapress-layout-split::after {
                    content: '' !important;
                    position: fixed !important;
                    top: 0 !important;
                    {$sides['panel']}: 0 !important;
                    width: 50% !important;
                    height: 100% !important;
                    background:
                        radial-gradient(circle at 20% 80%, rgba(255,255,255,0.12) 0%, transparent 50%),
                        radial-gradient(circle at 80% 20%, rgba(255,255,255,0.08) 0%, transparent 40%) !important;
                    z-index: 0 !important;
                    pointer-events: none !important;
                }
                body.login.devapress-layout-split #login {
                    position: fixed !important;
                    top: 0 !important;
                    {$sides['form']}: 0 !important;
                    width: 50% !important;
                    max-width: none !important;
                    height: 100vh !important;
                    margin: 0 !important;
                    padding: 48px 56px !important;
                    display: flex !important;
                    flex-direction: column !important;
                    justify-content: center !important;
                    align-items: center !important;
                    box-sizing: border-box !important;
                    z-index: 2 !important;
                    background: transparent !important;
                }
                body.login.devapress-layout-split #login h1 {
                    width: 100% !important;
                    max-width: 400px !important;
                    text-align: center !important;
                    margin: 0 0 28px !important;
                }
                body.login.devapress-layout-split #login h1 a {
                    margin: 0 auto !important;
                }
                body.login.devapress-layout-split form#loginform {
                    width: 100% !important;
                    max-width: 400px !important;
                    margin: 0 !important;
                    padding: 36px 32px !important;
                    box-shadow: 0 4px 24px rgba(15, 23, 42, 0.08), 0 1px 3px rgba(15, 23, 42, 0.04) !important;
                    border: 1px solid rgba(15, 23, 42, 0.06) !important;
                }
                body.login.devapress-layout-split #nav,
                body.login.devapress-layout-split #backtoblog {
                    width: 100% !important;
                    max-width: 400px !important;
                    margin: 16px 0 0 !important;
                    text-align: center !important;
                }
                body.login.devapress-layout-split .language-switcher {
                    position: fixed !important;
                    top: 16px !important;
                    {$sides['form']}: 16px !important;
                    z-index: 3 !important;
                }
                @media (max-width: 782px) {
                    body.login.devapress-layout-split::before,
                    body.login.devapress-layout-split::after {
                        position: relative !important;
                        width: 100% !important;
                        height: 200px !important;
                        display: block !important;
                        {$sides['panel']}: auto !important;
                        left: 0 !important;
                        right: 0 !important;
                    }
                    body.login.devapress-layout-split #login {
                        position: relative !important;
                        width: 100% !important;
                        height: auto !important;
                        min-height: auto !important;
                        padding: 32px 24px 48px !important;
                        {$sides['form']}: auto !important;
                        left: 0 !important;
                        right: 0 !important;
                    }
                    body.login.devapress-layout-split .language-switcher {
                        position: absolute !important;
                        top: 12px !important;
                        right: 12px !important;
                        left: auto !important;
                    }
                }
            ";
        }

        if ($layout === 'fullscreen') {
            $overlay = isset($settings['fullscreen_overlay'])
                ? max(0, min(80, (int) $settings['fullscreen_overlay']))
                : 40;
            $overlay_rgba = "rgba(15, 8, 30, " . ($overlay / 100) . ")";

            return "
                body.login.devapress-layout-fullscreen {
                    min-height: 100vh !important;
                    display: flex !important;
                    align-items: center !important;
                    justify-content: center !important;
                    padding: 32px 24px !important;
                    margin: 0 !important;
                    background: {$panel_bg} !important;
                    background-size: cover !important;
                    background-position: center !important;
                    background-attachment: fixed !important;
                    position: relative !important;
                }
                body.login.devapress-layout-fullscreen::before {
                    content: '' !important;
                    position: fixed !important;
                    inset: 0 !important;
                    background:
                        {$overlay_rgba},
                        radial-gradient(ellipse at 30% 20%, rgba(255,255,255,0.06) 0%, transparent 50%),
                        radial-gradient(ellipse at 70% 80%, rgba(0,0,0,0.15) 0%, transparent 50%) !important;
                    z-index: 0 !important;
                    pointer-events: none !important;
                }
                body.login.devapress-layout-fullscreen #login {
                    width: 100% !important;
                    max-width: 420px !important;
                    margin: 0 auto !important;
                    padding: 0 !important;
                    position: relative !important;
                    z-index: 1 !important;
                }
                body.login.devapress-layout-fullscreen #login h1 {
                    text-align: center !important;
                    margin-bottom: 24px !important;
                }
                body.login.devapress-layout-fullscreen #login h1 a {
                    margin: 0 auto !important;
                    filter: drop-shadow(0 2px 8px rgba(0,0,0,0.3)) !important;
                }
                body.login.devapress-layout-fullscreen form#loginform {
                    box-shadow:
                        0 0 0 1px rgba(255,255,255,0.1),
                        0 25px 50px -12px rgba(0, 0, 0, 0.45),
                        0 12px 24px -8px rgba(0, 0, 0, 0.25) !important;
                    padding: 40px 36px !important;
                    backdrop-filter: blur(2px) !important;
                }
                body.login.devapress-layout-fullscreen #nav,
                body.login.devapress-layout-fullscreen #backtoblog {
                    text-align: center !important;
                }
                body.login.devapress-layout-fullscreen #nav a,
                body.login.devapress-layout-fullscreen #backtoblog a {
                    color: rgba(255,255,255,0.92) !important;
                    text-shadow: 0 1px 3px rgba(0,0,0,0.4) !important;
                }
                body.login.devapress-layout-fullscreen .language-switcher {
                    position: fixed !important;
                    top: 16px !important;
                    right: 16px !important;
                    z-index: 2 !important;
                }
            ";
        }

        /* center */
        $center_bg = $form_side_bg;
        if (!empty($settings['bg_gradient_enable']) && !empty($settings['bg_gradient_color1']) && !empty($settings['bg_gradient_color2'])) {
            $c1 = esc_attr($settings['bg_gradient_color1']);
            $c2 = esc_attr($settings['bg_gradient_color2']);
            $center_bg = "linear-gradient(160deg, {$form_side_bg} 0%, {$c1}08 50%, {$c2}12 100%)";
        }

        return "
            body.login.devapress-layout-center {
                min-height: 100vh !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                padding: 32px 24px !important;
                margin: 0 !important;
                background: {$center_bg} !important;
                position: relative !important;
            }
            body.login.devapress-layout-center::before {
                content: '' !important;
                position: fixed !important;
                inset: 0 !important;
                background-image: radial-gradient(rgba(15, 23, 42, 0.04) 1px, transparent 1px) !important;
                background-size: 24px 24px !important;
                pointer-events: none !important;
                z-index: 0 !important;
            }
            body.login.devapress-layout-center #login {
                width: 100% !important;
                max-width: 420px !important;
                margin: 0 auto !important;
                padding: 0 !important;
                position: relative !important;
                z-index: 1 !important;
            }
            body.login.devapress-layout-center #login h1 {
                text-align: center !important;
                margin-bottom: 24px !important;
            }
            body.login.devapress-layout-center #login h1 a {
                margin: 0 auto !important;
            }
            body.login.devapress-layout-center form#loginform {
                box-shadow:
                    0 0 0 1px rgba(15, 23, 42, 0.04),
                    0 8px 32px rgba(15, 23, 42, 0.08),
                    0 2px 8px rgba(15, 23, 42, 0.04) !important;
                padding: 36px 32px !important;
            }
            body.login.devapress-layout-center #nav,
            body.login.devapress-layout-center #backtoblog {
                text-align: center !important;
            }
        ";
    }

    /**
     * @param array<string, mixed> $settings
     */
    private static function compile_component_css($settings, $layout) {
        $css = '';

        $logo_id  = $settings['logo_id'] ?? '';
        $logo_url = $logo_id ? wp_get_attachment_url((int) $logo_id) : '';
        if ($logo_url) {
            $css .= ".login.devapress-customized h1 a {
                background-image: url('{$logo_url}') !important;
                width: auto !important;
                height: 72px !important;
                background-size: contain !important;
                background-repeat: no-repeat !important;
                background-position: center !important;
            }";
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
                    background: rgba({$r}, {$g}, {$b}, 0.18) !important;
                    backdrop-filter: blur(20px) saturate(1.2) !important;
                    -webkit-backdrop-filter: blur(20px) saturate(1.2) !important;
                    border: 1px solid rgba(255,255,255,0.28) !important;
                }
            ";
        } elseif ($form_bg2 && $layout !== 'split') {
            $css .= "body.login.devapress-customized form#loginform {
                background: linear-gradient(145deg, {$form_bg}, {$form_bg2}) !important;
            }";
        } else {
            $css .= "body.login.devapress-customized form#loginform {
                background-color: {$form_bg} !important;
            }";
        }

        $label_color = esc_attr($settings['login_label_color'] ?? '#3c434a');
        $btn_bg          = esc_attr($settings['login_btn_bg'] ?? '#2271b1');
        $btn_color       = esc_attr($settings['login_btn_color'] ?? '#ffffff');
        $btn_radius      = esc_attr($settings['login_btn_radius'] ?? '4');
        $btn_hover_bg    = esc_attr($settings['login_btn_hover_bg'] ?? '#135e96');
        $btn_hover_color = esc_attr($settings['login_btn_hover_color'] ?? '#ffffff');

        $input_focus = $btn_bg;

        $css .= "
            body.login.devapress-customized form#loginform {
                border-radius: {$form_radius}px !important;
            }
            body.login.devapress-customized form#loginform input[type='text'],
            body.login.devapress-customized form#loginform input[type='password'] {
                border-radius: {$input_radius}px !important;
                border: 1px solid #e2e8f0 !important;
                padding: 12px 14px !important;
                background: #fff !important;
                box-shadow: none !important;
                font-size: 15px !important;
                transition: border-color 0.15s ease, box-shadow 0.15s ease !important;
            }
            body.login.devapress-customized form#loginform input[type='text']:focus,
            body.login.devapress-customized form#loginform input[type='password']:focus {
                border-color: {$input_focus} !important;
                box-shadow: 0 0 0 3px " . self::hex2rgba($btn_bg, 0.15) . " !important;
                outline: none !important;
            }
            body.login.devapress-customized form#loginform input[type='submit'] {
                background-color: {$btn_bg} !important;
                color: {$btn_color} !important;
                border-radius: {$btn_radius}px !important;
                border: none !important;
                padding: 12px 16px !important;
                font-weight: 600 !important;
                font-size: 15px !important;
                width: 100% !important;
                cursor: pointer !important;
                transition: background-color 0.15s ease, transform 0.1s ease !important;
                margin-top: 4px !important;
            }
            body.login.devapress-customized form#loginform input[type='submit']:hover {
                background-color: {$btn_hover_bg} !important;
                color: {$btn_hover_color} !important;
            }
            body.login.devapress-customized form#loginform input[type='submit']:active {
                transform: scale(0.98) !important;
            }
            body.login.devapress-customized label,
            body.login.devapress-customized #nav a,
            body.login.devapress-customized #backtoblog a {
                color: {$label_color} !important;
            }
            body.login.devapress-customized form#loginform label {
                font-weight: 500 !important;
                margin-bottom: 8px !important;
            }
        ";

        return $css;
    }

    /**
     * @param array<string, mixed> $settings
     */
    private static function build_panel_background($settings, $bg_url, $bg_size) {
        $grad_color1     = $settings['bg_gradient_color1'] ?? '';
        $grad_color2     = $settings['bg_gradient_color2'] ?? '';
        $grad_type       = $settings['bg_gradient_type'] ?? 'linear';
        $gradient_enable = !empty($settings['bg_gradient_enable']);
        $grad_opacity    = isset($settings['bg_gradient_opacity']) ? (int) $settings['bg_gradient_opacity'] : 100;
        $opacity         = max(0, min(1, $grad_opacity / 100));
        $bg_color        = $settings['bg_color'] ?? '';

        $layers = [];

        if ($bg_url) {
            $layers[] = "url('{$bg_url}') no-repeat center center / {$bg_size}";
        }

        if ($gradient_enable && $grad_color1 && $grad_color2) {
            $color1 = self::hex2rgba($grad_color1, $opacity);
            $color2 = self::hex2rgba($grad_color2, $opacity);

            if ($grad_type === 'radial') {
                $layers[] = "radial-gradient(ellipse at 30% 20%, {$color1}, {$color2})";
            } elseif ($grad_type === 'conic') {
                $layers[] = "conic-gradient(from 200deg at 60% 40%, {$color1}, {$color2}, {$color1})";
            } else {
                $layers[] = "linear-gradient(145deg, {$color1} 0%, {$color2} 100%)";
            }
        } elseif ($bg_color) {
            $layers[] = esc_attr($bg_color);
        }

        if (empty($layers)) {
            return 'linear-gradient(145deg, #6366f1 0%, #8b5cf6 50%, #a855f7 100%)';
        }

        return implode(', ', $layers);
    }

    public static function hex2rgba($color, $opacity = 1) {
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
