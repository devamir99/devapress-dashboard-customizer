jQuery(document).ready(function ($) {
    // Tab switching
    $('.devapress-nav-tabs .nav-tab').on('click', function (e) {
        e.preventDefault();
        $('.devapress-nav-tabs .nav-tab').removeClass('nav-tab-active');
        $(this).addClass('nav-tab-active');
        $('.devapress-tab-content').hide();
        $($(this).attr('href')).show();
    });

    // Preset card selection UI
    $('.devapress-preset-card input[type="radio"]').on('change', function () {
        var $grid = $(this).closest('.devapress-preset-grid');
        var section = $grid.data('section');
        var value = $(this).val();

        $grid.find('.devapress-preset-card').removeClass('is-selected');
        $(this).closest('.devapress-preset-card').addClass('is-selected');

        var $panel = $('.devapress-customize-panel[data-section="' + section + '"]');
        if (value === 'none') {
            $panel.slideUp(200);
        } else {
            $panel.slideDown(200);
        }
    });

    // Media: login background
    $('#devapress_bg_login_upload_btn').on('click', function (e) {
        e.preventDefault();

        var frame = wp.media({
            title: 'انتخاب تصویر پس‌زمینه لاگین',
            button: { text: 'انتخاب تصویر' },
            multiple: false
        });

        frame.on('select', function () {
            var attachment = frame.state().get('selection').first().toJSON();
            $('#devapress_bg_login_file').val(attachment.id);

            var html = '<div class="devapress-preview" id="devapress-bg-preview">' +
                '<img src="' + attachment.url + '" alt="">' +
                '<button type="button" class="button devapress-remove-media" data-target="devapress_bg_login_file" data-preview="devapress-bg-preview">حذف</button>' +
                '</div>';

            $('#devapress-bg-preview').remove();
            $('#devapress_bg_login_upload_btn').after(html);
        });

        frame.open();
    });

    // Media: login logo
    $('#devapress_login_logo_upload_btn').on('click', function (e) {
        e.preventDefault();

        var frame = wp.media({
            title: 'انتخاب لوگو صفحه لاگین',
            button: { text: 'انتخاب لوگو' },
            multiple: false
        });

        frame.on('select', function () {
            var attachment = frame.state().get('selection').first().toJSON();
            $('#devapress_login_logo').val(attachment.id);

            var html = '<div class="devapress-preview" id="devapress-logo-preview">' +
                '<img src="' + attachment.url + '" alt="">' +
                '<button type="button" class="button devapress-remove-media" data-target="devapress_login_logo" data-preview="devapress-logo-preview">حذف</button>' +
                '</div>';

            $('#devapress-logo-preview').remove();
            $('#devapress_login_logo_upload_btn').after(html);
        });

        frame.open();
    });

    // Remove media (scoped to target field)
    $(document).on('click', '.devapress-remove-media', function () {
        var target = $(this).data('target');
        var preview = $(this).data('preview');
        $('#' + target).val('');
        $('#' + preview).remove();
    });
});
