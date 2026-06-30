<?php
if (!defined('ABSPATH')) exit;

class Devapress_Admin_Settings
{
    public function __construct()
    {
        // Register all settings and handle reset actions
        add_action('admin_init', [$this, 'register_settings']);
        add_action('admin_init', [$this, 'handle_reset_font']);
        add_action('admin_init', [$this, 'handle_reset_colors']);
        add_action('admin_init', [$this, 'handle_reset_login']);
    }

    public function register_settings()
    {
        // -----------------------------
        // Fonts
        // -----------------------------
        register_setting('devapress_settings_group', 'devapress_font');
        register_setting('devapress_settings_group', 'devapress_font_file', [
            'sanitize_callback' => [$this, 'handle_font_upload']
        ]);

        // Login background & logo
        register_setting('devapress_settings_group', 'devapress_bg_login_file', [
            'sanitize_callback' => [$this, 'handle_bg_login_upload']
        ]);
        register_setting('devapress_settings_group', 'devapress_login_logo', [
            'sanitize_callback' => [$this, 'handle_login_logo_upload']
        ]);
        register_setting('devapress_settings_group', 'devapress_bg_login_color');
        register_setting('devapress_settings_group', 'devapress_bg_login_gradient_color1');
        register_setting('devapress_settings_group', 'devapress_bg_login_gradient_color2');
        register_setting('devapress_settings_group', 'devapress_bg_login_gradient_type');
        register_setting('devapress_settings_group', 'devapress_bg_login_gradient_enable');
        register_setting('devapress_settings_group', 'devapress_bg_login_gradient_opacity', [
            'sanitize_callback' => 'absint'
        ]);
        register_setting('devapress_settings_group', 'devapress_bg_login_size');
        register_setting('devapress_settings_group', 'devapress_login_form_bg');
        register_setting('devapress_settings_group', 'devapress_login_form_bg2');
        register_setting('devapress_settings_group', 'devapress_login_form_glass');
        register_setting('devapress_settings_group', 'devapress_login_form_radius');
        register_setting('devapress_settings_group', 'devapress_login_input_radius');

        // Login button styles
        register_setting('devapress_settings_group', 'devapress_login_btn_bg');
        register_setting('devapress_settings_group', 'devapress_login_btn_color');
        register_setting('devapress_settings_group', 'devapress_login_btn_radius');
        register_setting('devapress_settings_group', 'devapress_login_btn_hover_bg');
        register_setting('devapress_settings_group', 'devapress_login_btn_hover_color');
        register_setting('devapress_settings_group', 'devapress_login_font_enable');

        // Dashboard font and colors
        register_setting('devapress_settings_group', 'devapress_font_size');
        register_setting('devapress_settings_group', 'devapress_font_color');
        register_setting('devapress_settings_group', 'devapress_font_color_hover');
        register_setting('devapress_settings_group', 'devapress_font_color_active');
        register_setting('devapress_settings_group', 'devapress_apply_font_globally');
        register_setting('devapress_settings_group', 'devapress_icon_color');
        register_setting('devapress_settings_group', 'devapress_icon_hover_color');
        register_setting('devapress_settings_group', 'devapress_menu_color');
        register_setting('devapress_settings_group', 'devapress_menu_hover_color');
        register_setting('devapress_settings_group', 'devapress_menu_active_color');
        register_setting('devapress_settings_group', 'devapress_icon_active_color');
        register_setting('devapress_settings_group', 'devapress_login_label_color');

        // -----------------------------
        // Add settings sections and fields
        // -----------------------------
        add_settings_section('devapress_font_section', 'Font Settings', '__return_false', 'devapress-customizer');
        add_settings_field('devapress_font_field', 'Dashboard Font (Text)', [$this, 'render_font_field'], 'devapress-customizer', 'devapress_font_section');
        add_settings_field('devapress_bg_login_upload_field', 'Upload Login Background', [$this, 'devapress_bg_login_file'], 'devapress-customizer', 'devapress_font_section');
        add_settings_field('devapress_bg_login_color_field', 'Login Background Color', [$this, 'render_bg_login_color_field'], 'devapress-customizer', 'devapress_font_section');
        add_settings_field('devapress_bg_login_gradient_color1', 'Gradient Color 1', [$this, 'render_bg_login_gradient_color1'], 'devapress-customizer', 'devapress_font_section');
        add_settings_field('devapress_bg_login_gradient_color2', 'Gradient Color 2', [$this, 'render_bg_login_gradient_color2'], 'devapress-customizer', 'devapress_font_section');
        add_settings_field('devapress_bg_login_gradient_type', 'Gradient Type', [$this, 'render_bg_login_gradient_type'], 'devapress-customizer', 'devapress_font_section');
        add_settings_field('devapress_bg_login_size_field', 'Background Size', [$this, 'render_bg_login_size_field'], 'devapress-customizer', 'devapress_font_section');
        add_settings_field('devapress_login_form_bg_field', 'Login Form Background', [$this, 'render_login_form_bg_field'], 'devapress-customizer', 'devapress_font_section');
        add_settings_field('devapress_login_form_bg2', 'Secondary Form Background (Gradient)', [$this, 'color_picker_callback'], 'devapress-customizer', 'devapress_login_form_section', ['label_for' => 'devapress_login_form_bg2']);
        add_settings_field('devapress_login_form_glass', 'Enable Glass Form Background', [$this, 'checkbox_callback'], 'devapress-customizer', 'devapress_login_form_section', ['label_for' => 'devapress_login_form_glass']);
        add_settings_field('devapress_login_form_radius', 'Form Corner Radius (px)', [$this, 'render_login_form_radius'], 'devapress-customizer', 'devapress_font_section');
        add_settings_field('devapress_login_input_radius', 'Input Corner Radius (px)', [$this, 'render_login_input_form_radius'], 'devapress-customizer', 'devapress_font_section');

        // Button styles fields
        add_settings_field('devapress_login_btn_bg', 'Button Background Color', [$this, 'render_color_field_generic'], 'devapress-customizer', 'devapress_font_section', ['label_for' => 'devapress_login_btn_bg']);
        add_settings_field('devapress_login_btn_color', 'Button Text Color', [$this, 'render_color_field_generic'], 'devapress-customizer', 'devapress_font_section', ['label_for' => 'devapress_login_btn_color']);
        add_settings_field('devapress_login_btn_radius', 'Button Corner Radius (px)', [$this, 'render_number_field_generic'], 'devapress-customizer', 'devapress_font_section', ['label_for' => 'devapress_login_btn_radius']);
        add_settings_field('devapress_login_btn_hover_bg', 'Button Hover Background', [$this, 'render_color_field_generic'], 'devapress-customizer', 'devapress_font_section', ['label_for' => 'devapress_login_btn_hover_bg']);
        add_settings_field('devapress_login_btn_hover_color', 'Button Hover Text Color', [$this, 'render_color_field_generic'], 'devapress-customizer', 'devapress_font_section', ['label_for' => 'devapress_login_btn_hover_color']);
        add_settings_field('devapress_login_label_color', 'Login Form Label Color', [$this, 'render_login_label_color_field'], 'devapress-customizer', 'devapress_font_section');

        add_settings_field('devapress_login_font_enable', 'Apply Font on Login Page', 'devapress_apply_login_font_callback', 'devapress-customizer', 'devapress_font_section');
        add_settings_field('devapress_apply_font_globally', 'Apply Font Globally', [$this, 'render_apply_font_globally_field'], 'devapress-customizer', 'devapress_font_section');

        // Logo & font size/color
        add_settings_field('devapress_login_logo_upload_field', 'Upload Login Logo', [$this, 'devapress_render_login_logo_field'], 'devapress-customizer', 'devapress_font_section');
        add_settings_field('devapress_font_size_field', 'Dashboard Font Size (px)', [$this, 'render_font_size_field'], 'devapress-customizer', 'devapress_font_section');
        add_settings_field('devapress_font_color_field', 'Dashboard Font Color', [$this, 'render_color_field'], 'devapress-customizer', 'devapress_font_section');
        add_settings_field('devapress_font_color_hover_field', 'Dashboard Font Hover Color', [$this, 'render_font_color_hover_field'], 'devapress-customizer', 'devapress_font_section');
        add_settings_field('devapress_font_color_active', 'Active Dashboard Icon Color', [$this, 'render_font_color_active_field'], 'devapress-customizer', 'devapress_font_section');
        add_settings_field('devapress_icon_color', 'Dashboard Icon Color', [$this, 'render_icon_color_field'], 'devapress-customizer', 'devapress_font_section');
        add_settings_field('devapress_icon_hover_color', 'Dashboard Icon Hover Color', [$this, 'render_icon_hover_color_field'], 'devapress-customizer', 'devapress_font_section');
        add_settings_field('devapress_menu_color', 'Dashboard Menu Background', [$this, 'render_background_color_field'], 'devapress-customizer', 'devapress_font_section');
        add_settings_field('devapress_menu_hove_color', 'Dashboard Menu Hover Background', [$this, 'render_background_color_hover_field'], 'devapress-customizer', 'devapress_font_section');
        add_settings_field('devapress_menu_active_color', 'Active Dashboard Menu Background', [$this, 'render_background_color_active_field'], 'devapress-customizer', 'devapress_font_section');
        add_settings_field('devapress_icon_active_color', 'Active Dashboard Icon Color', [$this, 'render_icon_active_color_field'], 'devapress-customizer', 'devapress_font_section');
    }



    public function render_font_field()
    {
        $value = get_option('devapress_font', '');
        echo '<input type="text" name="devapress_font" value="' . esc_attr($value) . '" placeholder="مثلا IRANSans">';
    }

   
    public function render_apply_font_globally_field() {
        $value = get_option('devapress_apply_font_globally', 0);
        echo '<label>';
        echo '<input type="checkbox" name="devapress_apply_font_globally" value="1" ' . checked(1, $value, false) . '> ';
        echo 'اگر فعال باشد، فونت انتخابی روی کل داشبورد اعمال می‌شود';
        echo '</label>';
    }

    public function devapress_bg_login_file()
    {
        include DEVAPRESS_PLUGIN_DIR . 'views/admin/tab-login.php';
    }

    public function render_bg_login_size_field() {
        $value = get_option('devapress_bg_login_size', 'cover');
        ?>
        <select name="devapress_bg_login_size">
            <option value="cover" <?php selected($value, 'cover'); ?>>Cover</option>
            <option value="contain" <?php selected($value, 'contain'); ?>>Contain</option>
            <option value="auto" <?php selected($value, 'auto'); ?>>Auto</option>
        </select>
        <?php
    }

    public function render_login_form_bg_field() {
        $color = get_option('devapress_login_form_bg', '#ffffff');
        echo '<input type="color" name="devapress_login_form_bg" value="' . esc_attr($color) . '">';
    }

    public function color_picker_callback($args) {
        $option = get_option($args['label_for'], '');
        echo '<input type="text" id="' . esc_attr($args['label_for']) . '" 
           name="' . esc_attr($args['label_for']) . '" 
           value="' . esc_attr($option) . '" 
           class="my-color-field" data-default-color="#ffffff" />';
    }

    public function checkbox_callback($args) {
        $option = get_option($args['label_for'], 0);
        $checked = checked(1, $option, false);
        echo '<input type="checkbox" id="' . esc_attr($args['label_for']) . '" 
           name="' . esc_attr($args['label_for']) . '" value="1" ' . $checked . ' />';
    }

    public function render_login_form_radius()
    {
        $value = get_option('devapress_login_form_radius', '14');
        echo '<input type="number" name="devapress_login_form_radius" value="' . esc_attr($value) . '" style="width:80px;"> px';
    }

    public function render_login_input_form_radius()
    {
        $value = get_option('devapress_login_input_radius', '14');
        echo '<input type="number" name="devapress_login_input_radius" value="' . esc_attr($value) . '" style="width:80px;"> px';
    }


    public function render_color_field_generic($args) {
        $option = get_option($args['label_for'], '#2271b1');
        echo '<input type="color" id="' . esc_attr($args['label_for']) . '" 
           name="' . esc_attr($args['label_for']) . '" 
           value="' . esc_attr($option) . '">';
    }

    public function render_number_field_generic($args) {
        $option = get_option($args['label_for'], '4');
        echo '<input type="number" id="' . esc_attr($args['label_for']) . '" 
           name="' . esc_attr($args['label_for']) . '" 
           value="' . esc_attr($option) . '" 
           style="width:80px;"> px';
    }

    public function render_login_label_color_field() {
        $value = get_option('devapress_login_label_color', '#333333');
        echo '<input type="color" name="devapress_login_label_color" value="' . esc_attr($value) . '">';
    }

    public function devapress_apply_login_font_callback() {
        $value = get_option('devapress_login_font_enable', '0');
        ?>
        <label>
            <input type="checkbox" name="devapress_login_font_enable" value="1" <?php checked(1, $value); ?>>
            فونت انتخابی روی صفحه لاگین اعمال شود
        </label>
        <?php
    }
    public function render_font_size_field()
    {
        $value = get_option('devapress_font_size', '14');
        echo '<input type="number" name="devapress_font_size" value="' . esc_attr($value) . '" style="width:80px;"> px';
    }

    public function render_color_field()
    {
        $value = get_option('devapress_font_color', '#000000');
        echo '<input type="color" name="devapress_font_color" value="' . esc_attr($value) . '">';
    }

    public function handle_font_upload($old_value) {
        if (!empty($_FILES['devapress_font_file_upload']['name'])) {
            $uploaded = $_FILES['devapress_font_file_upload'];
            $upload_dir = wp_upload_dir()['basedir'] . '/devapress-fonts/';
            $upload_url = wp_upload_dir()['baseurl'] . '/devapress-fonts/';
            if (!file_exists($upload_dir)) wp_mkdir_p($upload_dir);

            $filename = sanitize_file_name($uploaded['name']);
            $target = $upload_dir . $filename;

            if (move_uploaded_file($uploaded['tmp_name'], $target)) {
                return $upload_url . $filename;
            }
        }
        return get_option('devapress_font_file', $old_value);
    }

    public function handle_bg_login_upload($old_value) {
        if (!empty($_FILES['devapress_bg_login_file']['name'])) {
            $attachment_id = media_handle_upload('devapress_bg_login_file', 0);

            if (!is_wp_error($attachment_id)) {
                return $attachment_id; 
            }
        }

        return $old_value;
    }

    public function render_bg_login_color_field() {
        $color = get_option('devapress_bg_login_color', '#ffffff');
        echo '<input type="color" name="devapress_bg_login_color" value="' . esc_attr($color) . '">';
    }

    public function render_bg_login_gradient_color1() {
        $color = get_option('devapress_bg_login_gradient_color1', '#ff0000');
        echo '<input type="color" name="devapress_bg_login_gradient_color1" value="' . esc_attr($color) . '">';
    }

    public function render_bg_login_gradient_color2() {
        $color = get_option('devapress_bg_login_gradient_color2', '#0000ff');
        echo '<input type="color" name="devapress_bg_login_gradient_color2" value="' . esc_attr($color) . '">';
    }

    public function render_bg_login_gradient_type() {
        $value = get_option('devapress_bg_login_gradient_type', 'linear');
      
    }

    public function handle_login_logo_upload($old_value) {
        if (!empty($_FILES['devapress_login_logo']['name'])) {
            $attachment_id = media_handle_upload('devapress_login_logo', 0);

            if (!is_wp_error($attachment_id)) {
                return $attachment_id; // ذخیره ID تصویر
            }
        }

        return $old_value;
    }

    public function render_font_color_hover_field()
    {
        $value = get_option('devapress_font_color_hover', '#2271b1');
        echo '<input type="color" name="devapress_font_color_hover" value="' . esc_attr($value) . '">';
    }

    public function render_font_color_active_field()
    {
        $value = get_option('devapress_font_color_active', '#2271b1');
        echo '<input type="color" name="devapress_font_color_active" value="' . esc_attr($value) . '">';
    }

    public function render_icon_color_field()
    {
        $value = get_option('devapress_icon_color', '#9ca2a7');
        echo '<input type="color" name="devapress_icon_color" value="' . esc_attr($value) . '">';
    }

    public function render_icon_hover_color_field()
    {
        $value = get_option('devapress_icon_hover_color', '#9ca2a7');
        echo '<input type="color" name="devapress_icon_hover_color" value="' . esc_attr($value) . '">';
    }

    public function render_background_color_field()
    {
        $value = get_option('devapress_menu_color', '#1d2327');
        echo '<input type="color" name="devapress_menu_color" value="' . esc_attr($value) . '">';
    }

    public function render_background_color_hover_field()
    {
        $value = get_option('devapress_menu_hover_color', '#1d2327');
        echo '<input type="color" name="devapress_menu_hover_color" value="' . esc_attr($value) . '">';
    }

    public function render_background_color_active_field()
    {
        $value = get_option('devapress_menu_active_color', '#9ca2a7');
        echo '<input type="color" name="devapress_menu_active_color" value="' . esc_attr($value) . '">';
    }

    public function render_icon_active_color_field()
    {
        $value = get_option('devapress_icon_active_color', '#9ca2a7');
        echo '<input type="color" name="devapress_icon_active_color" value="' . esc_attr($value) . '">';
    }

    
    public function handle_reset_font()
{
    if (isset($_GET['action']) && $_GET['action'] === 'reset_devapress_font') {
        check_admin_referer('devapress_reset_font'); // امنیت بهتر

        // حذف گزینه‌ها
        delete_option('devapress_font_file');
        delete_option('devapress_font_size');
        delete_option('devapress_font_color');
        delete_option('devapress_font_color_hover');
        delete_option('devapress_font_color_active');
        delete_option('devapress_apply_font_globally');

        // 👇 ست کردن مقادیر پیش‌فرض وردپرس
        update_option('devapress_font_size', '14px');
        update_option('devapress_font_color', '#FFFFFF');
        update_option('devapress_font_color_hover', '#2271b1');   // رنگ لینک‌ها در وردپرس
        update_option('devapress_font_color_active', '#FFFFFF');  // رنگ لینک فعال
        update_option('devapress_apply_font_globally', false);

        wp_redirect(admin_url('admin.php?page=devapress-customizer&reset=font'));
        exit;
    }
}


    public function handle_reset_colors()
    {
        if (isset($_GET['action']) && $_GET['action'] === 'reset_devapress_colors') {
            delete_option('devapress_icon_color');
            delete_option('devapress_icon_hover_color');
            delete_option('devapress_icon_active_color');
            delete_option('devapress_menu_color');
            delete_option('devapress_menu_hover_color');
            delete_option('devapress_menu_active_color');

            update_option('devapress_font_size', '14px'); 
            update_option('devapress_menu_active_color', '#2271b1'); 
            update_option('devapress_font_color_active', '#FFFFFF'); 
            update_option('devapress_font_color', '#FFFFFF'); 
            update_option('devapress_bg_color', '#f1f1f1'); 
            update_option('devapress_label_color', '#000000'); 
            update_option('devapress_border_radius', '4px'); 
            update_option('devapress_button_normal', '#2271b1'); 
            update_option('devapress_button_hover', '#135e96');

            wp_redirect(admin_url('admin.php?page=devapress-customizer&reset=colors'));
            exit;
        }
    }

    
public function handle_reset_login()
{
    if (isset($_GET['action']) && $_GET['action'] === 'reset_devapress_login') {

        // 🔐 Nonce validation
        if (!isset($_GET['_wpnonce']) || !wp_verify_nonce($_GET['_wpnonce'], 'devapress_reset_login')) {
            wp_die('The link is not valid or has expired.');
        }

        // ❌ Remove saved options
        delete_option('devapress_bg_login_file');
        delete_option('devapress_bg_login_color');
        delete_option('devapress_bg_login_gradient_color1');
        delete_option('devapress_bg_login_gradient_color2');
        delete_option('devapress_bg_login_gradient_type');
        delete_option('devapress_bg_login_gradient_enable');
        delete_option('devapress_bg_login_gradient_opacity');
        delete_option('devapress_bg_login_size');
        delete_option('devapress_login_form_bg');
        delete_option('devapress_login_form_bg2');
        delete_option('devapress_login_form_glass');
        delete_option('devapress_login_form_radius');
        delete_option('devapress_login_input_radius');
        delete_option('devapress_login_btn_bg');
        delete_option('devapress_login_btn_color');
        delete_option('devapress_login_btn_radius');
        delete_option('devapress_login_btn_hover_bg');
        delete_option('devapress_login_btn_hover_color');
        delete_option('devapress_login_label_color');
        delete_option('devapress_login_logo');
        delete_option('devapress_login_font_enable');

        // ✅ Restore default WordPress login styles
        update_option('devapress_bg_login_color', '#f1f1f1');   // default wp-login background
        update_option('devapress_login_form_bg', '#ffffff');   // form white background
        update_option('devapress_login_form_bg2', '#ffffff');   // form white background second color
        update_option('devapress_login_form_radius', '4px');
        update_option('devapress_login_input_radius', '4px');
        update_option('devapress_login_btn_bg', '#2271b1');    // wp button blue
        update_option('devapress_login_btn_color', '#ffffff'); // white text
        update_option('devapress_login_btn_hover_bg', '#135e96');
        update_option('devapress_login_btn_hover_color', '#ffffff');
        update_option('devapress_login_label_color', '#000000'); // black labels
        update_option('devapress_login_font_enable', false);
        // 🔁 Redirect back with message
        wp_redirect(admin_url('admin.php?page=devapress-customizer&reset=login'));
        exit;
    }
}


}
