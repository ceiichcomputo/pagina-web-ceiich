<?php
/**
 * The template part for displaying woocommerce cross sells products
 * @version 9.6.0
 */

defined( 'ABSPATH' ) || exit;
if ( $cross_sells ) :
?>
	<div class="kinfw-row">
		<div class="kinfw-col-12 cross-sells">
            <?php
                $heading = apply_filters( 'woocommerce_product_cross_sells_products_heading', esc_html__( 'You may be interested in&hellip;', 'onnat' ) );

				if ( $heading ) :
                    printf( '<h2>%1$s</h2>', esc_html( $heading ) );
                endif;

                woocommerce_product_loop_start();

                foreach ( $cross_sells as $cross_sell ) :

                    $post_object = get_post( $cross_sell->get_id() );

					setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

					wc_get_template_part( 'content', 'product' );

                endforeach;

                woocommerce_product_loop_end();
			?>
        </div>
    </div>
<?php
endif;
wp_reset_postdata();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */