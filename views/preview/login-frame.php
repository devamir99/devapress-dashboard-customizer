<?php
if (!defined('ABSPATH')) {
    exit;
}
/** @var string $css */
/** @var string $logo_url */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php esc_html_e('Login Preview', 'devapress-customizer'); ?></title>
    <style>
        body.login {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
        }
        #login {
            width: 320px;
            padding: 8% 0 0;
        }
        #login h1 a {
            display: block;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            width: 84px;
            height: 84px;
            margin: 0 auto 25px;
            text-indent: -9999px;
            overflow: hidden;
        }
        #loginform {
            margin: 0;
            padding: 26px 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,.13);
        }
        #loginform label {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
        }
        #loginform input[type="text"],
        #loginform input[type="password"] {
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 16px;
            padding: 8px 10px;
            font-size: 14px;
        }
        #loginform input[type="submit"] {
            width: 100%;
            padding: 8px 12px;
            font-size: 14px;
            cursor: pointer;
            border: none;
        }
        #nav, #backtoblog {
            text-align: center;
            margin-top: 16px;
            font-size: 13px;
        }
        #nav a, #backtoblog a {
            text-decoration: none;
        }
        <?php echo $css; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
    </style>
</head>
<body class="login devapress-customized">
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
