<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( ! class_exists( 'Onnat_Theme_Woo_YITH_Whishlist' ) ) {

    /**
     * The Onnat woocommerce YITH Whishlist compatibility class.
     */
    class Onnat_Theme_Woo_YITH_Whishlist {

		/**
		 * A reference to an instance of this class.
		 */
		private static $instance = null;

		/**
		 * Returns the instance.
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
            }

			return self::$instance;

        }

		/**
		 * Constructor
		 */
        public function __construct() {

            /**
             * Remove default YITH Wishlist Styles
             * add_action( 'wp_enqueue_scripts', [ $this, 'deregister_styles' ] );
             */

			add_action( 'init', [ $this, 'remove_button' ], 15 );
			add_action( 'after_switch_theme', [ $this, 'update_settings' ] );

			/**
			 * To add yith wishlist element in Header Site Options
			 */
			add_filter( 'kinfw-filter/site-options/header/elements', [ $this, 'add_header_elements' ]  );
			add_filter( 'kinfw-filter/theme/header/action/buttons', [ $this, 'add_button' ], 10, 2 );

            add_action( 'woocommerce_before_shop_loop_item_title', [ $this, 'product_wishlist_button' ], 30 );
            add_filter( 'yith_wcwl_add_to_wishlist_icon_html', [ $this, 'product_wishlist_button_icon' ] );

            add_action( 'woocommerce_after_add_to_cart_button', [ $this, 'wishlist_button' ] );

            add_filter( 'yith_wcwl_edit_title_icon', '__return_false' );
            add_filter( 'yith_wcwl_cancel_wishlist_title_icon', '__return_false' );
            add_filter( 'yith_wcwl_add_to_wishlist_options', [ $this, 'add_to_wishlist_settings' ] );
            #add_filter( 'yith_wcwl_wishlist_page_options', [ $this, 'wishlist_page_settings' ] );

            /**
             * Header YITH Wishlist
             */
            add_action( 'wp_ajax_kinfw-action/theme/header/action/yith-wishlist', [ $this, 'ajax_wishlist_count' ] );
            add_action( 'wp_ajax_nopriv_kinfw-action/theme/header/action/yith-wishlist', [ $this, 'ajax_wishlist_count' ] );

        }

        public function deregister_styles() {
            if (wp_style_is( 'yith-wcwl-font-awesome', 'registered' ) ) {
                wp_deregister_style( 'yith-wcwl-font-awesome' );
            }
        }

        public function remove_button() {
            remove_action( 'woocommerce_single_product_summary', [ YITH_WCWL_Frontend::get_instance(), 'print_button' ], 31 );
            remove_action( 'woocommerce_product_thumbnails', [ YITH_WCWL_Frontend::get_instance(), 'print_button' ], 21 );
            remove_action( 'woocommerce_after_single_product_summary', [ YITH_WCWL_Frontend::get_instance(), 'print_button' ], 11 );
        }

        public function update_settings() {
            update_option( 'yith_wcwl_show_on_loop', 'no' );
            update_option( 'yith_wcwl_repeat_remove_button', 'no' );
            update_option( 'yith_wcwl_button_position', 'shortcode' );
        }

        public function add_header_elements( $header_elements ) {
            $header_elements['header_wishlist'] = esc_html__( 'YITH Whishlist', 'onnat' );

            return $header_elements;
        }

		public function add_button( $html, $action ) {
			if( 'header_wishlist' === $action ) {
				return kinfw_action_woo_yith_wishlist_trigger();
			}

			return $html;
		}

        public function product_wishlist_button() {
            echo do_shortcode( '[yith_wcwl_add_to_wishlist/]' );
        }

        public function product_wishlist_button_icon() {
			return kinfw_icon( 'heart-regular', '', 'i' );
        }

        /**
         * Single Product Wishlist Button
         */
        public function wishlist_button() {

            echo do_shortcode( '[yith_wcwl_add_to_wishlist]');
        }

        public function add_to_wishlist_settings( $settings ) {
			$options = [
				'general_section_start',
				'after_add_to_wishlist_behaviour',
				'general_section_end',

				'shop_page_section_start',
                'show_on_loop',
                'loop_position',
				'shop_page_section_end',

                'product_page_section_start',
                'add_to_wishlist_position',
                'product_page_section_end',

				'style_section_start',
                'use_buttons',
                'add_to_wishlist_colors',
                'rounded_buttons_radius',
                'add_to_wishlist_icon',
                'add_to_wishlist_custom_icon',
                'added_to_wishlist_icon',
                'added_to_wishlist_custom_icon',
                'custom_css',
                'style_section_end',
			];

            foreach( $options as $option ) {
                unset( $settings['settings-add_to_wishlist'][ $option]);
            }

            return $settings;
        }

        public function wishlist_page_settings( $settings ) {

			$options = [
				'style_section_start',
                'use_buttons',
                'add_to_cart_colors',
                'rounded_buttons_radius',

                'add_to_cart_icon',
                'add_to_cart_custom_icon',
                'style_1_button_colors',

                'style_2_button_colors',
                'wishlist_table_style',
                'headings_style',

                'share_colors',
                'fb_button_icon',
                'fb_button_custom_icon',
                'fb_button_colors',

                'tw_button_icon',
                'tw_button_custom_icon',
                'tw_button_colors',

                'pr_button_icon',
                'pr_button_custom_icon',
                'pr_button_colors',

                'em_button_icon',
                'em_button_custom_icon',
                'em_button_colors',

                'wa_button_icon',
                'wa_button_custom_icon',
                'wa_button_colors',

                'style_section_end',
			];

            foreach( $options as $option ) {
                unset( $settings['settings-wishlist_page'][ $option]);
            }

            return $settings;
        }

        /**
         * Header : YITH Wishlist count
         */
        public function ajax_wishlist_count() {

            if( function_exists( 'yith_wcwl_count_all_products' ) ) {

                $count = yith_wcwl_count_all_products();
                $class = $count ? 'kinfw-show' : 'kinfw-hidden';

                wp_send_json_success( [
                    'count' => $count,
                    'class' => 'kinfw-header-wishlist-count '.$class
                ] );

            } else {
                wp_send_json_error( [
                    'msg' => sprintf('<span class="kinfw-failure-msg">%1$s</span>', esc_html__('something went wrong.', 'onnat' )  ),
                ] );
            }

            wp_die();
        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_woo_yith_wishlist' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_woo_yith_wishlist() {

        return Onnat_Theme_Woo_YITH_Whishlist::get_instance();
    }

}

kinfw_onnat_theme_woo_yith_wishlist();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */