<div class="wrap devapress-settings-page">

    <div class=".wrap.devapress-settings-page">
        <h1>سفارشی ساز دواپرس</h1>
        <p class=".devapress-settings-page p">
            تمامی تنظیمات داشبورد، رنگ‌ها و فونت‌ها را می‌توانید اینجا مدیریت کنید.
        </p>
    </div>

    <div class="nav-tab-wrapper">
        <a href="#tab-fonts" class="nav-tab nav-tab-active">فونت‌ها</a>
        <a href="#tab-colors" class="nav-tab">رنگ‌ها</a>
        <a href="#tab-login" class="nav-tab">صفحه لاگین</a>
        <a href="#tab-reset" class="nav-tab">ریست تنظیمات</a>
    </div>

    <form method="post" action="options.php" enctype="multipart/form-data">
        <?php settings_fields('devapress_settings_group'); ?>

        <div id="tab-fonts" class="devapress-tab-content">
            <?php include DEVAPRESS_VIEW_DIR . 'tab-fonts.php'; ?>
        </div>

        <div id="tab-colors" class="devapress-tab-content" style="display:none;">
            <?php include DEVAPRESS_VIEW_DIR . 'tab-colors.php'; ?>
        </div>

        <div id="tab-login" class="devapress-tab-content" style="display:none;">
            <?php include DEVAPRESS_VIEW_DIR . 'tab-login.php'; ?>
        </div>

        <div id="tab-reset" class="devapress-tab-content" style="display:none;">
            <?php include DEVAPRESS_VIEW_DIR . 'reset-options.php'; ?>
        </div>

        <?php submit_button(); ?>
    </form>
</div>

