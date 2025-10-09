<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Styles_Dynamic' ) ) {

	/**
	 * The Onnat Theme dynamic style setup class.
     *
     * Hint:
     * Copy the inline css in "kinfw-onnat-admin-elements"
     * Create a file "kinfw-elements.css" in active theme director and place the copied text in the file.
     * Why?
     *  to aviod calling the theme admin settings in each call, we just placed the dynamic style options to static css file to reduce server call.
	 */
    class Onnat_Theme_Styles_Dynamic {

		/**
		 * A reference to an instance of this class.
		 */
		private static $instance = null;

        public $tablet_responsive_css = '';

        public $mobile_responsive_css = '';

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

            /**
             * Copy the inline css in "kinfw-onnat-admin-elements"
             * Create a file "kinfw-onnat-elements.css" in active theme director and place the copied text in the file.
             * Why?
             *  to aviod calling the theme admin settings in each call, we just placed the dynamic style options to static css file to reduce server call.
             */
            $static_stylesheet = kinfw_is_elements_style_exists();
            if( !is_null( $static_stylesheet ) ) {
                return;
            }

            /**
             * Admin Panel : Styling
             */
            add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_hint' ] );
            add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_cursor_style' ] );
            add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_layout_style' ] );
            add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_body_style' ] );
            add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_loader_style' ] );
            add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_widget_style' ] );
            add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_heading_style' ] );
            add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_menu_label_style' ] );

            add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_not_found_style' ] );
            add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_custom_css' ] );

            add_action( 'wp_enqueue_scripts', [ $this, 'tablet_responsive_css' ] );
            add_action( 'wp_enqueue_scripts', [ $this, 'mobile_responsive_css' ] );

            do_action( 'kinfw-action/theme/styles/dynamic/loaded' );

        }

        public function enqueue_hint() {
            $css = sprintf(
                esc_html__('/* Create a file %s in active theme and add the below css in it. */', 'onnat' ),
                'kinfw-onnat-elements.css'
            );

            $css .= ONNAT_CONST_THEME_NEW_LINE;

            wp_add_inline_style( 'kinfw-onnat-admin-elements', $css );

        }

        /**
         * Custom Cursor css.
         */
        public function enqueue_cursor_style() {
            $css    = '';
            $cursor = kinfw_onnat_theme_options()->kinfw_get_option( 'cursor' );

            if( $cursor ) {
                $cursor_colors = kinfw_onnat_theme_options()->kinfw_get_option( 'cursor_colors' );
                foreach( $cursor_colors as $key => $cursor_color ) {
                    $color = isset( $cursor_color['color'] ) ? $cursor_color['color'] : '';
                    if( !empty( $color ) ) {
                        $css .= '.kinfw-cursor[data-color="kinfw-cursor-custom-'.$key.'-color"]:before {  background:'.$color.'; }';
                    }
                }
            }

            if( !empty( $css ) ) {

                wp_add_inline_style( 'kinfw-onnat-admin-elements', $css );

            }
        }

        /**
         * Layout css.
         * Generated based on admin panel options.
         */
        public function enqueue_layout_style() {

            $css      = '';
            $layout   = kinfw_onnat_theme_options()->kinfw_get_option( 'layout' );
            $bg_css   = kinfw_onnat_theme_options()->kinfw_get_option( 'body_bg' );

            $background_css = kinfw_bg_opt_css( $bg_css );
            if( !empty( $background_css ) ) {
                $css .= 'body {'.$background_css.'}';
            }

            if( 'kinfw-boxed-layout' === $layout ) {

                $bg_color = kinfw_onnat_theme_options()->kinfw_get_option( 'boxed_bg_color' );

                if( !empty( $bg_color ) ) {

                    $css .= 'body.kinfw-boxed-layout #kinfw-wrap { background-color:'.$bg_color.';}';
                }

            }

            if( !empty( $css ) ) {

                wp_add_inline_style( 'kinfw-onnat-admin-elements', $css );

            }
        }

        /**
         * Body css.
         * Generated based on admin panel options.
         */
        public function enqueue_body_style() {

            $css      = '';
            $selector = apply_filters( 'kinfw-filter/theme/output/typo/content', [ 'body' ] );
            $selector = implode(",", $selector );

            /**
             * Typo
             */
            $typo     = kinfw_onnat_theme_options()->kinfw_get_option( 'body_typo_size' );
            $size     = isset( $typo['size'] ) ? $typo['size'] : [];
            $typo_css = kinfw_typo_opt_css( $size );

            if( isset( $typo_css['css'] ) ) {
                $css .= $selector . ' {'. $typo_css['css'] .'}'.ONNAT_CONST_THEME_NEW_LINE;
            }

            if( isset( $typo_css['md_css'] ) ) {
                $this->tablet_responsive_css .= $selector . ' {'. $typo_css['md_css'] .'}'.ONNAT_CONST_THEME_NEW_LINE;
            }

            if( isset( $typo_css['sm_css'] ) ) {
                $this->mobile_responsive_css .= $selector . ' {'. $typo_css['sm_css'] .'}'.ONNAT_CONST_THEME_NEW_LINE;
            }

            /**
             * Link Color
             */
            $selector        = apply_filters( 'kinfw-filter/theme/output/style/anchor', [ 'a', '.xyz' ] );
            $hover_selector  = array_map(function($value) { return $value.":hover"; }, $selector);

            $selector        = implode(",", $selector );
            $hover_selector  = implode(",", $hover_selector );

            $body_link_color = kinfw_onnat_theme_options()->kinfw_get_option( 'body_link_color' );
            if( is_array( $body_link_color ) ) {
                if( isset( $body_link_color['color'] ) ) {
                    $css .= $selector .'{color:'.$body_link_color['color'].'}'.ONNAT_CONST_THEME_NEW_LINE;
                }

                if( isset( $body_link_color['hover'] ) ) {
                    $css .= $hover_selector . '{color:'.$body_link_color['hover'].'}'.ONNAT_CONST_THEME_NEW_LINE;
                }
            }

            if( !empty( $css ) ) {

                wp_add_inline_style( 'kinfw-onnat-admin-elements', $css );

            }

        }

        /**
         * Loader css.
         * Generated based on admin panel options.
         */
        public function enqueue_loader_style() {
            $css    = '';
            $loader = kinfw_onnat_theme_options()->kinfw_get_option( 'loader' );

            if( $loader ) {

                $loader_style = kinfw_onnat_theme_options()->kinfw_get_option( 'loader_style' );

                switch( $loader_style ) {

                    default:
                    case 'kinfw-pre-loader-circle kinfw-pre-loader-spinning-circle':
                        $loader_size = kinfw_onnat_theme_options()->kinfw_get_option( 'loader_size' );

                        if( is_array( $loader_size ) && isset( $loader_size['size'] ) ) {
                            $size = $loader_size['size'];

                            /**
                             * Desktop
                             */
                            if( !empty( $size['lg_loader_size'] ) ) {
                                $css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-circle { width:%1$spx; height:%1$spx; } %2$s', $size['lg_loader_size'], ONNAT_CONST_THEME_NEW_LINE );
                            }

                            if( !empty( $size['lg_border_size'] ) ) {
                                $css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-spinning-circle { border-width:%1$spx; } %2$s', $size['lg_border_size'], ONNAT_CONST_THEME_NEW_LINE );
                            }

                            /**
                             * Tablet
                             */
                            if( !empty( $size['md_loader_size'] ) ) {
                                $this->tablet_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-circle { width:%1$spx; height:%1$spx; } %2$s', $size['md_loader_size'], ONNAT_CONST_THEME_NEW_LINE );
                            }

                            if( !empty( $size['md_border_size'] ) ) {
                                $this->tablet_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-spinning-circle { border-width:%1$spx; } %2$s', $size['md_border_size'], ONNAT_CONST_THEME_NEW_LINE );
                            }

                            /**
                             * Mobile
                             */
                            if( !empty( $size['sm_loader_size'] ) ) {
                                $this->mobile_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-circle { width:%1$spx; height:%1$spx; } %2$s', $size['sm_loader_size'], ONNAT_CONST_THEME_NEW_LINE );
                            }

                            if( !empty( $size['sm_border_size'] ) ) {
                                $this->mobile_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-spinning-circle { border-width:%1$spx; } %2$s', $size['sm_border_size'], ONNAT_CONST_THEME_NEW_LINE );
                            }

                        }
                    break;

                    case 'kinfw-pre-loader-circle kinfw-pre-loader-spinning-circle-2':
                        $loader_size = kinfw_onnat_theme_options()->kinfw_get_option( 'loader_size' );

                        if( is_array( $loader_size ) && isset( $loader_size['size'] ) ) {
                            $size = $loader_size['size'];

                            /**
                             * Desktop
                             */
                            if( !empty( $size['lg_loader_size'] ) ) {
                                $circle_1 = $size['lg_loader_size'];
                                $circle_2 = round( ( $circle_1 * 3 ) / 4 );

                                $css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-circle { width:%1$spx; height:%1$spx; } %2$s', $circle_1, ONNAT_CONST_THEME_NEW_LINE );
                                $css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-spinning-circle-2:after { width:%1$spx; height:%1$spx; } %2$s', $circle_2, ONNAT_CONST_THEME_NEW_LINE );
                            }

                            if( !empty( $size['lg_border_size'] ) ) {
                                $border = $size['lg_border_size'];
                                $css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-spinning-circle { border-width:%1$spx; } %2$s', $border, ONNAT_CONST_THEME_NEW_LINE );
                                $css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-spinning-circle-2:after { border-width:%1$spx; } %2$s', $border, ONNAT_CONST_THEME_NEW_LINE );
                            }

                            /**
                             * Tablet
                             */
                            if( !empty( $size['md_loader_size'] ) ) {
                                $circle_1 = $size['md_loader_size'];
                                $circle_2 = round( ( $circle_1 * 3 ) / 4 );

                                $this->tablet_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-circle { width:%1$spx; height:%1$spx; } %2$s', $circle_1, ONNAT_CONST_THEME_NEW_LINE );
                                $this->tablet_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-spinning-circle-2:after { width:%1$spx; height:%1$spx; } %2$s', $circle_2, ONNAT_CONST_THEME_NEW_LINE );
                            }

                            if( !empty( $size['md_border_size'] ) ) {
                                $border = $size['md_border_size'];
                                $this->tablet_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-spinning-circle { border-width:%1$spx; } %2$s', $size['md_border_size'], ONNAT_CONST_THEME_NEW_LINE );
                                $this->tablet_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-spinning-circle-2:after { border-width:%1$spx; } %2$s', $size['md_border_size'], ONNAT_CONST_THEME_NEW_LINE );
                            }

                            /**
                             * Mobile
                             */
                            if( !empty( $size['sm_loader_size'] ) ) {
                                $circle_1 = $size['sm_loader_size'];
                                $circle_2 = round( ( $circle_1 * 3 ) / 4 );

                                $this->mobile_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-circle { width:%1$spx; height:%1$spx; } %2$s', $circle_1, ONNAT_CONST_THEME_NEW_LINE );
                                $this->mobile_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-spinning-circle-2:after { width:%1$spx; height:%1$spx; } %2$s', $circle_2, ONNAT_CONST_THEME_NEW_LINE );
                            }

                            if( !empty( $size['sm_border_size'] ) ) {
                                $border = $size['sm_border_size'];
                                $this->mobile_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-spinning-circle { border-width:%1$spx; } %2$s', $border, ONNAT_CONST_THEME_NEW_LINE );
                                $this->mobile_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-spinning-circle-2:after { border-width:%1$spx; } %2$s', $border, ONNAT_CONST_THEME_NEW_LINE );
                            }
                        }
                    break;

                    case 'kinfw-pre-loader-circle kinfw-pre-loader-spinning-circles':
                        $loader_size = kinfw_onnat_theme_options()->kinfw_get_option( 'loader_size' );

                        if( is_array( $loader_size ) && isset( $loader_size['size'] ) ) {
                            $size = $loader_size['size'];

                            /**
                             * Desktop
                             */
                            if( !empty( $size['lg_loader_size'] ) ) {
                                $circle_1 = $size['lg_loader_size'];
                                $circle_2 = round( ( $circle_1 / 2 ) );

                                $css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-circle { width:%1$spx; height:%1$spx; } %2$s', $circle_1, ONNAT_CONST_THEME_NEW_LINE );
                                $css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-spinning-circles:after { width:%1$spx; height:%1$spx; } %2$s', $circle_2, ONNAT_CONST_THEME_NEW_LINE );
                            }

                            if( !empty( $size['lg_border_size'] ) ) {
                                $css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-spinning-circles, #kinfw-pre-loader .kinfw-pre-loader-spinning-circles:after { border-width:%1$spx; } %2$s', $size['lg_border_size'], ONNAT_CONST_THEME_NEW_LINE );
                            }

                            /**
                             * Tablet
                             */
                            if( !empty( $size['md_loader_size'] ) ) {
                                $circle_1 = $size['md_loader_size'];
                                $circle_2 = round( ( $circle_1 / 2 ) );

                                $this->tablet_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-circle { width:%1$spx; height:%1$spx; } %2$s', $circle_1, ONNAT_CONST_THEME_NEW_LINE );
                                $this->tablet_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-spinning-circles:after { width:%1$spx; height:%1$spx; } %2$s', $circle_2, ONNAT_CONST_THEME_NEW_LINE );

                            }

                            if( !empty( $size['md_border_size'] ) ) {
                                $this->tablet_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-spinning-circles, #kinfw-pre-loader .kinfw-pre-loader-spinning-circles:after { border-width:%1$spx; } %2$s', $size['md_border_size'], ONNAT_CONST_THEME_NEW_LINE );
                            }

                            /**
                             * Mobile
                             */
                            if( !empty( $size['sm_loader_size'] ) ) {
                                $circle_1 = $size['sm_loader_size'];
                                $circle_2 = round( ( $circle_1 / 2 ) );

                                $this->mobile_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-circle { width:%1$spx; height:%1$spx; } %2$s', $circle_1, ONNAT_CONST_THEME_NEW_LINE );
                                $this->mobile_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-spinning-circles:after { width:%1$spx; height:%1$spx; } %2$s', $circle_2, ONNAT_CONST_THEME_NEW_LINE );
                            }

                            if( !empty( $size['sm_border_size'] ) ) {
                                $this->mobile_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-spinning-circles, #kinfw-pre-loader .kinfw-pre-loader-spinning-circles:after { border-width:%1$spx; } %2$s', $size['sm_border_size'], ONNAT_CONST_THEME_NEW_LINE );
                            }

                        }
                    break;

                    case 'kinfw-pre-loader-circle kinfw-pre-loader-spinning-semi-circle':
                        $loader_size = kinfw_onnat_theme_options()->kinfw_get_option( 'loader_size' );

                        if( is_array( $loader_size ) && isset( $loader_size['size'] ) ) {
                            $size = $loader_size['size'];

                            /**
                             * Desktop
                             */
                            if( !empty( $size['lg_loader_size'] ) ) {
                                $width  = $size['lg_loader_size'];
                                $height = round( ( $width / 2 ) );

                                $css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-spinning-semi-circle { width:%1$spx; height:%2$spx; } %3$s', $width, $height, ONNAT_CONST_THEME_NEW_LINE );
                                $css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-spinning-semi-circle:before { width:%1$spx; height:%1$spx; } %2$s', $width, ONNAT_CONST_THEME_NEW_LINE );

                            }

                            if( !empty( $size['lg_border_size'] ) ) {
                                $css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-spinning-semi-circle, #kinfw-pre-loader .kinfw-pre-loader-spinning-semi-circle:before { border-width:%1$spx; } %2$s', $size['lg_border_size'], ONNAT_CONST_THEME_NEW_LINE );
                            }

                            /**
                             * Tablet
                             */
                            if( !empty( $size['md_loader_size'] ) ) {
                                $width  = $size['md_loader_size'];
                                $height = round( ( $width / 2 ) );

                                $this->tablet_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-spinning-semi-circle { width:%1$spx; height:%2$spx; } %3$s', $width, $height, ONNAT_CONST_THEME_NEW_LINE );
                                $this->tablet_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-spinning-semi-circle:before { width:%1$spx; height:%1$spx; } %2$s', $width, ONNAT_CONST_THEME_NEW_LINE );

                            }

                            if( !empty( $size['md_border_size'] ) ) {
                                $this->tablet_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-spinning-semi-circle, #kinfw-pre-loader .kinfw-pre-loader-spinning-semi-circle:before { border-width:%1$spx; } %2$s', $size['md_border_size'], ONNAT_CONST_THEME_NEW_LINE );
                            }

                            /**
                             * Mobile
                             */
                            if( !empty( $size['sm_loader_size'] ) ) {
                                $width  = $size['sm_loader_size'];
                                $height = round( ( $width / 2 ) );

                                $this->mobile_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-spinning-semi-circle { width:%1$spx; height:%2$spx; } %3$s', $width, $height, ONNAT_CONST_THEME_NEW_LINE );
                                $this->mobile_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-spinning-semi-circle:before { width:%1$spx; height:%1$spx; } %2$s', $width, ONNAT_CONST_THEME_NEW_LINE );

                            }

                            if( !empty( $size['sm_border_size'] ) ) {
                                $this->mobile_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-spinning-semi-circle, #kinfw-pre-loader .kinfw-pre-loader-spinning-semi-circle:before { border-width:%1$spx; } %2$s', $size['sm_border_size'], ONNAT_CONST_THEME_NEW_LINE );
                            }
                        }
                    break;

                    case 'kinfw-pre-loader-circle kinfw-pre-loader-rotating-dots-circle':
                        $loader_size = kinfw_onnat_theme_options()->kinfw_get_option( 'loader_size' );
                        if( is_array( $loader_size ) && isset( $loader_size['size'] ) ) {
                            $size = $loader_size['size'];

                            /**
                             * Desktop
                             */
                            if( !empty( $size['lg_loader_size'] ) ) {
                                $circle_1 = $size['lg_loader_size'];
                                $circle_2 = round( ( $circle_1 / 10 ) );
                                $circle_2 = $circle_2 < 1 ? 1 : $circle_2;

                                $css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-circle { width:%1$spx; height:%1$spx; } %2$s', $circle_1, ONNAT_CONST_THEME_NEW_LINE );
                                $css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-rotating-dots-circle:after, #kinfw-pre-loader .kinfw-pre-loader-rotating-dots-circle:before { width:%1$spx; height:%1$spx; } %2$s', $circle_2, ONNAT_CONST_THEME_NEW_LINE );

                            }

                            if( !empty( $size['lg_border_size'] ) ) {
                                $css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-rotating-dots-circle { border-width:%1$spx; } %2$s', $size['lg_border_size'], ONNAT_CONST_THEME_NEW_LINE );
                            }

                            /**
                             * Tablet
                             */
                            if( !empty( $size['md_loader_size'] ) ) {
                                $circle_1 = $size['md_loader_size'];
                                $circle_2 = round( ( $circle_1 / 10 ) );
                                $circle_2 = $circle_2 < 1 ? 1 : $circle_2;

                                $this->tablet_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-circle { width:%1$spx; height:%1$spx; } %2$s', $circle_1, ONNAT_CONST_THEME_NEW_LINE );
                                $this->tablet_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-rotating-dots-circle:after, #kinfw-pre-loader .kinfw-pre-loader-rotating-dots-circle:before { width:%1$spx; height:%1$spx; } %2$s', $circle_2, ONNAT_CONST_THEME_NEW_LINE );
                            }

                            if( !empty( $size['md_border_size'] ) ) {
                                $this->tablet_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-rotating-dots-circle { border-width:%1$spx; } %2$s', $size['md_border_size'], ONNAT_CONST_THEME_NEW_LINE );
                            }

                            /**
                             * Mobile
                             */
                            if( !empty( $size['sm_loader_size'] ) ) {
                                $circle_1 = $size['sm_loader_size'];
                                $circle_2 = round( ( $circle_1 / 10 ) );
                                $circle_2 = $circle_2 < 1 ? 1 : $circle_2;

                                $this->mobile_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-circle { width:%1$spx; height:%1$spx; } %2$s', $circle_1, ONNAT_CONST_THEME_NEW_LINE );
                                $this->mobile_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-rotating-dots-circle:after, #kinfw-pre-loader .kinfw-pre-loader-rotating-dots-circle:before { width:%1$spx; height:%1$spx; } %2$s', $circle_2, ONNAT_CONST_THEME_NEW_LINE );
                            }

                            if( !empty( $size['sm_border_size'] ) ) {
                                $this->mobile_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-rotating-dots-circle { border-width:%1$spx; } %2$s', $size['sm_border_size'], ONNAT_CONST_THEME_NEW_LINE );
                            }

                        }
                    break;

                    case 'kinfw-pre-loader-circle kinfw-pre-loader-clock':
                        $loader_size = kinfw_onnat_theme_options()->kinfw_get_option( 'loader_size' );

                        if( is_array( $loader_size ) && isset( $loader_size['size'] ) ) {
                            $size = $loader_size['size'];

                            /**
                             * Desktop
                             */
                            if( !empty( $size['lg_loader_size'] ) ) {
                                $circle    = $size['lg_loader_size'];
                                $indicator = round( ( $circle / 2 ) );
                                $indicator = $indicator < 1 ? 1 : $indicator;

                                $css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-circle { width:%1$spx; height:%1$spx; } %2$s', $circle, ONNAT_CONST_THEME_NEW_LINE );
                                $css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-clock:after { height:%1$spx; } %2$s', $indicator, ONNAT_CONST_THEME_NEW_LINE );
                            }

                            if( !empty( $size['lg_border_size'] ) ) {
                                $css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-clock { border-width:%1$spx; } %2$s', $size['lg_border_size'], ONNAT_CONST_THEME_NEW_LINE );
                                $css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-clock:after { width:%1$spx; } %2$s', $size['lg_border_size'], ONNAT_CONST_THEME_NEW_LINE );
                            }

                            /**
                             * Tablet
                             */
                            if( !empty( $size['md_loader_size'] ) ) {
                                $circle    = $size['md_loader_size'];
                                $indicator = round( ( $circle / 2 ) );
                                $indicator = $indicator < 1 ? 1 : $indicator;

                                $this->tablet_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-circle { width:%1$spx; height:%1$spx; } %2$s', $circle, ONNAT_CONST_THEME_NEW_LINE );
                                $this->tablet_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-clock:after { height:%1$spx; } %2$s', $indicator, ONNAT_CONST_THEME_NEW_LINE );
                            }

                            if( !empty( $size['md_border_size'] ) ) {
                                $this->tablet_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-clock { border-width:%1$spx; } %2$s', $size['md_border_size'], ONNAT_CONST_THEME_NEW_LINE );
                                $this->tablet_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-clock:after { width:%1$spx; } %2$s', $size['md_border_size'], ONNAT_CONST_THEME_NEW_LINE );
                            }

                            /**
                             * Mobile
                             */
                            if( !empty( $size['sm_loader_size'] ) ) {
                                $circle    = $size['sm_loader_size'];
                                $indicator = round( ( $circle / 2 ) );
                                $indicator = $indicator < 1 ? 1 : $indicator;

                                $this->mobile_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-circle { width:%1$spx; height:%1$spx; } %2$s', $circle, ONNAT_CONST_THEME_NEW_LINE );
                                $this->mobile_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-clock:after { height:%1$spx; } %2$s', $indicator, ONNAT_CONST_THEME_NEW_LINE );
                            }

                            if( !empty( $size['sm_border_size'] ) ) {
                                $this->tablet_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-clock { border-width:%1$spx; } %2$s', $size['sm_border_size'], ONNAT_CONST_THEME_NEW_LINE );
                                $this->tablet_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-clock:after { width:%1$spx; } %2$s', $size['sm_border_size'], ONNAT_CONST_THEME_NEW_LINE );
                            }

                        }
                    break;

                    case 'kinfw-pre-loader-circle kinfw-pre-loader-spinning-line-1':
                        $loader_size = kinfw_onnat_theme_options()->kinfw_get_option( 'loader_size' );

                        if( is_array( $loader_size ) && isset( $loader_size['size'] ) ) {
                            $size = $loader_size['size'];

                            /**
                             * Desktop
                             */
                            if( !empty( $size['lg_loader_size'] ) ) {
                                $css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-circle { width:%1$spx; height:%1$spx; } %2$s', $size['lg_loader_size'], ONNAT_CONST_THEME_NEW_LINE );
                            }

                            if( !empty( $size['lg_border_size'] ) ) {
                                $css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-spinning-line-1 { border-top-width:%1$spx; border-right-width:%1$spx; } %2$s', $size['lg_border_size'], ONNAT_CONST_THEME_NEW_LINE );
                            }

                            /**
                             * Tablet
                             */
                            if( !empty( $size['md_loader_size'] ) ) {
                                $this->tablet_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-circle { width:%1$spx; height:%1$spx; } %2$s', $size['md_loader_size'], ONNAT_CONST_THEME_NEW_LINE );
                            }

                            if( !empty( $size['md_border_size'] ) ) {
                                $this->tablet_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-spinning-line-1 { border-top-width:%1$spx; border-right-width:%1$spx; } %2$s', $size['md_border_size'], ONNAT_CONST_THEME_NEW_LINE );
                            }

                            /**
                             * Mobile
                             */
                            if( !empty( $size['sm_loader_size'] ) ) {
                                $this->mobile_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-circle { width:%1$spx; height:%1$spx; } %2$s', $size['sm_loader_size'], ONNAT_CONST_THEME_NEW_LINE );
                            }

                            if( !empty( $size['sm_border_size'] ) ) {
                                $this->mobile_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-spinning-line-1 { border-top-width:%1$spx; border-right-width:%1$spx; } %2$s', $size['sm_border_size'], ONNAT_CONST_THEME_NEW_LINE );
                            }

                        }
                    break;

                    case 'kinfw-pre-loader-circle kinfw-pre-loader-spinning-line-2':
                        $loader_size = kinfw_onnat_theme_options()->kinfw_get_option( 'loader_size' );

                        if( is_array( $loader_size ) && isset( $loader_size['size'] ) ) {
                            $size = $loader_size['size'];

                            /**
                             * Desktop
                             */
                            if( !empty( $size['lg_loader_size'] ) ) {
                                $css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-circle, #kinfw-pre-loader .kinfw-pre-loader-spinning-line-2:after { width:%1$spx; height:%1$spx; } %2$s', $size['lg_loader_size'], ONNAT_CONST_THEME_NEW_LINE );
                            }

                            if( !empty( $size['lg_border_size'] ) ) {
                                $css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-spinning-line-2 { border-top-width:%1$spx; border-right-width:%1$spx; } %2$s', $size['lg_border_size'], ONNAT_CONST_THEME_NEW_LINE );
                                $css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-spinning-line-2:after { border-bottom-width:%1$spx; border-left-width:%1$spx; } %2$s', $size['lg_border_size'], ONNAT_CONST_THEME_NEW_LINE );
                            }

                            /**
                             * Tablet
                             */
                            if( !empty( $size['md_loader_size'] ) ) {
                                $this->tablet_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-circle, #kinfw-pre-loader .kinfw-pre-loader-spinning-line-2:after { width:%1$spx; height:%1$spx; } %2$s', $size['md_loader_size'], ONNAT_CONST_THEME_NEW_LINE );
                            }

                            if( !empty( $size['md_border_size'] ) ) {
                                $this->tablet_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-spinning-line-2 { border-top-width:%1$spx; border-right-width:%1$spx; } %2$s', $size['md_border_size'], ONNAT_CONST_THEME_NEW_LINE );
                                $this->tablet_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-spinning-line-2:after { border-bottom-width:%1$spx; border-left-width:%1$spx; } %2$s', $size['md_border_size'], ONNAT_CONST_THEME_NEW_LINE );
                            }

                            /**
                             * Mobile
                             */

                            if( !empty( $size['sm_loader_size'] ) ) {
                                $this->mobile_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-circle, #kinfw-pre-loader .kinfw-pre-loader-spinning-line-2:after { width:%1$spx; height:%1$spx; } %2$s', $size['sm_loader_size'], ONNAT_CONST_THEME_NEW_LINE );
                            }

                            if( !empty( $size['sm_border_size'] ) ) {
                                $this->mobile_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-spinning-line-2 { border-top-width:%1$spx; border-right-width:%1$spx; } %2$s', $size['sm_border_size'], ONNAT_CONST_THEME_NEW_LINE );
                                $this->mobile_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-spinning-line-2:after { border-bottom-width:%1$spx; border-left-width:%1$spx; } %2$s', $size['sm_border_size'], ONNAT_CONST_THEME_NEW_LINE );
                            }

                        }
                    break;

                    case 'kinfw-pre-loader-circle kinfw-pre-loader-fading-circle':
                        $loader_size = kinfw_onnat_theme_options()->kinfw_get_option( 'loader_size' );
                        if( is_array( $loader_size ) && isset( $loader_size['size'] ) ) {
                            $size = $loader_size['size'];

                            /**
                             * Desktop
                             */
                            if( !empty( $size['lg_loader_size'] ) ) {
                                $css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-fading-circle { width:%1$spx; height:%1$spx; } %2$s', $size['lg_loader_size'], ONNAT_CONST_THEME_NEW_LINE );
                            }

                            /**
                             * Tablet
                             */
                            if( !empty( $size['md_loader_size'] ) ) {
                                $this->tablet_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-fading-circle { width:%1$spx; height:%1$spx; } %2$s', $size['md_loader_size'], ONNAT_CONST_THEME_NEW_LINE );
                            }

                            /**
                             * Mobile
                             */
                            if( !empty( $size['sm_loader_size'] ) ) {
                                $this->mobile_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-fading-circle { width:%1$spx; height:%1$spx; } %2$s', $size['sm_loader_size'], ONNAT_CONST_THEME_NEW_LINE );
                            }
                        }
                    break;

                    case 'kinfw-pre-loader-spinning-dots':
                        $loader_size = kinfw_onnat_theme_options()->kinfw_get_option( 'loader_size' );

                        if( is_array( $loader_size ) && isset( $loader_size['size'] ) ) {
                            $size = $loader_size['size'];

                            /**
                             * Desktop
                             */
                            if( !empty( $size['lg_loader_size'] ) ) {
                                $css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-spinning-dots { font-size:%1$spx;} %2$s', $size['lg_loader_size'], ONNAT_CONST_THEME_NEW_LINE );
                            }

                            /**
                             * Tablet
                             */
                            if( !empty( $size['md_loader_size'] ) ) {
                                $this->tablet_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-spinning-dots { font-size:%1$spx;} %2$s', $size['md_loader_size'], ONNAT_CONST_THEME_NEW_LINE );
                            }

                            /**
                             * Mobile
                             */
                            if( !empty( $size['sm_loader_size'] ) ) {
                                $this->mobile_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-spinning-dots { font-size:%1$spx;} %2$s', $size['sm_loader_size'], ONNAT_CONST_THEME_NEW_LINE );
                            }

                        }
                    break;

                    case 'kinfw-pre-loader-circle kinfw-pre-loader-chasing-dots-1':
                        $loader_size = kinfw_onnat_theme_options()->kinfw_get_option( 'loader_size' );

                        if( is_array( $loader_size ) && isset( $loader_size['size'] ) ) {
                            $size = $loader_size['size'];

                            /**
                             * Desktop
                             */
                            if( !empty( $size['lg_loader_size'] ) ) {
                                $circle_1 = $size['lg_loader_size'];
                                $circle_2 = round( $circle_1 * 0.25 );

                                $css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-circle { width:%1$spx; height:%1$spx; } %2$s', $circle_1, ONNAT_CONST_THEME_NEW_LINE );
                                $css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-chasing-dots-1:after, .kinfw-pre-loader-chasing-dots-1:before { width:%1$spx; height:%1$spx; } %2$s', $circle_2, ONNAT_CONST_THEME_NEW_LINE );
                            }

                            /**
                             * Tablet
                             */
                            if( !empty( $size['md_loader_size'] ) ) {
                                $circle_1 = $size['md_loader_size'];
                                $circle_2 = round( $circle_1 * 0.25 );

                                $this->tablet_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-circle { width:%1$spx; height:%1$spx; } %2$s', $circle_1, ONNAT_CONST_THEME_NEW_LINE );
                                $this->tablet_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-chasing-dots-1:after, .kinfw-pre-loader-chasing-dots-1:before { width:%1$spx; height:%1$spx; } %2$s', $circle_2, ONNAT_CONST_THEME_NEW_LINE );
                            }

                            /**
                             * Mobile
                             */
                            if( !empty( $size['sm_loader_size'] ) ) {
                                $circle_1 = $size['sm_loader_size'];
                                $circle_2 = round( $circle_1 * 0.25 );

                                $this->mobile_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-circle { width:%1$spx; height:%1$spx; } %2$s', $circle_1, ONNAT_CONST_THEME_NEW_LINE );
                                $this->mobile_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-chasing-dots-1:after, .kinfw-pre-loader-chasing-dots-1:before { width:%1$spx; height:%1$spx; } %2$s', $circle_2, ONNAT_CONST_THEME_NEW_LINE );
                            }
                        }

                    break;

                    case 'kinfw-pre-loader-circle kinfw-pre-loader-chasing-dots-2':
                        $loader_size = kinfw_onnat_theme_options()->kinfw_get_option( 'loader_size' );

                        if( is_array( $loader_size ) && isset( $loader_size['size'] ) ) {
                            $size = $loader_size['size'];

                            /**
                             * Desktop
                             */
                            if( !empty( $size['lg_loader_size'] ) ) {
                                $circle_1 = $size['lg_loader_size'];
                                $circle_2 = round( $circle_1 / 3 );

                                $css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-circle { width:%1$spx; height:%1$spx; } %2$s', $circle_1, ONNAT_CONST_THEME_NEW_LINE );
                                $css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-chasing-dots-2:after, .kinfw-pre-loader-chasing-dots-2:before { width:%1$spx; height:%1$spx; } %2$s', $circle_2, ONNAT_CONST_THEME_NEW_LINE );
                            }

                            /**
                             * Tablet
                             */
                            if( !empty( $size['md_loader_size'] ) ) {
                                $circle_1 = $size['md_loader_size'];
                                $circle_2 = round( $circle_1 / 3 );

                                $this->tablet_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-circle { width:%1$spx; height:%1$spx; } %2$s', $circle_1, ONNAT_CONST_THEME_NEW_LINE );
                                $this->tablet_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-chasing-dots-2:after, .kinfw-pre-loader-chasing-dots-2:before { width:%1$spx; height:%1$spx; } %2$s', $circle_2, ONNAT_CONST_THEME_NEW_LINE );
                            }

                            /**
                             * Mobile
                             */
                            if( !empty( $size['sm_loader_size'] ) ) {
                                $circle_1 = $size['sm_loader_size'];
                                $circle_2 = round( $circle_1 / 3 );

                                $this->mobile_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-circle { width:%1$spx; height:%1$spx; } %2$s', $circle_1, ONNAT_CONST_THEME_NEW_LINE );
                                $this->mobile_responsive_css .= sprintf( '#kinfw-pre-loader .kinfw-pre-loader-chasing-dots-2:after, .kinfw-pre-loader-chasing-dots-2:before { width:%1$spx; height:%1$spx; } %2$s', $circle_2, ONNAT_CONST_THEME_NEW_LINE );
                            }
                        }

                    break;

                }
            }

            if( !empty( $css ) ) {

                wp_add_inline_style( 'kinfw-onnat-admin-elements', $css );

            }

        }

        /**
         * Widget css.
         * Generated based on admin panel options.
         */
        public function enqueue_widget_style() {
            $css = '';

            /**
             * Title Typo
             */
                $title_typo     = kinfw_onnat_theme_options()->kinfw_get_option( 'sidebar_title_typo_size' );
                $size           = isset( $title_typo['size'] ) ? $title_typo['size'] : [];
                $title_typo_css = kinfw_typo_opt_css( $size );

                if( isset( $title_typo_css['css'] ) ) {
                    $css .= '.kinfw-sidebar-holder .widget .kinfw-widget-title {'. $title_typo_css['css'] .'}'.ONNAT_CONST_THEME_NEW_LINE;
                }

                if( isset( $title_typo_css['md_css'] ) ) {
                    $this->tablet_responsive_css .= '.kinfw-sidebar-holder .widget .kinfw-widget-title {'. $title_typo_css['md_css'] .'}'.ONNAT_CONST_THEME_NEW_LINE;
                }

                if( isset( $title_typo_css['sm_css'] ) ) {
                    $this->mobile_responsive_css .= '.kinfw-sidebar-holder .widget .kinfw-widget-title {'. $title_typo_css['sm_css'] .'}'.ONNAT_CONST_THEME_NEW_LINE;
                }

            /**
             * Content Typo
             */
                $content_typo     = kinfw_onnat_theme_options()->kinfw_get_option( 'sidebar_content_typo_size' );
                $size             = isset( $content_typo['size'] ) ? $content_typo['size'] : [];
                $content_typo_css = kinfw_typo_opt_css( $size );

                if( isset( $content_typo_css['css'] ) ) {
                    $css .= '.kinfw-sidebar-holder .widget .kinfw-widget-content, .kinfw-sidebar-holder .widget .kinfw-widget-content a {'. $content_typo_css['css'] .'}'.ONNAT_CONST_THEME_NEW_LINE;
                }

                if( isset( $content_typo_css['md_css'] ) ) {
                    $this->tablet_responsive_css .= '.kinfw-sidebar-holder .widget .kinfw-widget-content, .kinfw-sidebar-holder .widget .kinfw-widget-content a {'. $content_typo_css['md_css'] .'}'.ONNAT_CONST_THEME_NEW_LINE;
                }

                if( isset( $content_typo_css['sm_css'] ) ) {
                    $this->mobile_responsive_css .= '.kinfw-sidebar-holder .widget .kinfw-widget-content, .kinfw-sidebar-holder .widget .kinfw-widget-content a {'. $content_typo_css['sm_css'] .'}'.ONNAT_CONST_THEME_NEW_LINE;
                }

            /**
             * Color
             */
                $contant_a_color = kinfw_onnat_theme_options()->kinfw_get_option( 'sidebar_link_color' );
                $contant_a_color = is_array( $contant_a_color ) ? array_filter( $contant_a_color ) : [];

                if( isset( $contant_a_color['color'] ) && !empty( $contant_a_color['color'] ) ) {
                    $css .= '.kinfw-sidebar-holder .widget .kinfw-widget-content a { color:'. $contant_a_color['color'] .';}'.ONNAT_CONST_THEME_NEW_LINE;
                }

                if( isset( $contant_a_color['hover'] ) && !empty( $contant_a_color['hover'] ) ) {
                    $css .= '.kinfw-sidebar-holder .widget .kinfw-widget-content a:hover { color:'. $contant_a_color['hover'] .';}'.ONNAT_CONST_THEME_NEW_LINE;
                }

            if( !empty( $css ) ) {
                wp_add_inline_style( 'kinfw-onnat-admin-elements', $css );
            }
        }

        /**
         * Heading css.
         * Generated based on admn panel options.
         */
        public function enqueue_heading_style() {
            $css = '';

            for($i = 1; $i <=6; $i++ ) {

                $key      = "h{$i}_tag_typo_size";
                $selector = apply_filters( "kinfw-filter/theme/output/typo/heading-tag/h{$i}", [ "h{$i}" ] );
                $selector = implode(",", $selector );

                $typo     = kinfw_onnat_theme_options()->kinfw_get_option( $key );
                $size     = isset( $typo['size'] ) ? $typo['size'] : [];
                $typo_css = kinfw_typo_opt_css( $size );

                if( isset( $typo_css['css'] ) ) {
                    $css .= $selector . ' {'. $typo_css['css'] .'}'.ONNAT_CONST_THEME_NEW_LINE;
                }

                if( isset( $typo_css['md_css'] ) ) {
                    $this->tablet_responsive_css .= $selector . ' {'. $typo_css['md_css'] .'}'.ONNAT_CONST_THEME_NEW_LINE;
                }

                if( isset( $typo_css['sm_css'] ) ) {
                    $this->mobile_responsive_css .= $selector . ' {'. $typo_css['sm_css'] .'}'.ONNAT_CONST_THEME_NEW_LINE;
                }

            }

            if( !empty( $css ) ) {
                wp_add_inline_style( 'kinfw-onnat-admin-elements', $css );
            }
        }

        /**
         * Menu label css.
         * Generated based on admin panel options.
         */
        public function enqueue_menu_label_style() {

            $css    = '';
            $labels = kinfw_onnat_theme_options()->kinfw_get_option( 'menu_labels' );

            foreach( $labels as $key => $label ) {

                $style  = '';
                $colors = isset( $label['colors'] ) ? $label['colors'] : [];

                $style .= isset( $colors['label'] ) ? 'color:'. $colors['label'] .';':'';
                $style .= isset( $colors['bg'] ) ? 'background-color:'. $colors['bg'] .';':'';

                if( !empty( $style ) ) {
                    $css .= '.kinfw-main-nav > ul li a .kinfw-menu-label-'.$key.'{'. $style .'}'.ONNAT_CONST_THEME_NEW_LINE;
                    $css .= '.kinfw-mobile-menu-nav ul > li > a .kinfw-menu-label-'.$key.'{'. $style .'}'.ONNAT_CONST_THEME_NEW_LINE;
                }
            }

            if( !empty( $css ) ) {

                wp_add_inline_style( 'kinfw-onnat-admin-elements', $css );
            }
        }

        public function enqueue_not_found_style() {
            $css    = '';

            $use_bg = kinfw_onnat_theme_options()->kinfw_get_option( 'use_404_background' );

            if( $use_bg ) {
                $bg_css = kinfw_onnat_theme_options()->kinfw_get_option( '404_background' );

                $background_css = kinfw_bg_opt_css( $bg_css );
                if( !empty( $background_css ) ) {
                    $css .= 'body.error404 {'.$background_css.'}';
                }
            }

            /**
             * Main Text
             */
                $selector = apply_filters( 'kinfw-filter/theme/output/typo/404/main_text', [ '.kinfw-error-404-main-text' ] );
                $selector = implode(",", $selector );

                $typo     = kinfw_onnat_theme_options()->kinfw_get_option( '404_main_text_typo_size' );
                $size     = isset( $typo['size'] ) ? $typo['size'] : [];
                $typo_css = kinfw_typo_opt_css( $size );

                if( isset( $typo_css['css'] ) ) {
                    $css .= $selector . ' {'. $typo_css['css'] .'}'.ONNAT_CONST_THEME_NEW_LINE;
                }

                if( isset( $typo_css['md_css'] ) ) {
                    $this->tablet_responsive_css .= $selector . ' {'. $typo_css['md_css'] .'}'.ONNAT_CONST_THEME_NEW_LINE;
                }

                if( isset( $typo_css['sm_css'] ) ) {
                    $this->mobile_responsive_css .= $selector . ' {'. $typo_css['sm_css'] .'}'.ONNAT_CONST_THEME_NEW_LINE;
                }

            /**
             * Sub Text
             */
                $selector = apply_filters( 'kinfw-filter/theme/output/typo/404/sub_text', [ '.kinfw-error-404-sub-text' ] );
                $selector = implode(",", $selector );

                $typo     = kinfw_onnat_theme_options()->kinfw_get_option( '404_sub_text_typo_size' );
                $size     = isset( $typo['size'] ) ? $typo['size'] : [];
                $typo_css = kinfw_typo_opt_css( $size );

                if( isset( $typo_css['css'] ) ) {
                    $css .= $selector . ' {'. $typo_css['css'] .'}'.ONNAT_CONST_THEME_NEW_LINE;
                }

                if( isset( $typo_css['md_css'] ) ) {
                    $this->tablet_responsive_css .= $selector . ' {'. $typo_css['md_css'] .'}'.ONNAT_CONST_THEME_NEW_LINE;
                }

                if( isset( $typo_css['sm_css'] ) ) {
                    $this->mobile_responsive_css .= $selector . ' {'. $typo_css['sm_css'] .'}'.ONNAT_CONST_THEME_NEW_LINE;
                }

            /**
             * Content Text
             */
                $selector = apply_filters( 'kinfw-filter/theme/output/typo/404/sub_text', [ '.kinfw-error-404-content' ] );
                $selector = implode(",", $selector );

                $typo     = kinfw_onnat_theme_options()->kinfw_get_option( '404_content_typo_size' );
                $size     = isset( $typo['size'] ) ? $typo['size'] : [];
                $typo_css = kinfw_typo_opt_css( $size );

                if( isset( $typo_css['css'] ) ) {
                    $css .= $selector . ' {'. $typo_css['css'] .'}'.ONNAT_CONST_THEME_NEW_LINE;
                }

                if( isset( $typo_css['md_css'] ) ) {
                    $this->tablet_responsive_css .= $selector . ' {'. $typo_css['md_css'] .'}'.ONNAT_CONST_THEME_NEW_LINE;
                }

                if( isset( $typo_css['sm_css'] ) ) {
                    $this->mobile_responsive_css .= $selector . ' {'. $typo_css['sm_css'] .'}'.ONNAT_CONST_THEME_NEW_LINE;
                }

            if( !empty( $css ) ) {

                wp_add_inline_style( 'kinfw-onnat-admin-elements', $css );
            }
        }

        /**
         * Custom CSS.
         * Generated based on admin panel options.
         */
        public function enqueue_custom_css() {

            $css = kinfw_onnat_theme_options()->kinfw_get_option( 'custom_css' );

            if( !empty( $css ) ) {

                wp_add_inline_style( 'kinfw-onnat-admin', $css );
            }
        }

        /**
         * Tablet CSS
         */
        public function tablet_responsive_css() {

            $css = $this->tablet_responsive_css;

            if( !empty( $css ) ) {

                $css = '@media only screen and (max-width: 992px) {'. ONNAT_CONST_THEME_NEW_LINE . $css . ONNAT_CONST_THEME_NEW_LINE .'}';
                wp_add_inline_style( 'kinfw-onnat-admin-elements', $css );
            }
        }

        /**
         * Mobile CSS
         */
        public function mobile_responsive_css() {

            $css = $this->mobile_responsive_css;

            if( !empty( $css ) ) {

                $css = '@media only screen and (max-width: 768px) {'. ONNAT_CONST_THEME_NEW_LINE . $css . ONNAT_CONST_THEME_NEW_LINE .'}';
                wp_add_inline_style( 'kinfw-onnat-admin-elements', $css );
            }
        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_styles_dynamic' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_styles_dynamic() {

        return Onnat_Theme_Styles_Dynamic::get_instance();
    }
}

kinfw_onnat_theme_styles_dynamic();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */