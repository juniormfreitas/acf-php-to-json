<?php
/*
* @link https://github.com/juniormfreitas/acf-php-to-json
* @since 0.0.1
*
* Plugin Name: ACF PHP to JSON Converter
* Description: Convert Advanced Custom Fields Pro migration file from PHP to JSON format in order to provide a better experience to developers in legacy Wordpress websites.
* Version: 0.0.3
* Author: Jose de Freitas
* Author URI: https://jfreitas.dev
* Plugin URI: https://github.com/juniormfreitas/acf-php-to-json
* Text Domain: acf-php-to-json
* Domain Path: /languages/
*/

if (!defined('ABSPATH')) {
    exit;
}

if (!defined('ACF_PHP_TO_JSON_VERSION')) {
    define('ACF_PHP_TO_JSON_VERSION', '0.0.3');
}

if (!defined('ACF_PHP_TO_JSON_NAME')) {
    define('ACF_PHP_TO_JSON_NAME', 'ACF PHP to JSON Converter');
}

if (!defined('ACF_PHP_TO_JSON_PAGE_TITLE')) {
    define('ACF_PHP_TO_JSON_PAGE_TITLE', 'ACF - Convert PHP migration fields to JSON');
}

if (!defined('ACF_PHP_TO_JSON_SLUG')) {
    define('ACF_PHP_TO_JSON_SLUG', 'acf-php-to-json');
}

if (!defined('ACF_PHP_TO_JSON_POST_TYPE')) {
    define('ACF_PHP_TO_JSON_POST_TYPE', 'acf-field-group');
}

if (!defined('ACF_PHP_TO_JSON_MENU_TITLE')) {
    define('ACF_PHP_TO_JSON_MENU_TITLE', __('Convert PHP to JSON', ACF_PHP_TO_JSON_SLUG));
}

if (!defined('ACF_PHP_TO_JSON_BASENAME')) {
    define('ACF_PHP_TO_JSON_BASENAME', plugin_basename(__FILE__));
}

if (!defined('ACF_PHP_TO_JSON_PLUGIN_DIR')) {
    define('ACF_PHP_TO_JSON_PLUGIN_DIR', plugin_dir_path(__FILE__));
}

load_plugin_textdomain(ACF_PHP_TO_JSON_SLUG, false, ACF_PHP_TO_JSON_SLUG . '/languages/');

if (is_admin()) {
    require_once ACF_PHP_TO_JSON_PLUGIN_DIR . '/admin/acf-php-to-json-admin.php';

    function acf_php_to_json_admin_scripts()
    {
        wp_enqueue_media();
        wp_enqueue_style(ACF_PHP_TO_JSON_SLUG, plugins_url('/admin/css/acf-php-to-json.css', __FILE__), array(), '1.0');
        wp_enqueue_script(ACF_PHP_TO_JSON_SLUG, plugins_url('/admin/js/acf-php-to-json.js', __FILE__), array(), '1.0', true);
    }
    add_action('admin_enqueue_scripts', 'acf_php_to_json_admin_scripts');

    function acf_php_to_json_init_plugin()
    {
        $PhpToJson = new Acf_Php_To_Json_Converter(ACF_PHP_TO_JSON_NAME, ACF_PHP_TO_JSON_SLUG, ACF_PHP_TO_JSON_VERSION);
        add_submenu_page('edit.php?post_type=' . ACF_PHP_TO_JSON_POST_TYPE, ACF_PHP_TO_JSON_PAGE_TITLE, ACF_PHP_TO_JSON_MENU_TITLE, 'manage_options', ACF_PHP_TO_JSON_SLUG, function () use ($PhpToJson) {
            echo $PhpToJson->renderMainPage();
        });
    }

    add_action('admin_menu', 'acf_php_to_json_init_plugin', 20);
}
