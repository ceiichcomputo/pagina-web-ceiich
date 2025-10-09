<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( ! class_exists( 'Onnat_Theme_Woo_Cart' ) ) {

    /**
     * The Onnat woocommerce cart class.
     */
    class Onnat_Theme_Woo_Cart {

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

			add_filter( 'kinfw-filter/theme/L10n', [ $this, 'i18N' ] );
			add_filter( 'wc_empty_cart_message', [ $this, 'empty_cart_msg' ] );

			add_action( 'kinfw-action/theme/woo/cart/buttons', [ $this, 'continue_shoping_btn' ], 10 );
			add_action( 'kinfw-action/theme/woo/cart/buttons', [ $this, 'empty_cart_btn' ], 20 );
			add_action( 'woocommerce_init', [ $this, 'clear_cart' ] );

			add_filter( 'woocommerce_cart_item_thumbnail', [ $this, 'cart_item_thumbnail' ], 10, 3 );

			remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
			add_action( 'woocommerce_after_cart', [ $this, 'cross_sell_display'] );

			if( function_exists('kf_woo_swatches_plugin_cart') ) {
				remove_action( 'woocommerce_before_cart_contents', [ KinForce_Woo_Swatches_Cart::get_instance([]), 'start_capture'], 1 );
				remove_action( 'woocommerce_cart_contents', [ KinForce_Woo_Swatches_Cart::get_instance([]), 'stop_capture'], 1 );
			}

        }

		public function i18n( $localize ) {

			if( !isset( $localize[ 'empty_cart' ] ) ) {

				$localize[ 'empty_cart' ] = esc_html__( 'Are you sure you want to empty cart?', 'onnat' );
			}

			return $localize;

		}

		public function empty_cart_msg() {
			return sprintf( esc_html__( '%1$s Your cart is currently empty', 'onnat' ), kinfw_icon( 'shopping-cart', 'kinfw-empty-cart' ) );
		}

		public function continue_shoping_btn() {

            if ( wc_get_page_id( 'shop' ) > 0 ) {

                printf( '<!-- .kinfw-woo-cart-shop-button -->
                    <a href="%1$s" class="kinfw-woo-cart-shop-button">%2$s</a>
                    <!-- /.kinfw-woo-cart-shop-button -->',
                    esc_url( wc_get_page_permalink( 'shop' ) ),
                    esc_html__('Continue Shopping', 'onnat')
                );
            }

		}

		public function empty_cart_btn() {

            $cart_url = wc_get_cart_url();
            $cart_url = add_query_arg( ['kinfw-empty-cart' => '1' ], $cart_url );

            printf( '<!-- .kinfw-woo-empty-cart-button -->
                <a href="%1$s" class="kinfw-woo-empty-cart-button">%2$s</a>
                <!-- /.kinfw-woo-empty-cart-button -->',
                esc_url( $cart_url ),
                esc_html__('Empty Cart', 'onnat')
            );

		}

		public function clear_cart() {

			if( isset( $_GET['kinfw-empty-cart'] ) && '1' === $_GET['kinfw-empty-cart'] ) {

                WC()->cart->empty_cart();

                $cart_url = wc_get_cart_url();

                wp_redirect( $cart_url );
                exit();

			}

		}

        public function cart_item_thumbnail( $thumbnail, $cart_item, $cart_item_key ) {

            $_product = $cart_item['data'];
            $_image   = is_cart() ?  $_product->get_image( [100, 100 ] ) : $_product->get_image( [ 70, 70 ] );

            return $_image;
        }

		public function cross_sell_display() {

			if ( is_checkout() ) {
				return;
			}

            $limit   = 2;
            $columns = 2;
            $orderby = 'rand';
            $order   = 'desc';

			// Get visible cross sells then sort them at random.
			$cross_sells = array_filter( array_map( 'wc_get_product', WC()->cart->get_cross_sells() ), 'wc_products_array_filter_visible' );

			wc_set_loop_prop( 'name', 'cross-sells' );
			wc_set_loop_prop( 'columns', apply_filters( 'woocommerce_cross_sells_columns', $columns ) );
			wc_set_loop_prop( 'kinfw-loop-class', 'kinfw-col-12 kinfw-col-lg-4 kinfw-col-md-6 kinfw-col-sm-12 kinfw-col-xl-3' );

			// Handle orderby and limit results.
			$orderby     = apply_filters( 'woocommerce_cross_sells_orderby', $orderby );
			$order       = apply_filters( 'woocommerce_cross_sells_order', $order );
			$cross_sells = wc_products_array_orderby( $cross_sells, $orderby, $order );
			$limit       = intval( apply_filters( 'woocommerce_cross_sells_total', $limit ) );
			$cross_sells = $limit > 0 ? array_slice( $cross_sells, 0, $limit ) : $cross_sells;

			wc_get_template( 'cart/cross-sells.php',[
				'cross_sells'    => $cross_sells,

				// Not used now, but used in previous version of up-sells.php.
				'posts_per_page' => $limit,
				'orderby'        => $orderby,
				'columns'        => $columns,
			]);

		}

    }

}

if( !function_exists( 'kinfw_onnat_theme_woo_cart' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_woo_cart() {

        return Onnat_Theme_Woo_Cart::get_instance();
    }

}

kinfw_onnat_theme_woo_cart();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */