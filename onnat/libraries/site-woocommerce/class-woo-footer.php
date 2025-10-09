<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( ! class_exists( 'Onnat_Theme_Woo_Footer' ) ) {

    /**
     * The Onnat woocommerce header class.
     */
    class Onnat_Theme_Woo_Footer {

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

            add_filter( 'kinfw-filter/theme/footer/settings', [ $this, 'page_footer_settings' ] );

            do_action( 'kinfw-action/theme/woo/footer/compatibility/loaded' );

        }

        /**
         * Handles footer settings for shop and product single.
         */
        public function page_footer_settings( $settings ) {
            if( is_shop() ) {
                $shop_id = get_option( 'woocommerce_shop_page_id' );
				$meta     = get_post_meta( $shop_id, ONNAT_CONST_THEME_PAGE_SETTINGS, true );
				$settings = $this->get_footer( $meta, $settings );

				return $settings;
            } else if( is_singular( 'product' ) ) {
				$meta     = get_post_meta( get_the_ID(), ONNAT_CONST_THEME_PRODUCT_SETTINGS, true );
				$settings = $this->get_footer( $meta, $settings );

				return $settings;
            }

            return $settings;
        }

		public function get_footer( $meta = '', $settings = [] ) {

			if( isset( $meta['footer'] ) ) {
				if( 'no_footer' === $meta['footer']) {
					$settings = [
						'footer_id'   => '',
						'footer_type' => 'footer'
					];
				} else if( 'elementor_footer' === $meta['footer'] ) {
					$settings = [
						'footer_id'   => $meta['elementor_footer'],
						'footer_type' => 'elementor'
					];
				} else if( 'theme_footer' === $meta['footer'] ) {
					$footer_id   = kinfw_onnat_theme_options()->kinfw_get_option( 'default_footer' );
					$footer_type = 'footer';

					if( 'elementor_footer' === $footer_id ) {
						$footer_type = 'elementor';
						$footer_id   = kinfw_onnat_theme_options()->kinfw_get_option( 'elementor_footer' );
					}

					$settings = [
						'footer_id'   => $footer_id,
						'footer_type' => $footer_type
					];
				} else if( 'custom_footer' === $meta['footer'] ) {
					$settings = [
						'footer_id'   => $meta['custom_footer'],
						'footer_type' => 'footer'
					];
				}
			}

			return $settings;
		}

    }

}

if( !function_exists( 'kinfw_onnat_theme_woo_footer' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_woo_footer() {

        return Onnat_Theme_Woo_Footer::get_instance();
    }

}

kinfw_onnat_theme_woo_footer();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */