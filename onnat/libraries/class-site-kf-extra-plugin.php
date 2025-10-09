<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_KF_Extra_Plugin' ) ) {

	/**
	 * The Onnat Theme basic kf extra plugin compatibility setup class.
	 */
    class Onnat_Theme_KF_Extra_Plugin {

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

            $this->load_elementor_extensions();

            add_filter( 'kinfw-filter/plugin/elementor/widgets/list', [ $this, 'widgets_list' ], 99999 );

            do_action( 'kinfw-action/theme/compatibility/plugin/kf-extra/loaded' );

        }

        public function load_elementor_extensions() {

            /**
             * GSAP Scroll Smoother for Elementor Container and Common
             */
            add_filter( 'kinfw-filter/plugin/elementor/extensions/gsap-scroll-smoother', function() {

                $elementor_ext_gsap_scrollsmoother = kinfw_onnat_theme_options()->kinfw_get_option( 'elementor_ext_gsap_scrollsmoother' );

                if( is_null( $elementor_ext_gsap_scrollsmoother ) || !empty( $elementor_ext_gsap_scrollsmoother ) ) {
                    return true;
                }

                return false;

            }, 999 );            

            /**
             * Shape Shift for Elementor container and section
             */
            add_filter( 'kinfw-filter/plugin/elementor/extensions/section-shape-shift', function() {

                $elementor_ext_shape_shift = kinfw_onnat_theme_options()->kinfw_get_option( 'elementor_ext_shape_shift' );

                if( is_null( $elementor_ext_shape_shift ) || !empty( $elementor_ext_shape_shift ) ) {
                    return true;
                }

                return false;

            }, 999 );            

            /**
             * Hover image for Elementor container,section and column
             */
            add_filter( 'kinfw-filter/plugin/elementor/extensions/section-hover-img', function() {

                $elementor_ext_ele_hover_image = kinfw_onnat_theme_options()->kinfw_get_option( 'elementor_ext_ele_hover_image' );

                if( is_null( $elementor_ext_ele_hover_image ) || !empty( $elementor_ext_ele_hover_image ) ) {
                    return true;
                }

                return false;

            }, 999 );

            /**
             * Wrapper Link Extension
             */
            add_filter( 'kinfw-filter/plugin/elementor/extensions/wrapper-link', function() {

                $elementor_ext_wrapper_link = kinfw_onnat_theme_options()->kinfw_get_option( 'elementor_ext_wrapper_link' );

                if( is_null( $elementor_ext_wrapper_link ) || !empty( $elementor_ext_wrapper_link ) ) {
                    return true;
                }

                return false;

            }, 999 );

            /**
             * Advance Custom Positioning Extension
             */
            add_filter( 'kinfw-filter/plugin/elementor/extensions/adv-custom-positioning', function() {

                $elementor_ext_adv_positioning = kinfw_onnat_theme_options()->kinfw_get_option( 'elementor_ext_adv_positioning' );

                if( is_null( $elementor_ext_adv_positioning ) || !empty( $elementor_ext_adv_positioning ) ) {

                    return true;
                }

                return false;

            }, 999 );

            /**
             * CSS Pseudo Extension
             */
            add_filter( 'kinfw-filter/plugin/elementor/extensions/css-pseudo', function() {

                $elementor_ext_css_pseudo = kinfw_onnat_theme_options()->kinfw_get_option( 'elementor_ext_css_pseudo' );

                if( is_null( $elementor_ext_css_pseudo ) || !empty( $elementor_ext_css_pseudo ) ) {
                    return true;
                }

                return false;

            }, 999 );

            /**
             * Custom Cursor
             */
            add_filter( 'kinfw-filter/plugin/elementor/extensions/custom-cursor', function() {

                $elementor_ext_cursor = kinfw_onnat_theme_options()->kinfw_get_option( 'cursor' );

                if( is_null( $elementor_ext_cursor ) || !empty( $elementor_ext_cursor ) ) {
                    return true;
                }

                return false;
            }, 999 );

            /**
             * Motion Effect Extension
             */
            add_filter( 'kinfw-filter/plugin/elementor/extensions/motion-fx', function() {

                $elementor_ext_motion_fx = kinfw_onnat_theme_options()->kinfw_get_option( 'elementor_ext_motion_fx' );

                if( is_null( $elementor_ext_motion_fx ) || !empty( $elementor_ext_motion_fx ) ) {
                    return true;
                }

                return false;

            }, 999 );

            /**
             * Custom CSS Extension
             */
            add_filter( 'kinfw-filter/plugin/elementor/extensions/custom-css', function() {

                $elementor_ext_custom_css = kinfw_onnat_theme_options()->kinfw_get_option( 'elementor_ext_custom_css' );

                if( is_null( $elementor_ext_custom_css ) || !empty( $elementor_ext_custom_css ) ) {
                    return true;
                }

                return false;

            }, 999 );

        }

        public function widgets_list( $widgets ) {

            $widgets_list = [];

            foreach( $widgets as $index => $widget ) {

                $option = kinfw_onnat_theme_options()->kinfw_get_option( $widget['settings']['id'] );

                $widget['enable']       = ( is_null( $option ) || !empty( $option ) ) ? true : false;
                $widgets_list[ $index ] = $widget;

            }

            return $widgets_list;
        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_kf_extra_plugin' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_kf_extra_plugin() {

        return Onnat_Theme_KF_Extra_Plugin::get_instance();
    }
}

kinfw_onnat_theme_kf_extra_plugin();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */