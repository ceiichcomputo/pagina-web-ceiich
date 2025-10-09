<?php
/**
 * The template for displaying product widget entries.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-product.php.
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.5
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

if ( ! is_a( $product, 'WC_Product' ) ) {
	return;
}

print( '<li>' );

    do_action( 'woocommerce_widget_product_item_start', $args );

    printf('
        <a href="%1$s">
            %2$s
            <span class="product-title"> %3$s </span>
        </a>',

        esc_url( $product->get_permalink() ),
        $product->get_image( [80, 80 ] ),
        wp_kses_post( $product->get_name() )
    );

    if ( ! empty( $show_rating ) ) {

        // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo wc_get_rating_html( $product->get_average_rating() );
    }

    // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    echo apply_filters( 'kinfw-filter/theme/util/is-str', $product->get_price_html() );


    do_action( 'woocommerce_widget_product_item_end', $args );

print( '</li>' );
