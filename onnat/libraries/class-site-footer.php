<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Footer' ) ) {

	/**
	 * The Onnat Theme footer hooks setup class.
	 */
    class Onnat_Theme_Footer {

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

            add_action( 'kinfw-action/theme/template/footer', [ $this, 'footer' ] );

            do_action( 'kinfw-action/theme/footer/loaded' );

        }

		public function footer() {

            if( is_singular('elementor_library') ) {
                return;
            }

			$settings = $this->get_settings();
			extract( $settings );

			$footer = 'footer-templates/standard-footer';

			if( !empty( $footer_id ) ) {

				if( 'footer' === $footer_type ) {

					switch( $footer_id ) {

						case 'default':
						case 'standard_footer':
							$footer = 'footer-templates/standard-footer';
						break;

						case 'footer_preset_two':
							$footer = 'footer-templates/footer-preset-two';
						break;

					}

				} elseif( 'elementor' === $footer_type ) {

					$footer = 'footer-templates/elementor-footer';
				}

			}

			$footer = apply_filters( 'kinfw-filter/theme/footer-template-part', $footer );

			if( !empty( $footer ) ) {
				get_template_part( $footer, '', $settings );
			}
		}

        public function get_settings() {

			$settings = [
				'footer_id'   => kinfw_onnat_theme_options()->kinfw_get_option( 'default_footer' ),
				'footer_type' => 'footer'
			];

			if( 'elementor_footer' === $settings['footer_id'] ) {
				$settings['footer_id']   = kinfw_onnat_theme_options()->kinfw_get_option( 'elementor_footer' );
				$settings['footer_type'] = 'elementor';
			}

			# 1. Front page = Latest posts
            if ( is_front_page() && !is_singular('page') ) {

			# 2. Posts Page
			} elseif ( is_home() && ! is_singular( 'page' ) ) {
				$post_id  = get_option( 'page_for_posts', true );
				$meta     = get_post_meta( $post_id, ONNAT_CONST_THEME_PAGE_SETTINGS, true );
				$settings = $this->get_footer( $meta, $settings );
			# 3. Search || Archive || 404
			} elseif ( is_search() || is_archive() || is_404() ) {
			# 4. Post
			} elseif( is_singular('post') ) {
				$meta     = get_post_meta( get_the_ID(), ONNAT_CONST_THEME_POST_SETTINGS, true );
				$settings = $this->get_footer( $meta, $settings );

			# 5. Page
			} elseif( is_singular('page') ) {
				$meta     = get_post_meta( get_the_ID(), ONNAT_CONST_THEME_PAGE_SETTINGS, true );
				$settings = $this->get_footer( $meta, $settings );
			}

			$settings = apply_filters( 'kinfw-filter/theme/footer/settings', $settings );

			return $settings;
        }

		public function get_footer( $meta = '', $settings = [] ) {

			if( isset( $meta['footer'] ) ) {
				if( 'no_footer' === $meta['footer']) {
					$settings = [
						'footer_id'   => '',
						'footer_type' => 'footer'
					];
				} else if( 'elementor_footer' === $meta['footer'] ) {
					$settings = [
						'footer_id'   => $meta['elementor_footer'],
						'footer_type' => 'elementor'
					];
				} else if( 'theme_footer' === $meta['footer'] ) {
					$footer_id   = kinfw_onnat_theme_options()->kinfw_get_option( 'default_footer' );
					$footer_type = 'footer';

					if( 'elementor_footer' === $footer_id ) {
						$footer_type = 'elementor';
						$footer_id   = kinfw_onnat_theme_options()->kinfw_get_option( 'elementor_footer' );
					}

					$settings = [
						'footer_id'   => $footer_id,
						'footer_type' => $footer_type
					];
				} else if( 'custom_footer' === $meta['footer'] ) {
					$settings = [
						'footer_id'   => $meta['custom_footer'],
						'footer_type' => 'footer'
					];
				}
			}

			return $settings;
		}

		/**
		 * Standard Footer inline css.
		 * Generated based on admin panel options.
		 */
		public function standard_footer_inline_css() {
            $css                   = '';
            $tablet_responsive_css = '';
            $mobile_responsive_css = '';

            /**
             * Background
             */
				$use_bg = kinfw_onnat_theme_options()->kinfw_get_option( 'use_standard_footer_background' );
				if( $use_bg ) {

					$bg_css = kinfw_bg_opt_css( kinfw_onnat_theme_options()->kinfw_get_option( 'standard_footer_background' ) );

					if( !empty( $bg_css ) ) {

						$css .= '#kinfw-footer-widgets.kinfw-footer-has-background {'.$bg_css.'}'.ONNAT_CONST_THEME_NEW_LINE;
					}
				}

            /**
             * Padding
             */
				$padding    = kinfw_onnat_theme_options()->kinfw_get_option( 'standard_footer_padding' );
				$lg_padding = isset( $padding['lg_padding'] ) ? $padding['lg_padding'] : [];
				$md_padding = isset( $padding['md_padding'] ) ? $padding['md_padding'] : [];
				$sm_padding = isset( $padding['sm_padding'] ) ? $padding['sm_padding'] : [];

				$padding_css    = kinfw_padding_opt_css(  $lg_padding );
				$padding_md_css = kinfw_padding_opt_css( $md_padding );
				$padding_sm_css = kinfw_padding_opt_css( $sm_padding );

				if( !empty( $padding_css ) ) {
					$css .= '#kinfw-footer-widgets {'.$padding_css.'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

				if( !empty( $padding_md_css ) ) {
					$tablet_responsive_css .= '#kinfw-footer-widgets {'.$padding_md_css.'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

				if( !empty( $padding_sm_css ) ) {
					$mobile_responsive_css .= '#kinfw-footer-widgets {'.$padding_sm_css.'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

            /**
             * Title Typography
             */
				$title_typo = kinfw_onnat_theme_options()->kinfw_get_option( 'standard_footer_section_title_typo' );

                if( isset( $title_typo['color'] ) ) {
                    $css .= '#kinfw-footer-widgets .kinfw-widget-title:before {background:'.$title_typo['color'].'}'.ONNAT_CONST_THEME_NEW_LINE;
                }

				$title_typo_size = kinfw_onnat_theme_options()->kinfw_get_option( 'standard_footer_section_title_typo_size' );
				$size            = isset( $title_typo_size['size'] ) ? $title_typo_size['size'] : [];
				$title_typo_css  = kinfw_typo_opt_css( $size );

				if( isset( $title_typo_css['css'] ) ) {
					$css .= '#kinfw-footer-widgets .widget .kinfw-widget-title {'.$title_typo_css['css'].'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

				if( isset( $title_typo_css['md_css'] ) ) {
					$tablet_responsive_css .= '#kinfw-footer-widgets .widget .kinfw-widget-title {'.$title_typo_css['md_css'].'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

				if( isset( $title_typo_css['sm_css'] ) ) {
					$mobile_responsive_css .= '#kinfw-footer-widgets .widget .kinfw-widget-title {'.$title_typo_css['sm_css'].'}'.ONNAT_CONST_THEME_NEW_LINE;
				}


            /**
             * Content Typography
             */
				$content_typo = kinfw_onnat_theme_options()->kinfw_get_option( 'standard_footer_section_content_typo_opt' );
				$size         = isset( $content_typo['size'] ) ? $content_typo['size'] : [];
				$color        = isset( $content_typo['link_color'] ) ? $content_typo['link_color'] : [];

				if( !empty( $color['color'] ) ) {
					$css .= '#kinfw-footer-widgets .kinfw-widget-content a { color:'.$color['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
				}

				if( !empty( $color['hover'] ) ) {
					$css .= '#kinfw-footer-widgets .kinfw-widget-content a:hover { color:'.$color['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;
				}

				$content_typo_css = kinfw_typo_opt_css( $size );

				if( isset( $content_typo_css['css'] ) ) {
					$css .= '#kinfw-footer-widgets .kinfw-widget-content, #kinfw-footer-widgets .kinfw-widget-content a {'.$content_typo_css['css'].'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

				if( isset( $content_typo_css['md_css'] ) ) {
					$tablet_responsive_css .= '#kinfw-footer-widgets .kinfw-widget-content, #kinfw-footer-widgets .kinfw-widget-content a {'.$content_typo_css['md_css'].'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

				if( isset( $content_typo_css['sm_css'] ) ) {
					$mobile_responsive_css .= '#kinfw-footer-widgets .kinfw-widget-content, #kinfw-footer-widgets .kinfw-widget-content a {'.$content_typo_css['sm_css'].'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

            /**
             * Bottom Block
             */
				/**
				 * Background
				 */
					$use_bg = kinfw_onnat_theme_options()->kinfw_get_option( 'use_standard_footer_bottom_background' );
					if( $use_bg ) {

						$bg_css = kinfw_bg_opt_css( kinfw_onnat_theme_options()->kinfw_get_option( 'standard_footer_bottom_background' ) );

						if( !empty( $bg_css ) ) {

							$css .= '#kinfw-footer-socket.kinfw-footer-socket-has-background {'.$bg_css.'}'.ONNAT_CONST_THEME_NEW_LINE;
						}
					}

				/**
				 * Padding
				 */
					$padding    = kinfw_onnat_theme_options()->kinfw_get_option( 'standard_footer_bottom_padding' );
					$lg_padding = isset( $padding['lg_padding'] ) ? $padding['lg_padding'] : [];
					$md_padding = isset( $padding['md_padding'] ) ? $padding['md_padding'] : [];
					$sm_padding = isset( $padding['sm_padding'] ) ? $padding['sm_padding'] : [];

					$padding_css    = kinfw_padding_opt_css(  $lg_padding );
					$padding_md_css = kinfw_padding_opt_css( $md_padding );
					$padding_sm_css = kinfw_padding_opt_css( $sm_padding );

					if( !empty( $padding_css ) ) {
						$css .= '#kinfw-footer-socket {'.$padding_css.'}'.ONNAT_CONST_THEME_NEW_LINE;
					}

					if( !empty( $padding_md_css ) ) {
						$tablet_responsive_css .= '#kinfw-footer-socket {'.$padding_md_css.'}'.ONNAT_CONST_THEME_NEW_LINE;
					}

					if( !empty( $padding_sm_css ) ) {
						$mobile_responsive_css .= '#kinfw-footer-socket {'.$padding_sm_css.'}'.ONNAT_CONST_THEME_NEW_LINE;
					}

                /**
                 * Copyright
                 */
					$copyright_typo = kinfw_onnat_theme_options()->kinfw_get_option( 'standard_footer_copyright_typo_opt' );
					$size           = isset( $copyright_typo['size'] ) ? $copyright_typo['size'] : [];
					$color          = isset( $copyright_typo['link_color'] ) ? $copyright_typo['link_color'] : [];

					if( !empty( $color['color'] ) ) {
						$css .= '#kinfw-copyright a { color:'.$color['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
					}

					if( !empty( $color['hover'] ) ) {
						$css .= '#kinfw-copyright a:hover { color:'.$color['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;
					}

					$copyright_typo_css = kinfw_typo_opt_css( $size );

					if( isset( $copyright_typo_css['css'] ) ) {
						$css .= '#kinfw-copyright {'.$copyright_typo_css['css'].'}'.ONNAT_CONST_THEME_NEW_LINE;
					}

					if( isset( $copyright_typo_css['md_css'] ) ) {
						$tablet_responsive_css .= '#kinfw-copyright {'.$copyright_typo_css['md_css'].'}'.ONNAT_CONST_THEME_NEW_LINE;
					}

					if( isset( $copyright_typo_css['sm_css'] ) ) {
						$mobile_responsive_css .= '#kinfw-copyright {'.$copyright_typo_css['sm_css'].'}'.ONNAT_CONST_THEME_NEW_LINE;
					}

			/**
			 * Menu
			 */
				$menu_typo = kinfw_onnat_theme_options()->kinfw_get_option( 'standard_footer_bottom_block_menu_typo_opt' );
				$size      = isset( $menu_typo['size'] ) ? $menu_typo['size'] : [];
				$color     = isset( $menu_typo['link_color'] ) ? $menu_typo['link_color'] : [];

				if( !empty( $color['color'] ) ) {
					$css .= '#kinfw-footer-socket #kinfw-footer-menu ul li a { color:'.$color['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
				}

				if( !empty( $color['hover'] ) ) {
					$css .= '#kinfw-footer-socket #kinfw-footer-menu ul li a:hover { color:'.$color['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;
				}

				$menu_typo_css = kinfw_typo_opt_css( $size );

				if( isset( $menu_typo_css['css'] ) ) {
					$css .= '#kinfw-footer-socket #kinfw-footer-menu {'.$menu_typo_css['css'].'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

				if( isset( $menu_typo_css['md_css'] ) ) {
					$tablet_responsive_css .= '#kinfw-footer-menu {'.$menu_typo_css['md_css'].'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

				if( isset( $menu_typo_css['sm_css'] ) ) {
					$mobile_responsive_css .= '#kinfw-footer-menu {'.$menu_typo_css['sm_css'].'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

			return [
				'css'    => $css,
				'tablet' => $tablet_responsive_css,
				'mobile' => $mobile_responsive_css,
			];
		}

		/**
		 * Footer Preset 2 inline css.
		 * Generated based on admin panel options.
		 */
		public function footer_preset_two_inline_css() {

            $css                   = '';
            $tablet_responsive_css = '';
            $mobile_responsive_css = '';

            /**
             * Background
             */
				$use_bg = kinfw_onnat_theme_options()->kinfw_get_option( 'use_footer_2_background' );
				if( $use_bg ) {

					$bg_css = kinfw_bg_opt_css( kinfw_onnat_theme_options()->kinfw_get_option( 'footer_2_background' ) );

					if( !empty( $bg_css ) ) {

						$css .= '#kinfw-footer-widgets.kinfw-footer-has-background {'.$bg_css.'}'.ONNAT_CONST_THEME_NEW_LINE;
					}
				}

            /**
             * Padding
             */
				$padding    = kinfw_onnat_theme_options()->kinfw_get_option( 'footer_2_padding' );
				$lg_padding = isset( $padding['lg_padding'] ) ? $padding['lg_padding'] : [];
				$md_padding = isset( $padding['md_padding'] ) ? $padding['md_padding'] : [];
				$sm_padding = isset( $padding['sm_padding'] ) ? $padding['sm_padding'] : [];

				$padding_css    = kinfw_padding_opt_css( $lg_padding );
				$padding_md_css = kinfw_padding_opt_css( $md_padding );
				$padding_sm_css = kinfw_padding_opt_css( $sm_padding );

				if( !empty( $padding_css ) ) {
					$css .= '#kinfw-footer-widgets {'.$padding_css.'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

				if( !empty( $padding_md_css ) ) {
					$tablet_responsive_css .= '#kinfw-footer-widgets {'.$padding_md_css.'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

				if( !empty( $padding_sm_css ) ) {
					$mobile_responsive_css .= '#kinfw-footer-widgets {'.$padding_sm_css.'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

            /**
             * Title Typography
             */
				$title_typo = kinfw_onnat_theme_options()->kinfw_get_option( 'footer_2_title_typo_size' );
				$size       = isset( $title_typo['size'] ) ? $title_typo['size'] : [];

				$title_typo_css = kinfw_typo_opt_css( $size );

				if( isset( $title_typo_css['css'] ) ) {
					$css .= '#kinfw-footer-widgets .widget .kinfw-widget-title {'.$title_typo_css['css'].'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

				if( isset( $title_typo_css['md_css'] ) ) {
					$tablet_responsive_css .= '#kinfw-footer-widgets .widget .kinfw-widget-title {'.$title_typo_css['md_css'].'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

				if( isset( $title_typo_css['sm_css'] ) ) {
					$mobile_responsive_css .= '#kinfw-footer-widgets .widget .kinfw-widget-title {'.$title_typo_css['sm_css'].'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

            /**
             * Content Typography
             */
				$content_typo = kinfw_onnat_theme_options()->kinfw_get_option( 'footer_2_content_typo_opt' );
				$size         = isset( $content_typo['size'] ) ? $content_typo['size'] : [];
				$color        = isset( $content_typo['link_color'] ) ? $content_typo['link_color'] : [];

				if( !empty( $color['color'] ) ) {
					$css .= '#kinfw-footer-widgets .kinfw-widget-content a { color:'.$color['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
				}

				if( !empty( $color['hover'] ) ) {
					$css .= '#kinfw-footer-widgets .kinfw-widget-content a:hover { color:'.$color['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;
				}

				$content_typo_css = kinfw_typo_opt_css( $size );
				if( isset( $content_typo_css['css'] ) ) {
					$css .= '#kinfw-footer-widgets .kinfw-widget-content, #kinfw-footer-widgets .kinfw-widget-content ul li a {'.$content_typo_css['css'].'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

				if( isset( $content_typo_css['md_css'] ) ) {
					$tablet_responsive_css .= '#kinfw-footer-widgets .kinfw-widget-content, #kinfw-footer-widgets .kinfw-widget-content ul li a {'.$content_typo_css['md_css'].'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

				if( isset( $content_typo_css['sm_css'] ) ) {
					$mobile_responsive_css .= '#kinfw-footer-widgets .kinfw-widget-content, #kinfw-footer-widgets .kinfw-widget-content ul li a {'.$content_typo_css['sm_css'].'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

			/**
			 * Social Menu
			 */
				$social_menu_color = kinfw_onnat_theme_options()->kinfw_get_option( 'footer_2_social_menu_icon_color' );
				if( !empty( $social_menu_color ) ) {
					$css .= '.kinfw-footer-social .kinfw-social-links li a:before { color:'.$social_menu_color.';}'.ONNAT_CONST_THEME_NEW_LINE;
				}

			/**
			 * Bottom Block
			 */
				/**
				 * Background
				 */
				$use_bg = kinfw_onnat_theme_options()->kinfw_get_option( 'use_footer_2_bottom_background' );
				if( $use_bg ) {

					$bg_css = kinfw_bg_opt_css( kinfw_onnat_theme_options()->kinfw_get_option( 'footer_2_bottom_background' ) );

					if( !empty( $bg_css ) ) {

						$css .= '#kinfw-footer-socket.kinfw-footer-socket-has-background {'.$bg_css.'}'.ONNAT_CONST_THEME_NEW_LINE;
					}
				}


				/**
				 * Padding
				 */
				$padding    = kinfw_onnat_theme_options()->kinfw_get_option( 'footer_2_bottom_padding' );
				$lg_padding = isset( $padding['lg_padding'] ) ? $padding['lg_padding'] : [];
				$md_padding = isset( $padding['md_padding'] ) ? $padding['md_padding'] : [];
				$sm_padding = isset( $padding['sm_padding'] ) ? $padding['sm_padding'] : [];

				$padding_css    = kinfw_padding_opt_css( $lg_padding );
				$padding_md_css = kinfw_padding_opt_css( $md_padding );
				$padding_sm_css = kinfw_padding_opt_css( $sm_padding );

				if( !empty( $padding_css ) ) {
					$css .= '#kinfw-footer-socket {'.$padding_css.'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

				if( !empty( $padding_md_css ) ) {
					$tablet_responsive_css .= '#kinfw-footer-socket {'.$padding_md_css.'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

				if( !empty( $padding_sm_css ) ) {
					$mobile_responsive_css .= '#kinfw-footer-socket {'.$padding_sm_css.'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

                /**
                 * Copyright
                 */
					$copyright_typo = kinfw_onnat_theme_options()->kinfw_get_option( 'footer_2_copyright_typo_opt' );
					$size           = isset( $copyright_typo['size'] ) ? $copyright_typo['size'] : [];
					$color          = isset( $copyright_typo['link_color'] ) ? $copyright_typo['link_color'] : [];

					if( !empty( $color['color'] ) ) {
						$css .= '#kinfw-copyright a { color:'.$color['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
					}

					if( !empty( $color['hover'] ) ) {
						$css .= '#kinfw-copyright a:hover { color:'.$color['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;
					}

					$copyright_typo_css = kinfw_typo_opt_css( $size );

					if( isset( $copyright_typo_css['css'] ) ) {
						$css .= '#kinfw-copyright {'.$copyright_typo_css['css'].'}'.ONNAT_CONST_THEME_NEW_LINE;
					}

					if( isset( $copyright_typo_css['md_css'] ) ) {
						$tablet_responsive_css .= '#kinfw-copyright {'.$copyright_typo_css['md_css'].'}'.ONNAT_CONST_THEME_NEW_LINE;
					}

					if( isset( $copyright_typo_css['sm_css'] ) ) {
						$mobile_responsive_css .= '#kinfw-copyright {'.$copyright_typo_css['sm_css'].'}'.ONNAT_CONST_THEME_NEW_LINE;
					}

				/**
				 * Menu
				 */
					$menu_typo = kinfw_onnat_theme_options()->kinfw_get_option( 'footer_2_bottom_block_menu_typo_opt' );
					$size      = isset( $menu_typo['size'] ) ? $menu_typo['size'] : [];
					$color     = isset( $menu_typo['link_color'] ) ? $menu_typo['link_color'] : [];

					if( !empty( $color['color'] ) ) {
						$css .= '#kinfw-footer-socket #kinfw-footer-menu ul li a { color:'.$color['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
					}

					if( !empty( $color['hover'] ) ) {
						$css .= '#kinfw-footer-socket #kinfw-footer-menu ul li a:hover { color:'.$color['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;
					}

					$menu_typo_css = kinfw_typo_opt_css( $size );

					if( isset( $menu_typo_css['css'] ) ) {
						$css .= '#kinfw-footer-menu {'.$menu_typo_css['css'].'}'.ONNAT_CONST_THEME_NEW_LINE;
					}

					if( isset( $menu_typo_css['md_css'] ) ) {
						$tablet_responsive_css .= '#kinfw-footer-menu {'.$menu_typo_css['md_css'].'}'.ONNAT_CONST_THEME_NEW_LINE;
					}

					if( isset( $menu_typo_css['sm_css'] ) ) {
						$mobile_responsive_css .= '#kinfw-footer-menu {'.$menu_typo_css['sm_css'].'}'.ONNAT_CONST_THEME_NEW_LINE;
					}

			return [
				'css'    => $css,
				'tablet' => $tablet_responsive_css,
				'mobile' => $mobile_responsive_css,
			];

		}

    }
}

if( !function_exists( 'kinfw_onnat_theme_footer' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_footer() {

        return Onnat_Theme_Footer::get_instance();
    }
}

kinfw_onnat_theme_footer();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */