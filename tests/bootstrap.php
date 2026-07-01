<?php
/**
 * PHPUnit bootstrap — WordPress function stubs for unit tests.
 */

declare(strict_types=1);

$GLOBALS['devapress_test_options'] = [];

if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__DIR__) . '/');
}

define('DEVAPRESS_VERSION', '2.2.0');
define('DEVAPRESS_PLUGIN_DIR', dirname(__DIR__) . '/');
define('DEVAPRESS_PLUGIN_URL', 'http://example.com/wp-content/plugins/devapress-dashboard-customizer/');
define('DEVAPRESS_ASSETS_URL', DEVAPRESS_PLUGIN_URL . 'assets/');
define('DEVAPRESS_FONTS_URL', DEVAPRESS_PLUGIN_URL . 'assets/fonts');
define('DEVAPRESS_ASSETS_DIR', DEVAPRESS_PLUGIN_DIR . 'assets/');
define('DEVAPRESS_VIEW_DIR', DEVAPRESS_PLUGIN_DIR . 'views/admin/');
define('DEVAPRESS_CSS_URL', DEVAPRESS_ASSETS_URL . 'css/');
define('DEVAPRESS_JS_URL', DEVAPRESS_ASSETS_URL . 'js/');

function devapress_test_reset_options(): void {
    $GLOBALS['devapress_test_options'] = [];
}

function get_option(string $option, $default = false) {
    return $GLOBALS['devapress_test_options'][$option] ?? $default;
}

function update_option(string $option, $value): bool {
    $GLOBALS['devapress_test_options'][$option] = $value;
    return true;
}

function delete_option(string $option): bool {
    unset($GLOBALS['devapress_test_options'][$option]);
    return true;
}

function sanitize_key(string $key): string {
    return preg_replace('/[^a-z0-9_\-]/', '', strtolower($key)) ?? '';
}

function sanitize_hex_color(string $color): string {
    if (preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color)) {
        return $color;
    }
    return '';
}

function absint($maybeint): int {
    return abs((int) $maybeint);
}

function esc_url_raw(string $url): string {
    return filter_var($url, FILTER_SANITIZE_URL) ?: '';
}

function esc_attr(string $text): string {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function esc_html(string $text): string {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function wp_json_encode($data, int $options = 0, int $depth = 512) {
    return json_encode($data, $options, $depth);
}

function home_url(string $path = ''): string {
    return 'http://example.com' . $path;
}

function admin_url(string $path = ''): string {
    return 'http://example.com/wp-admin/' . ltrim($path, '/');
}

function wp_get_attachment_url(int $id): string {
    if ($id <= 0) {
        return '';
    }
    return 'http://example.com/wp-content/uploads/image-' . $id . '.jpg';
}

function checked($checked, $current = true, bool $echo = true): string {
    $result = ((string) $checked === (string) $current) ? 'checked="checked"' : '';
    if ($echo) {
        echo $result;
    }
    return $result;
}

function selected($selected, $current = true, bool $echo = true): string {
    $result = ((string) $selected === (string) $current) ? 'selected="selected"' : '';
    if ($echo) {
        echo $result;
    }
    return $result;
}

require_once DEVAPRESS_PLUGIN_DIR . 'includes/class-devapress-presets.php';
require_once DEVAPRESS_PLUGIN_DIR . 'includes/class-devapress-settings.php';
require_once DEVAPRESS_PLUGIN_DIR . 'includes/admin/class-admin-export-import.php';
require_once DEVAPRESS_PLUGIN_DIR . 'includes/frontend/class-dashboard-customizer.php';
require_once DEVAPRESS_PLUGIN_DIR . 'includes/frontend/class-login-customizer.php';
require_once DEVAPRESS_PLUGIN_DIR . 'includes/class-devapress-css-builder.php';
