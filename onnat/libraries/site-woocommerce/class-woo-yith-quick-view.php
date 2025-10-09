<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( ! class_exists( 'Onnat_Theme_Woo_YITH_Quick_View' ) ) {

    /**
     * The Onnat woocommerce YITH Quick View compatibility class.
     */
    class Onnat_Theme_Woo_YITH_Quick_View {

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

			add_action( 'init', [ $this, 'remove_button' ], 15 );

			add_action( 'woocommerce_before_shop_loop_item_title', [
				YITH_WCQV_Frontend::get_instance(),
                'yith_add_quick_view_button'
            ], 30 );

			add_filter( 'yith_add_quick_view_button_html', [ $this, 'quick_view_button' ], 10, 3 );

            /**
             * Quick View Content
             */
                add_action( 'kinfw-action/theme/woo/yith-quick-view/product/image', 'woocommerce_show_product_images' );

                add_action( 'kinfw-action/theme/woo/yith-quick-view/product/summary', [ $this, 'quick_view_product_title' ], 1 );
                add_action( 'kinfw-action/theme/woo/yith-quick-view/product/summary', [ $this, 'quick_view_after_product_title_start' ], 1 );
                add_action( 'kinfw-action/theme/woo/yith-quick-view/product/summary', [ $this, 'quick_view_after_product_price_start' ], 5 );
                add_action( 'kinfw-action/theme/woo/yith-quick-view/product/summary', 'woocommerce_template_single_price', 6 );
                add_action( 'kinfw-action/theme/woo/yith-quick-view/product/summary', [ $this, 'quick_view_after_product_price_end' ], 15 );
                add_action( 'kinfw-action/theme/woo/yith-quick-view/product/summary', [ $this, 'quick_view_after_product_title_end' ], 50 );

                add_action( 'kinfw-action/theme/woo/yith-quick-view/product/summary', 'woocommerce_template_single_excerpt', 100 );

                add_action( 'kinfw-action/theme/woo/yith-quick-view/product/summary', [ $this, 'before_add_to_cart' ], 150 );
                add_action( 'kinfw-action/theme/woo/yith-quick-view/product/summary', 'woocommerce_template_single_add_to_cart', 160 );
                add_action( 'kinfw-action/theme/woo/yith-quick-view/product/summary', [ $this, 'after_add_to_cart_end' ], 200 );

                add_action( 'kinfw-action/theme/woo/yith-quick-view/product/summary', 'woocommerce_template_single_meta', 250 );
                add_action( 'kinfw-action/theme/woo/yith-quick-view/product/summary', 'woocommerce_template_single_sharing', 260 );
        }

		public function remove_button() {
            remove_action( 'woocommerce_after_shop_loop_item', [
                YITH_WCQV_Frontend::get_instance(),
                'yith_add_quick_view_button'
            ], 15 );

            remove_action( 'yith_wcwl_table_after_product_name', [
                YITH_WCQV_Frontend::get_instance(),
                'add_quick_view_button_wishlist'
            ], 15 );

        }

		public function quick_view_button( $button, $label, $product ) {

            $product_id = 0;

            if ( ! $product_id && $product instanceof WC_Product ) {
                $product_id = $product->get_id();
            }

			$button = sprintf(
				'<a href="javascript:void(0);" data-product_id="%1$s" data-title="%2$s" class="yith-wcqv-button kinfw-product-quick-view">%3$s</a>',
				esc_attr( $product_id ),
				$label,
				kinfw_icon( 'misc-eye', '', 'i' )
			);

			return $button;

		}

        public function quick_view_product_title() {
            global $product;

            echo '<div class="kinfw-product-before-title-wrap">';

                if ( $product->is_on_sale() ) {

                    printf( '<span class="kinfw-woo-single-product-labels kinfw-woo-single-product-on-sale">%1$s</span>', esc_html__('Sale', 'onnat' ) );
                }

                if ( $product->is_featured() ) {

                    printf( '<span class="kinfw-woo-single-product-labels kinfw-woo-single-product-hot">%1$s</span>', esc_html('Hot', 'onnat' ) );
                }

                if ($product->is_in_stock() && $product->is_type( 'simple' ) ) {

                    $availability = $product->get_availability();
                    printf(
                        '<span class="kinfw-woo-single-product-labels kinfw-woo-single-product-in-stock">%1$s</span>',
                        ! empty( $availability['availability'] ) ? $availability['availability'] : esc_html__('In Stock', 'onnat' )
                    );

                } else {

                    printf( '<span class="kinfw-woo-single-product-labels kinfw-woo-single-product-out-of-stock">%1$s</span>', esc_html__('Out of Stock', 'onnat' ) );
                }

            echo '</div>';

            echo '<div class="kinfw-product-title-wrap">';

                the_title('<h2 class="kinfw-product-title">', '</h2>');

                if ( post_type_supports( 'product', 'comments' ) && function_exists( 'wc_get_template' ) ) {
                    wc_get_template( 'single-product/rating.php' );
                }

            echo '</div>';

        }

        public function quick_view_after_product_title_start() {
            echo '<div class="kinfw-product-after-title-wrap">';
        }

        public function quick_view_after_product_price_start() {
            echo '<div class="kinfw-product-price-wrap">';
        }

        public function quick_view_after_product_price_end() {
            global $product;

            $percentage = '';

            if ( $product->is_on_sale() ) {

                $product_type  = $product->get_type();
                $regular_price = $product->get_regular_price();
                $sale_price    = $product->get_sale_price();

                if ( 'variable' === $product_type ) {
                    $max_percentage       = 0;
                    $available_variation_prices = $product->get_variation_prices();

                    foreach ($available_variation_prices['regular_price'] as $key => $regular_price) {
                        $sale_price = $available_variation_prices['sale_price'][$key];
                        if ($sale_price < $regular_price) {
                            $percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
                            if ($percentage > $max_percentage) {
                                $max_percentage = $percentage;
                            }
                        }
                    }
                    $percentage = $max_percentage;
                } else if( 'simple' === $product_type || 'external' === $product_type ) {
                    $percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
                }

                if( !empty( $percentage ) ) {
                    printf(
                        '<span class="kinfw-woo-single-product-labels kinfw-woo-single-product-percentage-off">%1$s%2$s %3$s</span>',
                        $percentage,
                        '%',
                        esc_html__( 'Off', 'onnat' )
                    );
                }
            }

            echo '</div>';
        }

        public function quick_view_after_product_title_end() {
            echo '</div>';
        }

        public function before_add_to_cart() {
            echo '<div class="kinfw-product-add-to-cart-wrap">';
        }

        public function after_add_to_cart_end() {
            echo '</div>';
        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_woo_yith_quick_view' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_woo_yith_quick_view() {

        return Onnat_Theme_Woo_YITH_Quick_View::get_instance();
    }

}

kinfw_onnat_theme_woo_yith_quick_view();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */