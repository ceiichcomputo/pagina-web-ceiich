<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( ! class_exists( 'Onnat_Theme_Woo_Single_Product' ) ) {

    /**
     * The Onnat woocommerce single product class.
     */
    class Onnat_Theme_Woo_Single_Product {

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


			add_action( 'woocommerce_before_single_product_summary', [ $this, 'row_start' ], 1 );
				remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );

				add_action( 'woocommerce_before_single_product_summary', [ $this, 'image_wrapper' ], 2 );
				add_action( 'woocommerce_single_product_summary', [ $this, 'image_wrapper_end' ], 1 );

                add_action( 'woocommerce_single_product_summary', [ $this, 'content_wrapper' ], 1 );
                add_action( 'woocommerce_after_single_product_summary', [ $this, 'content_wrapper_end' ], 1 );

                add_action( 'woocommerce_after_single_product_summary', [ $this, 'tab_wrapper' ], 1 );
                add_action( 'woocommerce_after_single_product_summary', [ $this, 'tab_wrapper_end' ], 14 );

                remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
                add_action( 'woocommerce_after_single_product_summary', [ $this, 'upsell_products' ], 15 );

                remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
                add_action( 'woocommerce_after_single_product_summary', [ $this, 'related_products' ], 20 );

			add_action( 'woocommerce_single_product_summary', [ $this, 'row_end' ], 999 );

            /**
             * Single Product Elements
             */
            add_filter( 'woocommerce_get_stock_html', '__return_empty_string' );
            remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
            remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );

            remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );

            add_action( 'woocommerce_single_product_summary', [ $this, 'before_title' ], 1 );
            add_action( 'woocommerce_single_product_summary', [ $this, 'single_title' ], 5 );

            add_action( 'woocommerce_single_product_summary', [ $this, 'after_title_wrapper' ], 5 );

                add_action( 'woocommerce_single_product_summary', [ $this, 'single_price_wrapper' ], 5 );
                add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 6 );
                add_action( 'woocommerce_single_product_summary', [ $this, 'single_price_wrapper_end' ], 6 );

                remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
            add_action( 'woocommerce_single_product_summary', [ $this, 'after_title_wrapper_end' ], 11 );

            add_action( 'woocommerce_single_product_summary', [ $this, 'sale_price_date' ], 29 );

            add_action( 'woocommerce_single_product_summary', [ $this, 'before_add_to_cart' ], 29 );
            add_action( 'woocommerce_single_product_summary', [ $this, 'after_add_to_cart_end' ], 35 );

            /**
             * Grouped Product
             */
            add_filter( 'woocommerce_grouped_product_columns', [ $this, 'grouped_product_columns' ] );
            add_action( 'woocommerce_grouped_product_list_before_label', [ $this, 'grouped_product_image_column' ] );

            /**
             * Quantity Input
             */
            add_filter( 'woocommerce_quantity_input_classes', [ $this, 'qty_input_classes' ], 10, 2 );
            add_action( 'woocommerce_before_quantity_input_field', [ $this, 'qty_input_wrap' ], 0 );
            add_action( 'woocommerce_before_quantity_input_field', [ $this, 'before_qty_input_field' ] );
            add_action( 'woocommerce_after_quantity_input_field', [ $this, 'after_qty_input_field' ] );
            add_action( 'woocommerce_after_quantity_input_field', [ $this, 'qty_input_wrap_end' ], 999 );

            /**
             * Product Tabs
             */
            add_filter( 'woocommerce_product_description_heading', '__return_empty_string' );
            add_filter( 'woocommerce_product_additional_information_heading', '__return_empty_string' );

            /**
             * Comment Form
             */
            add_filter( 'woocommerce_product_review_comment_form_args', [ $this, 'comment_form' ] );

            add_action('woocommerce_share', [ $this, 'social_share' ], 10);

        }

        public function row_start() {
            echo '<!-- .kinfw-single-product-content-wrap -->';
            echo '<div class="kinfw-single-product-content-wrap">';
                echo '<div class="kinfw-row">';
        }

        public function row_end() {
                echo '</div>';
            echo '</div> <!-- /.kinfw-single-product-content-wrap -->';
        }

        public function image_wrapper() {
            echo '<!-- .kinfw-single-product-img-wrap -->';
            echo '<div class="kinfw-single-product-img-wrap kinfw-col-12 kinfw-col-sm-12 kinfw-col-md-6">';
        }

        public function image_wrapper_end() {
            echo '</div> <!-- /.kinfw-single-product-img-wrap -->';
        }

        public function content_wrapper() {
            echo '<!-- .kinfw-single-product-info-wrap -->';
            echo '<div class="kinfw-single-product-info-wrap kinfw-col-12 kinfw-col-sm-12 kinfw-col-md-6">';
        }

        public function content_wrapper_end() {
            echo '</div> <!-- /.kinfw-single-product-info-wrap -->';
        }

        public function tab_wrapper() {
            echo '<!-- .kinfw-single-product-tab-wrap -->';
            echo '<div class="kinfw-single-product-tab-wrap">';
                echo '<div class="kinfw-row">';
                    echo '<div class="kinfw-col-12">';
        }

        public function tab_wrapper_end() {
                    echo '</div>';
                echo '</div>';
            echo '</div> <!-- / .kinfw-single-product-tab-wrap -->';
        }

        public function upsell_products( $limit = '-1', $columns = 4, $orderby = 'rand', $order = 'desc' ) {

            global $product;

            if ( ! $product ) {
                return;
            }

            // Handle the legacy filter which controlled posts per page etc.
            $args = apply_filters( 'woocommerce_upsell_display_args', [
                'posts_per_page' => '-1',
                'orderby'        => 'rand',
                'order'          => 'desc',
                'columns'        => 4,
            ] );

            wc_set_loop_prop( 'name', 'up-sells' );
            wc_set_loop_prop( 'columns', apply_filters( 'woocommerce_upsells_columns', isset( $args['columns'] ) ? $args['columns'] : $columns ) );
            wc_set_loop_prop( "kinfw-loop-class", 'kinfw-col-12 kinfw-col-lg-4 kinfw-col-md-6 kinfw-col-sm-12 kinfw-col-xl-3' );

            $orderby = apply_filters( 'woocommerce_upsells_orderby', isset( $args['orderby'] ) ? $args['orderby'] : $orderby );
            $order   = apply_filters( 'woocommerce_upsells_order', isset( $args['order'] ) ? $args['order'] : $order );
            $limit   = apply_filters( 'woocommerce_upsells_total', isset( $args['posts_per_page'] ) ? $args['posts_per_page'] : $limit );
            $columns = $args['columns'];

            // Get visible upsells then sort them at random, then limit result set.
            $upsells = wc_products_array_orderby( array_filter( array_map( 'wc_get_product', $product->get_upsell_ids() ), 'wc_products_array_filter_visible' ), $orderby, $order );
            $upsells = $limit > 0 ? array_slice( $upsells, 0, $limit ) : $upsells;

            wc_get_template( 'single-product/up-sells.php', [
                'upsells'        => $upsells,
                'posts_per_page' => $limit,
                'orderby'        => $orderby,
                'columns'        => $columns,
            ] );

        }

        public function related_products( $args = [] ) {

            global $product;

            if ( ! $product ) {
                return;
            }

            $defaults = [
                'posts_per_page' => 4,
                'columns'        => 4,
                'orderby'        => 'rand', // @codingStandardsIgnoreLine.
                'order'          => 'desc',
            ];

			$args = wp_parse_args( $args, $defaults );

            // Get visible related products then sort them at random.
            $args['related_products'] = array_filter( array_map( 'wc_get_product', wc_get_related_products( $product->get_id(), $args['posts_per_page'], $product->get_upsell_ids() ) ), 'wc_products_array_filter_visible' );

            // Handle orderby.
            $args['related_products'] = wc_products_array_orderby( $args['related_products'], $args['orderby'], $args['order'] );

            // Set global loop values.
            wc_set_loop_prop( 'name', 'related' );
            wc_set_loop_prop( 'columns', apply_filters( 'woocommerce_related_products_columns', $args['columns'] ) );
            wc_set_loop_prop( "kinfw-loop-class", 'kinfw-col-12 kinfw-col-lg-4 kinfw-col-md-6 kinfw-col-sm-12 kinfw-col-xl-3' );

            wc_get_template( 'single-product/related.php', $args );
        }

        public function before_title() {
            global $product;

            echo '<div class="kinfw-product-before-title-wrap">';

                if ( $product->is_on_sale() ) {

                    printf( '<span class="kinfw-woo-single-product-labels kinfw-woo-single-product-on-sale">%1$s</span>', esc_html__('Sale', 'onnat' ) );
                }

                if ( $product->is_featured() ) {

                    printf( '<span class="kinfw-woo-single-product-labels kinfw-woo-single-product-hot">%1$s</span>', esc_html('Hot', 'onnat' ) );
                }

                if ( $product->is_in_stock() ) {

                    $availability = $product->get_availability();
                    printf(
                        '<span class="kinfw-woo-single-product-labels kinfw-woo-single-product-in-stock">%1$s</span>',
                        ! empty( $availability['availability'] ) ? $availability['availability'] : esc_html__('In Stock', 'onnat' )
                    );

                } else {

                    printf( '<span class="kinfw-woo-single-product-labels kinfw-woo-single-product-out-of-stock">%1$s</span>', esc_html__('Out of Stock', 'onnat' ) );
                }

            echo '</div>';
        }

        public function single_title() {

            echo '<div class="kinfw-product-title-wrap">';

                the_title('<h2 class="kinfw-product-title">', '</h2>');

                if ( post_type_supports( 'product', 'comments' ) && function_exists( 'wc_get_template' ) ) {
                    wc_get_template( 'single-product/rating.php' );
                }

            echo '</div>';
        }

        public function after_title_wrapper() {
            echo '<div class="kinfw-product-after-title-wrap">';
        }

        public function after_title_wrapper_end() {
            echo '</div>';
        }

        public function single_price_wrapper() {
            echo '<div class="kinfw-product-price-wrap">';
        }

        public function single_price_wrapper_end() {
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

        public function sale_price_date() {
            global $product;
            if ( !$product->is_on_sale() ) {
                return;
            }

            $date = get_post_meta($product->get_id(), '_sale_price_dates_to', true);

            if ( $date ) {
                echo '<div class="kinfw-product-sale-price-date-wrap">';
                    printf( '<div class="kinfw-product-sale-price-date-label">%1$s</div>', esc_html__( 'Hurry Up! Sale ends in', 'onnat' ) );
                    printf('
                        <div class="kinfw-product-sale-price-date kinfw-countdown-timer" data-date="%1$s">
                            <div class="kinfw-countdown-timer-item kinfw-countdown-timer-days-item">
                                <div class="kinfw-countdown-digits"></div>
                                <div class="kinfw-countdown-label">%2$s</div>
                            </div>

                            <div class="kinfw-countdown-timer-item kinfw-countdown-timer-hours-item">
                                <div class="kinfw-countdown-digits"></div>
                                <div class="kinfw-countdown-label">%3$s</div>
                            </div>

                            <div class="kinfw-countdown-timer-item kinfw-countdown-timer-minutes-item">
                                <div class="kinfw-countdown-digits"></div>
                                <div class="kinfw-countdown-label">%4$s</div>
                            </div>

                            <div class="kinfw-countdown-timer-item kinfw-countdown-timer-seconds-item">
                                <div class="kinfw-countdown-digits"></div>
                                <div class="kinfw-countdown-label">%5$s</div>
                            </div>
                        </div>',
                        ( $date + ( get_option('gmt_offset') * HOUR_IN_SECONDS )  ),
                        esc_html__( 'Days', 'onnat' ),
                        esc_html__( 'Hrs', 'onnat' ),
                        esc_html__( 'Mins', 'onnat' ),
                        esc_html__( 'Secs', 'onnat' ),
                    );
                echo '</div>';
            }
        }

        public function before_add_to_cart() {
            echo '<div class="kinfw-product-add-to-cart-wrap">';
        }

        public function after_add_to_cart_end() {
            echo '</div>';
        }

        public function grouped_product_columns() {
            return [
                'label',
				'price',
				'quantity',
            ];
        }

        public function grouped_product_image_column( $product ) {

            $is_visible = $product->is_visible();
            printf( '<td class="woocommerce-grouped-product-list-item__image">%s%s%s</td>',
                $is_visible ? sprintf( '<a href="%s">', $product->get_permalink() ) : "",
                $product->get_image( [ 70, 70 ] ),
                $is_visible ? '</a>' : ""

            );
        }

        public function qty_input_classes( $classes, $product ) {
            array_push( $classes, 'kinfw-qty-input' );
            return $classes;
        }

        public function qty_input_wrap() {
            echo '<div class="kinfw-qty-wrap">';
        }

        public function before_qty_input_field() {
            echo '<span class="kinfw-qty-btn kinfw-qty-minus"></span>';
        }

        public function after_qty_input_field() {
            echo '<span class="kinfw-qty-btn kinfw-qty-plus"></span>';
        }

        public function qty_input_wrap_end() {
            echo '</div>';
        }

		public function comment_form( $comment_form ) {
            $commenter = wp_get_current_commenter();
            $req       = get_option( 'require_name_email' );
            $html_req  = ( $req ? " required='required'" : '' );


            $comment_form['class_form']           = 'kinfw-comment-form';
            $comment_form['comment_notes_before'] = '';
            $comment_form[ 'label_submit']        = esc_html__( 'Post Review', 'onnat' );
            $comment_form['submit_field']         = '<p class="kinfw-form-submit-button kinfw-comment-form-submit-button">%1$s %2$s</p>';

            /**
             * Field: Author
             */
                $comment_form['fields']['author'] = sprintf( '<div class="kinfw-row">
                    <div class="kinfw-col-12 kinfw-col-md-6">
                        <input id="author" name="author" type="text" value="%s" size="30" maxlength="245" placeholder="%s%s" %s/>
                    </div>',
                    esc_attr( $commenter['comment_author'] ),
                    esc_attr__('Name', 'onnat' ),
                    !empty( $html_req ) ? '*' : '',
                    $html_req
                );

            /**
             * Field: Email
             */
                $comment_form['fields']['email']  = sprintf( '<div class="kinfw-col-12 kinfw-col-md-6">
                            <input id="email" name="email" type="email" value="%s" size="30" placeholder="%s%s" %s/>
                        </div>
                    </div>',
                    esc_attr( $commenter['comment_author_email'] ),
                    esc_attr__('Email', 'onnat' ),
                    !empty( $html_req ) ? '*' : '',
                    $html_req
                );

            /**
             * Field: Cookies
             */
                if ( has_action( 'set_comment_cookies', 'wp_set_comment_cookies' ) && get_option( 'show_comments_cookies_opt_in' ) ) {

                    $consent = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';

                    $comment_form['fields']['cookies'] = sprintf(
                        '<p class="kinfw-comment-form-cookies-consent">%s %s</p>',
                        sprintf(
                            '<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"%s />',
                            $consent
                        ),
                        sprintf(
                            '<label for="kinfw-wp-comment-cookies-consent">%s</label>',
                            esc_html__( 'Save my name, email, and website in this browser for the next time I comment.', 'onnat' )
                        )
                    );
                }

            /**
             * Field: Review
             */
                $rating = '';
                if ( wc_review_ratings_enabled() ) {

                    $rating = sprintf( '<div class="kinfw-comment-form-rating kinfw-col-12">
                            <label for="rating"> %s </label>
                            <select name="rating" id="rating" required>
                                <option value=""></option>
                                <option value="1"></option>
                                <option value="2"></option>
                                <option value="3"></option>
                                <option value="4"></option>
                                <option value="5"></option>
                            </select>
                        </div>',
                        esc_html__( 'Your rating', 'onnat' )
                    );
                }

            /**
             * Field: Comment
             */
                $comment_form['comment_field'] = sprintf( '<div class="kinfw-row"> %s
                        <div class="kinfw-comment-form-review kinfw-col-12">
                            <textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" placeholder="%s" required="required"></textarea>
                        </div>
                    </div>',
                    $rating,
                    esc_attr__('Your Review *', 'onnat' )
                );

            return $comment_form;
		}

        public function social_share() {

            /**
             * Share List
             */
            $share_list   = '';
            $social_share = kinfw_onnat_theme_options()->kinfw_get_option( 'single_product_social_share' );

            if( isset( $social_share['enabled'] ) ) {

                $post_id    = get_the_ID();
                $post_title = get_the_title();
                $post_title = wp_strip_all_tags( $post_title );
                $post_url   = get_permalink( $post_id );
                $post_url   = rawurlencode( esc_url( $post_url ) );
                $post_desc  = urlencode( wp_trim_words( strip_shortcodes( get_the_content( $post_id ) ), 50 ) );
                $post_media = wp_get_attachment_url( get_post_thumbnail_id( $post_id ) );

                foreach( $social_share['enabled'] as $key => $share ) {

                    if( $key === 'facebook' ) {

                        $share_list .= sprintf('
                            <li>
                                <a title="%1$s" href="%2$s"></a>
                            </li>',
                            esc_html__( 'Share on Facebook', 'onnat' ),
                            add_query_arg( [
                                'u' => $post_url,
                            ], 'https://www.facebook.com/sharer.php' ),
                        );

                    }  else if( $key === 'linkedin' ) {

                        $share_list .= sprintf('
                            <li>
                                <a title="%1$s" href="%2$s"></a>
                            </li>',
                            esc_html__( 'Share on Linkedin', 'onnat' ),
                            add_query_arg( [
                                'mini'    => true,
                                'url'     => $post_url,
                                'title'   => $post_title,
                                'source'  => esc_url( home_url('/') ),
                                'summary' => $post_desc,
                            ], 'https://www.linkedin.com/shareArticle' ),
                        );

                    }  else if( $key === 'twitter' ) {

                        $share_list .= sprintf('
                            <li>
                                <a title="%1$s" href="%2$s"></a>
                            </li>',
                            esc_html__( 'Share on Twitter', 'onnat' ),
                            add_query_arg( [
                                'text' => $post_title,
                                'url'  => $post_url,
                            ], 'https://twitter.com/share' ),
                        );

                    }  else if( $key === 'googlep' ) {

                        $share_list .= sprintf('
                            <li>
                                <a title="%1$s" href="%2$s"></a>
                            </li>',
                            esc_html__( 'Share on Google Plus', 'onnat' ),
                            add_query_arg( [
                                'url' => $post_url,
                            ], 'https://plus.google.com/share' ),
                        );

                    }  else if( $key === 'pinterest' ) {

                        $share_list .= sprintf('
                            <li>
                                <a title="%1$s" href="%2$s"></a>
                            </li>',
                            esc_html__( 'Share on Pinterest', 'onnat' ),
                            add_query_arg( [
                                'url'         => $post_url,
                                'media'       => $post_media,
                                'description' => $post_desc,
                            ], 'https://www.pinterest.com/pin/create/button/' ),
                        );

                    }  else if( $key === 'reddit' ) {

                        $share_list .= sprintf('
                            <li>
                                <a title="%1$s" href="%2$s"></a>
                            </li>',
                            esc_html__( 'Share on Reddit', 'onnat' ),
                            add_query_arg( [
                                'url'   => $post_url,
                                'title' => $post_title,
                            ], 'https://www.reddit.com/submit' ),
                        );

                    }  else if( $key === 'tumblr' ) {

                        $share_list .= sprintf('
                            <li>
                                <a title="%1$s" href="%2$s"></a>
                            </li>',
                            esc_html__( 'Share on Tumblr', 'onnat' ),
                            add_query_arg( [
                                'canonicalUrl' => $post_url,
                            ], 'https://www.tumblr.com/widgets/share/tool' ),
                        );

                    }  else if( $key === 'viadeo' ) {

                        $share_list .= sprintf('
                            <li>
                                <a title="%1$s" href="%2$s"></a>
                            </li>',
                            esc_html__( 'Share on Viadeo', 'onnat' ),
                            add_query_arg( [
                                'url' => $post_url
                            ], 'https://partners.viadeo.com/share' ),
                        );

                    }  else if( $key === 'viber' ) {

                        $share_list .= sprintf('
                            <li>
                                <a title="%1$s" href="%2$s"></a>
                            </li>',
                            esc_html__( 'Share on Viber', 'onnat' ),
                            add_query_arg( [
                                'text' => $post_url,
                            ], 'viber://forward' ),
                        );

                    }  else if( $key === 'vk' ) {

                        $share_list .= sprintf('
                            <li>
                                <a title="%1$s" href="%2$s"></a>
                            </li>',
                            esc_html__( 'Share on VK', 'onnat' ),
                            add_query_arg( [
                                'url' => $post_url,
                            ], 'https://vk.com/share.php' ),
                        );

                    }

                }

                if(!empty( $share_list ) ) {

                    printf( '
                        <div class="kinfw-entry-product-social-share">
                            <p> %1$s </p>
                            <ul class="kinfw-social-links"> %2$s </ul>
                        </div>',
                        esc_html__( 'Share this', 'onnat' ),
                        $share_list,
                    );

                }

            }
        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_woo_single_product' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_woo_single_product() {

        return Onnat_Theme_Woo_Single_Product::get_instance();
    }

}

kinfw_onnat_theme_woo_single_product();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */