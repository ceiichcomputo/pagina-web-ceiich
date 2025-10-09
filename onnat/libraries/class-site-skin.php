<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Skin' ) ) {

	/**
	 * The Onnat Theme custom skin hook for single post setup class.
	 */
    class Onnat_Theme_Skin {

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

            add_action( 'wp_enqueue_scripts', [ $this, 'skin_vars' ], 11  );

        }

        public function skin_vars() {

            $vars = '';

            if( is_singular('elementor_library') ) {
                return;
            }

			# Post
			if( is_singular('post') ) {
                $meta = get_post_meta( get_the_ID(), ONNAT_CONST_THEME_POST_SETTINGS, true );
                $vars =  $this->css_vars( $meta );

			# Page
            } elseif( is_singular('page') ) {
                $meta = get_post_meta( get_the_ID(), ONNAT_CONST_THEME_PAGE_SETTINGS, true );
                $vars =  $this->css_vars( $meta );
            }

			$vars = apply_filters( 'kinfw-filter/theme/skin/settings', $vars );

            if( !empty( $vars ) ) {
                $css = ':root {'.ONNAT_CONST_THEME_NEW_LINE . $vars . '}'.ONNAT_CONST_THEME_NEW_LINE;

                if( !empty( $css ) ) {
                    wp_add_inline_style( 'kinfw-onnat-theme-style', $css );
                }
            }

        }

        public function css_vars( $meta = [] ) {

            $vars = '';

            if( isset( $meta['skin'] ) && $meta['skin'] ) {

                if( isset( $meta['skin_primary_color'] ) && $meta['skin_primary_color'] ) {
                    $vars .= '--kinfw-primary-color:' .$meta['skin_primary_color'] . ';' . ONNAT_CONST_THEME_NEW_LINE;
                }

                if( isset( $meta['skin_secondary_color'] ) && $meta['skin_secondary_color'] ) {
                    $vars .= '--kinfw-secondary-color:' .$meta['skin_secondary_color'] . ';' . ONNAT_CONST_THEME_NEW_LINE;
                }

                if( isset( $meta['skin_secondary_opacity_color'] ) && $meta['skin_secondary_opacity_color'] ) {
                    $vars .= '--kinfw-secondary-opacity-color:' .$meta['skin_secondary_opacity_color'] . ';' . ONNAT_CONST_THEME_NEW_LINE;
                }

                if( isset( $meta['skin_accent_color'] ) && $meta['skin_accent_color'] ) {
                    $vars .= '--kinfw-accent-color:' .$meta['skin_accent_color'] . ';' . ONNAT_CONST_THEME_NEW_LINE;
                }

                if( isset( $meta['skin_light_color'] ) && $meta['skin_light_color'] ) {
                    $vars .= '--kinfw-text-light-color:' .$meta['skin_light_color'] . ';' . ONNAT_CONST_THEME_NEW_LINE;
                }

                if( isset( $meta['skin_white_color'] ) && $meta['skin_white_color'] ) {
                    $vars .= '--kinfw-white-color:' .$meta['skin_white_color'] . ';' . ONNAT_CONST_THEME_NEW_LINE;
                }

                if( isset( $meta['skin_bg_light_color'] ) && $meta['skin_bg_light_color'] ) {
                    $vars .= '--kinfw-bg-light-color:' .$meta['skin_bg_light_color'] . ';' . ONNAT_CONST_THEME_NEW_LINE;
                }
            }

            if( !empty( $vars ) ) {
                $vars = "/* Single Post Specific Color Variables */". ONNAT_CONST_THEME_NEW_LINE . $vars;
            }

            return $vars;
        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_skin' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_skin() {

        return Onnat_Theme_Skin::get_instance();
    }
}

kinfw_onnat_theme_skin();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */