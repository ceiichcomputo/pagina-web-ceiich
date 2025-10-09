<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Page_Title' ) ) {

	/**
	 * The Onnat Theme page title ( breadcrumb ) hooks setup class.
	 */
    class Onnat_Theme_Page_Title {

		/**
		 * A reference to an instance of this class.
		 */
		private static $instance = null;

		private $labels = [];

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

            $this->labels = $this->labels();

            add_action( 'kinfw-action/theme/template/page-title', [ $this, 'breadcrumb' ] );

            do_action( 'kinfw-action/theme/page-title/loaded' );

        }

		public function labels() {
			$labels = apply_filters( 'kinfw-filter/theme/page-title/breaccrumb/labels', [
                'home'        => esc_html__( 'Home', 'onnat' ),
                'tag'         => esc_html__( 'Posts tagged "%s"', 'onnat' ),
                'author'      => esc_html__( 'Posted by %s', 'onnat' ),
                'search'      => esc_html__( 'Search results for "%s"', 'onnat' ),
                '404'         => esc_html__( '404 - Page not found', 'onnat' ),
                'query_paged' => esc_html__( ' (Page %s)', 'onnat' )
			] );
			return $labels;
		}

        public function breadcrumb() {

            if( is_singular('elementor_library') ) {
                return;
            }

			$settings = $this->get_settings();
			extract( $settings );

			if ( ( is_front_page() && !is_singular('page') ) && !$title_block ) {
				return;
			}

			if( $title_block || $breadcrumb_block ) {

                $classes   = implode( ' ', array_filter( $classes ) );
                $container = ( $use_full_width == true ) ? "kinfw-container-fluid" : "kinfw-container";


				printf('<!-- #kinfw-title-holder -->
					<div id="kinfw-title-holder" class="%1$s">
						<div class="%2$s">
							%3$s %4$s
						</div>
					</div><!-- /#kinfw-title-holder -->',
                    esc_attr( $classes ),
                    esc_attr( $container ),
					$this->title( $title_block, $title_tag ),
					$this->breadcrumbs( $breadcrumb_block ),
				);
			}
        }

        public function get_settings() {
			$settings = [];

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

            # 1. Front page = Latest posts
            if ( is_front_page() && !is_singular('page') ) {

            # 2. Posts Page
            } elseif ( is_home() && ! is_singular( 'page' ) ) {
				$post_id = get_option( 'page_for_posts', true );
				$meta    = get_post_meta( $post_id, ONNAT_CONST_THEME_PAGE_SETTINGS, true );

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
                            if( isset( $meta['page_title_overlay'] ) && $meta['page_title_overlay'] ) {
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

            # 3. Search || Archive || 404
            } elseif ( is_search() || is_archive() || is_404() ) {

            # 4. Post
            } elseif( is_singular('post') ) {

				$meta = get_post_meta( get_the_ID(), ONNAT_CONST_THEME_POST_SETTINGS, true );

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
                            if( isset( $meta['use_post_title_background' ] ) &&
                                $meta['use_post_title_background'] &&
                                isset( $meta['post_title_overlay'] ) &&
                                $meta['post_title_overlay'] )
                            {
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

            # 5. Page
            } elseif( is_singular('page') ) {
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
                            if ( isset( $meta['use_page_title_background'] ) && $meta['use_page_title_background'] ) {
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
                                isset( $meta['use_page_title_background'] ) &&
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

            }

            $background_css = kinfw_bg_opt_css( $bg_css );

            $css = '';
            if( !empty( $background_css ) ) {

                $css .=  '#kinfw-title-holder.kinfw-page-title-has-background { '. $background_css .' }';
            }

            if( !empty( $bg_overlay ) ) {

                $css .=  '#kinfw-title-holder:before { background-color:'. $bg_overlay .'; }';
            }

			$settings[ 'title_tag' ]        = $title_tag;
			$settings[ 'title_block' ]      = $title_block;
			$settings[ 'breadcrumb_block' ] = $breadcrumb_block;

            $settings[ 'classes' ]        = array_unique( $classes );
            $settings[ 'use_full_width']  = $use_full_width ? true : false;
            $settings[ 'css' ]            = !empty( $css ) ? $css : '';

			$settings = apply_filters( 'kinfw-filter/theme/page-title/settings', $settings );

			return $settings;
        }

		public function title( $title_block, $title_tag ) {

            if( !$title_block ) {
                return;
            }

            global $post;
            $title  = '';
			$return = '';

            # 1. Front page = Latest posts
			if ( is_front_page() && !is_singular('page') ) {

                $title = kinfw_onnat_theme_options()->kinfw_get_option( 'front_post_page_title' );

			# 2. Posts Page
			} elseif ( is_home() && ! is_singular( 'page' ) ) {

				$title = get_the_title( get_option( 'page_for_posts', true ) );

			# 3. Search
			} elseif ( is_search() ) {

                $title = kinfw_onnat_theme_options()->kinfw_get_option( 'search_title' );
                if( empty( $title ) ) {
                    $title = esc_html__('Search Results for:', 'onnat' );
                }

                $title = sprintf( esc_html__( '%1$s %2$s', 'onnat' ) , $title, get_search_query() );

            # 4. Archive
            } elseif ( is_archive() ) {

                $title = get_the_archive_title();

			# 5. 404
			} elseif ( is_404() ) {

                $title = kinfw_onnat_theme_options()->kinfw_get_option( '404_title' );

                if( empty( $title ) ) {
                    $title =   esc_html__( '404 - Page not found', 'onnat' );
                }

            } elseif( is_singular('post') ) {

				$title = get_the_title( $post->ID );
				$meta  = get_post_meta( get_the_ID(), ONNAT_CONST_THEME_POST_SETTINGS, true );

                if( isset( $meta['post_title'] ) ) {

                    if( 'theme_post_title' == $meta[ 'post_title' ] ) {

                        $post_title_type = kinfw_onnat_theme_options()->kinfw_get_option( 'single_post_page_title_type' );
                        if( $post_title_type === 'custom_txt' ) {
                            $title = kinfw_onnat_theme_options()->kinfw_get_option( 'single_post_page_title' );
                        }

                    } else if( 'custom_post_title' == $meta[ 'post_title' ] ) {
                        $post_title_type = $meta['single_post_page_title_type'];

                        if( $post_title_type === 'custom_post_title' ) {
                            $title = $meta[ 'single_post_page_title' ];
                        } else if( $post_title_type === 'theme_post_title' ) {
                            $post_title_type = kinfw_onnat_theme_options()->kinfw_get_option( 'single_post_page_title_type' );
                            if( $post_title_type === 'custom_txt' ) {
                                $title = kinfw_onnat_theme_options()->kinfw_get_option( 'single_post_page_title' );
                            }
                        }

                    }

                }

            } else {

                $title = get_the_title( $post->ID );

            }

			$title = apply_filters( 'kinfw-filter/theme/page-title', $title );

			if( !empty( $title ) ) {

				$return = sprintf('<!-- #kinfw-title-wrap -->
					<div id="kinfw-title-wrap">
						<%1$s>%2$s</%1$s>
					</div><!-- /#kinfw-title-wrap -->',
					$title_tag,
					$title
				);

			}

			return $return;

		}

		public function breadcrumbs( $breadcrumb_block ) {

            if( !$breadcrumb_block ) {
                return;
            }

			$return       = '';
			$breadcrumbs  = '';
			$labels       = $this->labels();
			$home_url     = esc_url( home_url( '/' ) );
			$link         = '<a class="kinfw-breadcrumbs-link" href="%1$s">' . '%2$s' . '</a>';
			$current_item = '<span class="kinfw-breadcrumbs-current">' . '%1$s' . '</span>';
			$separator    = sprintf(
                '<span class="kinfw-breadcrumbs-separator"> %1$s </span>',
                kinfw_onnat_theme_options()->kinfw_get_option( 'breadcrumb_separator' )
            );

			if( ! is_front_page() ) {

				if ( is_home() && ! is_singular( 'page' ) ) {

                    $breadcrumbs .= sprintf( $link, esc_url( $home_url ), $labels['home'] );
                    $breadcrumbs .= $separator;
                    $breadcrumbs .= sprintf( $current_item, get_the_title(  get_option( 'page_for_posts', true ) ) );

				} else {

                    $breadcrumbs .= sprintf( $link, esc_url( $home_url ), $labels[ 'home' ] );
                    $breadcrumbs .= $separator;

                    if ( is_tag() ) {

                        $breadcrumbs .= sprintf( $current_item, sprintf( $labels[ 'tag' ], single_tag_title( '', false ) ) );

                        if ( get_query_var( 'paged' ) ) {
                            $breadcrumbs .= sprintf( $current_item, sprintf( $labels['query_paged'], get_query_var( 'paged' ) ) );
                        }

                    } elseif ( is_day() ) {

                        $breadcrumbs .= sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ) );
                        $breadcrumbs .= $separator;

                        $breadcrumbs .= sprintf( $link, get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ), get_the_time( 'F' ) );
                        $breadcrumbs .= $separator;

                        $breadcrumbs .= sprintf( $current_item, get_the_time( 'd' ) );

                        if ( get_query_var( 'paged' ) ) {
                            $breadcrumbs .= sprintf( $current_item, sprintf( $labels['query_paged'], get_query_var( 'paged' ) ) );
                        }

                    } elseif ( is_month() ) {

                        $breadcrumbs .= sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ) );
                        $breadcrumbs .= $separator;

                        $breadcrumbs .= sprintf( $current_item, get_the_time( 'F' ) );

                        if ( get_query_var( 'paged' ) ) {
                            $breadcrumbs .= sprintf( $current_item, sprintf( $labels['query_paged'], get_query_var( 'paged' ) ) );
                        }

                    } elseif( is_year() ) {

                        $breadcrumbs .= sprintf( $current_item, get_the_time( 'Y' ) );

                        if ( get_query_var( 'paged' ) ) {
                            $breadcrumbs .= sprintf( $current_item, sprintf( $labels['query_paged'], get_query_var( 'paged' ) ) );
                        }

                    } elseif( is_author() ) {

                        $breadcrumbs .= sprintf( $current_item, sprintf( $labels[ 'author' ], get_the_author_meta( 'display_name', get_query_var( 'author' ) ) ) );

                        if ( get_query_var( 'paged' ) ) {
                            $breadcrumbs .= sprintf( $current_item, sprintf( $labels['query_paged'], get_query_var( 'paged' ) ) );
                        }

                    } elseif( is_category() ) {

                        $category = get_category( get_query_var( 'cat' ), false );

                        if ( isset( $category->parent ) && $category->parent !== 0 ) {

                            $breadcrumbs .= get_category_parents( $category->parent, true, $separator );
                        }

                        $breadcrumbs .= sprintf( $current_item, single_cat_title( '', false ) );

                        if ( get_query_var( 'paged' ) ) {
                            $breadcrumbs .= sprintf( $current_item, sprintf( $labels['query_paged'], get_query_var( 'paged' ) ) );
                        }

                    } elseif( is_search() ) {

                        $breadcrumbs .= sprintf( $current_item, sprintf( $labels[ 'search' ], get_search_query() ) );

                        if ( get_query_var( 'paged' ) ) {
                            $breadcrumbs .= sprintf( $current_item, sprintf( $labels['query_paged'], get_query_var( 'paged' ) ) );
                        }

                    } elseif( is_404() ) {

                        $breadcrumbs .= sprintf( $current_item, $labels[ '404' ] );

                    } elseif( is_singular( 'post' ) ) {

                        $category = get_the_category();
                        $breadcrumbs .= get_category_parents( $category[0], true, $separator );
                        $breadcrumbs .= sprintf( $current_item, get_the_title() );

                        if ( get_query_var( 'paged' ) ) {
                            $breadcrumbs .= sprintf( $current_item, sprintf( $labels['query_paged'], get_query_var( 'paged' ) ) );
                        }

                    } elseif ( is_page() ) {

                        global $post;

                        if ( $post->post_parent ) {

                            $parent_ids   = [];
                            $parent_ids[] = $post->post_parent;

                            foreach ( $parent_ids as $parent_id ) {

                                $breadcrumbs .= sprintf( $link, get_the_permalink( $parent_id ), get_the_title( $parent_id ) );
                                $breadcrumbs .= $separator;

                            }

                        }

                        $breadcrumbs .= apply_filters( 'kinfw-filter/theme/breadcrumbs/prefix', '', $link, $separator );
                        $breadcrumbs .= sprintf( $current_item, get_the_title() );

                        if ( get_query_var( 'paged' ) ) {
                            $breadcrumbs .= sprintf( $current_item, sprintf( $labels['query_paged'], get_query_var( 'paged' ) ) );
                        }

                    }

				}

			}

			$breadcrumbs = apply_filters( 'kinfw-filter/theme/breadcrumbs', $breadcrumbs, $labels, $link, $separator, $current_item  );

			if( !empty( $breadcrumbs ) ) {

				$return = sprintf('<!-- #kinfw-breadcrumb-wrap -->
					<div id="kinfw-breadcrumb-wrap">
						%1$s
					</div><!-- /#kinfw-breadcrumb-wrap -->',
					$breadcrumbs
				);

			}

			return $return;
		}
    }

}

if( !function_exists( 'kinfw_onnat_theme_page_title' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_page_title() {

        return Onnat_Theme_Page_Title::get_instance();
    }
}

kinfw_onnat_theme_page_title();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */