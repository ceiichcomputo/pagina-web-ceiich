<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Scripts' ) ) {

	/**
	 * The Onnat Theme basic scripts setup class.
	 */
    class Onnat_Theme_Scripts {

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

            add_action( 'wp_enqueue_scripts', [ $this, 'register_scripts' ], 9  );
            add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
            add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_theme_script' ], 900 );

            do_action( 'kinfw-action/theme/scripts/loaded' );

        }

        /**
         * Register scripts.
         */
        public function register_scripts() {

            $localize = [
                'ajax'      => esc_url( admin_url('admin-ajax.php') ),
                'scrollBar' => 'false',
            ];

            $cursor = kinfw_onnat_theme_options()->kinfw_get_option( 'cursor' );
            if( $cursor ) {
                $localize['cursorStyle']        = kinfw_onnat_theme_options()->kinfw_get_option( 'cursor_style' );
                $localize['defaultCursorColor'] = kinfw_onnat_theme_options()->kinfw_get_option( 'cursor_color' );
                $localize['defaultCursorSize']  = 'kinfw-cursor-sm-size';
            }

            $loader = kinfw_onnat_theme_options()->kinfw_get_option( 'loader' );
            if( $loader ) {
                $localize['loaderTimeOut'] = kinfw_onnat_theme_options()->kinfw_get_option( 'loader_timeout' );
            }

            $scroll_bar = kinfw_onnat_theme_options()->kinfw_get_option( 'scroll_bar' );
            if( $scroll_bar ) {

                $auto_hide =kinfw_onnat_theme_options()->kinfw_get_option( 'scroll_auto_hide' );

                $localize[ 'scrollBar' ]         = 'true';
                $localize[ 'scrollBarAutoHide' ] = $auto_hide ? 'false' : 'true';

                wp_register_script( 'smooth-scrollbar',
                    get_theme_file_uri( 'assets/js/smooth-scrollbar.min.js'  ),
                    [ 'jquery' ],
                    ONNAT_CONST_THEME_VERSION,
                    true
                );
            }

            if ( ! wp_script_is( 'kfw-gsap', 'enqueued' ) ) {
                wp_register_script( 'kfw-gsap',
                    get_theme_file_uri( 'assets/js/gsap.min.js'  ),
                    [ 'jquery' ],
                    ONNAT_CONST_THEME_VERSION,
                    true
                );
            }

            if ( ! wp_script_is( 'kfw-gsap-scroll-trigger', 'enqueued' ) ) {
                wp_register_script( 'kfw-gsap-scroll-trigger',
                    get_theme_file_uri( 'assets/js/ScrollTrigger.min.js'  ),
                    [ 'jquery', 'kfw-gsap' ],
                    ONNAT_CONST_THEME_VERSION,
                    true
                );
            }

            if ( ! wp_script_is( 'kfw-gsap-scroll-smoother', 'enqueued' ) ) {
                wp_register_script( 'kfw-gsap-scroll-smoother',
                    get_theme_file_uri( 'assets/js/ScrollSmoother.min.js'  ),
                    [ 'jquery', 'kfw-gsap', 'kfw-gsap-scroll-trigger' ],
                    ONNAT_CONST_THEME_VERSION,
                    true
                );
            }            

            if ( ! wp_script_is( 'fitvids', 'enqueued' ) ) {
                wp_register_script( 'fitvids',
                    get_theme_file_uri( 'assets/js/fitvids.min.js'  ),
                    [ 'jquery' ],
                    ONNAT_CONST_THEME_VERSION,
                    true
                );
            }

            if ( ! wp_script_is( 'swiper', 'enqueued' ) ) {
                if ( defined( 'ELEMENTOR_VERSION' ) ) {
                    wp_register_script( 'swiper',
                        plugins_url( 'elementor' ) . '/assets/lib/swiper/v8/swiper.min.js',
                        [],
                        ONNAT_CONST_THEME_VERSION,
                        true
                    );
                } else {
                    wp_register_script( 'swiper',
                        get_theme_file_uri( 'assets/js/swiper.min.js'  ),
                        [ 'jquery' ],
                        ONNAT_CONST_THEME_VERSION,
                        true
                    );
                }
            }

            if ( ! wp_script_is( 'jquery-magnific-popup', 'enqueued' ) ) {
                wp_register_script( 'jquery-magnific-popup',
                    get_theme_file_uri( 'assets/js/jquery.magnific-popup.min.js'  ),
                    [ 'jquery' ],
                    ONNAT_CONST_THEME_VERSION,
                    true
                );
            }

            if ( ! wp_script_is( 'jquery-select2', 'enqueued' ) ) {
                wp_register_script( 'jquery-select2',
                    get_theme_file_uri( 'assets/js/select2.min.js'  ),
                    [ 'jquery' ],
                    ONNAT_CONST_THEME_VERSION,
                    true
                );
            }

            if ( ! wp_script_is( 'jquery-tooltipster', 'enqueued' ) ) {
                wp_register_script( 'jquery-tooltipster',
                    get_theme_file_uri( 'assets/js/tooltipster.min.js'  ),
                    [],
                    ONNAT_CONST_THEME_VERSION,
                    true
                );
            }

            wp_register_script( 'kinfw-onnat-theme-script',
                get_theme_file_uri( 'assets/js/function' . ONNAT_CONST_THEME_DEBUG_SUFFIX . '.js'  ),
                [ 'jquery', 'jquery-ui-tabs' ],
                ONNAT_CONST_THEME_VERSION,
                true
            );

            wp_localize_script( 'jquery', 'KIN_FW_ONNAT_OBJ', [
                'theme'       => ONNAT_CONST_THEME,
                'themeAuthor' => ONNAT_CONST_THEME_AUTHOR
            ] );

            wp_localize_script( 'jquery', 'kinfw_onnat_L10n', apply_filters( 'kinfw-filter/theme/L10n', $localize ) );

        }

        /**
         * Enqueue scripts.
         */
        public function enqueue_scripts() {

            if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {

                wp_enqueue_script( 'comment-reply' );

            }

            $scroll_bar = kinfw_onnat_theme_options()->kinfw_get_option( 'scroll_bar' );
            if( $scroll_bar ) {

                wp_enqueue_script( 'smooth-scrollbar' );

            }

            wp_enqueue_script( 'kfw-gsap' );
            wp_enqueue_script( 'kfw-gsap-scroll-trigger' );
            wp_enqueue_script( 'kfw-gsap-scroll-smoother' );
            wp_enqueue_script( 'fitvids' );
            wp_enqueue_script( 'swiper' );
            wp_enqueue_script( 'jquery-magnific-popup' );
            wp_enqueue_script( 'jquery-select2' );
            wp_enqueue_script( 'jquery-tooltipster' );

        }

        /**
         * Enqueue theme script ( function.min.js ).
         */
        public function enqueue_theme_script() {

            wp_enqueue_script( 'kinfw-onnat-theme-script' );
        }


    }

}

if( !function_exists( 'kinfw_onnat_theme_scripts' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_scripts() {

        return Onnat_Theme_Scripts::get_instance();
    }

}

kinfw_onnat_theme_scripts();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */