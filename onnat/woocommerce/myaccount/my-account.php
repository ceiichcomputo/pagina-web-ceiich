<?php
/**
 * The template part for displaying woocommerce my account page
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_account_navigation' ); ?>

	<div class="kinfw-col-lg-8 kinfw-col-12">
		<div class="kinfw-woo-myaccount-content">
			<?php do_action( 'woocommerce_account_content' ); ?>
		</div>
	</div>

</div><!-- .kinfw-row opened in navigation.php -->