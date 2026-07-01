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
    $bg = '';
    if (!empty($preset['bg_gradient_enable']) && !empty($preset['bg_gradient_color1']) && !empty($preset['bg_gradient_color2'])) {
        $bg = 'linear-gradient(135deg, ' . esc_attr($preset['bg_gradient_color1']) . ', ' . esc_attr($preset['bg_gradient_color2']) . ')';
    } elseif (!empty($preset['bg_color'])) {
        $bg = esc_attr($preset['bg_color']);
    } else {
        $bg = 'linear-gradient(135deg, #667eea, #764ba2)';
    }
    $glass = !empty($preset['login_form_glass']);
    $form_bg = $glass ? 'rgba(255,255,255,0.2)' : esc_attr($preset['login_form_bg'] ?? '#fff');
    ?>
    <span class="devapress-preset-mock devapress-preset-mock--login"
          style="background:<?php echo esc_attr($bg); ?>;
                 --dp-form-bg:<?php echo esc_attr($form_bg); ?>;
                 --dp-form-radius:<?php echo esc_attr($preset['login_form_radius'] ?? '8'); ?>px;
                 --dp-btn:<?php echo esc_attr($preset['login_btn_bg'] ?? '#2271b1'); ?>;
                 <?php echo $glass ? '--dp-glass:blur(4px);' : ''; ?>">
        <span class="mock-logo"></span>
        <span class="mock-form">
            <span class="mock-field"></span>
            <span class="mock-field"></span>
            <span class="mock-button"></span>
        </span>
    </span>
<?php endif; ?>
