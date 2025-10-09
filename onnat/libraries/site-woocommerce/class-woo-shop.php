<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( ! class_exists( 'Onnat_Theme_Woo_Shop' ) ) {

    /**
     * The Onnat woocommerce shop and archive class.
     */
    class Onnat_Theme_Woo_Shop {

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
             * Shop and Archive hooks
             */
                remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
                remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );


                /**
                 * Shop & Archive Page - Header Section
                 */
                add_action( 'woocommerce_before_shop_loop', [ $this, 'header_wrapper' ], 10 );

                    add_action( 'woocommerce_before_shop_loop', [ $this, 'header_element_group' ], 15 );
                        add_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 25 );
                    add_action( 'woocommerce_before_shop_loop', [ $this, 'header_element_group_close' ], 50 );

                    add_action( 'woocommerce_before_shop_loop', [ $this, 'header_element_group' ], 55 );
                        add_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 60 );
                    add_action( 'woocommerce_before_shop_loop', [ $this, 'header_element_group_close' ], 70 );

                add_action( 'woocommerce_before_shop_loop', [ $this, 'header_wrapper_close' ], 100 );


                /**
                 * 1. Shop & Archive Loop Start
                 */
                add_action( 'woocommerce_before_shop_loop', [ $this, 'loop_item_class' ], 10 );
                add_filter( 'woocommerce_product_loop_start', [ $this, 'loop_wrapper' ] );

                    /**
                     * Loop Items
                     */
                    add_action( 'woocommerce_before_shop_loop_item', [ $this, 'product_wrapper' ], 1 );

                        remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
                        remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
                        remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
                        remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
                        remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

                        add_action( 'woocommerce_before_shop_loop_item_title', [ $this, 'image_wrapper' ], 1 );
                            add_action( 'woocommerce_before_shop_loop_item_title', [ $this, 'product_labels' ], 5 );
                            add_action( 'woocommerce_before_shop_loop_item_title', [ $this, 'product_thumbnail' ], 10 );

                            add_action( 'woocommerce_before_shop_loop_item_title', [ $this, 'product_hover_buttons_wrap' ], 20 );
                            add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 55 );
                            add_action( 'woocommerce_before_shop_loop_item_title', [ $this, 'product_hover_buttons_wrap_close' ], 60 );

                            add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 100 );
                            add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 100  );
                        add_action( 'woocommerce_before_shop_loop_item_title', [ $this, 'image_wrapper_close' ], 999 );


                        add_action( 'woocommerce_shop_loop_item_title', [ $this, 'content_wrapper' ], 0 );
                            remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
                            remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
                            add_action( 'woocommerce_shop_loop_item_title', [ $this, 'product_title' ], 10 );
                        add_action( 'woocommerce_after_shop_loop_item_title', [ $this, 'content_wrapper_close' ], 999 );

                    add_action( 'woocommerce_after_shop_loop_item', [ $this, 'product_wrapper_close' ], 999 );
                    add_filter( 'woocommerce_loop_add_to_cart_args', [$this, 'add_to_cart_args' ], 10, 2 );

            /**
             * 2. Shop & Archive Loop End
             */
            add_filter( 'woocommerce_product_loop_end', [ $this, 'loop_wrapper_close' ] );

            add_filter( 'woocommerce_loop_add_to_cart_link', [ $this, 'loop_add_to_cart_link' ], 10, 3 );

        }

        public function header_wrapper() {
            echo '<!-- #kinfw-woo-header-wrapper -->';
            echo '<div id="kinfw-woo-header-wrapper">';
                echo '<div class="kinfw-row">';
        }

        public function header_element_group() {
            echo '<div class="kinfw-col-12 kinfw-col-sm-6">';
        }

        public function header_element_group_close() {
            echo '</div>';
        }

        public function header_wrapper_close() {
            echo '</div>';
            echo '</div><!-- /#kinfw-woo-header-wrapper -->';
        }

        public function loop_item_class() {

            $class = '';

            if( is_shop() ) {

                $products_per_row = kinfw_onnat_theme_options()->kinfw_get_option( 'shop_products_per_row' );
                kinfw_onnat_theme_blog_utils()->blog_grid_col_class( $products_per_row );

                $class = implode( " ", $products_per_row );

            } elseif( is_product_category() || is_product_tag() ) {

                $products_per_row = kinfw_onnat_theme_options()->kinfw_get_option( 'woo_archive_template_products_per_row' );
                kinfw_onnat_theme_blog_utils()->blog_grid_col_class( $products_per_row );

                $class = implode( " ", $products_per_row );

            }

            if( !empty( $class ) ) {

                wc_set_loop_prop( "kinfw-loop-class", $class );
            }

        }

        public function loop_wrapper() {
            echo '<!-- .kinfw-products -->';
            echo '<div class="kinfw-row kinfw-products">';
        }

        public function product_wrapper() {
            global $product;

            $classes = wc_get_product_class( wc_get_loop_prop( "kinfw-loop-class" ), $product );
            $classes = implode( " ", array_reverse ( $classes ) );

            printf( '<!-- .kinfw-woo-product-item -->
                <div class="kinfw-woo-product-item %1$s">',$classes
            );
        }

        public function product_wrapper_close() {
            echo '</div><!-- /.kinfw-woo-product-item -->';
        }

        public function loop_wrapper_close() {
            echo '</div><!-- /.kinfw-products -->';
        }

        public function image_wrapper() {
            echo '<!-- .kinfw-woo-product-image -->';
            echo '<div class="kinfw-woo-product-image">';
        }

        public function product_labels() {

            global $product;

            if ( $product->is_featured() ) {
                printf( '<span class="kinfw-woo-product-hot">%1$s</span>', esc_html('Hot', 'onnat' ) );
            }

            if ( $product->is_on_sale() && $product->is_type( 'simple' ) ) {
                printf( '<span class="kinfw-woo-product-on-sale">%1$s</span>', esc_html('Sale', 'onnat' ) );
            }

        }

        public function product_thumbnail() {

            global $product;
            $image_size = apply_filters( 'single_product_archive_thumbnail_size', 'woocommerce_thumbnail' );

            if( $product ) {

                echo '<!-- .kinfw-woo-product-image-wrap -->';
                echo '<div class="kinfw-woo-product-image-wrap">';

                    printf( '<!-- .kinfw-woo-product-image -->
                        <div class="kinfw-woo-product-image">%1$s</div><!-- /.kinfw-woo-product-image -->',
                        $product->get_image( $image_size )
                    );

                    $meta = get_post_meta( $product->get_id(), '_kinfw_product_secondary_image', true );
                    if( is_array( $meta ) && !empty( $meta['image'] ) ) {
                        $id    = $meta['image']['id'];
                        $image = wp_get_attachment_image( $id, $image_size );

                        printf( '<!-- .kinfw-woo-product-hover-image -->
                            <div class="kinfw-woo-product-hover-image">%1$s</div><!-- /.kinfw-woo-product-hover-image -->',
                            $image
                        );
                    }

                echo '</div><!-- /.kinfw-woo-product-image-wrap -->';
            }
        }

        public function product_hover_buttons_wrap() {
            echo '<!-- .kinfw-woo-product-action-buttons-wrap -->';
            echo '<div class="kinfw-woo-product-action-buttons-wrap">';
        }

        public function product_hover_buttons_wrap_close() {
            echo '</div><!-- /.kinfw-woo-product-action-buttons-wrap -->';
        }

        public function image_wrapper_close() {
            echo '</div><!-- /.kinfw-woo-product-image -->';
        }

        public function content_wrapper() {
            echo '<!-- .kinfw-woo-product-content -->';
            echo '<div class="kinfw-woo-product-content">';
        }

        public function product_title() {
            do_action( 'kinfw-action/theme/woo/product-loop/before-product-title' );

            printf( '<h3 class="woocommerce-loop-product__title"><a href="%1$s">%2$s</a></h3>',
                esc_url_raw( get_the_permalink() ),
                get_the_title()
            );

            do_action( 'kinfw-action/theme/woo/product-loop/after-product-title' );
        }

        public function content_wrapper_close() {
            echo '</div><!-- /.kinfw-woo-product-content -->';
        }

        public function add_to_cart_args( $args, $product ) {
            $args['class']                    .= sprintf( ' kinfw-product-add-to-cart kinfw-product-%s', $product->get_type() );
            $args['attributes']['data-title']  = $product->add_to_cart_description();

            return $args;
        }

        public function loop_add_to_cart_link( $link, $product, $args ) {

            $icon_class = sprintf('shopping-woo-product-%s', $product->get_type() );

            $link = sprintf(
                // kfwoo-add-to-cart-btn-txt - to provide compatibility with our swatch plugin
                '<a href="%s" data-quantity="%s" class="%s" %s>%s <span class="kinfw-add-to-cart-btn-txt kfwoo-add-to-cart-btn-txt">%s</span> </a>',
                esc_url( $product->add_to_cart_url() ),
                esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
                esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
                isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
                kinfw_icon( $icon_class, '', 'i' ),
                esc_html( $product->add_to_cart_text() )
            );

            return $link;
        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_woo_shop' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_woo_shop() {

        return Onnat_Theme_Woo_Shop::get_instance();
    }

}

kinfw_onnat_theme_woo_shop();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */