<?php
if (!defined('ABSPATH')) {
    exit;
}

$images_url = DEVAPRESS_ASSETS_URL . 'images/presets/';
?>
<div class="devapress-about">
    <div class="devapress-setting-card devapress-about-hero">
        <h2>Devapress Dashboard Customizer</h2>
        <p>
            افزونه‌ای برای شخصی‌سازی حرفه‌ای <strong>پنل مدیریت وردپرس</strong> و
            <strong>صفحه ورود</strong> — مناسب پروژه‌های فارسی‌زبان و نمونه‌کار.
        </p>
        <ul class="devapress-about-features">
            <li>۳ طرح آماده برای منوی داشبورد + ۳ طرح صفحه لاگین</li>
            <li>پیش‌نمایش زنده بدون ذخیره</li>
            <li>خروجی / ورود JSON و دموهای آماده</li>
            <li>بدون اعمال استایل تا زمان انتخاب طرح</li>
        </ul>
    </div>

    <div class="devapress-setting-card">
        <h2>گالری طرح‌ها</h2>
        <p class="description">برای اعمال سریع، روی «استفاده از این طرح» کلیک کنید و سپس ذخیره کنید.</p>

        <h3>داشبورد</h3>
        <div class="devapress-gallery">
            <?php foreach (Devapress_Presets::dashboard_presets() as $id => $preset) : ?>
                <div class="devapress-gallery-card">
                    <img src="<?php echo esc_url($images_url . 'dashboard-' . $id . '.svg'); ?>"
                         alt="<?php echo esc_attr($preset['label']); ?>" loading="lazy">
                    <div class="devapress-gallery-card__body">
                        <strong><?php echo esc_html($preset['label']); ?></strong>
                        <p><?php echo esc_html($preset['description']); ?></p>
                        <button type="button" class="button button-secondary devapress-apply-preset"
                                data-section="dashboard" data-preset="<?php echo esc_attr($id); ?>">
                            استفاده از این طرح
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <h3 style="margin-top:24px;">صفحه لاگین</h3>
        <div class="devapress-gallery">
            <?php foreach (Devapress_Presets::login_presets() as $id => $preset) : ?>
                <div class="devapress-gallery-card">
                    <img src="<?php echo esc_url($images_url . 'login-' . $id . '.svg'); ?>"
                         alt="<?php echo esc_attr($preset['label']); ?>" loading="lazy">
                    <div class="devapress-gallery-card__body">
                        <strong><?php echo esc_html($preset['label']); ?></strong>
                        <p><?php echo esc_html($preset['description']); ?></p>
                        <button type="button" class="button button-secondary devapress-apply-preset"
                                data-section="login" data-preset="<?php echo esc_attr($id); ?>">
                            استفاده از این طرح
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
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
        <div class="devapress-setting-card">
            <h3>مجوز</h3>
            <p>GPL v2+</p>
        </div>
        <div class="devapress-setting-card">
            <h3>مخزن</h3>
            <p><a href="https://github.com/" target="_blank" rel="noopener">GitHub</a></p>
        </div>
    </div>
</div>
