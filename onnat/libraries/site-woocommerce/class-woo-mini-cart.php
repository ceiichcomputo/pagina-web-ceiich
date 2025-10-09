<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( ! class_exists( 'Onnat_Theme_Woo_Mini_Cart' ) ) {

    /**
     * The Onnat woocommerce mini cart class.
     */
    class Onnat_Theme_Woo_Mini_Cart {

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
			 * To add mini cart element in Header Site Options
			 */
			add_filter( 'kinfw-filter/site-options/header/elements', [ $this, 'add_header_elements' ]  );

			/**
			 * To show mini cart element in Headers
			 */
			add_filter( 'kinfw-filter/theme/header/action/buttons', [ $this, 'add_button' ], 10, 2 );

			/**
			 * To append mini cart content in site.
			 */
			add_action( 'kinfw-action/theme/header/action/forms', [ $this, 'mini_cart' ] );

			add_filter( 'woocommerce_add_to_cart_fragments', [ $this, 'header_cart_count_fragment' ] );

			/**
			 * woocommerce filter to adjust or modify the mini cart widget
			 */
			add_action( 'woocommerce_after_mini_cart', [ $this, 'alt_mini_cart' ] );

        }

		public function add_header_elements( $header_elements ) {

            $header_elements['header_cart'] = esc_html__( 'Cart', 'onnat' );

            return $header_elements;
		}

		public function add_button( $html, $action ) {

			if( 'header_cart' === $action ) {
				return kinfw_action_woo_min_cart_trigger();
			}

			return $html;
		}

		public function mini_cart( $action ) {
			if( 'header_cart' === $action ) {
				add_action( 'wp_footer', 'kinfw_action_header_mini_cart', -1 );
			}
		}

        public function header_cart_count_fragment( $fragments ) {

            $count = esc_html( WC()->cart->get_cart_contents_count() );

            $fragments['.kinfw-header-cart-count'] = sprintf( '<span class="kinfw-header-cart-count %1$s">%2$s</span>',
                $count ? 'kinfw-show': 'kinfw-hidden',
                $count
            );

            return $fragments;
        }

		public function alt_mini_cart() {
			if ( WC()->cart->is_empty() ) {
                $shop_id = get_option( 'woocommerce_shop_page_id' );

                if( !empty( $shop_id ) ) {

					printf( '<a href="%1$s" class="kinfw-start-shopping button">%2$s</a>',
                        esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ),
                        esc_html__( 'Start shopping', 'onnat' )
                    );

				}

			}
		}

    }

}

if( !function_exists( 'kinfw_onnat_theme_woo_mini_cart' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_woo_mini_cart() {

        return Onnat_Theme_Woo_Mini_Cart::get_instance();
    }

}

kinfw_onnat_theme_woo_mini_cart();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */