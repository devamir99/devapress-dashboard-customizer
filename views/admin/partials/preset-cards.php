<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * @var string $section   dashboard|login
 * @var string $name_attr form field name prefix
 * @var string $current   current preset id
 */
$presets = Devapress_Presets::list_for_section($section);
$type    = $section;
?>
<div class="devapress-preset-grid" data-section="<?php echo esc_attr($section); ?>">
    <label class="devapress-preset-card <?php echo $current === 'none' ? 'is-selected' : ''; ?>">
        <input type="radio"
               name="<?php echo esc_attr($name_attr); ?>"
               value="none"
               data-dp-preset-input
            <?php checked($current, 'none'); ?>>
        <?php
        $preset_id = 'none';
        $preset    = null;
        include DEVAPRESS_PLUGIN_DIR . 'views/admin/partials/preset-thumbnail.php';
        ?>
        <span class="devapress-preset-label">بدون تغییر</span>
        <span class="devapress-preset-desc">استایل پیش‌فرض وردپرس</span>
    </label>

    <?php foreach ($presets as $id => $preset) : ?>
        <label class="devapress-preset-card <?php echo $current === $id ? 'is-selected' : ''; ?>">
            <input type="radio"
                   name="<?php echo esc_attr($name_attr); ?>"
                   value="<?php echo esc_attr($id); ?>"
                   data-dp-preset-input
                <?php checked($current, $id); ?>>
            <?php
            $preset_id = $id;
            include DEVAPRESS_PLUGIN_DIR . 'views/admin/partials/preset-thumbnail.php';
            ?>
            <span class="devapress-preset-label"><?php echo esc_html($preset['label']); ?></span>
            <span class="devapress-preset-desc"><?php echo esc_html($preset['description']); ?></span>
        </label>
    <?php endforeach; ?>
</div>
