<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly to prevent unauthorized access

/**
 * Fetch saved color options from the database.
 * If not set, provide default fallback values.
 */
$menu_color                    = get_option('devapress_menu_color', '#0073aa'); // Normal dashboard menu background
$icon_color                    = get_option('devapress_icon_color', '#9ca2a7'); // Normal icon color
$icon_color_hover              = get_option('devapress_icon_hover_color', '#9ca2a7'); // Icon color on hover
$background_menu_color         = get_option('devapress_menu_color', '#1d2327'); // Menu background (normal)
$background_menu_hover_color   = get_option('devapress_menu_hover_color', '#1d2327'); // Menu background (hover)
$background_menu_active_color  = get_option('devapress_menu_active_color', '#9ca2a7'); // Menu background (active)
$icon_color_active             = get_option('devapress_icon_active_color', '#9ca2a7'); // Icon color (active)
?>

<!-- Dashboard Background - Normal -->
<div class="devapress-setting-card">
    <h3>رنگ پس زمینه داشبورد(حالت عادی)</h3>
    <div class="devapress-color-wrapper">
        <!-- Color input for normal dashboard background -->
        <input type="color" name="devapress_menu_color" value="<?php echo esc_attr($background_menu_color); ?>">
        <!-- Preview of the selected color -->
        <span class="devapress-color-preview" style="background-color:<?php echo esc_attr($background_menu_color); ?>;"></span>
    </div>
</div>

<!-- Dashboard Background - Hover -->
<div class="devapress-setting-card">
    <h3>رنگ پس زمینه داشبورد(حالت هاور)</h3>
    <div class="devapress-color-wrapper">
        <!-- Color input for dashboard background on hover -->
        <input type="color" name="devapress_menu_hover_color" value="<?php echo esc_attr($background_menu_hover_color); ?>">
        <span class="devapress-color-preview" style="background-color:<?php echo esc_attr($background_menu_hover_color); ?>;"></span>
    </div>
</div>

<!-- Dashboard Background - Active -->
<div class="devapress-setting-card">
    <h3>رنگ پس زمینه داشبورد(حالت فعال)</h3>
    <div class="devapress-color-wrapper">
        <!-- Color input for active dashboard background -->
        <input type="color" name="devapress_menu_active_color" value="<?php echo esc_attr($background_menu_active_color); ?>">
        <span class="devapress-color-preview" style="background-color:<?php echo esc_attr($background_menu_active_color); ?>;"></span>
    </div>
</div>

<!-- Icon Color - Normal -->
<div class="devapress-setting-card">
    <h3>رنگ آیکن ها (حالت عادی)</h3>
    <div class="devapress-color-wrapper">
        <!-- Color input for normal icon color -->
        <input type="color" name="devapress_icon_color" value="<?php echo esc_attr($icon_color); ?>">
        <span class="devapress-color-preview" style="background-color:<?php echo esc_attr($icon_color); ?>;"></span>
    </div>
</div>

<!-- Icon Color - Hover -->
<div class="devapress-setting-card">
    <h3>رنگ آیکن ها (حالت هاور)</h3>
    <div class="devapress-color-wrapper">
        <!-- Color input for icon color on hover -->
        <input type="color" name="devapress_icon_hover_color" value="<?php echo esc_attr($icon_color_hover); ?>">
        <span class="devapress-color-preview" style="background-color:<?php echo esc_attr($icon_color_hover); ?>;"></span>
    </div>
</div>

<!-- Icon Color - Active -->
<div class="devapress-setting-card">
    <h3>رنگ آیکن ها (حالت فعال)</h3>
    <div class="devapress-color-wrapper">
        <!-- Color input for active icon color -->
        <input type="color" name="devapress_icon_active_color" value="<?php echo esc_attr($icon_color_active); ?>">
        <span class="devapress-color-preview" style="background-color:<?php echo esc_attr($icon_color_active); ?>;"></span>
    </div>
</div>
