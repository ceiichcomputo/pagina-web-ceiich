<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Styles' ) ) {

	/**
	 * The Onnat Theme basic styles setup class.
	 */
    class Onnat_Theme_Styles {

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

            add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_main_style' ], 10 );

            add_action( 'wp_enqueue_scripts', [ $this, 'register_styles' ], 9  );
            add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ], 15 );

            add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_util_styles' ], 999999 );

            do_action( 'kinfw-action/theme/styles/loaded' );

        }

        /**
         * Enqueue theme main stylesheet.
         */
        public function enqueue_main_style() {

            $url = get_stylesheet_uri();

            if( is_child_theme() ) {
                $url = get_template_directory_uri() . '/style.css';
            }

            wp_enqueue_style( 'kinfw-onnat-theme-style', $url, [], ONNAT_CONST_THEME_VERSION );
        }

        /**
         * Register styles.
         */
        public function register_styles() {

            if ( ! wp_style_is( 'jquery-magnific-popup', 'enqueued' ) ) {
                wp_register_style( 'jquery-magnific-popup',
                    get_theme_file_uri(  'assets/css/magnific-popup.css' ),
                    [],
                    ONNAT_CONST_THEME_VERSION
                );
            }

            if ( ! wp_style_is( 'jquery-select2', 'enqueued' ) ) {
                wp_register_style( 'jquery-select2',
                    get_theme_file_uri(  'assets/css/select2.min.css' ),
                    [],
                    ONNAT_CONST_THEME_VERSION
                );
            }

            if ( ! wp_style_is( 'jquery-tooltipster', 'enqueued' ) ) {
                wp_register_style( 'jquery-tooltipster',
                    get_theme_file_uri(  'assets/css/tooltipster.min.css' ),
                    [],
                    ONNAT_CONST_THEME_VERSION
                );
            }

            if ( ! wp_style_is( 'swiper', 'enqueued' ) ) {
                wp_register_style( 'swiper',
                    get_theme_file_uri(  'assets/css/swiper.min.css' ),
                    [],
                    ONNAT_CONST_THEME_VERSION
                );
            }

            wp_register_style( 'kinfw-onnat-main-style',
                get_theme_file_uri(  'assets/css/style' . ONNAT_CONST_THEME_DEBUG_SUFFIX . '.css' ),
                [],
                ONNAT_CONST_THEME_VERSION
            );

        }

        /**
         * Enqueue styles.
         */
        public function enqueue_styles() {

            wp_enqueue_style( 'jquery-magnific-popup' );
            wp_enqueue_style( 'jquery-select2' );
            wp_enqueue_style( 'jquery-tooltipster' );
            wp_enqueue_style( 'swiper' );
            wp_enqueue_style( 'kinfw-onnat-main-style' );

        }

        /**
         * Enqueue theme utility styles.
         * these are the stylesheets loaded after all css loaded from plugins too.
         */
        public function enqueue_util_styles() {

            if( is_rtl() ){

                wp_enqueue_style( 'kinfw-onnat-theme-rtl-style',
                    get_stylesheet_uri( 'rtl.css' ),
                    [],
                    ONNAT_CONST_THEME_VERSION
                );
            }


            /**
             * Enqueue child theme stylesheet.
             */
            if( is_child_theme() ){

                $child_theme = wp_get_theme( get_stylesheet() );
                wp_enqueue_style( 'kinfw-onnat-theme-child-style',
                    get_stylesheet_uri(),
                    [ 'kinfw-onnat-main-style' ],
                    $child_theme->get('Version')
                );

            }

        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_styles' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_styles() {

        return Onnat_Theme_Styles::get_instance();
    }

}

kinfw_onnat_theme_styles();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */