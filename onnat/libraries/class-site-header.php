<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Header' ) ) {

	/**
	 * The Onnat Theme header hooks setup class.
	 */
    class Onnat_Theme_Header {

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

            add_action( 'kinfw-action/theme/template/header', [ $this, 'header' ] );

            do_action( 'kinfw-action/theme/header/loaded' );

        }

		public function header() {

            if( is_singular('elementor_library') ) {
                return;
            }

			$settings = $this->get_settings();
			extract( $settings );

			$header = 'header-templates/standard-header';

			if( !empty( $header_id ) ) {

				if( 'header' === $header_type ) {

					switch( $header_id ) {

						case 'default':
						case 'standard_header':
							$header = 'header-templates/standard-header';
						break;

						case 'transparent_header':
							$header = 'header-templates/transparent-header';
						break;

						case 'top_bar_standard_header':
							$header = 'header-templates/standard-header-with-top-bar';
						break;

						case 'top_bar_transparent_header':
							$header = 'header-templates/transparent-header-with-top-bar';
						break;

						case 'cascade_header':
							$header = 'header-templates/cascade-header';
						break;

					}

				} elseif( 'elementor' === $header_type ) {

					$header = 'header-templates/elementor-header';

				}

			}

			$header = apply_filters( 'kinfw-filter/theme/header-template-part', $header );

			if( !empty( $header ) ) {
				get_template_part( $header, '', $settings );
			}

		}

        public function get_settings() {

			$settings = [
				'header_id'   => kinfw_onnat_theme_options()->kinfw_get_option( 'default_header' ),
				'header_type' => 'header'
			];

			if( 'elementor_header' === $settings['header_id'] ) {
				$settings['header_id']   = kinfw_onnat_theme_options()->kinfw_get_option( 'elementor_header' );
				$settings['header_type'] = 'elementor';
			}

			# 1. Front page = Latest posts
            if ( is_front_page() && !is_singular('page') ) {

			# 2. Posts Page
			} elseif ( is_home() && ! is_singular( 'page' ) ) {
				$post_id  = get_option( 'page_for_posts', true );
				$meta     = get_post_meta( $post_id, ONNAT_CONST_THEME_PAGE_SETTINGS, true );
				$settings = $this->get_header( $meta, $settings );
			# 3. Search || Archive || 404
			} elseif ( is_search() || is_archive() || is_404() ) {
			# 4. Post
			} elseif( is_singular('post') ) {
				$meta     = get_post_meta( get_the_ID(), ONNAT_CONST_THEME_POST_SETTINGS, true );
				$settings = $this->get_header( $meta, $settings );

			# 5. Page
			} elseif( is_singular('page') ) {
				$meta     = get_post_meta( get_the_ID(), ONNAT_CONST_THEME_PAGE_SETTINGS, true );
				$settings = $this->get_header( $meta, $settings );
			}

			$settings = apply_filters( 'kinfw-filter/theme/header/settings', $settings );

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

		public function logo_block( $type = 'logo' ) {
			$return     = '';
			$logo_class = '';
			$logo       = [];

			if( 'logo' === $type ) {
				$logo       = kinfw_onnat_theme_options()->kinfw_get_option( 'logo' );
				$logo_class = 'logo-main';
			} else if( 'logo_alt' === $type ) {
				$logo       = kinfw_onnat_theme_options()->kinfw_get_option( 'logo_alt' );
				$logo_class = 'logo-main logo-alt';

			} else if( 'logo_mobile' === $type ) {
				$logo = kinfw_onnat_theme_options()->kinfw_get_option( 'logo_mobile' );
				$logo_class = 'logo-mobile';

			} else if( 'logo_sticky' === $type ) {
				$logo = kinfw_onnat_theme_options()->kinfw_get_option( 'logo_sticky' );
				$logo_class = 'logo-sticky';

			}

			if( is_array( $logo ) && isset( $logo['url'] ) ) {
				$img = sprintf( '
					<img src="%1$s" alt="%2$s" title="%3$s" class="%4$s">',
					esc_url( $logo['url'] ),
					esc_attr( $logo['alt'] ),
					esc_attr( $logo['title'] ),
					kinfw_is_svg( $logo['url'] ) ? 'kinfw-switch-svg' : '',
				);

				$return = sprintf( '<!-- .kinfw-logo -->
					<div class="kinfw-logo %1$s">
						<a href="%2$s"> %3$s </a>
					</div><!-- / .kinfw-logo -->',
					$logo_class,
					esc_url( home_url( '/' ) ),
					$img
				);
			}

			return $return;
		}

		public function menu_block( $menu_id = '', $device = 'lg' ) {

			$return     = '';
			$icon_close = kinfw_icon( 'math-cross' );

			if( empty( $menu_id ) ) {
				if( has_nav_menu('primary') ) {
					if( 'lg' === $device ) {
						$menu = wp_nav_menu([
							'theme_location'  => 'primary',
							'container'       => 'nav',
							'container_id'    => '',
							'container_class' => 'kinfw-main-nav',
							'fallback_cb'     => false,
							'echo'            => false,
							'items_wrap'      => '<ul>%3$s</ul>',
						]);

						$return = sprintf('<div class="kinfw-navigation-holder">%1$s</div>', $menu );
					} else if( 'mobile' === $device ) {
						$menu = wp_nav_menu([
							'theme_location'  => 'primary',
							'container'       => 'nav',
							'container_id'    => '',
							'container_class' => 'kinfw-mobile-menu-nav',
							'fallback_cb'     => false,
							'echo'            => false,
							'walker'          => new Onnat_Theme_Mobile_Nav_Menu_Walker,
							'items_wrap'      => '<ul class="kinfw-mobile-menu">
									<li class = "kinfw-mobile-menu-close">
										<a href="javascript:void(0);"> '. $icon_close .' </a>
									</li>
									%3$s
								</ul>
								<div class="kinfw-mobile-menu-overlay"></div>',
						]);

						$return = sprintf('<div class="kinfw-navigation-holder kinfw-mobile-navigation-holder">
							<div class="kinfw-mobile-navigation-trigger">
								%1$s
							</div>
							%2$s
							</div>',
							kinfw_icon( 'misc-bars' ),
							$menu
						);

					}
				} else {
					$args = [
						'echo'     => false,
						'title_li' => false,
						'walker'   => new Onnat_Theme_WP_List_Pages_Nav_Menu_Walker,
					];

					if( 'lg' === $device ) {
						$menu = wp_list_pages( $args );
						$return = sprintf('
							<div class="kinfw-navigation-holder">
								<nav class="kinfw-main-nav">
									<ul> %1$s </ul>
								</nav>
							</div>',
							$menu
						);
					} else if( 'mobile' === $device ) {
						$args['walker'] = new Onnat_Theme_WP_List_Pages_Nav_Menu_Mobile_Walker;

						$menu = wp_list_pages( $args );
						$return = sprintf('
							<div class="kinfw-navigation-holder kinfw-mobile-navigation-holder">
								<div class="kinfw-mobile-navigation-trigger">
									%1$s
								</div>
								<nav class="kinfw-mobile-menu-nav">
									<ul class="kinfw-mobile-menu">
										<li class="kinfw-mobile-menu-close">
											<a href="javascript:void(0);"> %2$s </a>
										</li>
										%3$s
									</ul>
									<div class="kinfw-mobile-menu-overlay"></div>
								</nav>
							</div>',
							kinfw_icon( 'misc-bars' ),
							kinfw_icon( 'math-cross' ),
							$menu
						);
					}
				}
			} else if( !empty( $menu_id ) ) {
				if( 'lg' === $device ) {
					$menu = wp_nav_menu([
						'menu'            => $menu_id,
						'container'       => 'nav',
						'container_id'    => '',
						'container_class' => 'kinfw-main-nav',
						'fallback_cb'     => false,
						'echo'            => false,
						'items_wrap'      => '<ul>%3$s</ul>',
					]);

					$return = sprintf('<div class="kinfw-navigation-holder">%1$s</div>', $menu );
				} else if( 'mobile' === $device ) {
					$menu = wp_nav_menu([
						'menu'            => $menu_id,
						'container'       => 'nav',
						'container_id'    => '',
						'container_class' => 'kinfw-mobile-menu-nav',
						'fallback_cb'     => false,
						'echo'            => false,
						'walker'          => new Onnat_Theme_Mobile_Nav_Menu_Walker,
						'items_wrap'      => '<ul class="kinfw-mobile-menu">
								<li class = "kinfw-mobile-menu-close">
									<a href="javascript:void(0);"> ' . $icon_close .' </a>
								</li>
								%3$s
							</ul>
							<div class="kinfw-mobile-menu-overlay"></div>',
					]);

					$return = sprintf('<div class="kinfw-navigation-holder kinfw-mobile-navigation-holder">
						<div class="kinfw-mobile-navigation-trigger">
							%1$s
						</div>
						%2$s
						</div>',
						kinfw_icon( 'misc-bars' ),
						$menu
					);

				}
			}

			return $return;
		}

		public function actions_block( $actions = [] ) {

			$return = '';

			if( is_array( $actions ) ) {

				$return .= '<div class="kinfw-header-group-action">';

					foreach( $actions as $action ) {

						switch( $action ) {
							case 'search':
								$return .= kinfw_action_search_trigger();
							break;

							case 'user_login':
								$return .= kinfw_action_user_login_trigger();
							break;

                            case 'hamburger-button':
                                $return .= kinfw_action_hamburger_trigger();
                            break;

							default:
								$return .= apply_filters( 'kinfw-filter/theme/header/action/buttons', '', $action );
							break;
						}
					}

				$return .= '</div>';

			}

			return $return;

		}

		public function actions_forms( $actions = [] ) {

			$return = '';

			if( !is_array( $actions )) {
				return;
			}

			foreach( $actions as $action ) {

				switch( $action ) {

					case 'search':
						if( function_exists('kinfw_action_search_form') ) {
							add_action( 'wp_footer', 'kinfw_action_search_form', -1 );
						}
					break;

					case 'user_login':
						if( function_exists('kinfw_action_user_login_form') ) {
							add_action( 'wp_footer', 'kinfw_action_user_login_form', -1 );
						}
					break;

					default:
						/**
						 * Add content to site.
						 */
						do_action( 'kinfw-action/theme/header/action/forms', $action );

						/**
						 * Filter the output.
						 */
						$return .= apply_filters( 'kinfw-filter/theme/header/action/forms', '', $action );
					break;

				}

			}

			return $return;

		}

        /**
         * Standard Header inline css
         */
        public function standard_header_inline_css() {

            $css                   = '';
            $tablet_responsive_css = '';
            $mobile_responsive_css = '';

			/**
			 * Header Wrapper
			 */
				$standard_header_style  = kinfw_onnat_theme_options()->kinfw_get_option( 'standard_header_style' );
				if( is_array( $standard_header_style ) ) {

					$standard_header_style = isset( $standard_header_style['style'] ) ? $standard_header_style['style'] : [];

					// Header
						if( isset( $standard_header_style['height'] ) && !empty( $standard_header_style['height'] ) ) {
							$css .= '.kinfw-std-header #kinfw-main-header { height:'.$standard_header_style['height'].'px;}'.ONNAT_CONST_THEME_NEW_LINE;
							$css .= '.kinfw-std-header #kinfw-main-header:before { height:'.$standard_header_style['height'].'px;}'.ONNAT_CONST_THEME_NEW_LINE;
						}

                        if( isset( $standard_header_style['bg_color'] ) && !empty( $standard_header_style['bg_color'] ) ) {
							$css .= '.kinfw-std-header #kinfw-main-header:before { background-color:'.$standard_header_style['bg_color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
                        }

						$main_menu_link_colors = isset( $standard_header_style['main_menu_link_color'] ) ? $standard_header_style['main_menu_link_color'] : [];
						if( !empty( $main_menu_link_colors['color'] ) ) {
							$css .= '.kinfw-std-header #kinfw-main-header .kinfw-main-nav > ul > li > a { color:'.$main_menu_link_colors['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $main_menu_link_colors['hover'] ) ) {
							$css .= '.kinfw-std-header #kinfw-main-header .kinfw-main-nav > ul > li > a:hover { color:'.$main_menu_link_colors['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $main_menu_link_colors['active'] ) ) {
							$css .= '.kinfw-std-header #kinfw-main-header .kinfw-main-nav > ul > li.current-menu-item > a, .kinfw-std-header #kinfw-main-header .kinfw-main-nav > ul > li.current-menu-parent > a, .kinfw-std-header #kinfw-main-header .kinfw-main-nav > ul > li.current-menu-ancestor > a { color:'.$main_menu_link_colors['active'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( isset( $standard_header_style['sub_bg_color'] ) && !empty( $standard_header_style['sub_bg_color'] ) ) {
                            $css .= '.kinfw-std-header #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu { background-color:'.$standard_header_style['sub_bg_color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
                        }

                        $submenu_link_colors = isset( $standard_header_style['sub_menu_link_color'] ) ? $standard_header_style['sub_menu_link_color'] : [];
						if( !empty( $submenu_link_colors['color'] ) ) {
							$css .= '.kinfw-std-header #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li a { color:'.$submenu_link_colors['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;

							$css .= '.kinfw-std-header #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li a:before { background:'.$submenu_link_colors['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $submenu_link_colors['hover'] ) ) {
							$css .= '.kinfw-std-header #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li a:hover { color:'.$submenu_link_colors['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;

							$css .= '.kinfw-std-header #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li a:before { background:'.$submenu_link_colors['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $submenu_link_colors['active'] ) ) {
							$css .= '.kinfw-std-header #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-item > a, .kinfw-std-header #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-parent > a, .kinfw-std-header #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-ancestor > a { color:'.$submenu_link_colors['active'].';}'.ONNAT_CONST_THEME_NEW_LINE;


							$css .= '.kinfw-std-header #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-item > a:before, .kinfw-std-header #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-parent > a:before, .kinfw-std-header #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-ancestor > a:before { background:'.$submenu_link_colors['active'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						/**
						 * Apply color for Sub menu hover link background
						 */
						if( !empty( $submenu_link_colors['focus'] ) ) {
							$css .= '.kinfw-std-header #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li a:hover { background-color:'.$submenu_link_colors['focus'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

					// Sticky Header
						if( isset( $standard_header_style['sticky_height'] ) && !empty( $standard_header_style['sticky_height'] ) ) {
							$css .= '.kinfw-std-header #kinfw-sticky-header { height:'.$standard_header_style['sticky_height'].'px;}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( isset( $standard_header_style['sticky_bg_color'] ) && !empty( $standard_header_style['sticky_bg_color'] ) ) {
							$css .= '.kinfw-std-header #kinfw-sticky-header { background-color:'.$standard_header_style['sticky_bg_color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						$sticky_main_menu_link_colors = isset( $standard_header_style['sticky_main_menu_link_color'] ) ? $standard_header_style['sticky_main_menu_link_color'] : [];

						if( !empty( $sticky_main_menu_link_colors['color'] ) ) {
							$css .= '.kinfw-std-header #kinfw-sticky-header .kinfw-main-nav > ul > li > a  { color:'.$sticky_main_menu_link_colors['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $sticky_main_menu_link_colors['hover'] ) ) {
							$css .= '.kinfw-std-header #kinfw-sticky-header .kinfw-main-nav > ul > li > a:hover { color:'.$sticky_main_menu_link_colors['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $sticky_main_menu_link_colors['active'] ) ) {
							$css .= '.kinfw-std-header #kinfw-sticky-header .kinfw-main-nav > ul > li.current-menu-item > a, .kinfw-std-header #kinfw-sticky-header .kinfw-main-nav > ul > li.current-menu-parent > a, .kinfw-std-header #kinfw-sticky-header .kinfw-main-nav > ul > li.current-menu-ancestor > a { color:'.$sticky_main_menu_link_colors['active'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( isset( $standard_header_style['sticky_sub_bg_color'] ) && !empty( $standard_header_style['sticky_sub_bg_color'] ) ) {
							$css .= '.kinfw-std-header #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu { background-color:'.$standard_header_style['sticky_sub_bg_color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						$sticky_submenu_link_colors = isset( $standard_header_style['sticky_sub_menu_link_color'] ) ? $standard_header_style['sticky_sub_menu_link_color'] : [];
						if( !empty( $sticky_submenu_link_colors['color'] ) ) {
							$css .= '.kinfw-std-header #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li a { color:'.$sticky_submenu_link_colors['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;

							$css .= '.kinfw-std-header #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li a:before { background:'.$sticky_submenu_link_colors['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $sticky_submenu_link_colors['hover'] ) ) {
							$css .= '.kinfw-std-header #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li a:hover { color:'.$sticky_submenu_link_colors['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;

							$css .= '.kinfw-std-header #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li a:before { background:'.$sticky_submenu_link_colors['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $sticky_submenu_link_colors['active'] ) ) {
							$css .= '.kinfw-std-header #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-item > a, .kinfw-std-header #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-parent > a, .kinfw-std-header #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-ancestor > a { color:'.$sticky_submenu_link_colors['active'].';}'.ONNAT_CONST_THEME_NEW_LINE;

							$css .= '.kinfw-std-header #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-item > a:before, .kinfw-std-header #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-parent > a:before, .kinfw-std-header #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-ancestor > a:before { background:'.$sticky_submenu_link_colors['active'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						/**
						 * Apply color for Sub menu hover link background
						 */
						if( !empty( $sticky_submenu_link_colors['focus'] ) ) {
							$css .= '.kinfw-std-header #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li a:hover { background-color:'.$submenu_link_colors['focus'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

					// Mobile Header
						if( isset( $standard_header_style['mobile_height'] ) && !empty( $standard_header_style['mobile_height'] ) ) {
							$css .= '.kinfw-std-header #kinfw-mobile-header { height:'.$standard_header_style['mobile_height'].'px;}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( isset( $standard_header_style['mobile_bg_color'] ) && !empty( $standard_header_style['mobile_bg_color'] ) ) {
							$css .= '.kinfw-std-header #kinfw-mobile-header { background-color:'.$standard_header_style['mobile_bg_color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( isset( $standard_header_style['mobile_menu_bg_color'] ) && !empty( $standard_header_style['mobile_menu_bg_color'] ) ) {
							$css .= '.kinfw-std-header #kinfw-mobile-header .kinfw-mobile-menu, .kinfw-std-header #kinfw-mobile-header .kinfw-mobile-menu .sub-menu { background:'.$standard_header_style['mobile_menu_bg_color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( isset( $standard_header_style['mobile_border_color'] ) && !empty( $standard_header_style['mobile_border_color'] ) ) {
							$css .= '.kinfw-std-header #kinfw-mobile-header ul.kinfw-mobile-menu li { border-bottom-color:'.$standard_header_style['mobile_border_color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						$mobile_menu_link_color = isset( $standard_header_style['mobile_menu_link_color'] ) ? $standard_header_style['mobile_menu_link_color'] : [];
						if( !empty( $mobile_menu_link_color['color'] ) ) {
							$css .= '.kinfw-std-header #kinfw-mobile-header ul.kinfw-mobile-menu li a { color:'.$mobile_menu_link_color['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $mobile_menu_link_color['hover'] ) ) {
							$css .= '.kinfw-std-header #kinfw-mobile-header ul.kinfw-mobile-menu li a:hover { color:'.$mobile_menu_link_color['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $mobile_menu_link_color['active'] ) ) {
							$css .= '.kinfw-std-header #kinfw-mobile-header ul.kinfw-mobile-menu li.current-menu-item > a, .kinfw-std-header #kinfw-mobile-header ul.kinfw-mobile-menu li.current-menu-parent > a, .kinfw-std-header #kinfw-mobile-header ul.kinfw-mobile-menu li.current-menu-ancestor > a { color:'.$mobile_menu_link_color['active'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

				}

            /**
             * Menu Typo
             */
				$menu_typo     = kinfw_onnat_theme_options()->kinfw_get_option( 'standard_header_main_menu_typo_size' );
				$size          = isset( $menu_typo['size'] ) ? $menu_typo['size'] : [];
				$menu_typo_css = kinfw_typo_opt_css( $size );

				if( isset( $menu_typo_css['css'] ) ) {
					$css .= '.kinfw-std-header .kinfw-main-nav > ul > li > a {'.$menu_typo_css['css'].'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

				if( isset( $menu_typo_css['md_css'] ) ) {
					$tablet_responsive_css .= '.kinfw-std-header .kinfw-main-nav > ul > li > a {'.$menu_typo_css['md_css'].'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

				if( isset( $menu_typo_css['sm_css'] ) ) {
					$mobile_responsive_css .= '.kinfw-std-header #kinfw-mobile-header ul.kinfw-mobile-menu li a {'.$menu_typo_css['sm_css'].'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

            /**
             * Sub Menu Typo
             */
				$sub_menu_typo     = kinfw_onnat_theme_options()->kinfw_get_option( 'standard_header_sub_menu_typo_size' );
				$size              = isset( $sub_menu_typo['size'] ) ? $sub_menu_typo['size'] : [];
				$sub_menu_typo_css = kinfw_typo_opt_css( $size );

				if( isset( $sub_menu_typo_css['css'] ) ) {
					$css .= '.kinfw-std-header .kinfw-main-nav ul li > ul.sub-menu li a {'.$sub_menu_typo_css['css'].'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

				if( isset( $sub_menu_typo_css['md_css'] ) ) {
					$tablet_responsive_css .= '.kinfw-std-header .kinfw-main-nav ul li > ul.sub-menu li a {'. $sub_menu_typo_css['md_css'] .'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

			/**
			 * Header Actions
			 */
			$actions = kinfw_onnat_theme_options()->kinfw_get_option( 'standard_header_icons' );
			if( is_array( $actions ) ) {

				$standard_header_icons_style  = kinfw_onnat_theme_options()->kinfw_get_option( 'standard_header_icons_style' );

				if( is_array( $standard_header_icons_style ) ) {

					$standard_header_icons_style = isset( $standard_header_icons_style['style'] ) ? $standard_header_icons_style['style'] : [];

					// Header
						if( !empty( $standard_header_icons_style['size'] ) ) {
							$css .= '.kinfw-std-header #kinfw-main-header .kinfw-header-group-action .kinfw-header-element { font-size: '.$standard_header_icons_style['size'].'px;}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						$standard_header_icons_color = isset( $standard_header_icons_style['color'] ) ? $standard_header_icons_style['color'] : [];

						if( !empty( $standard_header_icons_color['color'] ) ) {
							$css .= '.kinfw-std-header #kinfw-main-header .kinfw-header-group-action .kinfw-header-element, .kinfw-std-header #kinfw-main-header .kinfw-header-group-action .kinfw-header-element { color: '.$standard_header_icons_color['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $standard_header_icons_color['hover'] ) ) {
							$css .= '.kinfw-std-header #kinfw-main-header .kinfw-header-group-action .kinfw-header-element:hover { color: '.$standard_header_icons_color['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

					// Sticky Header
						if( !empty( $standard_header_icons_style['sticky_size'] ) ) {
							$css .= '.kinfw-std-header #kinfw-sticky-header .kinfw-header-group-action .kinfw-header-element { font-size: '.$standard_header_icons_style['sticky_size'].'px;}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						$standard_header_icons_color = isset( $standard_header_icons_style['sticky_color'] ) ? $standard_header_icons_style['sticky_color'] : [];

						if( !empty( $standard_header_icons_color['color'] ) ) {
							$css .= '.kinfw-std-header #kinfw-sticky-header .kinfw-header-group-action .kinfw-header-element { color: '.$standard_header_icons_color['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $standard_header_icons_color['hover'] ) ) {
							$css .= '.kinfw-std-header #kinfw-sticky-header .kinfw-header-group-action .kinfw-header-element:hover { color: '.$standard_header_icons_color['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

					// Mobile Header
						if( !empty( $standard_header_icons_style['mobile_size'] ) ) {
							$mobile_responsive_css .= '.kinfw-std-header #kinfw-mobile-header .kinfw-mobile-navigation-trigger .kinfw-icon, .kinfw-std-header #kinfw-mobile-header .kinfw-header-group-action .kinfw-header-element { font-size:'.$standard_header_icons_style['mobile_size'].'px;}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						$standard_header_icons_color = isset( $standard_header_icons_style['mobile_color'] ) ? $standard_header_icons_style['mobile_color'] : [];

						if( !empty( $standard_header_icons_color['color'] ) ) {
							$mobile_responsive_css .= '.kinfw-std-header #kinfw-mobile-header .kinfw-mobile-navigation-trigger .kinfw-icon, .kinfw-std-header #kinfw-mobile-header .kinfw-header-group-action .kinfw-header-element { color:'.$standard_header_icons_color['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $standard_header_icons_color['hover'] ) ) {
							$mobile_responsive_css .= '.kinfw-std-header #kinfw-mobile-header .kinfw-mobile-navigation-trigger .kinfw-icon:hover, .kinfw-std-header #kinfw-mobile-header .kinfw-header-group-action .kinfw-header-element:hover { color:'.$standard_header_icons_color['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

				}

			}

            return [
                'css'    => $css,
                'tablet' => $tablet_responsive_css,
                'mobile' => $mobile_responsive_css
            ];

		}

        /**
         * Standard Header With Top Bar inline css
         */
        public function standard_header_with_top_bar_inline_css() {

            $css                   = '';
            $tablet_responsive_css = '';
            $mobile_responsive_css = '';

            /**
             * Top Bar
             */
				$bar = kinfw_onnat_theme_options()->kinfw_get_option('top_bar_standard_header_top' );
				$bar =  isset( $bar['bar'] ) ? $bar['bar'] : null;
				if( $bar ) {

					if( isset($bar['height']) && !empty( $bar['height'] ) ) {
						$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-top-bar { height:'.$bar['height'].'px;}'.ONNAT_CONST_THEME_NEW_LINE;
						$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-top-bar .kinfw-top-bar-info .kinfw-top-bar-content li { line-height:'.$bar['height'].'px; }'.ONNAT_CONST_THEME_NEW_LINE;
						$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-main-header:before { top:'.$bar['height'].'px;}'.ONNAT_CONST_THEME_NEW_LINE;						
					}

					if( isset($bar['mobile_height']) && !empty( $bar['mobile_height'] ) ) {
						$mobile_responsive_css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-top-bar { height:'.$bar['mobile_height'].'px;}'.ONNAT_CONST_THEME_NEW_LINE;
						$mobile_responsive_css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-top-bar .kinfw-top-bar-info .kinfw-top-bar-content li { line-height:'.$bar['mobile_height'].'px; }'.ONNAT_CONST_THEME_NEW_LINE;
					}

					if( isset($bar['bg_color']) && !empty( $bar['bg_color'] ) ) {
						$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-top-bar { background-color:'.$bar['bg_color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
					}

					if( isset($bar['separator_color']) && !empty( $bar['separator_color'] ) ) {
						$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-top-bar .kinfw-top-bar-info .kinfw-top-bar-content li:before { background:'.$bar['separator_color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-top-bar .kinfw-top-bar-info .kinfw-top-bar-content li:last-child:before {background:none;}'.ONNAT_CONST_THEME_NEW_LINE;
					}

					if( isset($bar['icon_color']) && !empty( $bar['icon_color'] ) ) {
						$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-top-bar .kinfw-top-bar-info .kinfw-top-bar-content li .kinfw-icon { color:'.$bar['icon_color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
					}

					$link_colors = isset( $bar['link_color'] ) ? $bar['link_color'] : [];
					if( !empty( $link_colors['color'] ) ) {
						$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-top-bar .kinfw-top-bar-info .kinfw-top-bar-content li a { color:'.$link_colors['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
					}

					if( !empty( $link_colors['hover'] ) ) {
						$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-top-bar .kinfw-top-bar-info .kinfw-top-bar-content li a:hover { color:'.$link_colors['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;
					}
				}

			/**
			 * Header Wrapper
			 */
				$header_style  = kinfw_onnat_theme_options()->kinfw_get_option( 'top_bar_standard_header_style' );
				if( is_array( $header_style ) ) {

					$header_style = isset( $header_style['style'] ) ? $header_style['style'] : [];

					// Header
						if( isset( $header_style['height'] ) && !empty( $header_style['height'] ) ) {
							$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-main-header { height:'.$header_style['height'].'px;}'.ONNAT_CONST_THEME_NEW_LINE;
							$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-main-header:before { height:'.$header_style['height'].'px;}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( isset( $header_style['bg_color'] ) && !empty( $header_style['bg_color'] ) ) {
							$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-main-header:before { background-color:'.$header_style['bg_color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						$main_menu_link_colors = isset( $header_style['main_menu_link_color'] ) ? $header_style['main_menu_link_color'] : [];
						if( !empty( $main_menu_link_colors['color'] ) ) {
							$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-main-header .kinfw-main-nav > ul > li > a { color:'.$main_menu_link_colors['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $main_menu_link_colors['hover'] ) ) {
							$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-main-header .kinfw-main-nav > ul > li > a:hover { color:'.$main_menu_link_colors['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $main_menu_link_colors['active'] ) ) {
							$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-main-header .kinfw-main-nav > ul > li.current-menu-item > a, .kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-main-header .kinfw-main-nav > ul > li.current-menu-parent > a, .kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-main-header .kinfw-main-nav > ul > li.current-menu-ancestor > a { color:'.$main_menu_link_colors['active'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( isset( $header_style['sub_bg_color'] ) && !empty( $header_style['sub_bg_color'] ) ) {
							$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu { background-color:'.$header_style['sub_bg_color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						$submenu_link_colors = isset( $header_style['sub_menu_link_color'] ) ? $header_style['sub_menu_link_color'] : [];
						if( !empty( $submenu_link_colors['color'] ) ) {
							$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li a { color:'.$submenu_link_colors['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;

							$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li a:before { background:'.$submenu_link_colors['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $submenu_link_colors['hover'] ) ) {
							$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li a:hover { color:'.$submenu_link_colors['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;

							$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li a:before { background:'.$submenu_link_colors['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $submenu_link_colors['active'] ) ) {
							$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-item > a, .kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-parent > a, .kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-ancestor > a { color:'.$submenu_link_colors['active'].';}'.ONNAT_CONST_THEME_NEW_LINE;

							$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-item > a:before, .kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-parent > a:before, .kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-ancestor > a:before { background:'.$submenu_link_colors['active'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						/**
						 * Apply color for Sub menu hover link background
						 */
						if( !empty( $submenu_link_colors['focus'] ) ) {
							$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li a:hover { background-color:'.$submenu_link_colors['focus'].';}'.ONNAT_CONST_THEME_NEW_LINE;

						}

					// Sticky Header
						if( isset( $header_style['sticky_height'] ) && !empty( $header_style['sticky_height'] ) ) {
							$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-sticky-header { height:'.$header_style['sticky_height'].'px;}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( isset( $header_style['sticky_bg_color'] ) && !empty( $header_style['sticky_bg_color'] ) ) {
							$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-sticky-header { background-color:'.$header_style['sticky_bg_color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						$sticky_main_menu_link_colors = isset( $header_style['sticky_main_menu_link_color'] ) ? $header_style['sticky_main_menu_link_color'] : [];
						if( !empty( $sticky_main_menu_link_colors['color'] ) ) {
							$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-sticky-header .kinfw-main-nav > ul > li > a  { color:'.$sticky_main_menu_link_colors['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $sticky_main_menu_link_colors['hover'] ) ) {
							$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-sticky-header .kinfw-main-nav > ul > li > a:hover { color:'.$sticky_main_menu_link_colors['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $sticky_main_menu_link_colors['active'] ) ) {
							$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-sticky-header .kinfw-main-nav > ul > li.current-menu-item > a, .kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-sticky-header .kinfw-main-nav > ul > li.current-menu-parent > a, .kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-sticky-header .kinfw-main-nav > ul > li.current-menu-ancestor > a { color:'.$sticky_main_menu_link_colors['active'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( isset( $header_style['sticky_sub_bg_color'] ) && !empty( $header_style['sticky_sub_bg_color'] ) ) {
							$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu { background-color:'.$header_style['sticky_sub_bg_color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						$sticky_submenu_link_colors = isset( $header_style['sticky_sub_menu_link_color'] ) ? $header_style['sticky_sub_menu_link_color'] : [];
						if( !empty( $sticky_submenu_link_colors['color'] ) ) {
							$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li a { color:'.$sticky_submenu_link_colors['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;

							$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li a:before { background:'.$sticky_submenu_link_colors['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $sticky_submenu_link_colors['hover'] ) ) {
							$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li a:hover { color:'.$sticky_submenu_link_colors['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;

							$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li a:before { background:'.$sticky_submenu_link_colors['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $sticky_submenu_link_colors['active'] ) ) {
							$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-item > a, .kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-parent > a, .kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-ancestor > a { color:'.$sticky_submenu_link_colors['active'].';}'.ONNAT_CONST_THEME_NEW_LINE;
							$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-item > a:before, .kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-parent > a:before, .kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-ancestor > a:before { background:'.$sticky_submenu_link_colors['active'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						/**
						 * Apply color for Sub menu hover link background
						 */
						if( !empty( $sticky_submenu_link_colors['focus'] ) ) {
							$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li a:hover { background-color:'.$sticky_submenu_link_colors['focus'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

					// Mobile Header
						if( isset( $header_style['mobile_height'] ) && !empty( $header_style['mobile_height'] ) ) {
							$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-mobile-header { height:'.$header_style['mobile_height'].'px;}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( isset( $header_style['mobile_bg_color'] ) && !empty( $header_style['mobile_bg_color'] ) ) {
							$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-mobile-header { background-color:'.$header_style['mobile_bg_color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( isset( $header_style['mobile_menu_bg_color'] ) && !empty( $header_style['mobile_menu_bg_color'] ) ) {
							$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-mobile-header .kinfw-mobile-menu, .kinfw-std-header #kinfw-mobile-header .kinfw-mobile-menu .sub-menu { background:'.$header_style['mobile_menu_bg_color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( isset( $header_style['mobile_border_color'] ) && !empty( $header_style['mobile_border_color'] ) ) {
							$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-mobile-header ul.kinfw-mobile-menu li { border-bottom-color:'.$header_style['mobile_border_color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						$mobile_menu_link_color = isset( $header_style['mobile_menu_link_color'] ) ? $header_style['mobile_menu_link_color'] : [];
						if( !empty( $mobile_menu_link_color['color'] ) ) {
							$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-mobile-header ul.kinfw-mobile-menu li a { color:'.$mobile_menu_link_color['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $mobile_menu_link_color['hover'] ) ) {
							$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-mobile-header ul.kinfw-mobile-menu li a:hover { color:'.$mobile_menu_link_color['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $mobile_menu_link_color['active'] ) ) {
							$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-mobile-header ul.kinfw-mobile-menu li.current-menu-item > a, .kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-mobile-header ul.kinfw-mobile-menu li.current-menu-parent > a, .kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-mobile-header ul.kinfw-mobile-menu li.current-menu-ancestor > a { color:'.$mobile_menu_link_color['active'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

				}

            /**
             * Menu Typo
             */
				$menu_typo     = kinfw_onnat_theme_options()->kinfw_get_option( 'top_bar_standard_header_main_menu_typo_size' );
				$size          = isset( $menu_typo['size'] ) ? $menu_typo['size'] : [];
				$menu_typo_css = kinfw_typo_opt_css( $size );

				if( isset( $menu_typo_css['css'] ) ) {
					$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar .kinfw-main-nav > ul > li > a {'.$menu_typo_css['css'].'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

				if( isset( $menu_typo_css['md_css'] ) ) {
					$tablet_responsive_css .= '.kinfw-std-header.kinfw-std-header-with-top-bar .kinfw-main-nav > ul > li > a {'.$menu_typo_css['md_css'].'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

				if( isset( $menu_typo_css['sm_css'] ) ) {
					$mobile_responsive_css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-mobile-header ul.kinfw-mobile-menu li a {'.$menu_typo_css['sm_css'].'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

			/**
			 * Sub Menu Typo
			 */
				$sub_menu_typo     = kinfw_onnat_theme_options()->kinfw_get_option( 'top_bar_standard_header_sub_menu_typo_size' );
				$size              = isset( $sub_menu_typo['size'] ) ? $sub_menu_typo['size'] : [];
				$sub_menu_typo_css = kinfw_typo_opt_css( $size );

				if( isset( $sub_menu_typo_css['css'] ) ) {
					$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar .kinfw-main-nav ul li > ul.sub-menu li a {'.$sub_menu_typo_css['css'].'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

				if( isset( $sub_menu_typo_css['md_css'] ) ) {
					$tablet_responsive_css .= '.kinfw-std-header.kinfw-std-header-with-top-bar .kinfw-main-nav ul li > ul.sub-menu li a {'. $sub_menu_typo_css['md_css'] .'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

			/**
			 * Header Actions
			 */
				$actions = kinfw_onnat_theme_options()->kinfw_get_option( 'top_bar_standard_header_icons' );
				if( is_array( $actions ) ) {

					$header_icons_style  = kinfw_onnat_theme_options()->kinfw_get_option( 'top_bar_standard_header_icons_style' );

					if( is_array( $header_icons_style ) ) {

						$header_icons_style = isset( $header_icons_style['style'] ) ? $header_icons_style['style'] : [];

						// Header
							if( !empty( $header_icons_style['size'] ) ) {
								$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-main-header .kinfw-header-group-action .kinfw-header-element { font-size: '.$header_icons_style['size'].'px;}'.ONNAT_CONST_THEME_NEW_LINE;
							}

							$header_icons_color = isset( $header_icons_style['color'] ) ? $header_icons_style['color'] : [];
							if( !empty( $header_icons_color['color'] ) ) {
								$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-main-header .kinfw-header-group-action .kinfw-header-element { color: '.$header_icons_color['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
							}

							if( !empty( $header_icons_color['hover'] ) ) {
								$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-main-header .kinfw-header-group-action .kinfw-header-element:hover { color: '.$header_icons_color['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;
							}

						// Sticky Header
							if( !empty( $header_icons_style['sticky_size'] ) ) {
								$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-sticky-header .kinfw-header-group-action .kinfw-header-element { font-size: '.$header_icons_style['sticky_size'].'px;}'.ONNAT_CONST_THEME_NEW_LINE;
							}

							$sticky_header_icons_color = isset( $header_icons_style['sticky_color'] ) ? $header_icons_style['sticky_color'] : [];
							if( !empty( $sticky_header_icons_color['color'] ) ) {
								$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-sticky-header .kinfw-header-group-action .kinfw-header-element { color: '.$sticky_header_icons_color['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
							}

							if( !empty( $sticky_header_icons_color['hover'] ) ) {
								$css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-sticky-header .kinfw-header-group-action .kinfw-header-element:hover { color: '.$sticky_header_icons_color['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;
							}

						// Mobile Header
							if( !empty( $header_icons_style['mobile_size'] ) ) {
								$mobile_responsive_css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-mobile-header .kinfw-mobile-navigation-trigger .kinfw-icon, .kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-mobile-header .kinfw-header-group-action .kinfw-header-element { font-size:'.$header_icons_style['mobile_size'].'px;}'.ONNAT_CONST_THEME_NEW_LINE;
							}

							$mobile_header_icons_color = isset( $header_icons_style['mobile_color'] ) ? $header_icons_style['mobile_color'] : [];
							if( !empty( $mobile_header_icons_color['color'] ) ) {
								$mobile_responsive_css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-mobile-header .kinfw-mobile-navigation-trigger .kinfw-icon, .kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-mobile-header .kinfw-header-group-action .kinfw-header-element { color:'.$mobile_header_icons_color['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
							}

							if( !empty( $mobile_header_icons_color['hover'] ) ) {
								$mobile_responsive_css .= '.kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-mobile-header .kinfw-mobile-navigation-trigger .kinfw-icon:hover, .kinfw-std-header.kinfw-std-header-with-top-bar #kinfw-mobile-header .kinfw-header-group-action .kinfw-header-element:hover { color:'.$mobile_header_icons_color['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;
							}

					}

				}

            return [
                'css'    => $css,
                'tablet' => $tablet_responsive_css,
                'mobile' => $mobile_responsive_css
            ];

		}

        /**
         * Transparent Header inline css
         */
        public function transparent_header_inline_css() {

            $css                   = '';
            $tablet_responsive_css = '';
            $mobile_responsive_css = '';

			/**
			 * Header Wrapper
			 */
				$header_style  = kinfw_onnat_theme_options()->kinfw_get_option( 'transparent_header_style' );
				if( is_array( $header_style ) ) {

					$header_style = isset( $header_style['style'] ) ? $header_style['style'] : [];

					// Header
						if( isset( $header_style['height'] ) && !empty( $header_style['height'] ) ) {
							$css .= '.kinfw-transparent-header #kinfw-main-header { height:'.$header_style['height'].'px;}'.ONNAT_CONST_THEME_NEW_LINE;
							$css .= '.kinfw-transparent-header + #kinfw-content-wrap #kinfw-title-holder { padding-top:calc( 100px + '. $header_style['height'] .'px) }'.ONNAT_CONST_THEME_NEW_LINE;
							$css .= '.kinfw-transparent-header #kinfw-main-header:before { height:'.$header_style['height'].'px;}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( isset($header_style['bg_color']) && !empty( $header_style['bg_color'] ) ) {
							$css .= '.kinfw-transparent-header #kinfw-main-header:before { background-color:'.$header_style['bg_color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						$main_menu_link_colors = isset( $header_style['main_menu_link_color'] ) ? $header_style['main_menu_link_color'] : [];
						if( !empty( $main_menu_link_colors['color'] ) ) {
							$css .= '#kinfw-masthead.kinfw-transparent-header #kinfw-main-header .kinfw-main-nav > ul > li > a { color:'.$main_menu_link_colors['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $main_menu_link_colors['hover'] ) ) {
							$css .= '#kinfw-masthead.kinfw-transparent-header #kinfw-main-header .kinfw-main-nav > ul > li > a:hover { color:'.$main_menu_link_colors['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $main_menu_link_colors['active'] ) ) {
							$css .= '#kinfw-masthead.kinfw-transparent-header #kinfw-main-header .kinfw-main-nav > ul > li.current-menu-item > a, #kinfw-masthead.kinfw-transparent-header #kinfw-main-header .kinfw-main-nav > ul > li.current-menu-parent > a, #kinfw-masthead.kinfw-transparent-header #kinfw-main-header .kinfw-main-nav > ul > li.current-menu-ancestor > a { color:'.$main_menu_link_colors['active'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( isset( $header_style['sub_bg_color'] ) && !empty( $header_style['sub_bg_color'] ) ) {
							$css .= '#kinfw-masthead.kinfw-transparent-header #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu { background-color:'.$header_style['sub_bg_color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						$submenu_link_colors = isset( $header_style['sub_menu_link_color'] ) ? $header_style['sub_menu_link_color'] : [];
						if( !empty( $submenu_link_colors['color'] ) ) {
							$css .= '#kinfw-masthead.kinfw-transparent-header #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li a { color:'.$submenu_link_colors['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;

							$css .= '#kinfw-masthead.kinfw-transparent-header #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li a:before { background:'.$submenu_link_colors['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $submenu_link_colors['hover'] ) ) {
							$css .= '#kinfw-masthead.kinfw-transparent-header #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li a:hover { color:'.$submenu_link_colors['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;

							$css .= '#kinfw-masthead.kinfw-transparent-header #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li a:before { background:'.$submenu_link_colors['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $submenu_link_colors['active'] ) ) {
							$css .= '#kinfw-masthead.kinfw-transparent-header #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-item > a, #kinfw-masthead.kinfw-transparent-header #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-parent > a, #kinfw-masthead.kinfw-transparent-header #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-ancestor > a { color:'.$submenu_link_colors['active'].';}'.ONNAT_CONST_THEME_NEW_LINE;

							$css .= '#kinfw-masthead.kinfw-transparent-header #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-item > a:before, #kinfw-masthead.kinfw-transparent-header #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-parent > a:before, #kinfw-masthead.kinfw-transparent-header #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-ancestor > a:before { background:'.$submenu_link_colors['active'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						/**
						 * Apply color for Sub menu hover link background
						 */
						if( !empty( $submenu_link_colors['focus'] ) ) {
							$css .= '.kinfw-transparent-header #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li a:hover { background-color:'.$submenu_link_colors['focus'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

					// Sticky Header
						if( isset( $header_style['sticky_height'] ) && !empty( $header_style['sticky_height'] ) ) {
							$css .= '.kinfw-transparent-header #kinfw-sticky-header { height:'.$header_style['sticky_height'].'px;}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( isset( $header_style['sticky_bg_color'] ) && !empty( $header_style['sticky_bg_color'] ) ) {
							$css .= '.kinfw-transparent-header #kinfw-sticky-header { background-color:'.$header_style['sticky_bg_color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						$sticky_main_menu_link_colors = isset( $header_style['sticky_main_menu_link_color'] ) ? $header_style['sticky_main_menu_link_color'] : [];
						if( !empty( $sticky_main_menu_link_colors['color'] ) ) {
							$css .= '.kinfw-transparent-header #kinfw-sticky-header .kinfw-main-nav > ul > li > a  { color:'.$sticky_main_menu_link_colors['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $sticky_main_menu_link_colors['hover'] ) ) {
							$css .= '.kinfw-transparent-header #kinfw-sticky-header .kinfw-main-nav > ul > li > a:hover { color:'.$sticky_main_menu_link_colors['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $sticky_main_menu_link_colors['active'] ) ) {
							$css .= '.kinfw-transparent-header #kinfw-sticky-header .kinfw-main-nav > ul > li.current-menu-item > a, .kinfw-transparent-header #kinfw-sticky-header .kinfw-main-nav > ul > li.current-menu-parent > a, .kinfw-transparent-header #kinfw-sticky-header .kinfw-main-nav > ul > li.current-menu-ancestor > a { color:'.$sticky_main_menu_link_colors['active'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( isset( $header_style['sticky_sub_bg_color'] ) && !empty( $header_style['sticky_sub_bg_color'] ) ) {
							$css .= '.kinfw-transparent-header #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu { background-color:'.$header_style['sticky_sub_bg_color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						$sticky_submenu_link_colors = isset( $header_style['sticky_sub_menu_link_color'] ) ? $header_style['sticky_sub_menu_link_color'] : [];
						if( !empty( $sticky_submenu_link_colors['color'] ) ) {
							$css .= '.kinfw-transparent-header #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li a { color:'.$sticky_submenu_link_colors['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;

							$css .= '.kinfw-transparent-header #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li a:before { background:'.$sticky_submenu_link_colors['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $sticky_submenu_link_colors['hover'] ) ) {
							$css .= '.kinfw-transparent-header #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li a:hover { color:'.$sticky_submenu_link_colors['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;

							$css .= '.kinfw-transparent-header #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li a:before { background:'.$sticky_submenu_link_colors['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $sticky_submenu_link_colors['active'] ) ) {
							$css .= '.kinfw-transparent-header #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-item > a, .kinfw-transparent-header #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-parent > a, .kinfw-transparent-header #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-ancestor > a { color:'.$sticky_submenu_link_colors['active'].';}'.ONNAT_CONST_THEME_NEW_LINE;

							$css .= '.kinfw-transparent-header #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-item > a:before, .kinfw-transparent-header #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-parent > a:before, .kinfw-transparent-header #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-ancestor > a:before { color:'.$sticky_submenu_link_colors['active'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						/**
						 * Apply color for Sub menu hover link background
						 */
						if( !empty( $sticky_submenu_link_colors['focus'] ) ) {
							$css .= '.kinfw-transparent-header #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li a:hover { background-color:'.$sticky_submenu_link_colors['focus'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

					// Mobile Header
						if( isset( $header_style['mobile_height'] ) && !empty( $header_style['mobile_height'] ) ) {
							$css .= '.kinfw-transparent-header #kinfw-mobile-header { height:'.$header_style['mobile_height'].'px; margin-bottom:-'.$header_style['mobile_height'].'px;}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( isset( $header_style['mobile_menu_bg_color'] ) && !empty( $header_style['mobile_menu_bg_color'] ) ) {
							$css .= '.kinfw-transparent-header #kinfw-mobile-header .kinfw-mobile-menu,  #kinfw-mobile-header .kinfw-mobile-menu .sub-menu { background:'.$header_style['mobile_menu_bg_color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( isset( $header_style['mobile_border_color'] ) && !empty( $header_style['mobile_border_color'] ) ) {
							$css .= '.kinfw-transparent-header #kinfw-mobile-header ul.kinfw-mobile-menu li { border-bottom-color:'.$header_style['mobile_border_color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						$mobile_menu_link_color = isset( $header_style['mobile_menu_link_color'] ) ? $header_style['mobile_menu_link_color'] : [];
						if( !empty( $mobile_menu_link_color['color'] ) ) {
							$css .= '.kinfw-transparent-header #kinfw-mobile-header ul.kinfw-mobile-menu li a { color:'.$mobile_menu_link_color['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;

							$css .= '.kinfw-transparent-header #kinfw-mobile-header ul.kinfw-mobile-menu li a:before { background:'.$mobile_menu_link_color['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $mobile_menu_link_color['hover'] ) ) {
							$css .= '.kinfw-transparent-header #kinfw-mobile-header ul.kinfw-mobile-menu li a:hover { color:'.$mobile_menu_link_color['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;

							$css .= '.kinfw-transparent-header #kinfw-mobile-header ul.kinfw-mobile-menu li a:before { background:'.$mobile_menu_link_color['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $mobile_menu_link_color['active'] ) ) {
							$css .= '.kinfw-transparent-header #kinfw-mobile-header ul.kinfw-mobile-menu li.current-menu-item > a, .kinfw-transparent-header #kinfw-mobile-header ul.kinfw-mobile-menu li.current-menu-parent > a, .kinfw-transparent-header #kinfw-mobile-header ul.kinfw-mobile-menu li.current-menu-ancestor > a { color:'.$mobile_menu_link_color['active'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

				}

            /**
             * Menu Typo
             */
				$menu_typo     = kinfw_onnat_theme_options()->kinfw_get_option( 'transparent_header_main_menu_typo_size' );
				$size          = isset( $menu_typo['size'] ) ? $menu_typo['size'] : [];
				$menu_typo_css = kinfw_typo_opt_css( $size );

				if( isset( $menu_typo_css['css'] ) ) {
					$css .= '.kinfw-transparent-header .kinfw-main-nav > ul > li > a {'.$menu_typo_css['css'].'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

				if( isset( $menu_typo_css['md_css'] ) ) {
					$tablet_responsive_css .= '.kinfw-transparent-header .kinfw-main-nav > ul > li > a {'.$menu_typo_css['md_css'].'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

				if( isset( $menu_typo_css['sm_css'] ) ) {
					$mobile_responsive_css .= '.kinfw-transparent-header #kinfw-mobile-header ul.kinfw-mobile-menu li a {'.$menu_typo_css['sm_css'].'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

			/**
			 * Sub Menu Typo
			 */
				$sub_menu_typo     = kinfw_onnat_theme_options()->kinfw_get_option( 'transparent_header_sub_menu_typo_size' );
				$size              = isset( $sub_menu_typo['size'] ) ? $sub_menu_typo['size'] : [];
				$sub_menu_typo_css = kinfw_typo_opt_css( $size );

				if( isset( $sub_menu_typo_css['css'] ) ) {
					$css .= '.kinfw-transparent-header .kinfw-main-nav ul li > ul.sub-menu li a {'.$sub_menu_typo_css['css'].'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

				if( isset( $sub_menu_typo_css['md_css'] ) ) {
					$tablet_responsive_css .= '.kinfw-transparent-header .kinfw-main-nav ul li > ul.sub-menu li a {'. $sub_menu_typo_css['md_css'] .'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

			/**
			 * Header Actions
			 */
				$actions = kinfw_onnat_theme_options()->kinfw_get_option( 'transparent_header_icons' );
				if( is_array( $actions ) ) {

					$header_icons_style  = kinfw_onnat_theme_options()->kinfw_get_option( 'transparent_header_icons_style' );

					if( is_array( $header_icons_style ) ) {

						$header_icons_style = isset( $header_icons_style['style'] ) ? $header_icons_style['style'] : [];

						// Header
							if( !empty( $header_icons_style['size'] ) ) {
								$css .= '.kinfw-transparent-header #kinfw-main-header .kinfw-header-group-action .kinfw-header-element { font-size: '.$header_icons_style['size'].'px;}'.ONNAT_CONST_THEME_NEW_LINE;
							}

							$header_icons_color = isset( $header_icons_style['color'] ) ? $header_icons_style['color'] : [];
							if( !empty( $header_icons_color['color'] ) ) {
								$css .= '.kinfw-transparent-header #kinfw-main-header .kinfw-header-group-action .kinfw-header-element { color: '.$header_icons_color['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
							}

							if( !empty( $header_icons_color['hover'] ) ) {
								$css .= '.kinfw-transparent-header #kinfw-main-header .kinfw-header-group-action .kinfw-header-element:hover { color: '.$header_icons_color['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;
							}

						// Sticky Header
							if( !empty( $header_icons_style['sticky_size'] ) ) {
								$css .= '.kinfw-transparent-header #kinfw-sticky-header .kinfw-header-group-action .kinfw-header-element { font-size: '.$header_icons_style['sticky_size'].'px;}'.ONNAT_CONST_THEME_NEW_LINE;
							}

							$sticky_header_icons_color = isset( $header_icons_style['sticky_color'] ) ? $header_icons_style['sticky_color'] : [];
							if( !empty( $sticky_header_icons_color['color'] ) ) {
								$css .= '.kinfw-transparent-header #kinfw-sticky-header .kinfw-header-group-action .kinfw-header-element { color: '.$sticky_header_icons_color['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
							}

							if( !empty( $sticky_header_icons_color['hover'] ) ) {
								$css .= '.kinfw-transparent-header #kinfw-sticky-header .kinfw-header-group-action .kinfw-header-element:hover { color: '.$sticky_header_icons_color['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;
							}

						// Mobile Header
							if( !empty( $header_icons_style['mobile_size'] ) ) {
								$mobile_responsive_css .= '.kinfw-transparent-header #kinfw-mobile-header .kinfw-mobile-navigation-trigger .kinfw-icon,  #kinfw-mobile-header .kinfw-header-group-action .kinfw-header-element { font-size:'.$header_icons_style['mobile_size'].'px;}'.ONNAT_CONST_THEME_NEW_LINE;
							}

							$mobile_header_icons_color = isset( $header_icons_style['mobile_color'] ) ? $header_icons_style['mobile_color'] : [];
							if( !empty( $mobile_header_icons_color['color'] ) ) {
								$mobile_responsive_css .= '.kinfw-transparent-header #kinfw-mobile-header .kinfw-mobile-navigation-trigger .kinfw-icon,  #kinfw-mobile-header .kinfw-header-group-action .kinfw-header-element { color:'.$mobile_header_icons_color['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
							}

							if( !empty( $mobile_header_icons_color['hover'] ) ) {
								$mobile_responsive_css .= '.kinfw-transparent-header #kinfw-mobile-header .kinfw-mobile-navigation-trigger .kinfw-icon:hover,  #kinfw-mobile-header .kinfw-header-group-action .kinfw-header-element:hover { color:'.$mobile_header_icons_color['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;
							}

					}

				}

            return [
                'css'    => $css,
                'tablet' => $tablet_responsive_css,
                'mobile' => $mobile_responsive_css
            ];

		}

        /**
         * Transparent Header inline css
         */
        public function transparent_header_with_top_bar_inline_css() {
            $css                   = '';
            $tablet_responsive_css = '';
            $mobile_responsive_css = '';

            /**
             * Top Bar
             */
				$use_top_bar = kinfw_onnat_theme_options()->kinfw_get_option( 'top_bar_transparent_header_top');
				$bar = kinfw_onnat_theme_options()->kinfw_get_option('top_bar_transparent_header_top' );
				$bar =  isset( $bar['bar'] ) ? $bar['bar'] : null;
				if( $use_top_bar && $bar ) {

					if( isset($bar['height']) && !empty( $bar['height'] ) ) {
						$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-top-bar { height:'.$bar['height'].'px;}'.ONNAT_CONST_THEME_NEW_LINE;
						$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-top-bar .kinfw-top-bar-info .kinfw-top-bar-content li { line-height:'.$bar['height'].'px; }'.ONNAT_CONST_THEME_NEW_LINE;
						$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-main-header:before { top:'.$bar['height'].'px;}'.ONNAT_CONST_THEME_NEW_LINE;						
					}

					if( isset($bar['mobile_height']) && !empty( $bar['mobile_height'] ) ) {
						$mobile_responsive_css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-top-bar { height:'.$bar['mobile_height'].'px;}'.ONNAT_CONST_THEME_NEW_LINE;
						$mobile_responsive_css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-top-bar .kinfw-top-bar-info .kinfw-top-bar-content li { line-height:'.$bar['mobile_height'].'px; }'.ONNAT_CONST_THEME_NEW_LINE;
					}

					if( isset($bar['bg_color']) && !empty( $bar['bg_color'] ) ) {
						$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-top-bar { background-color:'.$bar['bg_color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
					}

					if( isset($bar['separator_color']) && !empty( $bar['separator_color'] ) ) {
						$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-top-bar .kinfw-top-bar-info .kinfw-top-bar-content li:before { background:'.$bar['separator_color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-top-bar .kinfw-top-bar-info .kinfw-top-bar-content li:last-child:before {background:none;}'.ONNAT_CONST_THEME_NEW_LINE;
					}

					if( isset($bar['icon_color']) && !empty( $bar['icon_color'] ) ) {
						$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-top-bar .kinfw-top-bar-info .kinfw-top-bar-content li .kinfw-icon { color:'.$bar['icon_color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
					}

					$link_colors = isset( $bar['link_color'] ) ? $bar['link_color'] : [];
					if( !empty( $link_colors['color'] ) ) {
						$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-top-bar .kinfw-top-bar-info .kinfw-top-bar-content li a { color:'.$link_colors['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
					}

					if( !empty( $link_colors['hover'] ) ) {
						$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-top-bar .kinfw-top-bar-info .kinfw-top-bar-content li a:hover { color:'.$link_colors['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;
					}
				}

			/**
			 * Header Wrapper
			 */
				$header_style  = kinfw_onnat_theme_options()->kinfw_get_option( 'top_bar_transparent_header_style' );
				if( is_array( $header_style ) ) {

					$header_style = isset( $header_style['style'] ) ? $header_style['style'] : [];

					// Header
						if( isset( $header_style['height'] ) && !empty( $header_style['height'] ) ) {

							$padding_top = '100px + '. $header_style['height'] .'px';
							if( $use_top_bar && $bar ) {
								if( isset($bar['height']) && !empty( $bar['height'] ) ) {
									$padding_top .= ' + '.$bar['height'].'px';
								}
							}

							$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-main-header { height:'.$header_style['height'].'px; margin-bottom:-'. $header_style['height'] .'px;}'.ONNAT_CONST_THEME_NEW_LINE;
							$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar + #kinfw-content-wrap #kinfw-title-holder { padding-top:calc( ' . $padding_top .' ) }'.ONNAT_CONST_THEME_NEW_LINE;
							$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-main-header:before { height:'.$header_style['height'].'px;}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( isset($header_style['bg_color']) && !empty( $header_style['bg_color'] ) ) {
							$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-main-header:before { background-color:'.$header_style['bg_color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						$main_menu_link_colors = isset( $header_style['main_menu_link_color'] ) ? $header_style['main_menu_link_color'] : [];
						if( !empty( $main_menu_link_colors['color'] ) ) {
							$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-main-header .kinfw-main-nav > ul > li > a { color:'.$main_menu_link_colors['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $main_menu_link_colors['hover'] ) ) {
							$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-main-header .kinfw-main-nav > ul > li > a:hover { color:'.$main_menu_link_colors['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $main_menu_link_colors['active'] ) ) {
							$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-main-header .kinfw-main-nav > ul > li.current-menu-item > a, .kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-main-header .kinfw-main-nav > ul > li.current-menu-parent > a, .kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-main-header .kinfw-main-nav > ul > li.current-menu-ancestor > a { color:'.$main_menu_link_colors['active'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( isset( $header_style['sub_bg_color'] ) && !empty( $header_style['sub_bg_color'] ) ) {
							$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu { background-color:'.$header_style['sub_bg_color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						$submenu_link_colors = isset( $header_style['sub_menu_link_color'] ) ? $header_style['sub_menu_link_color'] : [];
						if( !empty( $submenu_link_colors['color'] ) ) {
							$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li a { color:'.$submenu_link_colors['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;

							$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li a:before { background:'.$submenu_link_colors['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $submenu_link_colors['hover'] ) ) {
							$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li a:hover { color:'.$submenu_link_colors['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;

							$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li a:before { background:'.$submenu_link_colors['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $submenu_link_colors['active'] ) ) {
							$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-item > a, .kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-parent > a, .kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-ancestor > a { color:'.$submenu_link_colors['active'].';}'.ONNAT_CONST_THEME_NEW_LINE;

							$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-item > a:before, .kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-parent > a:before, .kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-ancestor > a:before { background:'.$submenu_link_colors['active'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						/**
						 * Apply color for Sub menu hover link background
						 */
						if( !empty( $submenu_link_colors['focus'] ) ) {
							$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-main-header .kinfw-main-nav ul li > ul.sub-menu li a:hover { background-color:'.$submenu_link_colors['focus'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

					// Sticky Header
						if( isset( $header_style['sticky_height'] ) && !empty( $header_style['sticky_height'] ) ) {
							$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-sticky-header { height:'.$header_style['sticky_height'].'px;}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( isset( $header_style['sticky_bg_color'] ) && !empty( $header_style['sticky_bg_color'] ) ) {
							$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-sticky-header { background-color:'.$header_style['sticky_bg_color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						$sticky_main_menu_link_colors = isset( $header_style['sticky_main_menu_link_color'] ) ? $header_style['sticky_main_menu_link_color'] : [];
						if( !empty( $sticky_main_menu_link_colors['color'] ) ) {
							$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-sticky-header .kinfw-main-nav > ul > li > a  { color:'.$sticky_main_menu_link_colors['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $sticky_main_menu_link_colors['hover'] ) ) {
							$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-sticky-header .kinfw-main-nav > ul > li > a:hover { color:'.$sticky_main_menu_link_colors['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $sticky_main_menu_link_colors['active'] ) ) {
							$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-sticky-header .kinfw-main-nav > ul > li.current-menu-item > a, .kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-sticky-header .kinfw-main-nav > ul > li.current-menu-parent > a, .kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-sticky-header .kinfw-main-nav > ul > li.current-menu-ancestor > a { color:'.$sticky_main_menu_link_colors['active'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( isset( $header_style['sticky_sub_bg_color'] ) && !empty( $header_style['sticky_sub_bg_color'] ) ) {
							$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu { background-color:'.$header_style['sticky_sub_bg_color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						$sticky_submenu_link_colors = isset( $header_style['sticky_sub_menu_link_color'] ) ? $header_style['sticky_sub_menu_link_color'] : [];
						if( !empty( $sticky_submenu_link_colors['color'] ) ) {
							$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li a { color:'.$sticky_submenu_link_colors['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;

							$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li a:before { background:'.$sticky_submenu_link_colors['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $sticky_submenu_link_colors['hover'] ) ) {
							$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li a:hover { color:'.$sticky_submenu_link_colors['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;

							$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li a:before { background:'.$sticky_submenu_link_colors['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $sticky_submenu_link_colors['active'] ) ) {
							$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-item > a, .kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-parent > a, .kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-ancestor > a { color:'.$sticky_submenu_link_colors['active'].';}'.ONNAT_CONST_THEME_NEW_LINE;

							$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-item > a:before, .kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-parent > a:before, .kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li.current-menu-ancestor > a:before { background:'.$sticky_submenu_link_colors['active'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						/**
						 * Apply color for Sub menu hover link background
						 */
						if( !empty( $sticky_submenu_link_colors['focus'] ) ) {
							$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-sticky-header .kinfw-main-nav ul li > ul.sub-menu li a:hover { background-color:'.$sticky_submenu_link_colors['focus'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

					// Mobile Header
						if( isset( $header_style['mobile_height'] ) && !empty( $header_style['mobile_height'] ) ) {
							$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-mobile-header { height:'.$header_style['mobile_height'].'px; margin-bottom:-'.$header_style['mobile_height'].'px;}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( isset( $header_style['mobile_menu_bg_color'] ) && !empty( $header_style['mobile_menu_bg_color'] ) ) {
							$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-mobile-header .kinfw-mobile-menu,  #kinfw-mobile-header.kinfw-transparent-header-with-top-bar .kinfw-mobile-menu .sub-menu { background:'.$header_style['mobile_menu_bg_color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( isset( $header_style['mobile_border_color'] ) && !empty( $header_style['mobile_border_color'] ) ) {
							$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-mobile-header ul.kinfw-mobile-menu li { border-bottom-color:'.$header_style['mobile_border_color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						$mobile_menu_link_color = isset( $header_style['mobile_menu_link_color'] ) ? $header_style['mobile_menu_link_color'] : [];
						if( !empty( $mobile_menu_link_color['color'] ) ) {
							$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-mobile-header ul.kinfw-mobile-menu li a { color:'.$mobile_menu_link_color['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;

							$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-mobile-header ul.kinfw-mobile-menu li a:before { background:'.$mobile_menu_link_color['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

						if( !empty( $mobile_menu_link_color['hover'] ) ) {
							$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-mobile-header ul.kinfw-mobile-menu li a:hover { color:'.$mobile_menu_link_color['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;

							$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-mobile-header ul.kinfw-mobile-menu li a:before { background:'.$mobile_menu_link_color['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;

						}

						if( !empty( $mobile_menu_link_color['active'] ) ) {
							$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-mobile-header ul.kinfw-mobile-menu li.current-menu-item > a, .kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-mobile-header ul.kinfw-mobile-menu li.current-menu-parent > a, .kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-mobile-header ul.kinfw-mobile-menu li.current-menu-ancestor > a { color:'.$mobile_menu_link_color['active'].';}'.ONNAT_CONST_THEME_NEW_LINE;
						}

				}

            /**
             * Menu Typo
             */
				$menu_typo     = kinfw_onnat_theme_options()->kinfw_get_option( 'top_bar_transparent_header_main_menu_typo_size' );
				$size          = isset( $menu_typo['size'] ) ? $menu_typo['size'] : [];
				$menu_typo_css = kinfw_typo_opt_css( $size );

				if( isset( $menu_typo_css['css'] ) ) {
					$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar .kinfw-main-nav > ul > li > a {'.$menu_typo_css['css'].'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

				if( isset( $menu_typo_css['md_css'] ) ) {
					$tablet_responsive_css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar .kinfw-main-nav > ul > li > a {'.$menu_typo_css['md_css'].'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

				if( isset( $menu_typo_css['sm_css'] ) ) {
					$mobile_responsive_css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-mobile-header ul.kinfw-mobile-menu li a {'.$menu_typo_css['sm_css'].'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

			/**
			 * Sub Menu Typo
			 */
				$sub_menu_typo     = kinfw_onnat_theme_options()->kinfw_get_option( 'top_bar_transparent_header_sub_menu_typo_size' );
				$size              = isset( $sub_menu_typo['size'] ) ? $sub_menu_typo['size'] : [];
				$sub_menu_typo_css = kinfw_typo_opt_css( $size );

				if( isset( $sub_menu_typo_css['css'] ) ) {
					$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar .kinfw-main-nav ul li > ul.sub-menu li a {'.$sub_menu_typo_css['css'].'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

				if( isset( $sub_menu_typo_css['md_css'] ) ) {
					$tablet_responsive_css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar .kinfw-main-nav ul li > ul.sub-menu li a {'. $sub_menu_typo_css['md_css'] .'}'.ONNAT_CONST_THEME_NEW_LINE;
				}

			/**
			 * Header Actions
			 */
				$actions = kinfw_onnat_theme_options()->kinfw_get_option( 'top_bar_transparent_header_icons' );
				if( is_array( $actions ) ) {

					$header_icons_style  = kinfw_onnat_theme_options()->kinfw_get_option( 'top_bar_transparent_header_icons_style' );

					if( is_array( $header_icons_style ) ) {

						$header_icons_style = isset( $header_icons_style['style'] ) ? $header_icons_style['style'] : [];

						// Header
							if( !empty( $header_icons_style['size'] ) ) {
								$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-main-header .kinfw-header-group-action .kinfw-header-element { font-size: '.$header_icons_style['size'].'px;}'.ONNAT_CONST_THEME_NEW_LINE;
							}

							$header_icons_color = isset( $header_icons_style['color'] ) ? $header_icons_style['color'] : [];
							if( !empty( $header_icons_color['color'] ) ) {
								$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-main-header .kinfw-header-group-action .kinfw-header-element { color: '.$header_icons_color['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
							}

							if( !empty( $header_icons_color['hover'] ) ) {
								$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-main-header .kinfw-header-group-action .kinfw-header-element:hover { color: '.$header_icons_color['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;
							}

						// Sticky Header
							if( !empty( $header_icons_style['sticky_size'] ) ) {
								$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-sticky-header .kinfw-header-group-action .kinfw-header-element { font-size: '.$header_icons_style['sticky_size'].'px;}'.ONNAT_CONST_THEME_NEW_LINE;
							}

							$sticky_header_icons_color = isset( $header_icons_style['sticky_color'] ) ? $header_icons_style['sticky_color'] : [];

							if( !empty( $sticky_header_icons_color['color'] ) ) {
								$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-sticky-header .kinfw-header-group-action .kinfw-header-element { color: '.$sticky_header_icons_color['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
							}

							if( !empty( $sticky_header_icons_color['hover'] ) ) {
								$css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-sticky-header .kinfw-header-group-action .kinfw-header-element:hover { color: '.$sticky_header_icons_color['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;
							}

						// Mobile Header
							if( !empty( $header_icons_style['mobile_size'] ) ) {
								$mobile_responsive_css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-mobile-header .kinfw-mobile-navigation-trigger .kinfw-icon,  #kinfw-mobile-header .kinfw-header-group-action .kinfw-header-element { font-size:'.$header_icons_style['mobile_size'].'px;}'.ONNAT_CONST_THEME_NEW_LINE;
							}

							$mobile_header_icons_color = isset( $header_icons_style['mobile_color'] ) ? $header_icons_style['mobile_color'] : [];

							if( !empty( $mobile_header_icons_color['color'] ) ) {
								$mobile_responsive_css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-mobile-header .kinfw-mobile-navigation-trigger .kinfw-icon,  #kinfw-mobile-header .kinfw-header-group-action .kinfw-header-element { color:'.$mobile_header_icons_color['color'].';}'.ONNAT_CONST_THEME_NEW_LINE;
							}

							if( !empty( $mobile_header_icons_color['hover'] ) ) {
								$mobile_responsive_css .= '.kinfw-transparent-header.kinfw-transparent-header-with-top-bar #kinfw-mobile-header .kinfw-mobile-navigation-trigger .kinfw-icon:hover,  #kinfw-mobile-header .kinfw-header-group-action .kinfw-header-element:hover { color:'.$mobile_header_icons_color['hover'].';}'.ONNAT_CONST_THEME_NEW_LINE;
							}

					}

				}

			return [
				'css'    => $css,
				'tablet' => $tablet_responsive_css,
				'mobile' => $mobile_responsive_css
			];

		}

		/**
		 * Cascade Header inline css
		 */
		public function cascade_header() {
            $css                   = '';
            $tablet_responsive_css = '';
            $mobile_responsive_css = '';

            return [
                'css'    => $css,
                'tablet' => $tablet_responsive_css,
                'mobile' => $mobile_responsive_css
            ];
		}

    }

}

if( !function_exists( 'kinfw_onnat_theme_header' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_header() {

        return Onnat_Theme_Header::get_instance();
    }
}

kinfw_onnat_theme_header();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */