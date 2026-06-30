<?php
/*
Plugin Name: devapress customizer
Description: پلاگینی برای شخصی‌سازی داشبورد و صفحه لاگین وردپرس (فونت، رنگ، کامپوننت‌ها)
Version: 1.0
Author: amir falahi
Text Domain: devapress-customizer
*/

if (!defined('ABSPATH')) {
    exit;
}

define('DEVAPRESS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('DEVAPRESS_PLUGIN_URL', plugin_dir_url(__FILE__));
define('DEVAPRESS_ASSETS_URL', DEVAPRESS_PLUGIN_URL . 'assets/');
define('DEVAPRESS_FONTS_URL', DEVAPRESS_PLUGIN_URL . 'assets/fonts');
define('DEVAPRESS_ASSETS_DIR', DEVAPRESS_PLUGIN_DIR . 'assets/');
define('DEVAPRESS_VIEW_DIR', DEVAPRESS_PLUGIN_DIR . 'views/admin/');
define('DEVAPRESS_CSS_URL', DEVAPRESS_ASSETS_URL . 'css/');
define('DEVAPRESS_JS_URL', DEVAPRESS_ASSETS_URL . 'js/');
define('DEVAPRESS_FONTS_DIR', DEVAPRESS_ASSETS_DIR . 'fonts/');

require_once DEVAPRESS_PLUGIN_DIR . 'class-core.php';

function devapress_init_plugin() {
    $core = new Devapress_Core();
    $core->init();
}
add_action('init', 'devapress_init_plugin');





