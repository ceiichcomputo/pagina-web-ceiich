<?php
/**
 * Quick view bone.
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH WooCommerce Quick View
 * @version 1.0.0
 */

defined( 'YITH_WCQV' ) || exit; // Exit if accessed directly.

?>

<div id="yith-quick-view-modal" class="yith-quick-view yith-modal">
	<div class="yith-quick-view-overlay"></div>
	<div class="yith-wcqv-wrapper">
		<div class="yith-wcqv-main">
			<div class="yith-wcqv-head">
				<a href="#" class="yith-quick-view-close">
					<?php echo kinfw_icon( 'math-cross' ); ?>
                </a>
			</div>
			<div id="yith-quick-view-content" class="yith-quick-view-content woocommerce single-product"></div>
		</div>
	</div>
</div>
<?php
