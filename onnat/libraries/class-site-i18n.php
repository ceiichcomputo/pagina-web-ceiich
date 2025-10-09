<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_i18n' ) ) {

	/**
	 * The Onnat Theme basic internationalization setup class.
	 */
    class Onnat_Theme_i18n {

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

            add_action( 'after_setup_theme', [ $this, 'i18n' ] );

            do_action( 'kinfw-action/theme/118n/loaded' );

        }

        public function i18n() {

            /**
             *  Child theme language support
             */
                load_theme_textdomain( 'onnat', get_stylesheet_directory() . '/languages' );

            /**
             *  Main theme language support
             */
                load_theme_textdomain( 'onnat', get_template_directory() . '/languages' );

        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_i18n' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_i18n() {

        return Onnat_Theme_i18n::get_instance();
    }
}

kinfw_onnat_theme_i18n();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */