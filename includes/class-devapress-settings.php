<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Central settings storage: preset + per-field overrides.
 */
class Devapress_Settings {

    const OPTION_KEY     = 'devapress_settings';
    const SETTINGS_VERSION = 2;

    /**
     * @return array<string, mixed>
     */
    public static function defaults() {
        return [
            'version'   => self::SETTINGS_VERSION,
            'dashboard' => [
                'preset'    => 'none',
                'overrides' => [],
                'font_file' => '',
                'login_font_enable' => false,
            ],
            'login' => [
                'preset'      => 'none',
                'overrides'   => [],
                'bg_image_id' => '',
                'logo_id'     => '',
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function get_all() {
        $saved = get_option(self::OPTION_KEY, []);
        if (!is_array($saved)) {
            $saved = [];
        }

        return self::array_merge_deep(self::defaults(), $saved);
    }

    /**
     * @param string $section dashboard|login
     */
    public static function is_active($section) {
        $all = self::get_all();
        $preset = $all[$section]['preset'] ?? 'none';

        return $preset !== 'none' && $preset !== '';
    }

    /**
     * Merge preset values with user overrides for a section.
     *
     * @param string $section dashboard|login
     * @return array<string, mixed>
     */
    public static function get_resolved($section) {
        $all = self::get_all();
        $section_data = $all[$section] ?? [];
        $preset_id = $section_data['preset'] ?? 'none';

        if ($preset_id === 'none' || $preset_id === '') {
            return [];
        }

        $preset = Devapress_Presets::get($section, $preset_id);
        if (!$preset) {
            return [];
        }

        unset($preset['label'], $preset['description']);

        $resolved = $preset;
        $overrides = $section_data['overrides'] ?? [];

        foreach ($overrides as $key => $value) {
            if ($value === '' || $value === null) {
                continue;
            }
            $resolved[$key] = $value;
        }

        if ($section === 'dashboard') {
            if (!empty($section_data['font_file'])) {
                $resolved['font_file'] = $section_data['font_file'];
            }
            $resolved['login_font_enable'] = !empty($section_data['login_font_enable']);
        }

        if ($section === 'login') {
            if (!empty($section_data['bg_image_id'])) {
                $resolved['bg_image_id'] = $section_data['bg_image_id'];
            }
            if (!empty($section_data['logo_id'])) {
                $resolved['logo_id'] = $section_data['logo_id'];
            }
        }

        return $resolved;
    }

    /**
     * @param array<string, mixed> $input
     * @return array<string, mixed>
     */
    public static function sanitize($input) {
        $current = self::get_all();

        if (!is_array($input)) {
            return $current;
        }

        $output = $current;

        $dashboard_preset = sanitize_key($input['dashboard']['preset'] ?? 'none');
        $login_preset     = sanitize_key($input['login']['preset'] ?? 'none');

        $valid_dashboard = array_keys(Devapress_Presets::dashboard_presets());
        $valid_login     = array_keys(Devapress_Presets::login_presets());

        $output['version'] = self::SETTINGS_VERSION;
        $output['dashboard']['preset'] = in_array($dashboard_preset, $valid_dashboard, true) || $dashboard_preset === 'none'
            ? $dashboard_preset
            : 'none';
        $output['login']['preset'] = in_array($login_preset, $valid_login, true) || $login_preset === 'none'
            ? $login_preset
            : 'none';

        $output['dashboard']['overrides'] = self::strip_preset_matches(
            'dashboard',
            $output['dashboard']['preset'],
            self::sanitize_dashboard_overrides($input['dashboard']['overrides'] ?? [])
        );
        $output['login']['overrides'] = self::strip_preset_matches(
            'login',
            $output['login']['preset'],
            self::sanitize_login_overrides($input['login']['overrides'] ?? [])
        );

        $output['dashboard']['font_file'] = self::maybe_handle_font_upload(
            $input['dashboard']['font_file'] ?? $current['dashboard']['font_file'] ?? ''
        );
        $output['dashboard']['login_font_enable'] = !empty($input['dashboard']['login_font_enable']);

        $output['login']['bg_image_id'] = absint($input['login']['bg_image_id'] ?? 0);
        $output['login']['logo_id']     = absint($input['login']['logo_id'] ?? 0);

        return $output;
    }

    /**
     * @param array<string, mixed> $overrides
     * @return array<string, mixed>
     */
    private static function sanitize_dashboard_overrides($overrides) {
        if (!is_array($overrides)) {
            return [];
        }

        $allowed = [
            'font_size', 'font_color', 'font_color_hover', 'font_color_active',
            'icon_color', 'icon_hover_color', 'icon_active_color',
            'menu_color', 'menu_hover_color', 'menu_active_color',
            'apply_font_globally',
        ];

        $clean = [];
        foreach ($allowed as $key) {
            if (!isset($overrides[$key]) || $overrides[$key] === '') {
                continue;
            }
            if ($key === 'font_size') {
                $clean[$key] = absint($overrides[$key]);
            } elseif ($key === 'apply_font_globally') {
                $clean[$key] = !empty($overrides[$key]);
            } else {
                $clean[$key] = sanitize_hex_color($overrides[$key]) ?: '';
            }
        }

        return array_filter($clean, static function ($v) {
            return $v !== '' && $v !== false;
        });
    }

    /**
     * @param array<string, mixed> $overrides
     * @return array<string, mixed>
     */
    private static function sanitize_login_overrides($overrides) {
        if (!is_array($overrides)) {
            return [];
        }

        $color_keys = [
            'bg_color', 'bg_gradient_color1', 'bg_gradient_color2',
            'login_form_bg', 'login_form_bg2',
            'login_btn_bg', 'login_btn_color',
            'login_btn_hover_bg', 'login_btn_hover_color',
            'login_label_color',
        ];
        $number_keys = [
            'bg_gradient_opacity', 'login_form_radius', 'login_input_radius', 'login_btn_radius',
        ];
        $select_keys = [
            'bg_gradient_type' => ['linear', 'radial', 'conic'],
            'bg_size'          => ['cover', 'contain', 'auto'],
        ];
        $bool_keys = ['bg_gradient_enable', 'login_form_glass'];

        $clean = [];
        foreach ($color_keys as $key) {
            if (!empty($overrides[$key])) {
                $clean[$key] = sanitize_hex_color($overrides[$key]);
            }
        }
        foreach ($number_keys as $key) {
            if (isset($overrides[$key]) && $overrides[$key] !== '') {
                $clean[$key] = absint($overrides[$key]);
            }
        }
        foreach ($select_keys as $key => $allowed) {
            if (!empty($overrides[$key]) && in_array($overrides[$key], $allowed, true)) {
                $clean[$key] = $overrides[$key];
            }
        }
        foreach ($bool_keys as $key) {
            if (isset($overrides[$key]) && $overrides[$key] !== '') {
                $clean[$key] = !empty($overrides[$key]);
            }
        }

        return $clean;
    }

    /**
     * @param string $section dashboard|login
     */
    public static function reset_section($section) {
        $all = self::get_all();
        if (!isset($all[$section])) {
            return;
        }

        $defaults = self::defaults();
        $all[$section] = $defaults[$section];
        update_option(self::OPTION_KEY, $all);
    }

    /**
     * Migrate legacy per-option storage to unified settings.
     */
    public static function maybe_migrate() {
        $current = get_option(self::OPTION_KEY, null);

        if (is_array($current) && !empty($current['version'])) {
            return;
        }

        $has_legacy = get_option('devapress_menu_color', false) !== false
            || get_option('devapress_font_size', false) !== false
            || get_option('devapress_bg_login_file', false) !== false;

        if (!$has_legacy) {
            update_option(self::OPTION_KEY, self::defaults());
            return;
        }

        $settings = self::defaults();
        $settings['dashboard']['preset'] = 'minimal-dark';
        $settings['login']['preset']     = 'classic-clean';

        $settings['dashboard']['font_file'] = get_option('devapress_font_file', '');
        $settings['dashboard']['login_font_enable'] = (bool) get_option('devapress_login_font_enable', false);

        $settings['dashboard']['overrides'] = array_filter([
            'font_size'          => self::strip_px(get_option('devapress_font_size', '')),
            'font_color'         => get_option('devapress_font_color', ''),
            'font_color_hover'   => get_option('devapress_font_color_hover', ''),
            'font_color_active'  => get_option('devapress_font_color_active', ''),
            'icon_color'         => get_option('devapress_icon_color', ''),
            'icon_hover_color'   => get_option('devapress_icon_hover_color', ''),
            'icon_active_color'  => get_option('devapress_icon_active_color', ''),
            'menu_color'         => get_option('devapress_menu_color', ''),
            'menu_hover_color'   => get_option('devapress_menu_hover_color', ''),
            'menu_active_color'  => get_option('devapress_menu_active_color', ''),
            'apply_font_globally'=> get_option('devapress_apply_font_globally', ''),
        ]);

        $settings['login']['bg_image_id'] = absint(get_option('devapress_bg_login_file', 0));
        $settings['login']['logo_id']     = absint(get_option('devapress_login_logo', 0));

        $settings['login']['overrides'] = array_filter([
            'bg_color'              => get_option('devapress_bg_login_color', ''),
            'bg_gradient_color1'    => get_option('devapress_bg_login_gradient_color1', ''),
            'bg_gradient_color2'    => get_option('devapress_bg_login_gradient_color2', ''),
            'bg_gradient_type'      => get_option('devapress_bg_login_gradient_type', ''),
            'bg_gradient_enable'    => get_option('devapress_bg_login_gradient_enable', ''),
            'bg_gradient_opacity'   => get_option('devapress_bg_login_gradient_opacity', ''),
            'bg_size'               => get_option('devapress_bg_login_size', ''),
            'login_form_bg'         => get_option('devapress_login_form_bg', ''),
            'login_form_bg2'        => get_option('devapress_login_form_bg2', ''),
            'login_form_glass'      => get_option('devapress_login_form_glass', ''),
            'login_form_radius'     => self::strip_px(get_option('devapress_login_form_radius', '')),
            'login_input_radius'    => self::strip_px(get_option('devapress_login_input_radius', '')),
            'login_btn_bg'          => get_option('devapress_login_btn_bg', ''),
            'login_btn_color'       => get_option('devapress_login_btn_color', ''),
            'login_btn_radius'      => self::strip_px(get_option('devapress_login_btn_radius', '')),
            'login_btn_hover_bg'    => get_option('devapress_login_btn_hover_bg', ''),
            'login_btn_hover_color' => get_option('devapress_login_btn_hover_color', ''),
            'login_label_color'     => get_option('devapress_login_label_color', ''),
        ]);

        update_option(self::OPTION_KEY, $settings);
    }

    /**
     * Handle font upload during settings save.
     *
     * @param string $current_url
     */
    private static function maybe_handle_font_upload($current_url) {
        if (empty($_FILES['devapress_font_file_upload']['name'])) {
            return esc_url_raw($current_url);
        }

        $uploaded   = $_FILES['devapress_font_file_upload'];
        $upload_dir = wp_upload_dir()['basedir'] . '/devapress-fonts/';
        $upload_url = wp_upload_dir()['baseurl'] . '/devapress-fonts/';

        if (!file_exists($upload_dir)) {
            wp_mkdir_p($upload_dir);
        }

        $allowed = ['ttf', 'otf', 'woff', 'woff2'];
        $ext     = strtolower(pathinfo($uploaded['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed, true)) {
            return esc_url_raw($current_url);
        }

        $filename = sanitize_file_name($uploaded['name']);
        $target   = $upload_dir . $filename;

        if (move_uploaded_file($uploaded['tmp_name'], $target)) {
            return esc_url_raw($upload_url . $filename);
        }

        return esc_url_raw($current_url);
    }

    /**
     * Remove override values that are identical to the selected preset.
     *
     * @param string               $section
     * @param string               $preset_id
     * @param array<string, mixed> $overrides
     * @return array<string, mixed>
     */
    private static function strip_preset_matches($section, $preset_id, $overrides) {
        if ($preset_id === 'none' || empty($overrides)) {
            return $overrides;
        }

        $preset = Devapress_Presets::get($section, $preset_id);
        if (!$preset) {
            return $overrides;
        }

        foreach ($overrides as $key => $value) {
            if (!array_key_exists($key, $preset)) {
                continue;
            }
            $preset_val = $preset[$key];
            if ((string) $value === (string) $preset_val || $value == $preset_val) {
                unset($overrides[$key]);
            }
        }

        return $overrides;
    }

    /**
     * @param mixed $value
     */
    private static function strip_px($value) {
        if (!is_string($value)) {
            return $value;
        }
        return str_replace('px', '', $value);
    }

    /**
     * @param array<string, mixed> $base
     * @param array<string, mixed> $replace
     * @return array<string, mixed>
     */
    private static function array_merge_deep($base, $replace) {
        foreach ($replace as $key => $value) {
            if (is_array($value) && isset($base[$key]) && is_array($base[$key])) {
                $base[$key] = self::array_merge_deep($base[$key], $value);
            } else {
                $base[$key] = $value;
            }
        }
        return $base;
    }

    /**
     * Get effective value for a field (preset + override) for admin form display.
     *
     * @param string $section
     * @param string $key
     * @param mixed  $default
     * @return mixed
     */
    public static function get_field_value($section, $key, $default = '') {
        $resolved = self::get_resolved($section);
        if (isset($resolved[$key]) && $resolved[$key] !== '') {
            return $resolved[$key];
        }

        $all = self::get_all();
        $preset_id = $all[$section]['preset'] ?? 'none';
        if ($preset_id !== 'none') {
            $preset = Devapress_Presets::get($section, $preset_id);
            if ($preset && isset($preset[$key])) {
                return $preset[$key];
            }
        }

        return $default;
    }

    /**
     * Admin settings page URL.
     */
    public static function admin_url($args = []) {
        $url = admin_url('options-general.php?page=devapress-customizer');
        if (!empty($args)) {
            $url = add_query_arg($args, $url);
        }
        return $url;
    }
}
