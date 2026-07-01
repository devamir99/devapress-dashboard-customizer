<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * @var string $type     dashboard|login|none
 * @var string $preset_id
 * @var array|null $preset
 */
$is_none = ($preset_id === 'none' || empty($preset));

if ($is_none) : ?>
    <span class="devapress-preset-mock devapress-preset-mock--none">
        <span class="dashicons dashicons-wordpress"></span>
    </span>
<?php elseif ($type === 'dashboard') : ?>
    <span class="devapress-preset-mock devapress-preset-mock--dashboard"
          style="--dp-menu:<?php echo esc_attr($preset['menu_color']); ?>;
                 --dp-menu-hover:<?php echo esc_attr($preset['menu_hover_color']); ?>;
                 --dp-menu-active:<?php echo esc_attr($preset['menu_active_color']); ?>;
                 --dp-text:<?php echo esc_attr($preset['font_color']); ?>;
                 --dp-text-active:<?php echo esc_attr($preset['font_color_active']); ?>;
                 --dp-icon:<?php echo esc_attr($preset['icon_color']); ?>;">
        <span class="mock-sidebar">
            <span class="mock-item mock-item--active"></span>
            <span class="mock-item"></span>
            <span class="mock-item"></span>
        </span>
        <span class="mock-content">
            <span class="mock-bar"></span>
            <span class="mock-line"></span>
            <span class="mock-line mock-line--short"></span>
        </span>
    </span>
<?php else : ?>
    <?php
    $layout = $preset['login_layout'] ?? 'center';
    $grad1  = $preset['bg_gradient_color1'] ?? '#667eea';
    $grad2  = $preset['bg_gradient_color2'] ?? '#764ba2';
    $panel  = "linear-gradient(135deg, {$grad1}, {$grad2})";
    $form_bg = esc_attr($preset['login_form_bg'] ?? '#fff');
    $btn     = esc_attr($preset['login_btn_bg'] ?? '#2271b1');
    ?>
    <span class="devapress-preset-mock devapress-preset-mock--login devapress-preset-mock--layout-<?php echo esc_attr($layout); ?>"
          style="--dp-panel:<?php echo esc_attr($panel); ?>;
                 --dp-form-side:<?php echo esc_attr($preset['split_form_bg'] ?? '#f0f0f1'); ?>;
                 --dp-form-bg:<?php echo $form_bg; ?>;
                 --dp-btn:<?php echo $btn; ?>;">
        <?php if ($layout === 'split') : ?>
            <span class="mock-split">
                <span class="mock-split__form">
                    <span class="mock-logo-sm"></span>
                    <span class="mock-field"></span>
                    <span class="mock-field"></span>
                    <span class="mock-button"></span>
                </span>
                <span class="mock-split__panel"></span>
            </span>
        <?php elseif ($layout === 'fullscreen') : ?>
            <span class="mock-fullscreen">
                <span class="mock-fullscreen__bg"></span>
                <span class="mock-fullscreen__card">
                    <span class="mock-field"></span>
                    <span class="mock-field"></span>
                    <span class="mock-button"></span>
                </span>
            </span>
        <?php else : ?>
            <span class="mock-center">
                <span class="mock-center__card">
                    <span class="mock-logo-sm"></span>
                    <span class="mock-field"></span>
                    <span class="mock-field"></span>
                    <span class="mock-button"></span>
                </span>
            </span>
        <?php endif; ?>
    </span>
<?php endif; ?>
