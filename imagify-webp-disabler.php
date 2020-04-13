<?php
/**
* Plugin Name: Imagify WebP Picture Tag replacement Disabler
* Description: Plugin to prevent, programmatically, the replacement of <img> tags with <picture>, when Imagify WebP feature is enabled.
* Version:     1
* Author:      Jose Sotelo
* Author URI:  https://inboundlatino.com/
* Text Domain: imagify-webp-disabler
*/
if ( ! defined( 'ABSPATH' ) ) {
exit; // Exit if accessed directly.
}
final class Imagify_webp_disabler{
    private static $_instance = null;
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    const MINIMUM_PHP_VERSION = '5.4';
    public function __construct() {
        add_action( 'plugins_loaded', [ $this, 'init' ] );
    }
    public function init()
    {
        // Check for required PHP version
        if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);
            return;
        }
        // Check if Imagify Exists
        if (!function_exists('_imagify_init')) {
            add_action('admin_notices', [$this, 'admin_notice_missing_main_plugin']);
            return;
        }
        // Add Plugin actions
        require_once('plugin.php');
    }
    public function admin_notice_missing_main_plugin() {
        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
        $message = sprintf(
            esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'imagify-webp-disabler' ),
            '<strong>' . esc_html__( 'Imagify WebP Picture Tag replacement Disabler', 'imagify-webp-disabler' ) . '</strong>',
            '<strong>' . esc_html__( 'Imagify', 'imagify-webp-disabler' ) . '</strong>'
        );
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }
    public function admin_notice_minimum_php_version() {
        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
        $message = sprintf(
        /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'imagify-webp-disabler' ),
            '<strong>' . esc_html__( 'Imagify WebP Picture Tag replacement Disabler', 'imagify-webp-disabler' ) . '</strong>',
            '<strong>' . esc_html__( 'PHP', 'imagify-webp-disabler' ) . '</strong>',
            self::MINIMUM_PHP_VERSION
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }
}
Imagify_webp_disabler::instance();
