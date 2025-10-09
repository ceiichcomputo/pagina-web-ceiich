<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Options_Custom_CSS' ) ) {

	/**
	 *  The Onnat theme custom css options setup class.
	 */
    class Onnat_Theme_Options_Custom_CSS {

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

            if( !function_exists( 'kf_onnat_extra_plugin' ) ) {

                return;
            }

            $this->settings();

            do_action( 'kinfw-action/theme/site-options/custom-css/loaded' );

        }

        public function settings() {

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'id'     => 'theme_custom_css_section',
                'title'  => esc_html__( 'Custom CSS', 'onnat' ),
                'fields' => [
                    [
                        'id'       => 'custom_css',
                        'type'     => 'code_editor',
                        'title'    => esc_html__( 'Custom CSS', 'onnat' ),
                        'subtitle' => esc_html__( 'Enter your CSS code in the field below. Do not include any tags or HTML in the field.', 'onnat' ),
                    ],
                ]
            ] );

        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_options_custom_css' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_options_custom_css() {

        return Onnat_Theme_Options_Custom_CSS::get_instance();
    }
}

kinfw_onnat_theme_options_custom_css();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */