<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Styles_Options' ) ) {

	/**
	 * The Onnat Theme dynamic style setup class.
	 */
    class Onnat_Theme_Styles_Options {

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

            add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_header_style' ] );
            add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_breadcrumb_style' ] );
            add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_footer_style' ] );

            add_action( 'wp_enqueue_scripts', [ $this, 'tablet_responsive_css' ] );
            add_action( 'wp_enqueue_scripts', [ $this, 'mobile_responsive_css' ] );

            do_action( 'kinfw-action/theme/styles/options/loaded' );

        }

        /**
         * Header
         */
        public function enqueue_header_style() {

            $inline_css = [];
            $settings   = kinfw_onnat_theme_header()->get_settings();
			extract( $settings );

			if( isset( $header_id ) && isset( $header_type ) ) {

                if( 'elementor' === $header_type ) {

                    $check_elementor = kinfw_is_elementor_callable();

                    if( $check_elementor ) {

                        if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
                            $css_file = new \Elementor\Core\Files\CSS\Post( $header_id );
                            $css_file->enqueue();
                        }
                    }

                } else {

					switch( $header_id ) {

						case 'default':
                        case 'standard_header':
                            $inline_css = kinfw_onnat_theme_header()->standard_header_inline_css();
						break;

                        case 'transparent_header':
                            $inline_css = kinfw_onnat_theme_header()->transparent_header_inline_css();
						break;

						case 'top_bar_standard_header':
                            $inline_css = kinfw_onnat_theme_header()->standard_header_with_top_bar_inline_css();
                        break;

						case 'top_bar_transparent_header':
                            $inline_css = kinfw_onnat_theme_header()->transparent_header_with_top_bar_inline_css();
						break;

                        case 'cascade_header':
                            $inline_css = kinfw_onnat_theme_header()->cascade_header();
                        break;

                    }

                    if( !empty( $inline_css['css'] ) ) {

                        wp_add_inline_style( 'kinfw-onnat-admin', $inline_css['css'] );

                        $this->tablet_responsive_css .= $inline_css['tablet'];
                        $this->mobile_responsive_css .= $inline_css['mobile'];
                    }

                }

            }

        }

        /**
         * Breadcrumb css.
         * Generated based on admin panel options.
         */
        public function enqueue_breadcrumb_style() {

            $css      = '';
            $settings = kinfw_onnat_theme_page_title()->get_settings();

            if( $settings[ 'title_block' ] || $settings[ 'breadcrumb_block' ] ) {

                if( !empty( $settings['css'] ) ) {

                    wp_add_inline_style( 'kinfw-onnat-admin', $settings['css'] );

                }

                /**
                 * Title Block
                 */
                if( $settings['title_block' ] ) {

                    /**
                     * Spacing
                     */
                        $title_block_css    = '';
                        $title_block_md_css = '';
                        $title_block_sm_css = '';

                        $spacing = kinfw_onnat_theme_options()->kinfw_get_option( 'page_title_spacing' );

                        $title_block_css .= kinfw_padding_opt_css( isset( $spacing['lg_padding'] ) ? $spacing['lg_padding'] : [] );
                        $title_block_css .= kinfw_margin_opt_css(  isset( $spacing['lg_margin'] ) ? $spacing['lg_margin'] : [] );

                        $title_block_md_css .= kinfw_padding_opt_css(  isset(  $spacing['md_padding'] ) ? $spacing['md_padding'] : [] );
                        $title_block_md_css .= kinfw_margin_opt_css(  isset( $spacing['md_margin'] ) ? $spacing['md_margin'] : [] );

                        $title_block_sm_css .= kinfw_padding_opt_css(  isset( $spacing['sm_padding'] ) ? $spacing['sm_padding'] : [] );
                        $title_block_sm_css .= kinfw_margin_opt_css(  isset( $spacing['sm_margin'] ) ? $spacing['sm_margin'] : [] );

                        if( !empty( $title_block_css ) ) {

                            $css .= '#kinfw-title-holder {'.$title_block_css.'}'.ONNAT_CONST_THEME_NEW_LINE;
                        }

                        if( !empty( $title_block_md_css ) ) {

                            $this->tablet_responsive_css .= '#kinfw-title-holder {'.$title_block_md_css.'}'.ONNAT_CONST_THEME_NEW_LINE;
                        }

                        if( !empty( $title_block_sm_css ) ) {

                            $this->mobile_responsive_css .= '#kinfw-title-holder {'.$title_block_sm_css.'}'.ONNAT_CONST_THEME_NEW_LINE;
                        }

                    /**
                     * Typo
                     */
                        $page_title_typo     = kinfw_onnat_theme_options()->kinfw_get_option( 'page_title_typo_size' );
                        $size                = isset( $page_title_typo['size'] ) ? $page_title_typo['size'] : [];
                        $page_title_typo_css = kinfw_typo_opt_css( $size );

                        if( isset( $page_title_typo_css['css'] ) ) {
                            $css .= '#kinfw-title-wrap > * {'. $page_title_typo_css['css'] .'}'.ONNAT_CONST_THEME_NEW_LINE;
                        }

                        if( isset( $page_title_typo_css['md_css'] ) ) {
                            $this->tablet_responsive_css .= '#kinfw-title-wrap > * {'. $page_title_typo_css['md_css'] .'}'.ONNAT_CONST_THEME_NEW_LINE;
                        }

                        if( isset( $page_title_typo_css['sm_css'] ) ) {
                            $this->mobile_responsive_css .= '#kinfw-title-wrap  > * {'. $page_title_typo_css['sm_css'] .'}'.ONNAT_CONST_THEME_NEW_LINE;
                        }

                }

                /**
                 * Breadcrumb Block
                 */
                if( $settings['breadcrumb_block' ] ) {

                    $breadcrumb_block_typo_css    = '';
                    $breadcrumb_block_typo_md_css = '';
                    $breadcrumb_block_typo_sm_css = '';

                    $typo = kinfw_onnat_theme_options()->kinfw_get_option( 'breadcrumb_typo_size' );
                    $size = isset( $typo['size'] ) ? $typo['size'] : [];

                    $breadcrumb_block_typo_css .= ( !empty( $size['lg_font_size'] ) ) ? "font-size:{$size['lg_font_size']}px;" : "";
                    $breadcrumb_block_typo_css .= ( !empty( $size['lg_line_height'] ) ) ? "line-height:{$size['lg_line_height']}px;" : "";
                    $breadcrumb_block_typo_css .= ( !empty( $size['lg_letter_space'] ) ) ? "letter-spacing:{$size['lg_letter_space']}px;" : "";

                    $breadcrumb_block_typo_md_css .= ( !empty( $size['md_font_size'] ) ) ? "font-size:{$size['md_font_size']}px;" : "";
                    $breadcrumb_block_typo_md_css .= ( !empty( $size['md_line_height'] ) ) ? "line-height:{$size['md_line_height']}px;" : "";
                    $breadcrumb_block_typo_md_css .= ( !empty( $size['md_letter_space'] ) ) ? "letter-spacing:{$size['md_letter_space']}px;" : "";

                    $breadcrumb_block_typo_sm_css .= ( !empty( $size['sm_font_size'] ) ) ? "font-size:{$size['sm_font_size']}px;" : "";
                    $breadcrumb_block_typo_sm_css .= ( !empty( $size['sm_line_height'] ) ) ? "line-height:{$size['sm_line_height']}px;" : "";
                    $breadcrumb_block_typo_sm_css .= ( !empty( $size['sm_letter_space'] ) ) ? "letter-spacing:{$size['sm_letter_space']}px;" : "";

                    $breadcrumb_link_colors = kinfw_onnat_theme_options()->kinfw_get_option( 'breadcrumb_link_color' );
                    if( !empty( $breadcrumb_link_colors ) ){

                        if( !empty( $breadcrumb_link_colors['color'] ) ) {
                            $css .= '#kinfw-title-holder #kinfw-breadcrumb-wrap a,#kinfw-title-holder #kinfw-breadcrumb-wrap .kinfw-breadcrumbs-separator { color: '.$breadcrumb_link_colors['color'].'}'.ONNAT_CONST_THEME_NEW_LINE;
                        }
                        if( !empty( $breadcrumb_link_colors['hover'] ) ) {
                            $css .= '#kinfw-title-holder #kinfw-breadcrumb-wrap a:hover {color:'.$breadcrumb_link_colors['hover'].'}'.ONNAT_CONST_THEME_NEW_LINE;
                        }
                    }

                    /**
                     * CSS
                     */
                    if( !empty( $breadcrumb_block_typo_css ) ) {

                        $css .= '#kinfw-title-holder #kinfw-breadcrumb-wrap {'.$breadcrumb_block_typo_css.'}'.ONNAT_CONST_THEME_NEW_LINE;
                    }

                    if( !empty( $breadcrumb_block_typo_md_css ) ) {

                        $this->tablet_responsive_css .= '#kinfw-title-holder #kinfw-breadcrumb-wrap {'.$breadcrumb_block_typo_md_css.'}'.ONNAT_CONST_THEME_NEW_LINE;
                    }

                    if( !empty( $breadcrumb_block_typo_sm_css ) ) {

                        $this->mobile_responsive_css .= '#kinfw-title-holder #kinfw-breadcrumb-wrap {'.$breadcrumb_block_typo_sm_css.'}'.ONNAT_CONST_THEME_NEW_LINE;
                    }



                }

                if( !empty( $css ) ) {

                    wp_add_inline_style( 'kinfw-onnat-admin', $css );

                }

            }

        }

        /**
         * Footer
         */
        public function enqueue_footer_style() {

            $inline_css = [];
            $settings   = kinfw_onnat_theme_footer()->get_settings();
			extract( $settings );


			if( isset( $footer_id ) && isset( $footer_type ) ) {

                if( 'elementor' === $footer_type ) {

                    $check_elementor = kinfw_is_elementor_callable();

                    if( $check_elementor ) {

                        if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
                            $css_file = new \Elementor\Core\Files\CSS\Post( $footer_id );
                            $css_file->enqueue();
                        }
                    }
                } else {

					switch( $footer_id ) {
						case 'default':
                        case 'standard_footer':
                            $inline_css = kinfw_onnat_theme_footer()->standard_footer_inline_css();
                        break;

                        case 'footer_preset_two':
                            $inline_css = kinfw_onnat_theme_footer()->footer_preset_two_inline_css();
                        break;
                    }

                    if( !empty( $inline_css['css'] ) ) {

                        wp_add_inline_style( 'kinfw-onnat-admin', $inline_css['css'] );

                        $this->tablet_responsive_css .= $inline_css['tablet'];
                        $this->mobile_responsive_css .= $inline_css['mobile'];
                    }

                }
            }

        }

        /**
         * Tablet CSS
         */
        public function tablet_responsive_css() {

            $css = $this->tablet_responsive_css;

            if( !empty( $css ) ) {

                $css = '@media only screen and (max-width: 992px) {'. ONNAT_CONST_THEME_NEW_LINE . $css . ONNAT_CONST_THEME_NEW_LINE .'}';
                wp_add_inline_style( 'kinfw-onnat-admin', $css );
            }
        }

        /**
         * Mobile CSS
         */
        public function mobile_responsive_css() {

            $css = $this->mobile_responsive_css;

            if( !empty( $css ) ) {

                $css = '@media only screen and (max-width: 768px) {'. ONNAT_CONST_THEME_NEW_LINE . $css . ONNAT_CONST_THEME_NEW_LINE .'}';
                wp_add_inline_style( 'kinfw-onnat-admin', $css );
            }
        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_styles_options' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_styles_options() {

        return Onnat_Theme_Styles_Options::get_instance();
    }
}

kinfw_onnat_theme_styles_options();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */