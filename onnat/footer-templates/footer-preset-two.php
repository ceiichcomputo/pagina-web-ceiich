<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Footer_Preset_Two' ) ) {

	/**
	 * The Onnat Theme Footer Preset Two setup class.
	 */
    class Onnat_Theme_Footer_Preset_Two {

		/**
		 * A reference to an instance of this class.
		 */
		private static $instance = null;

		/**
		 * Returns the instance.
		 */
		public static function get_instance( $args ) {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self( $args );
            }

			return self::$instance;

		}

		/**
		 * Constructor
		 */
        public function __construct( $args ) {
            $this->build( $args );
        }

        public function build( $args ) {

			if( 'footer' === $args['footer_type'] && 'footer_preset_two' === $args['footer_id'] ) {

				printf( '<!-- #kinfw-footer -->
					<footer id="kinfw-footer" class="kinfw-footer-preset-two">
						%1$s %2$s
					</footer> <!-- /#kinfw-footer -->',
					$this->widgets_area_block(),
					$this->bottom_block()
				);
            }

        }

		public function widgets_area_block() {

            $return      = '';
            $cols        = kinfw_onnat_theme_options()->kinfw_get_option( 'footer_2_column' );
            $social_menu = kinfw_onnat_theme_options()->kinfw_get_option( 'footer_2_social_menu' );

			if( !empty( $cols ) || !empty( $social_menu ) ) {

				$col_sections = '';

				if( !empty( $cols ) ) {

					$cols = explode("#", $cols );

					foreach( $cols as $key => $col ) {

						$widget_area = kinfw_onnat_theme_options()->kinfw_get_option( 'footer_2_section_'.$key );

						$col_sections .= sprintf( '<div class="%1$s">%2$s</div>',
                            esc_attr( $col ),
                            $this->widget_areas( $widget_area )
                        );

					}

					if( !empty( $col_sections ) ) {

						$col_sections = sprintf( '<div class="kinfw-row">%1$s</div>', $col_sections);
					}

				}

				if( !empty( $social_menu ) ) {

					$social_nav_menu = wp_get_nav_menu_object( $social_menu );

					if( $social_nav_menu ) {

						$social_nav_menu_args = [
							'menu'            => $social_nav_menu,
							'container'       => 'div',
							'container_class' => 'kinfw-social-menu kinfw-footer-social',
							'fallback_cb'     => false,
							'echo'            => false,
							'menu_class'      => '',
							'items_wrap'      => '<ul class="kinfw-social-links">%3$s</ul>',
							'depth'           => 1,
							'link_before'     => '<span class="kinfw-hidden">',
							'link_after'      => '</span>',
							'walker'          => new Onnat_Theme_Footer_Nav_Menu_Walker
						];

						$social_menu = sprintf( '<div class="kinfw-row"> <div class="kinfw-col-12 kinfw-align-center">%1$s</div> </div>', call_user_func( 'wp_nav_menu', $social_nav_menu_args ) );

					}

				}

				if( !empty( $col_sections ) || !empty( $social_menu ) ) {

					$full_width = kinfw_onnat_theme_options()->kinfw_get_option( 'footer_2_full_width' );

					$tpl_slug   = get_page_template_slug();
					$tpl_slugs  = apply_filters( 'kinfw-filter/theme/template/post-type/slugs', [] );
					$full_width = in_array( $tpl_slug, $tpl_slugs  )  ?  true : $full_width;		

					$return = sprintf( '<!-- #kinfw-footer-widgets -->
						<div id="kinfw-footer-widgets" class="%1$s">
							<div class="%2$s">
								%3$s %4$s
							</div>
						</div><!-- /#kinfw-footer-widgets -->',
						kinfw_onnat_theme_options()->kinfw_get_option( 'use_footer_2_background' ) ? "kinfw-footer-has-background" : '',
						$full_width ? "kinfw-container-fluid" : "kinfw-container",
						$col_sections,
						$social_menu
					);

				}

			}

			return $return;

		}

		public function bottom_block() {

			$use_block   = kinfw_onnat_theme_options()->kinfw_get_option( 'use_footer_2_bottom_block' );
			$block       = kinfw_onnat_theme_options()->kinfw_get_option( 'footer_2_bottom_block' );

			if( !$use_block || empty( $block ) ) {
				return;
			}

			$return   = '';
			$sections = '';

			$copyright = $this->copyright( kinfw_onnat_theme_options()->kinfw_get_option( 'footer_2_copyright' ) );
			$menu      = $this->footer_menu( kinfw_onnat_theme_options()->kinfw_get_option( 'footer_2_bottom_menu' ) );

            $copyright = !empty( $copyright ) ? sprintf( '<div class="kinfw-col-12 kinfw-align-center">%1$s</div>', $copyright ) : '';
            $menu      = !empty( $menu ) ? sprintf( '<div class="kinfw-col-12 kinfw-align-center">%1$s</div>', $menu ) : '';

			if( $block == 'copyright' ) {

                $sections .= $copyright;

			} elseif( $block == 'menu' ) {

                $sections .= $menu;
			} elseif( $block == 'copyright+menu' ) {

				$sections .= $copyright . $menu;
			} elseif( $block == 'menu+copyright' ) {

				$sections .= $menu . $copyright;
			}

			if( empty( $sections ) ) {
				return;
			}

			$full_width = kinfw_onnat_theme_options()->kinfw_get_option( 'footer_2_bottom_full_width' );

			$tpl_slug   = get_page_template_slug();
			$tpl_slugs  = apply_filters( 'kinfw-filter/theme/template/post-type/slugs', [] );
			$full_width = in_array( $tpl_slug, $tpl_slugs  )  ?  true : $full_width;

			$return = sprintf( '<!-- #kinfw-footer-socket -->
				<div id="kinfw-footer-socket" class="%1$s">
					<div class="%2$s">
						<div class="kinfw-row">%3$s</div>
					</div>
				</div><!-- /#kinfw-footer-socket -->',
				kinfw_onnat_theme_options()->kinfw_get_option( 'use_footer_2_bottom_background' ) ? "kinfw-footer-socket-has-background" : '',
                $full_width ? "kinfw-container-fluid" : "kinfw-container",
				$sections
			);

			return $return;

		}

		public function widget_areas( $ids ) {

			if( !is_array( $ids ) ){
				return;
			}

			ob_start();
			foreach( $ids as $id ) {
				dynamic_sidebar( $id );
			}

			$widget_area = ob_get_contents();
			ob_end_clean();

			return $widget_area;
		}

		public function copyright( $copyright ) {

			if( !empty( $copyright ) ) {

				return sprintf( '<div id="kinfw-copyright">%1$s</div>',$copyright );
			}

			return;
		}

		public function footer_menu( $menu_id ) {

			if( !empty( $menu_id ) ) {

				$nav_menu = wp_get_nav_menu_object( $menu_id );

				if( !$nav_menu ) {
					return;
				}
				
				$nav_menu_args = [
					'menu'           => $nav_menu,
					'container'      => '',
					'fallback_cb'    => false,
					'echo'           => false,
					'menu_class'     => '',
					'items_wrap'     => '<ul>%3$s</ul>',
					'depth'          => 1,
					'walker'         => new Onnat_Theme_Footer_Nav_Menu_Walker
				];

				return sprintf( '<div id="kinfw-footer-menu">%1$s</div>', call_user_func( 'wp_nav_menu', $nav_menu_args ) );

			}

			return;
		}

    }
}

if( !function_exists( 'kinfw_onnat_theme_footer_preset_two' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_footer_preset_two( $args ) {

        return Onnat_Theme_Footer_Preset_Two::get_instance( $args );
    }
}

kinfw_onnat_theme_footer_preset_two( $args );

/* Omit closing PHP tag to avoid "Headers already sent" issues. */