<?php
/**
 * The template part for displaying hader hamburger button.
 *
 */

if( count( $args ) && isset( $args['content'] ) ) {
	?>
	<!-- .kinfw-popup-modal -->
	<div id="kinfw-header-hamburger-btn-modal" class="kinfw-popup-modal">
		<div class="kinfw-popup-modal-overlay"></div>
		<div class="kinfw-popup-modal-content-wrap">
			<a class="kinfw-popup-modal-close" href="javascript:void(0);">
				<?php echo kinfw_icon( 'onnat-cross' ); ?>
			</a>
			<div class="kinfw-popup-modal-content">
				<?php echo apply_filters( 'kinfw-filter/theme/util/is-str', $args['content'] ); ?>
			</div>
		</div>
	</div><!-- / .kinfw-popup-modal -->
	<?php
}