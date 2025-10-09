<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Standard_Footer' ) ) {

	/**
	 * The Onnat Theme Standard Footer setup class.
	 */
    class Onnat_Theme_Standard_Footer {

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

			if( 'footer' === $args['footer_type'] && 'standard_footer' === $args['footer_id'] ) {

				printf( '<!-- #kinfw-footer -->
					<footer id="kinfw-footer" class="kinfw-std-footer">
						%1$s %2$s
					</footer> <!-- /#kinfw-footer -->',
					$this->widgets_area_block(),
					$this->bottom_block()
				);

			}
        }

		public function widgets_area_block() {

			$cols = kinfw_onnat_theme_options()->kinfw_get_option( 'standard_footer_column' );

			if( empty( $cols ) ) {
				return;
			}

			$return   = '';
			$sections = '';
			$cols     = explode("#", $cols );

			foreach( $cols as $key => $col ) {

				$widget_area = kinfw_onnat_theme_options()->kinfw_get_option( 'standard_footer_section_'.$key );
				$widget_area = $this->widget_areas( $widget_area );

				if( !empty( $widget_area ) ) {

					$sections .= sprintf( '<div class="%1$s">%2$s</div>',
						esc_attr( $col ),
						$widget_area
					);
				}

			}

			if( empty( $sections ) ) {
				return;
			}

			$full_width = kinfw_onnat_theme_options()->kinfw_get_option( 'standard_footer_full_width' );

			$tpl_slug   = get_page_template_slug();
			$tpl_slugs  = apply_filters( 'kinfw-filter/theme/template/post-type/slugs', [] );
			$full_width = in_array( $tpl_slug, $tpl_slugs  )  ?  true : $full_width;

			$return = sprintf( '<!-- #kinfw-footer-widgets -->
				<div id="kinfw-footer-widgets" class="%1$s">
					<div class="%2$s">
						<div class="kinfw-row">%3$s</div>
					</div>
				</div><!-- /#kinfw-footer-widgets -->',
				kinfw_onnat_theme_options()->kinfw_get_option( 'use_standard_footer_background' ) ? "kinfw-footer-has-background" : '',
                $full_width ? "kinfw-container-fluid" : "kinfw-container",
				$sections
			);

			return $return;

		}

		public function bottom_block() {

			$use_block = kinfw_onnat_theme_options()->kinfw_get_option( 'use_standard_footer_bottom_block' );
			$block     = kinfw_onnat_theme_options()->kinfw_get_option( 'standard_footer_bottom_block' );

			if( !$use_block || empty( $block ) ) {
				return;
			}

			$return   = '';
			$sections = '';

			$alignment = kinfw_onnat_theme_options()->kinfw_get_option( 'standard_footer_bottom_alignment' );
			$copyright = $this->copyright( kinfw_onnat_theme_options()->kinfw_get_option( 'standard_footer_copyright' ) );
			$menu      = $this->footer_menu( kinfw_onnat_theme_options()->kinfw_get_option( 'standard_footer_bottom_menu' ) );

			if( $block == 'copyright' && !empty( $copyright ) ) {

				$sections .= sprintf( '<div class="kinfw-col-12 %1$s">%2$s</div>', $alignment, $copyright );

			} elseif( $block == 'menu' && !empty( $menu ) ) {

				$sections .= sprintf( '<div class="kinfw-col-12 %1$s">%2$s</div>', $alignment, $menu );

			} elseif( $block == 'copyright+menu' || $block == 'menu+copyright' ) {

				$alignment = kinfw_onnat_theme_options()->kinfw_get_option( 'standard_footer_bottom_alignment_alt' );

				if( !empty( $copyright ) && !empty( $menu ) ) {

					if( $block == 'copyright+menu' ) {

						$class = '';
						if( $alignment == 'align-left' ) {
							$class = 'kinfw-footer-socket-align-left';
						} elseif( $alignment == 'align-center' ) {
							$class = 'kinfw-footer-socket-align-center';
						} elseif( $alignment == 'align-right' ) {
							$class = 'kinfw-footer-socket-align-right';
						} elseif( $alignment == 'align-split' ) {
							$class = 'kinfw-col-sm-6';
						}

						$sections .= sprintf('
							<div class="kinfw-col-12 %1$s">%2$s</div>
							<div class="kinfw-col-12 %1$s">%3$s</div>',
							$class,$copyright,$menu
						);
					} elseif(  $block == 'menu+copyright' ) {

						$class = '';
						if( $alignment == 'align-left' ) {
							$class = 'kinfw-footer-socket-align-left';
						} elseif( $alignment == 'align-center' ) {
							$class = 'kinfw-footer-socket-align-center';
						} elseif( $alignment == 'align-right' ) {
							$class = 'kinfw-footer-socket-align-right';
						} elseif( $alignment == 'align-split' ) {
							$class = 'kinfw-col-sm-6';
						}

						$sections .= sprintf('
							<div class="kinfw-col-12 %1$s">%2$s</div>
							<div class="kinfw-col-12 %1$s">%3$s</div>',
							$class,$menu,$copyright
						);

					}

				} else {

					$item = '';
					$class = '';

					if( !empty( $copyright ) ) {
						$item = $copyright;
					}

					if( !empty( $menu ) ) {
						$item = $menu;
					}

					if( $alignment == 'align-left' ) {
						$class = 'align-left';
					} elseif( $alignment == 'align-center' || $alignment == 'align-split' ) {
						$class = 'align-center';
					} elseif( $alignment == 'align-right' ) {
						$class = 'align-right';
					}

					if( !empty( $class ) && !empty( $item ) ) {
						$sections .= sprintf( '<div class="kinfw-col-12 %1$s">%2$s</div>', $class, $item );
					}
				}

			}

			if( empty( $sections ) ) {
				return;
			}

			$full_width = kinfw_onnat_theme_options()->kinfw_get_option( 'standard_footer_bottom_full_width' );

			$return = sprintf( '<!-- #kinfw-footer-socket -->
				<div id="kinfw-footer-socket" class="%1$s">
					<div class="%2$s">
						<div class="kinfw-row">%3$s</div>
					</div>
				</div><!-- /#kinfw-footer-socket -->',
				kinfw_onnat_theme_options()->kinfw_get_option( 'use_standard_footer_bottom_background' ) ? "kinfw-footer-socket-has-background" : '',
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

if( !function_exists( 'kinfw_onnat_theme_standard_footer' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_standard_footer( $args ) {

        return Onnat_Theme_Standard_Footer::get_instance( $args );
    }
}

kinfw_onnat_theme_standard_footer( $args );

/* Omit closing PHP tag to avoid "Headers already sent" issues. */