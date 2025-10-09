<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Inline_CSS' ) ) {

    /**
     * The Onnat Theme inline style hook setup class.
     */
    class Onnat_Theme_Inline_CSS {

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

            add_action( 'wp_enqueue_scripts', [ $this, 'register_style' ], 1  );
            add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_style' ], 99999  );

        }

        /**
         * Register inline css.
         * To add styles generated from theme options.
         */
        public function register_style() {

            $url = '';

            /**
             * Copy the inline css in "kinfw-onnat-admin-elements"
             * Create a file "kinfw-onnat-elements.css" in active theme director and place the copied text in the file.
             * Why?
             *  to aviod calling the theme admin settings in each call, we just placed the dynamic style options to static css file to reduce server call.
             */
            $static_stylesheet = kinfw_is_elements_style_exists();
            if( !is_null( $static_stylesheet ) ) {
                $url = $static_stylesheet;
            }

            wp_register_style( 'kinfw-onnat-admin-elements', $url, [] );
            wp_register_style( 'kinfw-onnat-admin', '', [] );

        }

        public function enqueue_style() {

            wp_enqueue_style( 'kinfw-onnat-admin-elements' );
            wp_add_inline_style( 'kinfw-onnat-admin-elements', '' );

            wp_enqueue_style( 'kinfw-onnat-admin' );
            wp_add_inline_style( 'kinfw-onnat-admin', '' );
        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_inline_styles' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_inline_styles() {

        return Onnat_Theme_Inline_CSS::get_instance();
    }

}

kinfw_onnat_theme_inline_styles();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */