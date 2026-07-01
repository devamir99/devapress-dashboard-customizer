<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * @var string $section   dashboard|login
 * @var string $name_attr form field name prefix e.g. devapress_settings[dashboard][preset]
 * @var string $current   current preset id
 */
$presets = Devapress_Presets::list_for_section($section);
?>
<div class="devapress-preset-grid" data-section="<?php echo esc_attr($section); ?>">
    <label class="devapress-preset-card <?php echo $current === 'none' ? 'is-selected' : ''; ?>">
        <input type="radio"
               name="<?php echo esc_attr($name_attr); ?>"
               value="none"
            <?php checked($current, 'none'); ?>>
        <span class="devapress-preset-preview devapress-preset-preview--none">
            <span class="dashicons dashicons-dismiss"></span>
        </span>
        <span class="devapress-preset-label">بدون تغییر</span>
        <span class="devapress-preset-desc">استایل پیش‌فرض وردپرس</span>
    </label>

    <?php foreach ($presets as $id => $preset) : ?>
        <label class="devapress-preset-card <?php echo $current === $id ? 'is-selected' : ''; ?>">
            <input type="radio"
                   name="<?php echo esc_attr($name_attr); ?>"
                   value="<?php echo esc_attr($id); ?>"
                <?php checked($current, $id); ?>>
            <span class="devapress-preset-preview devapress-preset-preview--<?php echo esc_attr($id); ?>"></span>
            <span class="devapress-preset-label"><?php echo esc_html($preset['label']); ?></span>
            <span class="devapress-preset-desc"><?php echo esc_html($preset['description']); ?></span>
        </label>
    <?php endforeach; ?>
</div>
