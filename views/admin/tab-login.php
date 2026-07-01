<?php
if (!defined('ABSPATH')) {
    exit;
}

$all    = Devapress_Settings::get_all();
$login  = $all['login'];
$resolved  = Devapress_Settings::get_resolved('login');
$overrides = $login['overrides'] ?? [];

$val = static function ($key, $default = '') use ($resolved, $overrides) {
    if (isset($overrides[$key]) && $overrides[$key] !== '' && $overrides[$key] !== false) {
        return $overrides[$key];
    }
    if (isset($resolved[$key]) && $resolved[$key] !== '' && $resolved[$key] !== false) {
        return $resolved[$key];
    }
    return $default;
};

$bg_id  = $login['bg_image_id'] ?? '';
$bg_url = $bg_id ? wp_get_attachment_url($bg_id) : '';
$logo_id  = $login['logo_id'] ?? '';
$logo_url = $logo_id ? wp_get_attachment_url($logo_id) : '';
?>

<div class="devapress-setting-card">
    <h2>انتخاب طرح صفحه لاگین</h2>
    <?php
    $section   = 'login';
    $name_attr = 'devapress_settings[login][preset]';
    $current   = $login['preset'] ?? 'none';
    include DEVAPRESS_PLUGIN_DIR . 'views/admin/partials/preset-cards.php';
    ?>
</div>

<div class="devapress-customize-panel" data-section="login" <?php echo ($login['preset'] ?? 'none') === 'none' ? 'style="display:none;"' : ''; ?>>
    <h2>سفارشی‌سازی صفحه لاگین</h2>

    <div class="devapress-setting-card">
        <h3>تصویر پس‌زمینه</h3>
        <input type="hidden" id="devapress_bg_login_file" name="devapress_settings[login][bg_image_id]" value="<?php echo esc_attr($bg_id); ?>">
        <button type="button" class="button" id="devapress_bg_login_upload_btn">
            <?php echo $bg_url ? 'تغییر تصویر' : 'انتخاب تصویر'; ?>
        </button>
        <?php if ($bg_url) : ?>
            <div class="devapress-preview" id="devapress-bg-preview">
                <img src="<?php echo esc_url($bg_url); ?>" alt="">
                <button type="button" class="button devapress-remove-media" data-target="devapress_bg_login_file" data-preview="devapress-bg-preview">حذف</button>
            </div>
        <?php endif; ?>
    </div>

    <div class="devapress-setting-card">
        <h3>لوگوی صفحه لاگین</h3>
        <input type="hidden" id="devapress_login_logo" name="devapress_settings[login][logo_id]" value="<?php echo esc_attr($logo_id); ?>">
        <button type="button" class="button" id="devapress_login_logo_upload_btn">
            <?php echo $logo_url ? 'تغییر لوگو' : 'انتخاب لوگو'; ?>
        </button>
        <?php if ($logo_url) : ?>
            <div class="devapress-preview" id="devapress-logo-preview">
                <img src="<?php echo esc_url($logo_url); ?>" alt="">
                <button type="button" class="button devapress-remove-media" data-target="devapress_login_logo" data-preview="devapress-logo-preview">حذف</button>
            </div>
        <?php endif; ?>
    </div>

    <div class="devapress-settings-grid">
        <div class="devapress-setting-card">
            <h3>اندازه پس‌زمینه</h3>
            <select name="devapress_settings[login][overrides][bg_size]">
                <?php $bg_size = $val('bg_size', 'cover'); ?>
                <option value="cover" <?php selected($bg_size, 'cover'); ?>>Cover</option>
                <option value="contain" <?php selected($bg_size, 'contain'); ?>>Contain</option>
                <option value="auto" <?php selected($bg_size, 'auto'); ?>>Auto</option>
            </select>
        </div>

        <div class="devapress-setting-card">
            <h3>گرادیانت پس‌زمینه</h3>
            <label>
                <input type="checkbox" name="devapress_settings[login][overrides][bg_gradient_enable]" value="1"
                    <?php checked(!empty($val('bg_gradient_enable', false))); ?>>
                فعال
            </label>
        </div>

        <div class="devapress-setting-card">
            <h3>شفافیت گرادیانت (%)</h3>
            <input type="number" name="devapress_settings[login][overrides][bg_gradient_opacity]"
                   value="<?php echo esc_attr($val('bg_gradient_opacity', '100')); ?>" min="0" max="100" class="devapress-input">
        </div>

        <div class="devapress-setting-card">
            <h3>رنگ پس‌زمینه ساده</h3>
            <input type="color" name="devapress_settings[login][overrides][bg_color]"
                   value="<?php echo esc_attr($val('bg_color', '#f0f0f1')); ?>">
        </div>

        <div class="devapress-setting-card">
            <h3>رنگ گرادیانت ۱</h3>
            <input type="color" name="devapress_settings[login][overrides][bg_gradient_color1]"
                   value="<?php echo esc_attr($val('bg_gradient_color1', '#667eea')); ?>">
        </div>

        <div class="devapress-setting-card">
            <h3>رنگ گرادیانت ۲</h3>
            <input type="color" name="devapress_settings[login][overrides][bg_gradient_color2]"
                   value="<?php echo esc_attr($val('bg_gradient_color2', '#764ba2')); ?>">
        </div>

        <div class="devapress-setting-card">
            <h3>نوع گرادیانت</h3>
            <?php $grad_type = $val('bg_gradient_type', 'linear'); ?>
            <select name="devapress_settings[login][overrides][bg_gradient_type]">
                <option value="linear" <?php selected($grad_type, 'linear'); ?>>خطی</option>
                <option value="radial" <?php selected($grad_type, 'radial'); ?>>دایره‌ای</option>
                <option value="conic" <?php selected($grad_type, 'conic'); ?>>مخروطی</option>
            </select>
        </div>

        <div class="devapress-setting-card">
            <h3>پس‌زمینه فرم</h3>
            <input type="color" name="devapress_settings[login][overrides][login_form_bg]"
                   value="<?php echo esc_attr($val('login_form_bg', '#ffffff')); ?>">
            <input type="color" name="devapress_settings[login][overrides][login_form_bg2]"
                   value="<?php echo esc_attr($val('login_form_bg2', '')); ?>" title="رنگ دوم (گرادیانت فرم)">
        </div>

        <div class="devapress-setting-card">
            <h3>افکت شیشه‌ای (Glass)</h3>
            <label>
                <input type="checkbox" name="devapress_settings[login][overrides][login_form_glass]" value="1"
                    <?php checked(!empty($val('login_form_glass', false))); ?>>
                فعال
            </label>
        </div>

        <div class="devapress-setting-card">
            <h3>گردی فرم (px)</h3>
            <input type="number" name="devapress_settings[login][overrides][login_form_radius]"
                   value="<?php echo esc_attr($val('login_form_radius', '8')); ?>" class="devapress-input" min="0" max="50">
        </div>

        <div class="devapress-setting-card">
            <h3>گردی فیلدها (px)</h3>
            <input type="number" name="devapress_settings[login][overrides][login_input_radius]"
                   value="<?php echo esc_attr($val('login_input_radius', '6')); ?>" class="devapress-input" min="0" max="50">
        </div>

        <div class="devapress-setting-card">
            <h3>دکمه — پس‌زمینه</h3>
            <input type="color" name="devapress_settings[login][overrides][login_btn_bg]"
                   value="<?php echo esc_attr($val('login_btn_bg', '#2271b1')); ?>">
        </div>

        <div class="devapress-setting-card">
            <h3>دکمه — متن</h3>
            <input type="color" name="devapress_settings[login][overrides][login_btn_color]"
                   value="<?php echo esc_attr($val('login_btn_color', '#ffffff')); ?>">
        </div>

        <div class="devapress-setting-card">
            <h3>دکمه — گردی (px)</h3>
            <input type="number" name="devapress_settings[login][overrides][login_btn_radius]"
                   value="<?php echo esc_attr($val('login_btn_radius', '4')); ?>" class="devapress-input" min="0" max="50">
        </div>

        <div class="devapress-setting-card">
            <h3>دکمه — هاور پس‌زمینه</h3>
            <input type="color" name="devapress_settings[login][overrides][login_btn_hover_bg]"
                   value="<?php echo esc_attr($val('login_btn_hover_bg', '#135e96')); ?>">
        </div>

        <div class="devapress-setting-card">
            <h3>دکمه — هاور متن</h3>
            <input type="color" name="devapress_settings[login][overrides][login_btn_hover_color]"
                   value="<?php echo esc_attr($val('login_btn_hover_color', '#ffffff')); ?>">
        </div>

        <div class="devapress-setting-card">
            <h3>رنگ لیبل و لینک‌ها</h3>
            <input type="color" name="devapress_settings[login][overrides][login_label_color]"
                   value="<?php echo esc_attr($val('login_label_color', '#3c434a')); ?>">
        </div>
    </div>
</div>
