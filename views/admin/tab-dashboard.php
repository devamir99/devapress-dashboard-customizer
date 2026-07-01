<?php
if (!defined('ABSPATH')) {
    exit;
}

$all       = Devapress_Settings::get_all();
$dashboard = $all['dashboard'];
$resolved  = Devapress_Settings::get_resolved('dashboard');
$overrides = $dashboard['overrides'] ?? [];

$val = static function ($key, $default = '') use ($resolved, $overrides) {
    if (isset($overrides[$key]) && $overrides[$key] !== '') {
        return $overrides[$key];
    }
    if (isset($resolved[$key]) && $resolved[$key] !== '') {
        return $resolved[$key];
    }
    return $default;
};
?>

<div class="devapress-setting-card">
    <h2>انتخاب طرح منوی داشبورد</h2>
    <?php
    $section   = 'dashboard';
    $name_attr = 'devapress_settings[dashboard][preset]';
    $current   = $dashboard['preset'] ?? 'none';
    include DEVAPRESS_PLUGIN_DIR . 'views/admin/partials/preset-cards.php';
    ?>
</div>

<div class="devapress-customize-panel" data-section="dashboard" <?php echo ($dashboard['preset'] ?? 'none') === 'none' ? 'style="display:none;"' : ''; ?>>
    <h2>سفارشی‌سازی داشبورد</h2>
    <p class="description">فیلدهای خالی از مقادیر طرح انتخاب‌شده استفاده می‌کنند.</p>

    <div class="devapress-setting-card">
        <h3>آپلود فونت سفارشی</h3>
        <div class="devapress-file-input-wrapper">
            <label class="devapress-file-input-label">انتخاب فایل</label>
            <input type="file" name="devapress_font_file_upload" accept=".ttf,.otf,.woff,.woff2"
                   onchange="this.previousElementSibling.innerText = this.files[0]?.name || 'انتخاب فایل';">
        </div>
        <?php if (!empty($dashboard['font_file'])) : ?>
            <p class="devapress-file-name">فونت فعلی: <?php echo esc_html(basename($dashboard['font_file'])); ?></p>
            <input type="hidden" name="devapress_settings[dashboard][font_file]" value="<?php echo esc_attr($dashboard['font_file']); ?>">
        <?php endif; ?>
    </div>

    <div class="devapress-settings-grid">
        <div class="devapress-setting-card">
            <h3>سایز فونت</h3>
            <input type="number" name="devapress_settings[dashboard][overrides][font_size]"
                   value="<?php echo esc_attr($val('font_size', '14')); ?>" class="devapress-input" min="10" max="24"
                   data-dp-preview="font_size" data-dp-section="dashboard"> px
        </div>

        <div class="devapress-setting-card">
            <h3>رنگ متن منو (عادی)</h3>
            <input type="color" name="devapress_settings[dashboard][overrides][font_color]"
                   value="<?php echo esc_attr($val('font_color', '#f0f0f1')); ?>" data-dp-preview="font_color" data-dp-section="dashboard">
        </div>

        <div class="devapress-setting-card">
            <h3>رنگ متن منو (هاور)</h3>
            <input type="color" name="devapress_settings[dashboard][overrides][font_color_hover]"
                   value="<?php echo esc_attr($val('font_color_hover', '#72aee6')); ?>" data-dp-preview="font_color_hover" data-dp-section="dashboard">
        </div>

        <div class="devapress-setting-card">
            <h3>رنگ متن منو (فعال)</h3>
            <input type="color" name="devapress_settings[dashboard][overrides][font_color_active]"
                   value="<?php echo esc_attr($val('font_color_active', '#ffffff')); ?>" data-dp-preview="font_color_active" data-dp-section="dashboard">
        </div>

        <div class="devapress-setting-card">
            <h3>پس‌زمینه منو (عادی)</h3>
            <input type="color" name="devapress_settings[dashboard][overrides][menu_color]"
                   value="<?php echo esc_attr($val('menu_color', '#1d2327')); ?>" data-dp-preview="menu_color" data-dp-section="dashboard">
        </div>

        <div class="devapress-setting-card">
            <h3>پس‌زمینه منو (هاور)</h3>
            <input type="color" name="devapress_settings[dashboard][overrides][menu_hover_color]"
                   value="<?php echo esc_attr($val('menu_hover_color', '#2c3338')); ?>" data-dp-preview="menu_hover_color" data-dp-section="dashboard">
        </div>

        <div class="devapress-setting-card">
            <h3>پس‌زمینه منو (فعال)</h3>
            <input type="color" name="devapress_settings[dashboard][overrides][menu_active_color]"
                   value="<?php echo esc_attr($val('menu_active_color', '#2271b1')); ?>" data-dp-preview="menu_active_color" data-dp-section="dashboard">
        </div>

        <div class="devapress-setting-card">
            <h3>رنگ آیکن (عادی)</h3>
            <input type="color" name="devapress_settings[dashboard][overrides][icon_color]"
                   value="<?php echo esc_attr($val('icon_color', '#a7aaad')); ?>" data-dp-preview="icon_color" data-dp-section="dashboard">
        </div>

        <div class="devapress-setting-card">
            <h3>رنگ آیکن (هاور)</h3>
            <input type="color" name="devapress_settings[dashboard][overrides][icon_hover_color]"
                   value="<?php echo esc_attr($val('icon_hover_color', '#72aee6')); ?>" data-dp-preview="icon_hover_color" data-dp-section="dashboard">
        </div>

        <div class="devapress-setting-card">
            <h3>رنگ آیکن (فعال)</h3>
            <input type="color" name="devapress_settings[dashboard][overrides][icon_active_color]"
                   value="<?php echo esc_attr($val('icon_active_color', '#ffffff')); ?>" data-dp-preview="icon_active_color" data-dp-section="dashboard">
        </div>
    </div>

    <div class="devapress-setting-card">
        <h3>اعمال فونت روی کل داشبورد</h3>
        <label>
            <input type="checkbox" name="devapress_settings[dashboard][overrides][apply_font_globally]" value="1"
                <?php checked(!empty($val('apply_font_globally', false))); ?>>
            فونت روی محتوای داخلی صفحات ادمین هم اعمال شود
        </label>
    </div>

    <div class="devapress-setting-card">
        <h3>اعمال فونت روی صفحه لاگین</h3>
        <label>
            <input type="checkbox" name="devapress_settings[dashboard][login_font_enable]" value="1"
                <?php checked(!empty($dashboard['login_font_enable'])); ?>>
            همان فونت داشبورد روی صفحه ورود هم اعمال شود
        </label>
    </div>
</div>
