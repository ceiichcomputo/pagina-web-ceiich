<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Cascade_Header' ) ) {

	/**
	 * The Onnat Theme Standard Header with Top Bar setup class.
	 */
    class Onnat_Theme_Cascade_Header {

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

			if( 'header' === $args['header_type'] && 'cascade_header' === $args['header_id'] ) {

				$full_width = kinfw_onnat_theme_options()->kinfw_get_option( 'cascade_header_full_width');
				$actions    = kinfw_onnat_theme_options()->kinfw_get_option( 'cascade_header_icons' );

				$tpl_slug   = get_page_template_slug();
				$tpl_slugs  = apply_filters( 'kinfw-filter/theme/template/post-type/slugs', [] );
				$full_width = in_array( $tpl_slug, $tpl_slugs ) ? true : $full_width;

				printf( '<!-- #kinfw-masthead -->
                    <header id="kinfw-masthead" class="kinfw-cascade-header kinfw-cascade-header-with-top-bar">
                        %6$s
                        <div class="%1$s">
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
                    </header>',
                    $full_width ? "kinfw-container-fluid" : "kinfw-container",

					kinfw_onnat_theme_header()->logo_block(),
                    kinfw_onnat_theme_header()->menu_block( kinfw_onnat_theme_options()->kinfw_get_option( 'cascade_header_menu' ), 'lg' ),
					$this->actions_block( $actions ),
					$this->actions_forms( $actions ),

					$this->tob_bar(),

					kinfw_onnat_theme_header()->logo_block( 'logo_sticky' ),

					kinfw_onnat_theme_header()->logo_block( 'logo_mobile' ),
					kinfw_onnat_theme_header()->menu_block( kinfw_onnat_theme_options()->kinfw_get_option( 'cascade_header_menu' ), 'mobile' ),
                );
            }

        }

        public function tob_bar() {
			$use_top_bar = kinfw_onnat_theme_options()->kinfw_get_option( 'top_bar_cascade_header' );

			if( !$use_top_bar ) {
				return;
			}

            $bar = kinfw_onnat_theme_options()->kinfw_get_option('top_bar_cascade_header_top' );
            $bar = isset( $bar['bar'] ) ? array_filter( $bar['bar'] ) : null;

			if( !$bar ) {
                return;
            }

            $top_bar_1 = $top_bar_2 = '';

			/**
			 * Top Bar 1
			 */
            if( isset( $bar['social_menu'] ) && !empty( $bar['social_menu'] ) ) {

                $social_menu = wp_get_nav_menu_object( $bar['social_menu'] );

				if( $social_menu ) {

                    $social_menu_args = [
                        'menu'            => $social_menu,
                        'container'       => '',
                        'container_class' => '',
                        'fallback_cb'     => false,
                        'echo'            => false,
                        'menu_class'      => '',
                        'items_wrap'      => '<ul class="kinfw-social-links">%3$s</ul>',
                        'depth'           => 1,
                        'link_before'     => '<span class="kinfw-hidden">',
                        'link_after'      => '</span>',
                        'walker'          => new Onnat_Theme_Footer_Nav_Menu_Walker
                    ];

                    $top_bar_1 = call_user_func( 'wp_nav_menu', $social_menu_args );

                }

                if( !empty( $top_bar_1 ) ) {
                    $menu_title = '';
                    if( isset( $bar['social_menu_title'] ) && !empty( $bar['social_menu_title'] ) ) {
                        $menu_title = sprintf( '<span> %1$s </span>', $bar['social_menu_title'] );
                    }

					$top_bar_1 = sprintf( '
                        <div class="kinfw-top-bar-info-left"> %1$s %2$s </div>',
						$menu_title,
						$top_bar_1
					);
                }

            }

            /**
             * Top Bar 2
             */
            $phone = $email = $inline_address = '';
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

            if( isset( $bar['inline_address'] ) && !empty( $bar['inline_address'] ) ) {
                $inline_address = sprintf( '
                    <li>
                        %1$s %2$s
                    </li>',
                    kinfw_icon( 'misc-map-pin' ),
                    antispambot( $bar['inline_address'] )
                );
            }

            if( !empty( $phone ) || !empty( $email ) || !empty( $inline_address ) ) {
                $top_bar_2 = sprintf( '
                    <div class="kinfw-top-bar-info-right">
                        <ul class="kinfw-top-bar-content">
                            %1$s %2$s %3$s
                        </ul>
                    </div>',
                    $phone,
                    $email,
                    $inline_address
                );
            }

			if( !empty( $top_bar_1 ) || !empty( $top_bar_2 ) ) {
				$full_width = kinfw_onnat_theme_options()->kinfw_get_option( 'cascade_header_full_width');

				$tpl_slug   = get_page_template_slug();
				$tpl_slugs  = apply_filters( 'kinfw-filter/theme/template/post-type/slugs', [] );
				$full_width = in_array( $tpl_slug, $tpl_slugs ) ? true : $full_width;

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

                            case 'button':
                                $btn_settings = kinfw_onnat_theme_options()->kinfw_get_option( 'cascade_header_icon_button' );
                                if( isset( $btn_settings['url'] ) && isset( $btn_settings['text'] ) ) {
                                    $return .= sprintf('
                                        <a href="%1$s" class="kinfw-ripple-button kinfw-header-button" %3$s>
                                            <span class="kinfw-ripple-button-txt">%2$s</span>
                                            <span class="kinfw-ripple-button-hover"></span>
                                        </a>',
                                        $btn_settings['url'],
                                        $btn_settings['text'],
                                        isset( $btn_settings['target'] ) ? sprintf( 'target="%1$s"', $btn_settings['target'] ) : ''
                                    );
                                }
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

                    case 'hamburger-button':
                        add_action( 'wp_footer', function(){
                            $page_id = kinfw_onnat_theme_options()->kinfw_get_option( 'cascade_header_icon_hamburger_button' );
                            $template = kinfw_elementor_doc_content( $page_id );

                            if( !empty( $template ) ) {
                                get_template_part( 'header-templates/hamburger/hamburger', '', [ 'content' => $template ] );
                            }
                        }, -1 );
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

if( !function_exists( 'kinfw_onnat_theme_cascade_header' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_cascade_header( $args ) {

        return Onnat_Theme_Cascade_Header::get_instance( $args );
    }
}

kinfw_onnat_theme_cascade_header( $args );

/* Omit closing PHP tag to avoid "Headers already sent" issues. */