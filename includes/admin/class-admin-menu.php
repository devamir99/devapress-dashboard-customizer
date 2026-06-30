<?php
if (!defined('ABSPATH')) exit;

/**
 * Class Devapress_Admin_Menu
 *
 * Handles the registration of the plugin settings menu in the WordPress admin.
 * Adds a submenu under Settings and loads the settings page view.
 */
class Devapress_Admin_Menu {

    /**
     * Register the plugin submenu page under Settings
     *
     * - Page title: "Devapress Customizer"
     * - Menu title: "Devapress Customizer"
     * - Capability: manage_options (admin only)
     * - Menu slug: devapress-customizer
     * - Callback: render_settings_page
     */
    public function register_menu() {
        add_submenu_page(
            'options-general.php',       // Parent menu: Settings
            'Devapress Customizer',      // Page title
            'شخصی ساز دواپرس',      // Menu title
            'manage_options',            // Capability
            'devapress-customizer',      // Menu slug
            [$this, 'render_settings_page'] // Callback to render the page
        );
    }

    /**
     * Render the settings page
     *
     * Includes the PHP view file for the plugin settings page.
     * Displays an error message if the view file does not exist.
     *
     * @return string|void Returns the path of the view file if found
     */
    public function render_settings_page() {
        $view_file = DEVAPRESS_VIEW_DIR . 'settings-page.php';

        if (file_exists($view_file)) {
            include $view_file;
        } else {
            echo '<p>Settings view file not found!</p>';
        }

        return $view_file;
    }
}
