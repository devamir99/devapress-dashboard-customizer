<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * @var string $section dashboard|login
 */
$preview_id = 'devapress-live-preview-' . $section;
$label      = $section === 'dashboard' ? 'پیش‌نمایش منوی داشبورد' : 'پیش‌نمایش صفحه لاگین';
?>
<aside class="devapress-live-preview" id="<?php echo esc_attr($preview_id); ?>" data-section="<?php echo esc_attr($section); ?>">
    <div class="devapress-live-preview__header">
        <h3><?php echo esc_html($label); ?></h3>
        <span class="devapress-live-preview__badge">زنده</span>
    </div>

    <?php if ($section === 'dashboard') : ?>
        <div class="devapress-mock-dashboard" data-preview-target="dashboard">
            <div class="devapress-mock-dashboard__sidebar">
                <div class="devapress-mock-dashboard__item devapress-mock-dashboard__item--active">
                    <span class="devapress-mock-dashboard__icon dashicons dashicons-dashboard"></span>
                    <span class="devapress-mock-dashboard__text">پیشخوان</span>
                </div>
                <div class="devapress-mock-dashboard__item">
                    <span class="devapress-mock-dashboard__icon dashicons dashicons-admin-post"></span>
                    <span class="devapress-mock-dashboard__text">نوشته‌ها</span>
                </div>
                <div class="devapress-mock-dashboard__item">
                    <span class="devapress-mock-dashboard__icon dashicons dashicons-admin-page"></span>
                    <span class="devapress-mock-dashboard__text">برگه‌ها</span>
                </div>
                <div class="devapress-mock-dashboard__item">
                    <span class="devapress-mock-dashboard__icon dashicons dashicons-admin-appearance"></span>
                    <span class="devapress-mock-dashboard__text">نمایش</span>
                </div>
            </div>
            <div class="devapress-mock-dashboard__main">
                <div class="devapress-mock-dashboard__title"></div>
                <div class="devapress-mock-dashboard__card"></div>
                <div class="devapress-mock-dashboard__card devapress-mock-dashboard__card--short"></div>
            </div>
        </div>
    <?php else : ?>
        <div class="devapress-mock-login" data-preview-target="login">
            <div class="devapress-mock-login__logo"></div>
            <div class="devapress-mock-login__form">
                <div class="devapress-mock-login__label"></div>
                <div class="devapress-mock-login__input"></div>
                <div class="devapress-mock-login__label"></div>
                <div class="devapress-mock-login__input"></div>
                <div class="devapress-mock-login__button">ورود</div>
            </div>
            <div class="devapress-mock-login__links">
                <span></span><span></span>
            </div>
        </div>

        <div class="devapress-live-preview__iframe-wrap" style="display:none;">
            <p class="description">پیش‌نمایش واقعی (پس از ذخیره موقت تنظیمات)</p>
            <iframe id="devapress-login-iframe" class="devapress-live-preview__iframe"
                    title="<?php esc_attr_e('Login preview', 'devapress-customizer'); ?>"
                    src="about:blank"></iframe>
        </div>
        <button type="button" class="button button-secondary devapress-open-real-login" style="margin-top:8px;">
            باز کردن wp-login.php در تب جدید
        </button>
    <?php endif; ?>

    <p class="devapress-live-preview__hint description">
        تغییرات فرم را بلافاصله می‌بینید. برای اعمال روی سایت «ذخیره تغییرات» را بزنید.
    </p>
</aside>
