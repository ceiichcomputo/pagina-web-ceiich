<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Transparent_Header' ) ) {

	/**
	 * The Onnat Theme Standard Header setup class.
	 */
    class Onnat_Theme_Transparent_Header {

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

			if( 'header' === $args['header_type'] && 'transparent_header' === $args['header_id'] ) {

				$full_width = kinfw_onnat_theme_options()->kinfw_get_option( 'transparent_header_full_width' );
				$actions    = kinfw_onnat_theme_options()->kinfw_get_option( 'transparent_header_icons' );

				$tpl_slug   = get_page_template_slug();
				$tpl_slugs  = apply_filters( 'kinfw-filter/theme/template/post-type/slugs', [] );
				$full_width = in_array( $tpl_slug, $tpl_slugs  )  ?  true : $full_width;

				printf( '<!-- #kinfw-masthead -->
					<header id="kinfw-masthead" class="kinfw-transparent-header">
						<div class="%1$s">
							%5$s
							<div id="kinfw-main-header" class="hide-on-lg hide-on-md hide-on-sm hide-on-xs">
								%2$s %3$s %4$s
							</div>
							<div id="kinfw-sticky-header" class="hide-on-lg hide-on-md hide-on-sm hide-on-xs">
								%6$s %3$s %4$s
							</div>
							<div id="kinfw-mobile-header" class="hide-on-xl visible-on-lg visible-on-md visible-on-sm visible-on-xs">
								%7$s %8$s %4$s
							</div>
						</div>
					</header><!-- /#kinfw-masthead -->',
					$full_width ? "kinfw-container-fluid" : "kinfw-container",
					kinfw_onnat_theme_header()->logo_block(),
					kinfw_onnat_theme_header()->menu_block( kinfw_onnat_theme_options()->kinfw_get_option( 'transparent_header_menu' ), 'lg' ),
					kinfw_onnat_theme_header()->actions_block( $actions ),
					$this->actions_forms( $actions ),

					kinfw_onnat_theme_header()->logo_block( 'logo_sticky' ),

					kinfw_onnat_theme_header()->logo_block( 'logo_mobile' ),
					kinfw_onnat_theme_header()->menu_block( kinfw_onnat_theme_options()->kinfw_get_option( 'transparent_header_menu' ), 'mobile' ),
				);

			}

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

					case 'hamburger-button':
						add_action( 'wp_footer', function(){
							$page_id = kinfw_onnat_theme_options()->kinfw_get_option( 'transparent_header_icon_hamburger_button' );
							$template = kinfw_elementor_doc_content( $page_id );

							if( !empty( $template ) ) {
								get_template_part( 'header-templates/hamburger/hamburger', '', [ 'content' => $template ] );
							}
						}, -1);

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
    }
}

if( !function_exists( 'kinfw_onnat_theme_transparent_header' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_transparent_header( $args ) {

        return Onnat_Theme_Transparent_Header::get_instance( $args );
    }
}

kinfw_onnat_theme_transparent_header( $args );

/* Omit closing PHP tag to avoid "Headers already sent" issues. */