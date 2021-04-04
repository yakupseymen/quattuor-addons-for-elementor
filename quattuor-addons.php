<?php
/**
 * Plugin Name: Quattuor Addons for Elementor
 * Description: Simple Elementor extension.
 * Version: 0.1.1
 * Author: J4
 * Author URI:  https://j4cob.net
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: quattuor-addons
 * 
 * Quattuor Addons for Elementor is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 * 
 * Quattuor Addons for Elementor is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Main Quattuor Addons for Elementor Class
 */
if ( !class_exists( 'Quattuor_Addons' ) ) {
    final class Quattuor_Addons {

        const VERSION = '0.1.1';
        const MINIMUM_ELEMENTOR_VERSION = '3.0.0';
        const MINIMUM_PHP_VERSION = '7.0';

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
            return self::$_instance;

        }

        public function __construct() {

            add_action( 'plugins_loaded', [ $this, 'on_plugins_loaded' ] );

        }

        public function i18n() {

            load_plugin_textdomain( 'quattuor-addons' );

        }

        /**
         * On Plugins Loaded
         *
         * Checks if Elementor has loaded, and performs some compatibility checks.
         * If All checks pass, inits the plugin.
         *
         * Fired by `plugins_loaded` action hook.
         *
         * @since 0.1.0
         *
         * @access public
         */
        public function on_plugins_loaded() {

            if ( $this->is_compatible() ) {
                add_action( 'elementor/init', [ $this, 'init' ] );
            }

        }

        /**
         * Compatibility Checks
         *
         * Checks if the installed version of Elementor meets the plugin's minimum requirement.
         * Checks if the installed PHP version meets the plugin's minimum requirement.
         *
         * @since 0.1.0
         *
         * @access public
         */
        public function is_compatible() {

            // Check if Elementor installed and activated
            if ( ! did_action( 'elementor/loaded' ) ) {
                add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
                return false;
            }

            // Check for required Elementor version
            if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
                add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
                return false;
            }

            // Check for required PHP version
            if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
                add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
                return false;
            }

            return true;

        }

        /**
         * Initialize the plugin
         *
         * Load the plugin only after Elementor (and other plugins) are loaded.
         * Load the files required to run the plugin.
         *
         * Fired by `plugins_loaded` action hook.
         *
         * @since 0.1.0
         *
         * @access public
         */
        public function init() {
        
            $this->i18n();

            // Add Plugin actions
            add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
            add_action( 'elementor/elements/categories_registered', [ $this, 'add_elementor_widget_categories' ] );
            add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'widget_styles' ] );
            add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );
            add_filter( 'woocommerce_add_to_cart_fragments', [ $this, 'woocommerce_header_add_to_cart_fragment'] );

        }

        public function init_widgets() {

            // Include Widget files & Register widget
            if (class_exists('WooCommerce')){
                require_once( __DIR__ . '/widgets/header/cart.php' );
                \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Quattuor_Header_Cart() );
                require_once( __DIR__ . '/widgets/header/my-account.php' );
                \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Quattuor_Header_Account() );
            }

            require_once( __DIR__ . '/widgets/header/search.php' );
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Quattuor_Header_Search() );
            require_once( __DIR__ . '/widgets/header/vertical-menu.php' );
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Quattuor_Vertical_Menu() );
        }

        function add_elementor_widget_categories( $elements_manager ) {

            $elements_manager->add_category(
                'cat-quattuor',
                [
                    'title' => __( 'Quattuor Addons', 'quattuor-addons' ),
                    'icon' => 'fa fa-plug',
                ]
            );
            $elements_manager->add_category(
                'quattuor-header',
                [
                    'title' => __( 'Quattuor Header Addons', 'quattuor-addons' ),
                    'icon' => 'fa fa-plug',
                ]
            );
        
        }

        public function widget_styles() {

            wp_register_style( 'quattuor-addons-widgets', plugins_url( 'assets/css/widgets.css', __FILE__ ) );
            wp_enqueue_style( 'quattuor-addons-widgets' );

        }

        public function widget_scripts() {

            wp_register_script( 'quattuor-addons-widgets', plugins_url( 'assets/js/widgets.js', __FILE__ ) );
            wp_enqueue_script( 'quattuor-addons-widgets' );
    
        }

        public function woocommerce_header_add_to_cart_fragment( $fragments ) {   
            $fragments['span.quattuor-cart-badge'] = '<span class="quattuor-cart-badge flex-center">' . WC()->cart->get_cart_contents_count() . '</span>';
            $fragments['div.quattuor-cart-total'] = '<div class="quattuor-cart-total">' . WC()->cart->get_cart_total() . '</div>';
            return $fragments;
        }
        

        public function admin_notice_missing_main_plugin() {

            if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

            $message = sprintf(
                /* translators: 1: Plugin name 2: Elementor */
                esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'quattuor-addons' ),
                '<strong>' . esc_html__( 'Quattuor Addons for Elementor', 'quattuor-addons' ) . '</strong>',
                '<strong>' . esc_html__( 'Elementor', 'quattuor-addons' ) . '</strong>'
            );

            printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

        }

        public function admin_notice_minimum_elementor_version() {

            if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

            $message = sprintf(
                /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
                esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'quattuor-addons' ),
                '<strong>' . esc_html__( 'Quattuor Addons for Elementor', 'quattuor-addons' ) . '</strong>',
                '<strong>' . esc_html__( 'Elementor', 'quattuor-addons' ) . '</strong>',
                self::MINIMUM_ELEMENTOR_VERSION
            );

            printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

        }

        public function admin_notice_minimum_php_version() {

            if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

            $message = sprintf(
                /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
                esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'quattuor-addons' ),
                '<strong>' . esc_html__( 'Quattuor Addons for Elementor', 'quattuor-addons' ) . '</strong>',
                '<strong>' . esc_html__( 'PHP', 'quattuor-addons' ) . '</strong>',
                self::MINIMUM_PHP_VERSION
            );

            printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

        }

    }

    Quattuor_Addons::instance();

}