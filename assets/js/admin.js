// alert('aaa');
jQuery(document).ready(function($){
    $('.nav-tab').click(function(e){
        e.preventDefault();
        $('.nav-tab').removeClass('nav-tab-active');
        $(this).addClass('nav-tab-active');
        $('.devapress-tab-content').hide();
        $($(this).attr('href')).show();
    });
});

// upload fonts
jQuery(document).ready(function($){
    $('#upload-font-btn').on('click', function(e){
        e.preventDefault();

        var file_frame = wp.media({
            title: 'انتخاب فونت',
            button: { text: 'استفاده از این فونت' },
            multiple: false,
            library: {
                type: ['application/font-woff','application/font-woff2','application/x-font-ttf','application/x-font-otf']
            }
        });

        file_frame.on('select', function(){
            var attachment = file_frame.state().get('selection').first().toJSON();
            $('#devapress_font_file').val(attachment.url);
        });

        file_frame.open();
    });
});





// let bgFrame;


//bg-login upload
//bg-login upload
// jQuery(document).ready(function($){
//     $('#devapress_bg_login_upload_btn').on('click', function(e){
//         e.preventDefault();
//
//         if(bgFrame) { bgFrame.open(); return; }
//
//         bgFrame = wp.media({
//             title: 'انتخاب تصویر پس‌زمینه لاگین',
//             button: { text: 'انتخاب تصویر' },
//             multiple: false
//         });
//
//         bgFrame.on('select', function(){
//             var attachment = bgFrame.state().get('selection').first().toJSON();
//             $('#devapress_bg_login_file').val(attachment.id);
//
//             // آپدیت پیش‌نمایش
//             var html = '<div class="devapress-preview" style="margin-top:10px;">' +
//                 '<img src="'+attachment.url+'" style="max-width:200px; border:1px solid #ccc; border-radius:6px;">' +
//                 '<span>'+attachment.filename+'</span>' +
//                 '<button type="button" class="button devapress-remove-upload-login">حذف تصویر</button>' +
//                 '</div>';
//
//             $('#devapress_bg_login_upload_btn').nextAll('.devapress-preview').remove();
//             $('#devapress_bg_login_upload_btn').after(html);
//         });
//
//         bgFrame.open();
//     });
//
//     // حذف تصویر (با کلاس مشترک، نه id)
//     $(document).on('click', '.devapress-remove-upload-login', function(){
//         var parentDiv = $(this).closest('.devapress-preview');
//
//         // تشخیص اینکه پس‌زمینه است یا لوگو
//         if(parentDiv.find('#devapress_bg_login_file').length || $('#devapress_bg_login_file').length){
//             $('#devapress_bg_login_file').val('');
//         } else if(parentDiv.find('#devapress_login_logo').length || $('#devapress_login_logo').length){
//             $('#devapress_login_logo').val('');
//         }
//
//         parentDiv.remove();
//     });
// });


let bgFrame; // ✅ تعریف در سطح گلوبال فایل

jQuery(document).ready(function($){
    $('#devapress_bg_login_upload_btn').on('click', function(e){
        e.preventDefault();

        // if(bgFrame) {
        //     bgFrame.open();
        //     return;
        // }

        bgFrame = wp.media({
            title: 'انتخاب تصویر پس‌زمینه لاگین',
            button: { text: 'انتخاب تصویر' },
            multiple: false
        });

        bgFrame.on('select', function(){
            var attachment = bgFrame.state().get('selection').first().toJSON();
            $('#devapress_bg_login_file').val(attachment.id);

            // آپدیت پیش‌نمایش
            var html = '<div class="devapress-preview" style="margin-top:10px;">' +
                '<img src="'+attachment.url+'" style="max-width:200px; border:1px solid #ccc; border-radius:6px;">' +
                '<span>'+attachment.filename+'</span>' +
                '<button type="button" class="button devapress-remove-upload-login">حذف تصویر</button>' +
                '</div>';

            $('#devapress_bg_login_upload_btn').nextAll('.devapress-preview').remove();
            $('#devapress_bg_login_upload_btn').after(html);
        });

        bgFrame.open();
    });

    // حذف تصویر
    $(document).on('click', '.devapress-remove-upload-login', function(){
        var parentDiv = $(this).closest('.devapress-preview');

        // تشخیص اینکه پس‌زمینه است یا لوگو
        if($('#devapress_bg_login_file').length){
            $('#devapress_bg_login_file').val('');
        } else if($('#devapress_login_logo').length){
            $('#devapress_login_logo').val('');
        }

        parentDiv.remove();
    });
});





// jQuery(document).ready(function($){
//     var frame;
//     $('#devapress_bg_login_upload_btn').on('click', function(e){
//         e.preventDefault();
//
//         // اگر فریم قبلا باز شده بود، ازش استفاده کن
//         if(frame) {
//             frame.open();
//             return;
//         }
//
//         frame = wp.media({
//             title: 'انتخاب تصویر پس‌زمینه لاگین',
//             button: { text: 'انتخاب تصویر' },
//             multiple: false
//         });
//
//         frame.on('select', function(){
//             var attachment = frame.state().get('selection').first().toJSON();
//             $('#devapress_bg_login_file').val(attachment.id);
//
//             // آپدیت پیش‌نمایش
//             var html = '<div class="devapress-preview" style="margin-top:10px;">' +
//                 '<img src="'+attachment.url+'" style="max-width:200px; border:1px solid #ccc; border-radius:6px;">' +
//                 '<span>'+attachment.filename+'</span>' +
//                 '<button type="button" class="button" id="devapress_bg_login_remove_btn">حذف تصویر</button>' +
//                 '</div>';
//             $('#devapress_bg_login_file').nextAll('.devapress-preview').remove();
//             $('#devapress_bg_login_upload_btn').after(html);
//         });
//
//         frame.open();
//     });
//
//     // حذف تصویر
//     $(document).on('click', '#devapress_bg_login_remove_btn', function(){
//         $('#devapress_bg_login_file').val('');
//         $(this).parent('.devapress-preview').remove();
//     });
// });




let logoFrame; // ✅ تعریف در سطح گلوبال فایل

//logo login upload
//logo login upload
jQuery(document).ready(function($){
    $('#devapress_login_logo_upload_btn').on('click', function(e){
        e.preventDefault();

        // if(logoFrame) { logoFrame.open(); return; }

        logoFrame = wp.media({
            title: 'انتخاب لوگو صفحه لاگین',
            button: { text: 'انتخاب لوگو' },
            multiple: false
        });

        logoFrame.on('select', function(){
            var attachment = logoFrame.state().get('selection').first().toJSON();
            $('#devapress_login_logo').val(attachment.id);

            var html = '<div class="devapress-preview" style="margin-top:10px;">' +
                '<img src="'+attachment.url+'" style="max-width:200px; border:1px solid #ccc; border-radius:6px;">' +
                '<span>'+attachment.filename+'</span>' +
                '<button type="button" class="button devapress-remove-upload-login">حذف لوگو</button>' +
                '</div>';

            $('#devapress_login_logo_upload_btn').nextAll('.devapress-preview').remove();
            $('#devapress_login_logo_upload_btn').after(html);
        });

        logoFrame.open();
    });
});





// jQuery(document).ready(function($){
//     var frame;
//     $('#devapress_login_logo_upload_btn').on('click', function(e){
//         e.preventDefault();
//
//         if(frame) { frame.open(); return; }
//
//         frame = wp.media({
//             title: 'انتخاب لوگو صفحه لاگین',
//             button: { text: 'انتخاب لوگو' },
//             multiple: false
//         });
//
//         frame.on('select', function(){
//             var attachment = frame.state().get('selection').first().toJSON();
//             $('#devapress_login_logo').val(attachment.id);
//
//             var html = '<div class="devapress-preview" style="margin-top:10px;">' +
//                 '<img src="'+attachment.url+'" style="max-width:200px; border:1px solid #ccc; border-radius:6px;">' +
//                 '<span>'+attachment.filename+'</span>' +
//                 '<button type="button" class="button" id="devapress_login_logo_remove_btn">حذف لوگو</button>' +
//                 '</div>';
//             $('#devapress_login_logo_upload_btn').nextAll('.devapress-preview').remove();
//             $('#devapress_login_logo_upload_btn').after(html);
//         });
//
//         frame.open();
//     });
//
//     $(document).on('click', '#devapress_login_logo_remove_btn', function(){
//         $('#devapress_login_logo').val('');
//         $(this).parent('.devapress-preview').remove();
//     });
// });


