<?php
/**
 * The template for displaying product widget entries.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-reviews.php
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

print( '<li>' );

    do_action( 'woocommerce_widget_product_review_item_start', $args );

    printf('<a href="%1$s"> %2$s <span class="product-title"> %3$s </span> </a>',
        esc_url( get_comment_link( $comment->comment_ID ) ),
        $product->get_image( [80, 80 ] ),
        wp_kses_post( $product->get_name() )
    );

    echo wc_get_rating_html( intval( get_comment_meta( $comment->comment_ID, 'rating', true ) ) );

    printf(
        '<span class="reviewer"> %1$s </span>',
        sprintf( esc_html__( 'by %s', 'onnat' ), get_comment_author( $comment->comment_ID ) )
    );

    do_action( 'woocommerce_widget_product_review_item_end', $args );

print( '</li>' );
