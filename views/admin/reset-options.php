<div class="devapress-setting-card">
    <h1>ریست تنظیمات</h1>

    <div class="devapress-reset-section">
        <p>اگر می‌خواهید تنظیمات فونت را به حالت پیش‌فرض بازگردانید:</p>
        <a href="<?php echo esc_url( wp_nonce_url(
            admin_url('admin.php?page=devapress-customizer&action=reset_devapress_font'),
            'devapress_reset_font'
        )); ?>"
           class="button-reset-option">
            ریست فونت
        </a>
    </div>

    <div class="devapress-reset-section">
        <p>بازنشانی تنظیمات رنگ به حالت پیش‌فرض:</p>
        <a href="<?php echo esc_url( wp_nonce_url(
            admin_url('admin.php?page=devapress-customizer&action=reset_devapress_colors'),
            'devapress_reset_colors'
        )); ?>"
           class="button-reset-option">
            ریست رنگ ها
        </a>
    </div>

    <div class="devapress-reset-section">
        <p>بازنشانی تنظیمات صفحه ورود به حالت پیش‌فرض:</p>
        <a href="<?php echo esc_url( wp_nonce_url(
            admin_url('admin.php?page=devapress-customizer&action=reset_devapress_login'),
            'devapress_reset_login'
        )); ?>"
           class="button-reset-option">
            ریست صفحه لاگین
        </a>
    </div>
</div>
