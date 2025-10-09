<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Skin' ) ) {

	/**
	 * The Onnat Theme custom skin hook for our CPT single post setup class.
	 */
    class Onnat_Theme_Our_CPT_Skin {

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

            add_filter( 'kinfw-filter/theme/skin/settings', [ $this, 'skin_vars' ] );

            do_action( 'kinfw-action/theme/our/cpt/skin/compatibility/loaded' );
        }

        public function skin_vars( $vars ) {

            $post_types = apply_filters( 'kinfw-filter/theme/metabox/template/post-type', [] );

            if( !empty( $post_types ) && is_singular( $post_types ) ) {

                $meta = get_post_meta( get_the_ID(), '_kinfw_cpt_options', true );
                $vars =  $this->css_vars( $meta );
            }

            return $vars;
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
                $vars = "/* CPT Single Post Specific Color Variables */". ONNAT_CONST_THEME_NEW_LINE . $vars;
            }

            return $vars;
        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_our_cpt_skin' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_our_cpt_skin() {

        return Onnat_Theme_Our_CPT_Skin::get_instance();
    }
}

kinfw_onnat_theme_our_cpt_skin();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */