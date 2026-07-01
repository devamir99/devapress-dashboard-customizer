(function ($, config) {
    'use strict';

    var debounceTimer = null;

    function getSelectedPreset(section) {
        var $input = $('input[name="devapress_settings[' + section + '][preset]"]:checked');
        return $input.length ? $input.val() : 'none';
    }

    function getPresetBase(section, presetId) {
        if (!presetId || presetId === 'none') {
            return {};
        }
        var presets = section === 'login' ? config.loginPresets : config.dashboardPresets;
        return $.extend({}, presets[presetId] || {});
    }

    function collectSectionSettings(section) {
        var presetId = getSelectedPreset(section);
        var data = getPresetBase(section, presetId);

        if (presetId === 'none') {
            return null;
        }

        $('[data-dp-section="' + section + '"][data-dp-preview]').each(function () {
            var key = $(this).data('dp-preview');
            var val = $(this).val();
            if (val !== '' && val !== undefined) {
                data[key] = val;
            }
        });

        $('[name^="devapress_settings[' + section + '][overrides]"]').each(function () {
            var name = $(this).attr('name');
            var match = name.match(/\[overrides\]\[([^\]]+)\]/);
            if (!match) {
                return;
            }
            var key = match[1];
            if ($(this).attr('type') === 'checkbox') {
                data[key] = $(this).is(':checked');
            } else if ($(this).val() !== '') {
                data[key] = $(this).val();
            }
        });

        if (section === 'login') {
            data.bg_image_id = $('#devapress_bg_login_file').val() || '';
            data.logo_id = $('#devapress_login_logo').val() || '';
        }

        return data;
    }

    function applyDashboardPreview(data) {
        var $mock = $('.devapress-mock-dashboard');
        if (!$mock.length) {
            return;
        }

        if (!data) {
            $mock.addClass('is-disabled');
            return;
        }

        $mock.removeClass('is-disabled').css({
            '--dp-menu': data.menu_color || '#1d2327',
            '--dp-menu-hover': data.menu_hover_color || '#2c3338',
            '--dp-menu-active': data.menu_active_color || '#2271b1',
            '--dp-text': data.font_color || '#f0f0f1',
            '--dp-text-hover': data.font_color_hover || '#72aee6',
            '--dp-text-active': data.font_color_active || '#fff',
            '--dp-icon': data.icon_color || '#a7aaad',
            '--dp-icon-active': data.icon_active_color || '#fff',
            '--dp-font-size': (data.font_size || '14') + 'px'
        });
    }

    function hexToRgb(hex) {
        hex = (hex || '').replace('#', '');
        if (hex.length !== 6) {
            return null;
        }
        return {
            r: parseInt(hex.substr(0, 2), 16),
            g: parseInt(hex.substr(2, 2), 16),
            b: parseInt(hex.substr(4, 2), 16)
        };
    }

    function applyLoginPreview(data) {
        var $mock = $('.devapress-mock-login');
        if (!$mock.length) {
            return;
        }

        if (!data) {
            $mock.addClass('is-disabled');
            return;
        }

        $mock.removeClass('is-disabled');

        var bg = '#f0f0f1';
        if (data.bg_gradient_enable === true || data.bg_gradient_enable === '1' || data.bg_gradient_enable === 1) {
            if (data.bg_gradient_color1 && data.bg_gradient_color2) {
                bg = 'linear-gradient(135deg, ' + data.bg_gradient_color1 + ', ' + data.bg_gradient_color2 + ')';
            }
        } else if (data.bg_color) {
            bg = data.bg_color;
        }

        var formBg = data.login_form_bg || '#ffffff';
        var glass = data.login_form_glass === true || data.login_form_glass === '1' || data.login_form_glass === 1;
        if (glass) {
            var rgb = hexToRgb(formBg) || { r: 255, g: 255, b: 255 };
            formBg = 'rgba(' + rgb.r + ',' + rgb.g + ',' + rgb.b + ',0.25)';
        } else if (data.login_form_bg2) {
            formBg = 'linear-gradient(135deg, ' + data.login_form_bg + ', ' + data.login_form_bg2 + ')';
        }

        $mock.css({
            'background': bg,
            '--dp-form-bg': formBg,
            '--dp-form-radius': (data.login_form_radius || '8') + 'px',
            '--dp-input-radius': (data.login_input_radius || '6') + 'px',
            '--dp-btn': data.login_btn_bg || '#2271b1',
            '--dp-btn-color': data.login_btn_color || '#ffffff',
            '--dp-btn-radius': (data.login_btn_radius || '4') + 'px',
            '--dp-label': data.login_label_color || '#3c434a',
            '--dp-glass': glass ? 'blur(10px)' : 'none'
        });
    }

    function refreshPreviews() {
        applyDashboardPreview(collectSectionSettings('dashboard'));
        applyLoginPreview(collectSectionSettings('login'));
    }

    function applyPresetToForm(section, presetId) {
        var base = getPresetBase(section, presetId);
        if (!base || presetId === 'none') {
            return;
        }

        $.each(base, function (key, value) {
            var $field = $('[name="devapress_settings[' + section + '][overrides][' + key + ']"]');
            if ($field.attr('type') === 'checkbox') {
                $field.prop('checked', !!value);
            } else if ($field.length && value !== undefined) {
                $field.val(value);
            }
        });

        refreshPreviews();
    }

    function saveLoginPreviewTransient() {
        var data = collectSectionSettings('login');
        if (!data || !config.ajaxUrl) {
            return;
        }

        $.post(config.ajaxUrl, {
            action: 'devapress_save_preview',
            nonce: config.nonce,
            preview: JSON.stringify(data)
        });
    }

    function debouncedPreviewUpdate() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(function () {
            refreshPreviews();
            saveLoginPreviewTransient();
        }, 300);
    }

    function reloadLoginIframe() {
        var $iframe = $('#devapress-login-iframe');
        if (!$iframe.length || getSelectedPreset('login') === 'none') {
            return;
        }
        var url = config.loginPreviewUrl + '&_=' + Date.now();
        $iframe.attr('src', url);
        $iframe.closest('.devapress-live-preview__iframe-wrap').show();
    }

    $(document).ready(function () {
        refreshPreviews();

        $('#devapress-settings-form').on('input change', '[data-dp-preview], [name*="devapress_settings"]', debouncedPreviewUpdate);

        $('input[data-dp-preset-input]').on('change', function () {
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
                applyPresetToForm(section, value);
            }

            debouncedPreviewUpdate();
            if (section === 'login') {
                setTimeout(reloadLoginIframe, 400);
            }
        });

        $('.devapress-open-real-login').on('click', function () {
            window.open(config.loginUrl, '_blank');
        });

        if (getSelectedPreset('login') !== 'none') {
            saveLoginPreviewTransient();
            setTimeout(reloadLoginIframe, 500);
        }
    });
})(jQuery, window.devapressPreview || {});
