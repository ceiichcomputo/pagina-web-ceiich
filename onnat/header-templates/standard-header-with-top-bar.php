<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Standard_Header_Top_Bar' ) ) {

	/**
	 * The Onnat Theme Standard Header with Top Bar setup class.
	 */
    class Onnat_Theme_Standard_Header_Top_Bar {

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

			if( 'header' === $args['header_type'] && 'top_bar_standard_header' === $args['header_id'] ) {

				$full_width = kinfw_onnat_theme_options()->kinfw_get_option( 'top_bar_standard_header_full_width');
				$actions    = kinfw_onnat_theme_options()->kinfw_get_option( 'top_bar_standard_header_icons' );

				$tpl_slug   = get_page_template_slug();
				$tpl_slugs  = apply_filters( 'kinfw-filter/theme/template/post-type/slugs', [] );
				$full_width = in_array( $tpl_slug, $tpl_slugs  )  ?  true : $full_width;

				printf( '<!-- #kinfw-masthead -->
					<header id="kinfw-masthead" class="kinfw-std-header kinfw-std-header-with-top-bar">
						%6$s

						<div class="%1$s">
							%5$s
							<div id="kinfw-main-header" class="hide-on-lg hide-on-md hide-on-sm hide-on-xs">
								%2$s %3$s %4$s
							</div>
							<div id="kinfw-sticky-header" class="hide-on-lg hide-on-md hide-on-sm hide-on-xs">
								%7$s %3$s %4$s
							</div>
							<div id="kinfw-mobile-header" class="hide-on-xl visible-on-lg visible-on-md visible-on-sm visible-on-xs">
								%8$s %9$s %4$s
							</div>
						</div>
					</header><!-- /#kinfw-masthead -->',
					$full_width ? "kinfw-container-fluid" : "kinfw-container",
					kinfw_onnat_theme_header()->logo_block(),
					kinfw_onnat_theme_header()->menu_block( kinfw_onnat_theme_options()->kinfw_get_option( 'top_bar_standard_header_menu' ), 'lg' ),
					kinfw_onnat_theme_header()->actions_block( $actions ),
					$this->actions_forms( $actions ),
					$this->tob_bar(),

					kinfw_onnat_theme_header()->logo_block( 'logo_sticky' ),

					kinfw_onnat_theme_header()->logo_block( 'logo_mobile' ),
					kinfw_onnat_theme_header()->menu_block( kinfw_onnat_theme_options()->kinfw_get_option( 'top_bar_standard_header_menu' ), 'mobile' ),

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
							$page_id = kinfw_onnat_theme_options()->kinfw_get_option( 'top_bar_standard_header_icon_hamburger_button' );
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

		public function tob_bar() {

			$use_top_bar = kinfw_onnat_theme_options()->kinfw_get_option( 'top_bar_standard_header');

			if( !$use_top_bar ) {
				return;
			}

            $bar = kinfw_onnat_theme_options()->kinfw_get_option('top_bar_standard_header_top' );
            $bar =  isset( $bar['bar'] ) ? $bar['bar'] : null;

			if( !$bar ) {
                return;
            }

			$top_bar_1 = $top_bar_2 = '';

			/**
			 * Top Bar 1
			 */
				if( isset( $bar['phone_no'] ) && !empty( $bar['phone_no'] ) ) {

					$cleaned_phone_number   = preg_replace('/\D/', '', $bar['phone_no']);
					$formatted_phone_number = preg_replace('/^(\d{3})(\d{2})(\d{4})$/', '$1-$2-$3', $cleaned_phone_number);

					$phone = sprintf( '
						<li>
							%1$s
							<a href="tel:%2$s">%3$s</a>
						</li>',
						kinfw_icon( 'misc-phone-call' ),
						$formatted_phone_number,
						$bar['phone_no'],
					);
				}

				if( isset( $bar['email_id'] ) && !empty( $bar['email_id'] ) ) {
                    $email = sprintf( '
						<li>
							%1$s
							<a href="mailto:%2$s">%2$s</a>
						</li>',
						kinfw_icon( 'misc-mail' ),
						antispambot( $bar['email_id'] )
					);
                }

				if( !empty( $phone ) || !empty( $email ) ) {
					$top_bar_1 = sprintf( '
						<div class="kinfw-top-bar-info-left">
							<ul class="kinfw-top-bar-content">
								%1$s %2$s
							</ul>
						</div>',
						$phone,
						$email
					);
				}

			/**
			 * Top Bar 2
			 */
				if( isset( $bar['social_menu'] ) && !empty( $bar['social_menu'] ) ) {

					$social_menu = wp_get_nav_menu_object( $bar['social_menu'] );

					if( $social_menu ) {

						$social_menu_args = [
							'menu'            => $social_menu,
							'container'       => 'div',
							'container_class' => 'kinfw-top-bar-info-right',
							'fallback_cb'     => false,
							'echo'            => false,
							'menu_class'      => '',
							'items_wrap'      => '<ul class="kinfw-social-links">%3$s</ul>',
							'depth'           => 1,
							'link_before'     => '<span class="kinfw-hidden">',
							'link_after'      => '</span>',
							'walker'          => new Onnat_Theme_Footer_Nav_Menu_Walker,	
						];

						$top_bar_2 = call_user_func( 'wp_nav_menu', $social_menu_args );
					}

				}

			if( !empty( $top_bar_1 ) || !empty( $top_bar_2 ) ) {

				$full_width = kinfw_onnat_theme_options()->kinfw_get_option( 'top_bar_standard_header_full_width');

				$tpl_slug   = get_page_template_slug();
				$tpl_slugs  = apply_filters( 'kinfw-filter/theme/template/post-type/slugs', [] );
				$full_width = in_array( $tpl_slug, $tpl_slugs  )  ?  true : $full_width;

				$return = sprintf('<!-- #kinfw-top-bar -->
					<div id="kinfw-top-bar">
						<div class="%1$s">
							<div class="kinfw-top-bar-info">
								%2$s %3$s
							</div>
						</div>
					</div> <!-- #kinfw-top-bar -->',
					$full_width ? "kinfw-container-fluid" : "kinfw-container",
					$top_bar_1,
					$top_bar_2
				);

				return $return;
			}

		}
    }
}

if( !function_exists( 'kinfw_onnat_theme_standard_header_top_bar' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_standard_header_top_bar( $args ) {

        return Onnat_Theme_Standard_Header_Top_Bar::get_instance( $args );
    }
}

kinfw_onnat_theme_standard_header_top_bar( $args );
/* Omit closing PHP tag to avoid "Headers already sent" issues. */