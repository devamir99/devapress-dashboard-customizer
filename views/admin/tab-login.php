<?php
$bg_id      = get_option('devapress_bg_login_file', '');
$bg_url     = $bg_id ? wp_get_attachment_url($bg_id) : '';
$logo_id    = get_option('devapress_login_logo', '');
$logo_url   = $logo_id ? wp_get_attachment_url($logo_id) : '';
$bg_color   = get_option('devapress_bg_login_color', '#ffffff');
$grad_color1 = get_option('devapress_bg_login_gradient_color1', '');
$grad_color2 = get_option('devapress_bg_login_gradient_color2', '');
$grad_type   = get_option('devapress_bg_login_gradient_type', 'linear');
$anim       = get_option('devapress_login_bg_animation', 'off');
$bg_size = get_option('devapress_bg_login_size', 'cover');
$gradient_enable = get_option('devapress_bg_login_gradient_enable', '1');
$grad_opacity = get_option('devapress_bg_login_gradient_opacity', '100'); // پیش‌فرض 100%
$form_bg = get_option('devapress_login_form_bg', '#ffffff');
$form_bg2 = get_option('devapress_login_form_bg2', ''); // رنگ دوم
$glass = get_option('devapress_login_form_glass', 0);
$form_radius = get_option('devapress_login_form_radius', '8');
$input_radius = get_option('devapress_login_input_radius', '6');
$label_color    = get_option('devapress_login_label_color', '#333333');



?>
<div class="devapress-setting-card">
    <h3>پس‌زمینه صفحه لاگین</h3>

    <input type="hidden" id="devapress_bg_login_file" name="devapress_bg_login_file" value="<?php echo esc_attr($bg_id); ?>">

    <button type="button" class="button" id="devapress_bg_login_upload_btn">
        <?php echo $bg_url ? 'تغییر تصویر' : 'انتخاب تصویر'; ?>
    </button>

    <div class="devapress-setting-card" style="margin-top:20px;">
        <h3>حالت قرار گیری پس‌زمینه</h3>
        <select name="devapress_bg_login_size">
            <option value="cover" <?php selected($bg_size, 'cover'); ?>>Cover</option>
            <option value="contain" <?php selected($bg_size, 'contain'); ?>>Contain</option>
            <option value="auto" <?php selected($bg_size, 'auto'); ?>>Auto</option>
        </select>
        <p style="margin-top:5px; color:#666;">انتخاب نحوه نمایش تصویر پس‌زمینه</p>
    </div>

    <?php if ($bg_url): ?>
        <div class="devapress-preview" style="margin-top:10px;">
            <img src="<?php echo esc_url($bg_url); ?>" style="max-width:200px; border:1px solid #ccc; border-radius:6px;">
            <span><?php echo esc_html(basename($bg_url)); ?></span>
            <button type="button" class="button devapress-remove-upload-login" id="devapress_bg_login_remove_btn">حذف تصویر</button>
        </div>
    <?php endif; ?>
</div>

<div class="devapress-setting-card">
    <h3>لوگوی صفحه لاگین</h3>

    <input type="hidden" id="devapress_login_logo" name="devapress_login_logo" value="<?php echo esc_attr($logo_id); ?>">

    <button type="button" class="button" id="devapress_login_logo_upload_btn">
        <?php echo $logo_url ? 'تغییر لوگو' : 'انتخاب لوگو'; ?>
    </button>

    <?php if ($logo_url): ?>
        <div class="devapress-preview" style="margin-top:10px;">
            <img src="<?php echo esc_url($logo_url); ?>" style="max-width:200px; border:1px solid #ccc; border-radius:6px;">
            <span><?php echo esc_html(basename($logo_url)); ?></span>
            <button type="button" class="button devapress-remove-upload-login" id="devapress_login_logo_remove_btn">حذف لوگو</button>
        </div>
    <?php endif; ?>
</div>

<div class="devapress-setting-card" style="margin-top:20px;">
    <h3>فعال کردن گرادیانت روی پس‌زمینه</h3>
    <select name="devapress_bg_login_gradient_enable">
        <option value="1" <?php selected($gradient_enable, '1'); ?>>فعال</option>
        <option value="0" <?php selected($gradient_enable, '0'); ?>>غیرفعال</option>
    </select>
</div>
<div class="devapress-setting-card" style="margin-top:20px;">
    <h3>شفافیت گرادیانت (%)</h3>
    <input type="number" name="devapress_bg_login_gradient_opacity" value="<?php echo esc_attr($grad_opacity); ?>" min="0" max="100" style="width:80px;"> %
</div>


<div class="devapress-setting-card" style="margin-top:20px;">
    <h3>رنگ پس‌زمینه صفحه لاگین (رنگ اول)</h3>
    <input type="color" name="devapress_bg_login_gradient_color1" value="<?php echo esc_attr($grad_color1); ?>">
</div>
<div class="devapress-setting-card" style="margin-top:20px;">
    <h3>رنگ پس‌زمینه صفحه لاگین (رنگ دوم)</h3>
    <input type="color" name="devapress_bg_login_gradient_color2" value="<?php echo esc_attr($grad_color2); ?>">
</div>

<select name="devapress_bg_login_gradient_type">
    <option value="linear" <?php selected($grad_type, 'linear'); ?>>گرادیانت خطی</option>
    <option value="radial" <?php selected($grad_type, 'radial'); ?>>گرادیانت دایره‌ای</option>
    <option value="conic"  <?php selected($grad_type, 'conic'); ?>>گرادیانت مخروطی</option>
</select>

<div class="devapress-setting-card" style="margin-top: 30px">
    <span>شخصی سازی فرم ورود</span>
</div>

<div class="devapress-setting-card">
    <h3>پس‌زمینه فرم لاگین</h3>
    <input type="color" name="devapress_login_form_bg" value="<?php echo esc_attr($form_bg); ?>">
    <input type="color" name="devapress_login_form_bg2" value="<?php echo esc_attr($form_bg2); ?>">
</div>

<div class="devapress-setting-card" style="margin-top:20px;">
    <h3>فعال کردن پس‌زمینه شیشه‌ای فرم لاگین</h3>
    <label>
        <input type="checkbox" name="devapress_login_form_glass" value="1" <?php checked($glass, 1); ?> />
        فعال‌سازی (Glass Effect)
    </label>
    <p style="margin-top:5px; color:#666;">
        با فعال کردن این گزینه، فرم ورود پس‌زمینه شیشه‌ای با افکت بلور خواهد داشت.
    </p>
</div>

<div class="devapress-setting-card" style="margin-top:20px;">
    <h3>گردی گوشه‌های فرم ورود</h3>
    <input type="number" name="devapress_login_form_radius"
           value="<?php echo esc_attr($form_radius); ?>"
           min="0" max="50" style="width:80px;"> px
    <p style="margin-top:5px; color:#666;">میزان گرد شدن گوشه‌های فرم ورود</p>
</div>

<div class="devapress-setting-card" style="margin-top:20px;">
    <h3>گردی گوشه‌های فیلدهای ورود</h3>
    <input type="number" name="devapress_login_input_radius"
           value="<?php echo esc_attr($input_radius); ?>"
           min="0" max="50" style="width:80px;"> px
    <p style="margin-top:5px; color:#666;">میزان گرد شدن گوشه‌های فیلدهای فرم ورود (نام کاربری، رمز عبور)</p>
</div>

<div class="devapress-setting-card">
    <h3>تنظیمات دکمه فرم لاگین</h3>
    <table class="form-table">
        <tr>
            <th scope="row">رنگ پس‌زمینه دکمه</th>
            <td>
                <?php
                $btn_bg = get_option('devapress_login_btn_bg', '#2271b1');
                ?>
                <input type="color" name="devapress_login_btn_bg" value="<?php echo esc_attr($btn_bg); ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">رنگ متن دکمه</th>
            <td>
                <?php
                $btn_color = get_option('devapress_login_btn_color', '#ffffff');
                ?>
                <input type="color" name="devapress_login_btn_color" value="<?php echo esc_attr($btn_color); ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">گردی گوشه دکمه (px)</th>
            <td>
                <?php
                $btn_radius = get_option('devapress_login_btn_radius', '4');
                ?>
                <input type="number" name="devapress_login_btn_radius" value="<?php echo esc_attr($btn_radius); ?>" style="width:80px;"> px
            </td>
        </tr>
        <tr>
            <th scope="row">رنگ پس‌زمینه هاور</th>
            <td>
                <?php
                $btn_hover_bg = get_option('devapress_login_btn_hover_bg', '#1a5a91');
                ?>
                <input type="color" name="devapress_login_btn_hover_bg" value="<?php echo esc_attr($btn_hover_bg); ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">رنگ متن هاور</th>
            <td>
                <?php
                $btn_hover_color = get_option('devapress_login_btn_hover_color', '#ffffff');
                ?>
                <input type="color" name="devapress_login_btn_hover_color" value="<?php echo esc_attr($btn_hover_color); ?>">
            </td>
        </tr>
    </table>
    <div class="devapress-option">
        <label for="devapress_label_color">رنگ متن لیبل فرم</label>
        <input type="color"
               id="devapress_label_color"
               name="devapress_login_label_color"
               value="<?php echo esc_attr($label_color) ?>">
    </div>
</div>



<!--$grad_color1 = get_option('devapress_bg_login_gradient_color1', '');-->
<!--$grad_color2 = get_option('devapress_bg_login_gradient_color2', '');-->
<!--$grad_type   = get_option('devapress_bg_login_gradient_type', 'linear');-->
