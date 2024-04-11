<?php
/**
 * Plugin Name: Script Blocker
 * Description: Blocks scripts based on specified keywords.
 * Version: 1.0
 * Author: Your Name
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function sb_add_admin_menu() {
    add_options_page(
        'Script Blocker Settings',
        'Script Blocker',
        'manage_options',
        'script-blocker',
        'sb_settings_page'
    );
}
add_action('admin_menu', 'sb_add_admin_menu');

function sb_settings_page() {
    ?>
    <div class="wrap">
        <h2>Script Blocker Settings</h2>
        <form method="post" action="options.php">
            <?php
            settings_fields('sb_settings');
            do_settings_sections('sb_settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function sb_register_settings() {
    register_setting('sb_settings', 'sb_keywords');
    register_setting('sb_settings', 'sb_enable_blocking');

    add_settings_section('sb_main_section', null, null, 'sb_settings');

    add_settings_field(
        'sb_keywords_field',
        'Keywords to Block',
        'sb_keywords_field_render',
        'sb_settings',
        'sb_main_section'
    );

    add_settings_field(
        'sb_enable_blocking_field',
        'Enable Blocking',
        'sb_enable_blocking_field_render',
        'sb_settings',
        'sb_main_section'
    );
}
add_action('admin_init', 'sb_register_settings');

function sb_keywords_field_render() {
    $options = get_option('sb_keywords');
    echo '<input type="text" name="sb_keywords" value="' . esc_attr($options) . '"/>';
}

function sb_enable_blocking_field_render() {
    $options = get_option('sb_enable_blocking');
    echo '<input type="checkbox" name="sb_enable_blocking" ' . checked(1, $options, false) . '/>';
}

function sb_block_scripts($buffer) {
    if (!get_option('sb_enable_blocking')) {
        return $buffer;
    }

    $keywords = explode(',', get_option('sb_keywords'));
    if (empty($keywords)) {
        return $buffer;
    }

    foreach ($keywords as $keyword) {
        $keyword = trim($keyword);
        if (empty($keyword)) {
            continue;
        }

        $buffer = preg_replace(
            '/<script\s+(.*?)type=[\'"]?text\/javascript[\'"]?(.*?)src=[\'"]?(.*?' . preg_quote($keyword) . '.*?)["\']?(.*?)>/',
            '<script $1 type="text/plain" src="$3$4>',
            $buffer
        );
    }

    return $buffer;
}
add_action('template_redirect', function() {
    ob_start('sb_block_scripts');
});

function sb_activate() {
    add_option('sb_enable_blocking', '0');
    add_option('sb_keywords', '');
}
register_activation_hook(__FILE__, 'sb_activate');

function sb_deactivate() {
    delete_option('sb_enable_blocking');
    delete_option('sb_keywords');
}
register_deactivation_hook(__FILE__, 'sb_deactivate');
