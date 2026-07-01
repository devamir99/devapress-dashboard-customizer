<?php
if (!defined('ABSPATH')) {
    exit;
}
/** @var string $css */
/** @var string $logo_url */
/** @var array $data */
$layout = sanitize_html_class($data['login_layout'] ?? 'center');
$body_classes = 'login devapress-customized devapress-layout-' . $layout;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php esc_html_e('Login Preview', 'devapress-customizer'); ?></title>
    <link rel="stylesheet" href="<?php echo esc_url(DEVAPRESS_CSS_URL . 'login.css'); ?>?v=<?php echo esc_attr(DEVAPRESS_VERSION); ?>">
    <style>
        <?php echo $css; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
    </style>
</head>
<body class="<?php echo esc_attr($body_classes); ?>">
<div id="login">
    <h1>
        <a href="#" <?php echo $logo_url ? 'style="background-image:url(' . esc_url($logo_url) . ')"' : ''; ?>>
            <?php bloginfo('name'); ?>
        </a>
    </h1>
    <form id="loginform">
        <p>
            <label for="user_login"><?php esc_html_e('Username or Email Address', 'devapress-customizer'); ?></label>
            <input type="text" id="user_login" disabled placeholder="admin">
        </p>
        <p>
            <label for="user_pass"><?php esc_html_e('Password', 'devapress-customizer'); ?></label>
            <input type="password" id="user_pass" disabled placeholder="••••••••">
        </p>
        <p>
            <input type="submit" value="<?php esc_attr_e('Log In', 'devapress-customizer'); ?>" disabled>
        </p>
    </form>
    <p id="nav"><a href="#"><?php esc_html_e('Lost your password?', 'devapress-customizer'); ?></a></p>
    <p id="backtoblog"><a href="#">&larr; <?php esc_html_e('Go to', 'devapress-customizer'); ?> <?php bloginfo('name'); ?></a></p>
</div>
</body>
</html>
