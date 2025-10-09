<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 * The template for displaying Pagination - Show numbered pagination for catalog pages
 *
 * @version 9.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$total   = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );
$current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
$base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
$format  = isset( $format ) ? $format : '';

if ( $total <= 1 ) {
	return;
}
?>
<div id="kinfw-blog-pagination">
    <nav class="navigation pagination woocommerce-pagination">
        <div class="nav-links">
            <?php
                echo paginate_links(
                    apply_filters(
                        'woocommerce_pagination_args',
                        [ // WPCS: XSS ok.
                            'base'      => $base,
                            'format'    => $format,
                            'add_args'  => false,
                            'current'   => max( 1, $current ),
                            'total'     => $total,
                            'prev_text' => is_rtl() ? kinfw_icon( 'onnat-line-arrow-long-right-tiny' ) : kinfw_icon( 'onnat-line-arrow-long-left-tiny' ),
                            'next_text' => is_rtl() ? kinfw_icon( 'onnat-line-arrow-long-left-tiny' ) : kinfw_icon( 'onnat-line-arrow-long-right-tiny' ),
                            'end_size'  => 3,
                            'mid_size'  => 3,
                        ]
                    )
                );
            ?>
        </div>
    </nav>
</div>