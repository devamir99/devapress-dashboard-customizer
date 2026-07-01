<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package Devapress_Customizer
 */

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

delete_option('devapress_settings');

$legacy_options = [
    'devapress_font',
    'devapress_font_file',
    'devapress_font_size',
    'devapress_font_color',
    'devapress_font_color_hover',
    'devapress_font_color_active',
    'devapress_apply_font_globally',
    'devapress_login_font_enable',
    'devapress_icon_color',
    'devapress_icon_hover_color',
    'devapress_icon_active_color',
    'devapress_menu_color',
    'devapress_menu_hover_color',
    'devapress_menu_active_color',
    'devapress_bg_login_file',
    'devapress_login_logo',
    'devapress_bg_login_color',
    'devapress_bg_login_gradient_color1',
    'devapress_bg_login_gradient_color2',
    'devapress_bg_login_gradient_type',
    'devapress_bg_login_gradient_enable',
    'devapress_bg_login_gradient_opacity',
    'devapress_bg_login_size',
    'devapress_login_form_bg',
    'devapress_login_form_bg2',
    'devapress_login_form_glass',
    'devapress_login_form_radius',
    'devapress_login_input_radius',
    'devapress_login_btn_bg',
    'devapress_login_btn_color',
    'devapress_login_btn_radius',
    'devapress_login_btn_hover_bg',
    'devapress_login_btn_hover_color',
    'devapress_login_label_color',
];

foreach ($legacy_options as $option) {
    delete_option($option);
}

global $wpdb;
$wpdb->query(
    $wpdb->prepare(
        "DELETE FROM {$wpdb->options} WHERE option_name LIKE %s OR option_name LIKE %s",
        $wpdb->esc_like('_transient_devapress_preview_') . '%',
        $wpdb->esc_like('_transient_timeout_devapress_preview_') . '%'
    )
);
