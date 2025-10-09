<?php
/**
 * Quick view content.
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH WooCommerce Quick View
 * @version 1.0.0
 */

defined( 'YITH_WCQV' ) || exit; // Exit if accessed directly.

while ( have_posts() ) :
	the_post();
	?>

	<div class="product">
	<?php if ( ! post_password_required() ) : ?>
		<div id="product-<?php the_ID(); ?>" <?php post_class( 'product kinfw-yith-quick-view' ); ?>>
			<div class="kinfw-yith-quick-view-content-wrap kinfw-row">
				<div class="kinfw-yith-quick-view-product-img-wrap kinfw-col-12 kinfw-col-md-6 kinfw-col-sm-12">
					<?php do_action( 'kinfw-action/theme/woo/yith-quick-view/product/image' ); ?>
                </div>

				<div class="kinfw-yith-quick-view-product-info-wrap kinfw-col-12 kinfw-col-md-6 kinfw-col-sm-12">
					<?php do_action( 'kinfw-action/theme/woo/yith-quick-view/product/summary' ); ?>
                </div>
            </div>
		</div>
	<?php else :
			echo get_the_password_form(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		endif; ?>
	</div>
	<?php
endwhile; // end of the loop.
