<div class="wrap devapress-settings-page">
    <h1>سفارشی‌ساز دواپرس</h1>
    <p class="description">
        یک طرح از پیش‌تعریف‌شده انتخاب کنید، سپس در صورت نیاز تنظیمات را سفارشی کنید.
        تا زمانی که طرحی انتخاب نشود، هیچ استایلی اعمال نمی‌شود.
    </p>

    <?php
    $reset_notice = isset($_GET['reset']) ? sanitize_key($_GET['reset']) : '';
    if ($reset_notice) :
        $messages = [
            'dashboard' => 'تنظیمات داشبورد بازنشانی شد.',
            'login'     => 'تنظیمات صفحه لاگین بازنشانی شد.',
            'all'       => 'همه تنظیمات بازنشانی شد.',
        ];
        if (isset($messages[$reset_notice])) :
            ?>
            <div class="notice notice-success is-dismissible"><p><?php echo esc_html($messages[$reset_notice]); ?></p></div>
        <?php
        endif;
    endif;

    if (isset($_GET['settings-updated'])) :
        ?>
        <div class="notice notice-success is-dismissible"><p>تغییرات ذخیره شد.</p></div>
    <?php endif; ?>

    <div class="nav-tab-wrapper devapress-nav-tabs">
        <a href="#tab-dashboard" class="nav-tab nav-tab-active">داشبورد</a>
        <a href="#tab-login" class="nav-tab">صفحه لاگین</a>
        <a href="#tab-reset" class="nav-tab">بازنشانی</a>
    </div>

    <form method="post" action="options.php" enctype="multipart/form-data">
        <?php settings_fields('devapress_settings_group'); ?>

        <div id="tab-dashboard" class="devapress-tab-content">
            <?php include DEVAPRESS_VIEW_DIR . 'tab-dashboard.php'; ?>
        </div>

        <div id="tab-login" class="devapress-tab-content" style="display:none;">
            <?php include DEVAPRESS_VIEW_DIR . 'tab-login.php'; ?>
        </div>

        <div id="tab-reset" class="devapress-tab-content" style="display:none;">
            <?php include DEVAPRESS_VIEW_DIR . 'reset-options.php'; ?>
        </div>

        <?php submit_button('ذخیره تغییرات'); ?>
    </form>
</div>
