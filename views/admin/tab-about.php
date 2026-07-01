<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="devapress-about">
    <div class="devapress-setting-card devapress-about-hero">
        <h2>Devapress Dashboard Customizer</h2>
        <p>
            افزونه‌ای برای شخصی‌سازی حرفه‌ای <strong>پنل مدیریت وردپرس</strong> و
            <strong>صفحه ورود</strong> — مناسب پروژه‌های فارسی‌زبان و نمونه‌کار.
        </p>
        <ul class="devapress-about-features">
            <li>۳ طرح آماده برای منوی داشبورد</li>
            <li>۳ طرح آماده برای صفحه لاگین</li>
            <li>پیش‌نمایش زنده بدون ذخیره</li>
            <li>سفارشی‌سازی رنگ، فونت، گرادیانت و Glass Effect</li>
            <li>بدون اعمال استایل تا زمان انتخاب طرح</li>
        </ul>
    </div>

    <div class="devapress-settings-grid">
        <div class="devapress-setting-card">
            <h3>نسخه</h3>
            <p><?php echo esc_html(DEVAPRESS_VERSION); ?></p>
        </div>
        <div class="devapress-setting-card">
            <h3>نویسنده</h3>
            <p>Amir Falahi</p>
        </div>
        <div class="devapress-setting-card">
            <h3>حداقل وردپرس</h3>
            <p>5.0+</p>
        </div>
        <div class="devapress-setting-card">
            <h3>PHP</h3>
            <p>7.4+</p>
        </div>
    </div>

    <div class="devapress-setting-card">
        <h3>طرح‌های داشبورد</h3>
        <ul>
            <?php foreach (Devapress_Presets::dashboard_presets() as $id => $p) : ?>
                <li><code><?php echo esc_html($id); ?></code> — <?php echo esc_html($p['label']); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="devapress-setting-card">
        <h3>طرح‌های صفحه لاگین</h3>
        <ul>
            <?php foreach (Devapress_Presets::login_presets() as $id => $p) : ?>
                <li><code><?php echo esc_html($id); ?></code> — <?php echo esc_html($p['label']); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
