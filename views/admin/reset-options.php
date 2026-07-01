<div class="devapress-setting-card">
    <h2>بازنشانی تنظیمات</h2>

    <div class="devapress-reset-section">
        <p>تنظیمات داشبورد (طرح و سفارشی‌سازی) به حالت اولیه برمی‌گردد.</p>
        <a href="<?php echo esc_url(wp_nonce_url(
            Devapress_Settings::admin_url(['action' => 'reset_devapress_dashboard']),
            'devapress_reset_dashboard'
        )); ?>" class="button button-secondary">
            بازنشانی داشبورد
        </a>
    </div>

    <div class="devapress-reset-section">
        <p>تنظیمات صفحه لاگین به حالت اولیه برمی‌گردد.</p>
        <a href="<?php echo esc_url(wp_nonce_url(
            Devapress_Settings::admin_url(['action' => 'reset_devapress_login']),
            'devapress_reset_login'
        )); ?>" class="button button-secondary">
            بازنشانی صفحه لاگین
        </a>
    </div>

    <div class="devapress-reset-section">
        <p>همه تنظیمات افزونه پاک می‌شود و هیچ استایلی اعمال نخواهد شد.</p>
        <a href="<?php echo esc_url(wp_nonce_url(
            Devapress_Settings::admin_url(['action' => 'reset_devapress_all']),
            'devapress_reset_all'
        )); ?>" class="button button-reset-option"
           onclick="return confirm('آیا از بازنشانی کامل مطمئن هستید؟');">
            بازنشانی کامل
        </a>
    </div>
</div>
