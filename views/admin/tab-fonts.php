<?php
if (!defined('ABSPATH')) exit; // Prevent direct access

// Fetch saved font settings from WordPress options
$font_file           = get_option('devapress_font_file', '');
$font_size           = get_option('devapress_font_size', '14'); // Default font size: 14px
$font_color          = get_option('devapress_font_color', '#000000'); // Default black
$font_color_hover    = get_option('devapress_font_color_hover', '#2271b1'); // Hover color
$font_color_active   = get_option('devapress_font_color_active', '#2271b1'); // Active state color
$login_font_enable   = get_option('devapress_login_font_enable', '0'); // Default: disabled
$apply_globally      = get_option('devapress_apply_font_globally', 0); // Apply font to all admin pages
?>

<!-- Font Upload Section -->
<div class="devapress-setting-card">
    <h3>آپلود فونت دلخواه</h3>
    <div class="devapress-file-input-wrapper">
        <label class="devapress-file-input-label">انتخاب فایل</label>
        <input type="file" name="devapress_font_file_upload" accept=".ttf,.otf,.woff,.woff2"
               onchange="this.previousSibling.innerText = this.files[0]?.name || 'انتخاب فایل';">
    </div>
    <?php if ($font_file): ?>
        <!-- Display currently uploaded font file -->
        <span class="devapress-file-name"><?php echo esc_html(basename($font_file)); ?></span>
    <?php endif; ?>
</div>

<!-- Font Size Section -->
<div class="devapress-setting-card">
    <h3>سایز فونت داشبورد</h3>
    <input type="number" name="devapress_font_size" value="<?php echo esc_attr($font_size); ?>" class="devapress-input"> px
</div>

<!-- Font Color (Normal State) -->
<div class="devapress-setting-card">
    <h3>رنگ فونت داشبورد(در حالت عادی)</h3>
    <input type="color" name="devapress_font_color" value="<?php echo esc_attr($font_color); ?>" class="devapress-color-input">
</div>

<!-- Font Color (Hover State) -->
<div class="devapress-setting-card">
    <h3>رنگ فونت داشبورد(در حالت هاور)</h3>
    <input type="color" name="devapress_font_color_hover" value="<?php echo esc_attr($font_color_hover); ?>" class="devapress-color-input">
</div>

<!-- Font Color (Active State) -->
<div class="devapress-setting-card">
    <h3>رنگ فونت داشبورد(در حالت فعال)</h3>
    <input type="color" name="devapress_font_color_active" value="<?php echo esc_attr($font_color_active); ?>" class="devapress-color-input">
</div>

<!-- Apply Font Globally Section -->
<div class="devapress-setting-card">
    <h3>اعمال فونت روی صفحات داخلی پنل ادمین</h3>
    <select name="devapress_apply_font_globally">
        <option value="1" <?php selected($apply_globally, '1'); ?>>فعال</option>
        <option value="0" <?php selected($apply_globally, '0'); ?>>غیرفعال</option>
    </select>
    <p style="color:#666; font-size:13px; margin-top:5px;">
        در صورت فعال بودن، فونت انتخابی در داشبورد روی صفحات سایت هم اعمال می‌شود.
    </p>
</div>

<!-- Apply Font to Login Page Section -->
<div class="devapress-setting-card">
    <h3>اعمال فونت روی صفحات ورود</h3>
    <select name="devapress_login_font_enable">
        <option value="1" <?php selected($login_font_enable, '1'); ?>>فعال</option>
        <option value="0" <?php selected($login_font_enable, '0'); ?>>غیرفعال</option>
    </select>
    <p style="color:#666; font-size:13px; margin-top:5px;">
        در صورت فعال بودن، فونت انتخابی در داشبورد روی صفحه لاگین هم اعمال می‌شود.
    </p>
</div>
