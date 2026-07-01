<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="devapress-tools">
    <div class="devapress-setting-card">
        <h2>خروجی گرفتن از تنظیمات</h2>
        <p class="description">
            تمام تنظیمات فعلی (طرح‌ها، رنگ‌ها و overrideها) را در یک فایل JSON ذخیره کنید.
            URL تصاویر و فونت برای انتقال به سایت دیگر ضمیمه می‌شود.
        </p>
        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <?php wp_nonce_field('devapress_export_settings'); ?>
            <input type="hidden" name="action" value="devapress_export_settings">
            <?php submit_button('دانلود JSON تنظیمات', 'secondary', 'submit', false); ?>
        </form>
    </div>

    <div class="devapress-setting-card">
        <h2>ورود تنظیمات از فایل</h2>
        <p class="description">فایل JSON خروجی‌گرفته‌شده از همین افزونه را بارگذاری کنید.</p>
        <form method="post" enctype="multipart/form-data"
              action="<?php echo esc_url(Devapress_Settings::admin_url()); ?>">
            <?php wp_nonce_field('devapress_import_settings'); ?>
            <input type="hidden" name="devapress_import_action" value="upload">
            <p>
                <input type="file" name="devapress_import_file" accept=".json,application/json" required>
            </p>
            <p>
                <label>
                    <input type="checkbox" name="devapress_import_media" value="1">
                    تلاش برای دانلود تصاویر و فونت از URLهای ضمیمه‌شده
                </label>
            </p>
            <?php submit_button('وارد کردن تنظیمات', 'primary', 'submit', false); ?>
        </form>
    </div>

    <div class="devapress-setting-card">
        <h2>بارگذاری سریع دمو</h2>
        <p class="description">ترکیب‌های آماده برای تست سریع یا نمایش در نمونه‌کار.</p>
        <div class="devapress-demo-grid">
            <?php foreach (Devapress_Export_Import::demo_presets() as $id => $label) : ?>
                <a class="devapress-demo-card"
                   href="<?php echo esc_url(wp_nonce_url(
                       Devapress_Settings::admin_url(['devapress_demo' => $id]),
                       'devapress_import_demo'
                   )); ?>"
                   onclick="return confirm('تنظیمات فعلی با این دمو جایگزین می‌شود. ادامه می‌دهید؟');">
                    <span class="devapress-demo-card__icon dashicons dashicons-download"></span>
                    <span class="devapress-demo-card__label"><?php echo esc_html($label); ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>
