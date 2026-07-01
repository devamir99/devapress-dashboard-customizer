<div class="wrap devapress-settings-page">
    <div class="devapress-page-header">
        <div class="devapress-page-header__main">
            <h1>
                سفارشی‌ساز دواپرس
                <span class="devapress-version-badge">v<?php echo esc_html(DEVAPRESS_VERSION); ?></span>
            </h1>
            <p class="description">
                ۶ طرح آماده برای داشبورد و صفحه ورود — با پیش‌نمایش زنده و امکان سفارشی‌سازی کامل.
            </p>
        </div>
        <div class="devapress-page-header__meta">
            <span>توسط Amir Falahi</span>
            <a href="<?php echo esc_url(wp_login_url()); ?>" target="_blank" rel="noopener" class="button button-secondary">
                مشاهده صفحه لاگین
            </a>
        </div>
    </div>

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

    <?php
    if (!empty($_GET['imported'])) :
        $msg = !empty($_GET['msg']) ? sanitize_text_field(wp_unslash($_GET['msg'])) : 'تنظیمات وارد شد.';
        ?>
        <div class="notice notice-success is-dismissible"><p><?php echo esc_html($msg); ?></p></div>
    <?php endif;

    if (!empty($_GET['import-error'])) :
        $msg = !empty($_GET['msg']) ? sanitize_text_field(wp_unslash($_GET['msg'])) : 'خطا در ورود تنظیمات.';
        ?>
        <div class="notice notice-error is-dismissible"><p><?php echo esc_html($msg); ?></p></div>
    <?php endif; ?>

    <div class="nav-tab-wrapper devapress-nav-tabs">
        <a href="#tab-dashboard" class="nav-tab nav-tab-active">داشبورد</a>
        <a href="#tab-login" class="nav-tab">صفحه لاگین</a>
        <a href="#tab-about" class="nav-tab">درباره</a>
        <a href="#tab-tools" class="nav-tab">ابزارها</a>
        <a href="#tab-reset" class="nav-tab">بازنشانی</a>
    </div>

    <form method="post" action="options.php" enctype="multipart/form-data" id="devapress-settings-form">
        <?php settings_fields('devapress_settings_group'); ?>

        <div id="tab-dashboard" class="devapress-tab-content">
            <div class="devapress-tab-layout">
                <div class="devapress-tab-layout__settings">
                    <?php include DEVAPRESS_VIEW_DIR . 'tab-dashboard.php'; ?>
                </div>
                <div class="devapress-tab-layout__preview">
                    <?php
                    $section = 'dashboard';
                    include DEVAPRESS_VIEW_DIR . 'partials/live-preview.php';
                    ?>
                </div>
            </div>
        </div>

        <div id="tab-login" class="devapress-tab-content" style="display:none;">
            <div class="devapress-tab-layout">
                <div class="devapress-tab-layout__settings">
                    <?php include DEVAPRESS_VIEW_DIR . 'tab-login.php'; ?>
                </div>
                <div class="devapress-tab-layout__preview">
                    <?php
                    $section = 'login';
                    include DEVAPRESS_VIEW_DIR . 'partials/live-preview.php';
                    ?>
                </div>
            </div>
        </div>

        <div id="tab-about" class="devapress-tab-content" style="display:none;">
            <?php include DEVAPRESS_VIEW_DIR . 'tab-about.php'; ?>
        </div>

        <div id="tab-tools" class="devapress-tab-content" style="display:none;">
            <?php include DEVAPRESS_VIEW_DIR . 'tab-tools.php'; ?>
        </div>

        <div id="tab-reset" class="devapress-tab-content" style="display:none;">
            <?php include DEVAPRESS_VIEW_DIR . 'reset-options.php'; ?>
        </div>

        <div class="devapress-form-footer">
            <?php submit_button('ذخیره تغییرات'); ?>
        </div>
    </form>
</div>
