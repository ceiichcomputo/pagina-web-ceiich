<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( ! class_exists( 'Onnat_Theme_Our_CPT_Footer' ) ) {

    /**
     * The Onnat Our CPT Footer compatibility class.
     */
    class Onnat_Theme_Our_CPT_Footer {

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
            do_action( 'kinfw-action/theme/our/cpt/footer/compatibility/loaded' );
        }

        /**
         * Handles footer settings for our own custom post type single.
         */
        public function page_footer_settings( $settings ) {

            $post_types = apply_filters( 'kinfw-filter/theme/metabox/template/post-type', [] );

            if( !empty( $post_types ) && is_singular( $post_types ) ) {

                $settings = [
                    'footer_id'   => kinfw_onnat_theme_options()->kinfw_get_option( 'default_footer' ),
                    'footer_type' => 'footer'
                ];

                if( 'elementor_footer' === $settings['footer_id'] ) {
                    $settings['footer_id']   = kinfw_onnat_theme_options()->kinfw_get_option( 'elementor_footer' );
                    $settings['footer_type'] = 'elementor';
                }

                $meta     = get_post_meta( get_the_ID(), '_kinfw_cpt_options', true );
				$settings = $this->get_footer( $meta, $settings );

                return $settings;

            }

            return $settings;
        }

        /**
         * Custom Post Type : Footer
         */
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

if( !function_exists( 'kinfw_onnat_theme_our_cpt_footer' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_our_cpt_footer() {

        return Onnat_Theme_Our_CPT_Footer::get_instance();
    }

}

kinfw_onnat_theme_our_cpt_footer();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */