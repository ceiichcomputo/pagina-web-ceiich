<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Options' ) ) {

	/**
	 * Configure theme option tabs.
	 */
    class Onnat_Theme_Options {

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

            $this->init();
            $this->load_modules();

            do_action( 'kinfw-action/theme/site-options/loaded' );

        }

        public function init() {

            if( !function_exists( 'kf_onnat_extra_plugin' ) ) {
                return;
            }

            CSF::createOptions( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'menu_title'      => esc_html__( 'Theme Options', 'onnat' ),
                'menu_slug'       => 'kinfw-onnat-options',
                'framework_title' => sprintf(
                    /* translators: %s: Theme Brand Name */
                    esc_html__( '%s Settings Panel', 'onnat' ),
                    ONNAT_CONST_THEME
                ),
                'menu_type'       => 'submenu',
                'menu_parent'     => ONNAT_CONST_SAN_THEME,
                'enqueue_webfont' => true,
                'footer_text' => '',
            ] );

        }

        public function load_modules() {

            require_once get_theme_file_path( 'libraries/site-options/class-site-options-general.php' );
            require_once get_theme_file_path( 'libraries/site-options/class-site-options-header.php' );
            require_once get_theme_file_path( 'libraries/site-options/class-site-options-page-title.php' );
            require_once get_theme_file_path( 'libraries/site-options/class-site-options-footer.php' );
            require_once get_theme_file_path( 'libraries/site-options/class-site-options-styling.php' );
            require_once get_theme_file_path( 'libraries/site-options/class-site-options-template-hierarchy.php' );
            require_once get_theme_file_path( 'libraries/site-options/class-site-options-sidebars.php' );
            require_once get_theme_file_path( 'libraries/site-options/class-site-options-custom-css.php' );
            require_once get_theme_file_path( 'libraries/site-options/class-site-options-backup.php' );

        }

        /**
         * Get saved options to use it in theme.
         */
        public function kinfw_get_option( $option ) {

            $options = get_option( ONNAT_CONST_THEME_OPTION_PREFIX );

            if( isset( $options[$option] ) ) {

                if( is_array( $options[$option] ) ) {
                    $arr = array_filter( $options[ $option ] );
                    if( count( $arr ) > 0  ) {
                        return $arr;
                    } else {
                        return []; // return $this->kinfw_get_default_option( $option );
                    }
                } else {
                    return $options[$option];
                }
            } else {
                return $this->kinfw_get_default_option( $option );
            }
        }

        /**
         * Get default values to use it in theme.
         */
        public function kinfw_get_default_option( $option ) {

            $defaults = apply_filters( 'kinfw-filter/theme/site-options/default', [] );

            if( isset( $defaults[ $option ] ) ) {
                return $defaults[ $option ];
            }

            return NULL;
        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_options' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_options() {

        return Onnat_Theme_Options::get_instance();
    }
}

kinfw_onnat_theme_options();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */