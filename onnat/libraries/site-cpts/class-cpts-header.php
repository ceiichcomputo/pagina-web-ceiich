<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( ! class_exists( 'Onnat_Theme_Our_CPT_Header' ) ) {

    /**
     * The Onnat Our CPT Header compatibility class.
     */
    class Onnat_Theme_Our_CPT_Header {

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

            add_filter( 'kinfw-filter/theme/header/settings', [ $this, 'page_header_settings' ] );
            add_filter( 'kinfw-filter/theme/breadcrumbs', [ $this, 'breadcrumbs' ],10, 5 );

            add_filter( 'kinfw-filter/theme/page-title/settings', [ $this, 'page_title_settings' ] );

            do_action( 'kinfw-action/theme/our/cpt/header/compatibility/loaded' );
        }

        /**
         * Handles header settings for our own custom post type single.
         */
        public function page_header_settings( $settings ) {

            $post_types = apply_filters( 'kinfw-filter/theme/metabox/template/post-type', [] );

            if( !empty( $post_types ) && is_singular( $post_types ) ) {

                $settings = [
                    'header_id'   => kinfw_onnat_theme_options()->kinfw_get_option( 'default_footer' ),
                    'header_type' => 'header'
                ];

                if( 'elementor_header' === $settings['header_id'] ) {
                    $settings['header_id']   = kinfw_onnat_theme_options()->kinfw_get_option( 'elementor_header' );
                    $settings['header_type'] = 'elementor';
                }

                $meta     = get_post_meta( get_the_ID(), '_kinfw_cpt_options', true );
				$settings = $this->get_header( $meta, $settings );

                return $settings;
            }

            return $settings;
        }

        /**
         * Custom Post Type : Header
         */
		public function get_header( $meta = '', $settings = [] ) {

			if( isset( $meta['header'] ) ) {
				if( 'no_header' === $meta['header']) {
					$settings = [
						'header_id'   => '',
						'header_type' => 'header'
					];
				} else if( 'elementor_header' === $meta['header'] ) {
					$settings = [
						'header_id'   => $meta['elementor_header'],
						'header_type' => 'elementor'
					];
				} else if( 'theme_header' === $meta['header'] ) {
					$header_id   = kinfw_onnat_theme_options()->kinfw_get_option( 'default_header' );
					$header_type = 'header';

					if( 'elementor_header' === $header_id ) {
						$header_type = 'elementor';
						$header_id   = kinfw_onnat_theme_options()->kinfw_get_option( 'elementor_header' );
					}

					$settings = [
						'header_id'   => $header_id,
						'header_type' => $header_type
					];
				} else if( 'custom_header' === $meta['header'] ) {
					$settings = [
						'header_id'   => $meta['custom_header'],
						'header_type' => 'header'
					];
				}
			}

			return $settings;

		}

        /**
         * Custom Post Type : Breadcrumb
         */
        public function breadcrumbs( $breadcrumbs, $labels, $link, $separator, $current_item ) {

            if( is_singular( 'kinfw-service' ) ) {
                global $post;

                $breadcrumbs .= get_the_term_list( $post->ID, 'kinfw-service-group', '', $separator, $separator );
                $breadcrumbs .= sprintf( $current_item, get_the_title() );
            } elseif( is_singular( 'kinfw-team-member' ) ) {
                global $post;

                $breadcrumbs .= get_the_term_list( $post->ID, 'kinfw-team-group', '', $separator, $separator );
                $breadcrumbs .= sprintf( $current_item, get_the_title() );

            } elseif( is_singular( 'kinfw-project' ) ) {
                global $post;

                $breadcrumbs .= get_the_term_list( $post->ID, 'kinfw-project-category', '', $separator, $separator );
                $breadcrumbs .= sprintf( $current_item, get_the_title() );                

            } elseif( is_post_type_archive( 'kinfw-team-member' ) || is_tax('kinfw-team-group') ) {

                $term = get_term_by( 'slug', get_query_var('kinfw-team-group'), get_query_var('taxonomy') );
                $breadcrumbs .= sprintf( $current_item, $term->name );

            } elseif( is_post_type_archive( 'kinfw-service' ) || is_tax('kinfw-service-group') ) {

                $term = get_term_by( 'slug', get_query_var('kinfw-service-group'), get_query_var('taxonomy') );
                $breadcrumbs .= sprintf( $current_item, $term->name );

            } elseif( is_post_type_archive( 'kinfw-project' ) || is_tax('kinfw-project-category') ) {

                $term = get_term_by( 'slug', get_query_var('kinfw-project-category'), get_query_var('taxonomy') );
                $breadcrumbs .= sprintf( $current_item, $term->name );

            }

            return $breadcrumbs;
        }

        /**
         * Custom Post Type : Page Title
         */
        public function page_title_settings( $settings ) {

			$title_tag        = kinfw_onnat_theme_options()->kinfw_get_option( 'page_title_tag' );
			$title_block      = kinfw_onnat_theme_options()->kinfw_get_option( 'page_title' );
			$breadcrumb_block = kinfw_onnat_theme_options()->kinfw_get_option( 'breadcrumb' );

            $use_full_width = kinfw_onnat_theme_options()->kinfw_get_option( 'use_page_title_full_width' );
            $use_bg         = kinfw_onnat_theme_options()->kinfw_get_option( 'use_page_title_background' );

            $theme_option_page_title_align = kinfw_onnat_theme_options()->kinfw_get_option( 'page_title_alignment');
            $theme_option_breadcrumb_align = kinfw_onnat_theme_options()->kinfw_get_option( 'breadcrumb_alignment');

            $classes        = [
                $use_bg ? 'kinfw-page-title-has-background' : '',
                $theme_option_page_title_align,
                $theme_option_breadcrumb_align
            ];

            $bg_css     = [];
            $bg_overlay = '';

            if( $use_bg ) {
                $bg_css = kinfw_onnat_theme_options()->kinfw_get_option( 'page_title_background' );
                $bg_overlay = kinfw_onnat_theme_options()->kinfw_get_option( 'page_title_overlay' );
            }

            $post_types = apply_filters( 'kinfw-filter/theme/metabox/template/post-type', [] );
            if( !empty( $post_types ) && is_singular( $post_types ) ) {

                $meta = get_post_meta( get_the_ID(), '_kinfw_cpt_options', true );

                /**
                 * Page Title
                 */
                if( isset( $meta['post_title'] ) ) {

                    if( 'theme_post_title' == $meta[ 'post_title' ] ) {
                    } elseif( 'custom_post_title' == $meta[ 'post_title' ] ) {
                        $title_block = true;

                        # Alignment
                            $index = array_search( $theme_option_page_title_align, $classes );
                            if( $index !== false ) {
                                unset( $classes[ $index ] );
                            }
                            array_push( $classes, $meta['post_title_alignment'] );

                        # Background
                            if ( isset( $meta['use_post_title_background' ] ) && $meta['use_post_title_background'] ) {
                                array_push( $classes, 'kinfw-page-title-has-background' );

                                $bg_css = isset( $meta['post_title_background'] ) ? $meta['post_title_background'] : [];
                            } else {
                                $index  = array_search( 'kinfw-page-title-has-background', $classes );
                                if( $index !== false ) {
                                    unset( $classes[ $index ] );
                                }
                            }

                        # Overlay
                            if(
                                isset( $meta['use_post_title_background' ] ) &&
                                $meta['use_post_title_background'] &&
                                isset( $meta['post_title_overlay'] ) &&
                                $meta['post_title_overlay']
                            ) {
                                $bg_overlay = $meta['post_title_overlay'];
                            } else {
                                $bg_overlay = '';
                            }

                        # Full Width
                            if( isset($meta['use_post_title_full_width']) && $meta['use_post_title_full_width'] ) {
                                $use_full_width = true;
                            } else {
                                $use_full_width = false;
                            }

                    } elseif( 'no_post_title' == $meta[ 'post_title' ] ) {
                        $title_block = false;

                        $index = array_search( $theme_option_page_title_align, $classes );
                        if( $index !== false ){
                            unset( $classes[ $index ] );
                        }
                    }

                }

                /**
                 * Breadcrumb
                 */
                if( isset( $meta['breadcrumb'] ) ) {

                    if( 'theme_breadcrumb' == $meta[ 'breadcrumb' ] ) {
                    } elseif( 'custom_breadcrumb' == $meta[ 'breadcrumb' ] ) {
                        $breadcrumb_block = true;

                        $index = array_search( $theme_option_breadcrumb_align, $classes );
                        if( $index !== false ){
                            unset( $classes[ $index ] );
                        }

                        array_push( $classes, $meta['breadcrumb_alignment'] );

                    } elseif( 'no_breadcrumb' == $meta[ 'breadcrumb' ] ) {
                        $breadcrumb_block = false;

                        $index = array_search( $theme_option_breadcrumb_align, $classes );
                        if( $index !== false ){
                            unset( $classes[ $index ] );
                        }
                    }

                }

                $background_css = kinfw_bg_opt_css( $bg_css );

                $css = '';
                if( !empty( $background_css ) ) {

                    $css .=  '#kinfw-title-holder.kinfw-page-title-has-background { '. $background_css .' }';
                }

                if( !empty( $bg_overlay ) ) {

                    $css .=  '#kinfw-title-holder:before { background-color'. $bg_overlay .' }';
                }

                $settings[ 'title_tag' ]        = $title_tag;
                $settings[ 'title_block' ]      = $title_block;
                $settings[ 'breadcrumb_block' ] = $breadcrumb_block;

                $settings[ 'classes' ]        = array_unique( $classes );
                $settings[ 'use_full_width']  = $use_full_width ? true : false;
                $settings[ 'css' ]            = !empty( $css ) ? $css : '';

                return $settings;
            }

            return $settings;

        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_our_cpt_header' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_our_cpt_header() {

        return Onnat_Theme_Our_CPT_Header::get_instance();
    }

}

kinfw_onnat_theme_our_cpt_header();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */