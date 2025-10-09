<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( ! class_exists( 'Onnat_Theme_Header_Mini_Cart' ) ) {

    /**
     * The Onnat header login form class.
     */
    class Onnat_Theme_Header_Mini_Cart {

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
             * Widget
             */
            $widget = '';

            ob_start();
            if ( class_exists( 'WC_Widget_Cart' ) ) {
                the_widget( 'WC_Widget_Cart', [ 'title' => '',  ], [
                    'before_widget' => '',
                    'after_widget'  => '',
                    'before_title'  => '',
                    'after_title'   => '',
                ] );
            }
            $widget = ob_get_contents();
            ob_end_clean();

            printf( '<!-- #kinfw-header-mini-cart-modal -->
                <div id="kinfw-header-mini-cart-modal">
                    <div class="kinfw-header-mini-cart-modal-content">
                        <div class="kinfw-header-mini-cart-modal-heading">
                            <span>%1$s</span>
                            <a class="kinfw-header-mini-cart-close" href="javascript:void(0);">%2$s</a>
                        </div>
                        <div class="kinfw-header-mini-cart-modal-widget">%3$s</div>
                    </div>
                    <div class="kinfw-header-mini-cart-modal-overlay"></div>
                </div><!-- / #kinfw-header-mini-cart-modal -->',
                apply_filters( 'kinfw-filter/theme/header/action/mini-cart/heading', esc_html__('Your Cart', 'onnat' ) ),
                kinfw_icon( 'onnat-cross' ),
                $widget
            );
        }
    }

    Onnat_Theme_Header_Mini_Cart::get_instance();

}
/* Omit closing PHP tag to avoid "Headers already sent" issues. */