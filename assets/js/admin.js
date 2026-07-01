jQuery(document).ready(function ($) {
    $('.devapress-nav-tabs .nav-tab').on('click', function (e) {
        e.preventDefault();
        $('.devapress-nav-tabs .nav-tab').removeClass('nav-tab-active');
        $(this).addClass('nav-tab-active');
        $('.devapress-tab-content').hide();
        $($(this).attr('href')).show();
    });

    $('#devapress_bg_login_upload_btn').on('click', function (e) {
        e.preventDefault();

        var frame = wp.media({
            title: 'انتخاب تصویر پس‌زمینه لاگین',
            button: { text: 'انتخاب تصویر' },
            multiple: false
        });

        frame.on('select', function () {
            var attachment = frame.state().get('selection').first().toJSON();
            $('#devapress_bg_login_file').val(attachment.id).trigger('change');

            var html = '<div class="devapress-preview" id="devapress-bg-preview">' +
                '<img src="' + attachment.url + '" alt="">' +
                '<button type="button" class="button devapress-remove-media" data-target="devapress_bg_login_file" data-preview="devapress-bg-preview">حذف</button>' +
                '</div>';

            $('#devapress-bg-preview').remove();
            $('#devapress_bg_login_upload_btn').after(html);
        });

        frame.open();
    });

    $('#devapress_login_logo_upload_btn').on('click', function (e) {
        e.preventDefault();

        var frame = wp.media({
            title: 'انتخاب لوگو صفحه لاگین',
            button: { text: 'انتخاب لوگو' },
            multiple: false
        });

        frame.on('select', function () {
            var attachment = frame.state().get('selection').first().toJSON();
            $('#devapress_login_logo').val(attachment.id).trigger('change');

            var html = '<div class="devapress-preview" id="devapress-logo-preview">' +
                '<img src="' + attachment.url + '" alt="">' +
                '<button type="button" class="button devapress-remove-media" data-target="devapress_login_logo" data-preview="devapress-logo-preview">حذف</button>' +
                '</div>';

            $('#devapress-logo-preview').remove();
            $('#devapress_login_logo_upload_btn').after(html);
        });

        frame.open();
    });

    $(document).on('click', '.devapress-remove-media', function () {
        var target = $(this).data('target');
        var preview = $(this).data('preview');
        $('#' + target).val('').trigger('change');
        $('#' + preview).remove();
    });

    // Apply preset from gallery (about tab)
    $('.devapress-apply-preset').on('click', function () {
        var section = $(this).data('section');
        var preset = $(this).data('preset');
        var tabId = section === 'login' ? '#tab-login' : '#tab-dashboard';

        $('.devapress-nav-tabs .nav-tab').removeClass('nav-tab-active');
        $('.devapress-nav-tabs .nav-tab[href="' + tabId + '"]').addClass('nav-tab-active');
        $('.devapress-tab-content').hide();
        $(tabId).show();

        var $radio = $('input[name="devapress_settings[' + section + '][preset]"][value="' + preset + '"]');
        $radio.prop('checked', true).trigger('change');

        $('html, body').animate({ scrollTop: $(tabId).offset().top - 50 }, 300);
    });
});
