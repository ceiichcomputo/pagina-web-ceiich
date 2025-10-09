<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( ! class_exists( 'Onnat_Theme_Woo_Header' ) ) {

    /**
     * The Onnat woocommerce header class.
     */
    class Onnat_Theme_Woo_Header {

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


            add_filter( 'kinfw-filter/theme/page-title', [ $this, 'page_title' ] );
            add_filter( 'kinfw-filter/theme/breadcrumbs', [ $this, 'breadcrumbs' ],10, 5 );
            add_filter( 'kinfw-filter/theme/breadcrumbs/prefix', [ $this, 'prefix_breadcrumb' ], 10, 3  );

            add_filter( 'kinfw-filter/theme/page-title/settings', [ $this, 'page_title_settings' ] );

            do_action( 'kinfw-action/theme/woo/header/compatibility/loaded' );

        }

        /**
         * Handles header settings for shop and product single.
         */
        public function page_header_settings( $settings ) {
            if( is_shop() ) {
				$shop_id  = get_option( 'woocommerce_shop_page_id' );
				$meta     = get_post_meta( $shop_id, ONNAT_CONST_THEME_PAGE_SETTINGS, true );
				$settings = $this->get_header( $meta, $settings );

                return $settings;

            } else if( is_singular( 'product' ) ) {
				$meta     = get_post_meta( get_the_ID(), ONNAT_CONST_THEME_PRODUCT_SETTINGS, true );
				$settings = $this->get_header( $meta, $settings );

                return $settings;
            }

            return $settings;
        }

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

        public function page_title( $title ) {

            if( is_shop() ) {

                $shop_id = get_option( 'woocommerce_shop_page_id' );
                $title   = !empty( $shop_id ) ? get_the_title( $shop_id ) : esc_html__( 'Shop', 'onnat' );
            } elseif( is_product_category() ) {

                $taxonomy = get_term( get_queried_object_id(), 'product_cat' );
                if ( ! empty( $taxonomy ) ) {
                    $title = esc_html( $taxonomy->name );
                }
            } elseif( is_product_tag() ) {

                $taxonomy = get_term( get_queried_object_id(), 'product_tag' );
                if ( ! empty( $taxonomy ) ) {
                    $title = esc_html( $taxonomy->name );
                }
            }

            return $title;

        }

        public function breadcrumbs( $breadcrumbs, $labels, $link, $separator, $current_item ) {

            if( is_shop() ) {

                $shop_id = get_option( 'woocommerce_shop_page_id' );
                $title   = !empty( $shop_id ) ? get_the_title( $shop_id ) : esc_html__( 'Shop', 'onnat' );

                $breadcrumbs .= sprintf( $current_item, $title );

                if ( get_query_var( 'paged' ) ) {
                    $breadcrumbs .= sprintf( $current_item, sprintf( $labels['query_paged'], get_query_var( 'paged' ) ) );
                }
            } else if( is_singular( 'product' ) ) {

                $shop_id = get_option( 'woocommerce_shop_page_id' );

                if( !empty( $shop_id ) ) {

                    $breadcrumbs .= sprintf( $link, get_the_permalink( $shop_id ), get_the_title( $shop_id ) );
                    $breadcrumbs .= $separator;
                }

                $breadcrumbs .= sprintf( $current_item, get_the_title() );
            } elseif( is_product_category() ) {

                $shop_id = get_option( 'woocommerce_shop_page_id' );

                if( !empty( $shop_id ) ) {

                    $breadcrumbs .= sprintf( $link, get_the_permalink( $shop_id ), get_the_title( $shop_id ) );
                    $breadcrumbs .= $separator;
                }

                $taxonomy = get_term( get_queried_object_id(), 'product_cat' );
                if ( ! empty( $taxonomy ) ) {

                    $breadcrumbs .= sprintf( $current_item, esc_html( $taxonomy->name ) );
                }

                if ( get_query_var( 'paged' ) ) {
                    $breadcrumbs .= sprintf( $current_item, sprintf( $labels['query_paged'], get_query_var( 'paged' ) ) );
                }
            } elseif( is_product_tag() ) {

                $shop_id = get_option( 'woocommerce_shop_page_id' );

                if( !empty( $shop_id ) ) {

                    $breadcrumbs .= sprintf( $link, get_the_permalink( $shop_id ), get_the_title( $shop_id ) );
                    $breadcrumbs .= $separator;
                }

                $taxonomy = get_term( get_queried_object_id(), 'product_tag' );
                if ( ! empty( $taxonomy ) ) {

                    $breadcrumbs .= sprintf( $current_item, esc_html( $taxonomy->name ) );
                }

                if ( get_query_var( 'paged' ) ) {
                    $breadcrumbs .= sprintf( $current_item, sprintf( $labels['query_paged'], get_query_var( 'paged' ) ) );
                }
            }

            $endpoint       = is_wc_endpoint_url() ? WC()->query->get_current_endpoint() : '';
            $endpoint_title = $endpoint ? WC()->query->get_endpoint_title( $endpoint ) : '';

            if( !empty( $endpoint_title ) ) {
                $breadcrumbs .= sprintf( $current_item, ' ( '.$endpoint_title.' )' );
            }

            return $breadcrumbs;

        }

        public function prefix_breadcrumb( $prefix, $link, $separator ) {

            if( is_cart() || is_checkout() || is_account_page() ) {

                $shop_id = get_option( 'woocommerce_shop_page_id' );

                if( !empty( $shop_id ) ) {

                    $prefix .= sprintf( $link, get_the_permalink( $shop_id ), get_the_title( $shop_id ) );
                    $prefix .= $separator;
                }

            }

            return $prefix;

        }

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
                $bg_css     = kinfw_onnat_theme_options()->kinfw_get_option( 'page_title_background' );
                $bg_overlay = kinfw_onnat_theme_options()->kinfw_get_option( 'page_title_overlay' );
            }

            if( is_shop() ) {
				$shop_id = get_option( 'woocommerce_shop_page_id' );
				$meta    = get_post_meta( $shop_id, ONNAT_CONST_THEME_PAGE_SETTINGS, true );

                /**
                 * Page Title
                 */
                if( isset( $meta['page_title'] ) ) {

                    if( 'theme_page_title' == $meta[ 'page_title' ] ) {
                    } elseif( 'custom_page_title' == $meta[ 'page_title' ] ) {
                        $title_block = true;

                        # Alignment
                            $index = array_search( $theme_option_page_title_align, $classes );
                            if( $index !== false ) {
                                unset( $classes[ $index ] );
                            }
                            array_push( $classes, $meta['page_title_alignment'] );

                        # Background
                            if ( isset( $meta['use_page_title_background' ] ) && $meta['use_page_title_background'] ) {
                                array_push( $classes, 'kinfw-page-title-has-background' );

                                $bg_css = isset( $meta['page_title_background'] ) ? $meta['page_title_background'] : [];
                            } else {
                                $index  = array_search( 'kinfw-page-title-has-background', $classes );
                                if( $index !== false ) {
                                    unset( $classes[ $index ] );
                                }
                            }

                        # Overlay
                            if(
                                isset( $meta['use_page_title_background' ] ) &&
                                $meta['use_page_title_background'] &&
                                isset( $meta['page_title_overlay'] ) &&
                                $meta['page_title_overlay']
                            ) {
                                $bg_overlay = $meta['page_title_overlay'];
                            } else {
                                $bg_overlay = '';
                            }

                        # Full Width
                            if( isset($meta['use_page_title_full_width']) && $meta['use_page_title_full_width'] ) {
                                $use_full_width = true;
                            } else {
                                $use_full_width = false;
                            }

                    } elseif( 'no_page_title' == $meta[ 'page_title' ] ) {
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

            } else if( is_singular( 'product' ) ) {

                $meta = get_post_meta( get_the_ID(), ONNAT_CONST_THEME_PAGE_SETTINGS, true );

                /**
                 * Page Title
                 */
                if( isset( $meta['page_title'] ) ) {

                    if( 'theme_page_title' == $meta[ 'page_title' ] ) {
                    } elseif( 'custom_page_title' == $meta[ 'page_title' ] ) {
                        $title_block = true;

                        # Alignment
                            $index = array_search( $theme_option_page_title_align, $classes );
                            if( $index !== false ) {
                                unset( $classes[ $index ] );
                            }
                            array_push( $classes, $meta['page_title_alignment'] );

                        # Background
                            if ( isset( $meta['use_page_title_background' ] ) && $meta['use_page_title_background'] ) {
                                array_push( $classes, 'kinfw-page-title-has-background' );

                                $bg_css = isset( $meta['page_title_background'] ) ? $meta['page_title_background'] : [];
                            } else {
                                $index  = array_search( 'kinfw-page-title-has-background', $classes );
                                if( $index !== false ) {
                                    unset( $classes[ $index ] );
                                }
                            }

                        # Overlay
                            if(
                                isset( $meta['use_page_title_background' ] ) &&
                                $meta['use_page_title_background'] &&
                                isset( $meta['page_title_overlay'] ) &&
                                $meta['page_title_overlay']
                            ) {
                                $bg_overlay = $meta['page_title_overlay'];
                            } else {
                                $bg_overlay = '';
                            }

                        # Full Width
                            if( isset($meta['use_page_title_full_width']) && $meta['use_page_title_full_width'] ) {
                                $use_full_width = true;
                            } else {
                                $use_full_width = false;
                            }

                    } elseif( 'no_page_title' == $meta[ 'page_title' ] ) {
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

if( !function_exists( 'kinfw_onnat_theme_woo_header' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_woo_header() {

        return Onnat_Theme_Woo_Header::get_instance();
    }

}

kinfw_onnat_theme_woo_header();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */