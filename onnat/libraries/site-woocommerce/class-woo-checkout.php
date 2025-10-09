<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( ! class_exists( 'Onnat_Theme_Woo_Checkout' ) ) {

    /**
     * The Onnat woocommerce checkout class.
     */
    class Onnat_Theme_Woo_Checkout {

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

            add_action( 'woocommerce_checkout_before_customer_details', [ $this, 'row_start' ], 1 );

                add_action( 'woocommerce_checkout_before_customer_details', [ $this, 'section_start' ], 2 );
                add_action( 'woocommerce_checkout_after_customer_details', [ $this, 'section_end' ], 11 );

                add_action( 'woocommerce_checkout_before_order_review_heading', [ $this, 'section_start' ], 1 );
                add_action( 'woocommerce_checkout_after_order_review', [ $this, 'section_end' ], 1 );

            add_action( 'woocommerce_checkout_after_order_review', [ $this, 'row_end' ], 999 );
        }

        public function row_start() {
            echo '<div class="kinfw-row">';
        }

        public function row_end() {
            echo '</div>';
        }

        public function section_start() {
            if ( WC()->checkout()->get_checkout_fields() ) {
                echo '<div class="kinfw-col-12 kinfw-col-sm-12 kinfw-col-md-12 kinfw-col-lg-6">';
            }
        }

        public function section_end() {
            if ( WC()->checkout()->get_checkout_fields() ) {
                echo '</div>';
            }
        }
    }

}

if( !function_exists( 'kinfw_onnat_theme_woo_checkout' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_woo_checkout() {

        return Onnat_Theme_Woo_Checkout::get_instance();
    }

}

kinfw_onnat_theme_woo_checkout();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */