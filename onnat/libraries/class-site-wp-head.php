<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_WP_Head' ) ) {

	/**
	 * The Onnat Theme basic wp_head hook setup class.
	 */
    class Onnat_Theme_WP_Head {

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

            add_filter( 'wp_headers', [ $this, 'meta_x_ua_compatible' ] );
            add_action( 'wp_head', [ $this, 'meta_address_bar' ], -1 );
            add_action( 'wp_head', [ $this, 'meta_viewport' ], -1 );
            add_action( 'wp_head', [ $this, 'pingback_header' ], -1 );
            add_action( 'wp_head', [ $this, 'apple_meta_tags' ], -1 );
            add_filter( 'get_the_generator_html', [ $this, 'generator_tag' ], 10, 2 );
            add_filter( 'get_the_generator_xhtml', [ $this, 'generator_tag' ], 10, 2 );
            add_filter( 'wp_head', [ $this, 'site_icon' ], 2 );

            do_action( 'kinfw-action/theme/wp-head/loaded' );

        }

        public function meta_x_ua_compatible( $headers ) {

            $headers['X-UA-Compatible'] = 'IE=edge';

            return $headers;
        }

        /**
         * To change the color of the address bar in various browsers.
         */
        public function meta_address_bar() {
            $meta_tags   = [];

            $meta_tags[] = sprintf( '<meta name="%s" data-kinfw-browser-color content="%s">%s', 'theme-color', '--kinfw-secondary-color', ONNAT_CONST_THEME_NEW_LINE  );
            $meta_tags[] = sprintf( '<meta name="%s" data-kinfw-browser-color content="%s">%s', 'apple-mobile-web-app-status-bar-style', '--kinfw-secondary-color', ONNAT_CONST_THEME_NEW_LINE  );
            $meta_tags[] = sprintf( '<meta name="%s" data-kinfw-browser-color content="%s">%s', 'msapplication-navbutton-color', '--kinfw-secondary-color', ONNAT_CONST_THEME_NEW_LINE  );
            $meta_tags[] = sprintf( '<meta name="%s" data-kinfw-browser-color content="%s">%s', 'msapplication-TileColor', '--kinfw-secondary-color', ONNAT_CONST_THEME_NEW_LINE  );

            $meta_tags = apply_filters( 'kinfw-filter/theme/meta-tag/browser/address-bar-color', $meta_tags );
            echo implode( $meta_tags );
        }

        public function meta_viewport() {

            echo apply_filters( 'kinfw-filter/theme/meta-tag/viewport', '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">' . ONNAT_CONST_THEME_NEW_LINE );
        }

        public function pingback_header() {

            if ( is_singular() && pings_open() ) {

                printf( '<link rel="pingback" href="%s">' . ONNAT_CONST_THEME_NEW_LINE, esc_url( get_bloginfo( 'pingback_url' ) ) );

            }
        }

        public function apple_meta_tags() {

            echo apply_filters( 'kinfw-filter/theme/meta-tag/apple-web-app-capable', '<meta name="apple-mobile-web-app-capable" content="yes">' . ONNAT_CONST_THEME_NEW_LINE );
        }

        public function generator_tag( $gen, $type ) {

            $esc_tag = sprintf(
                /* translators: 1:Name of a theme 2: Version number of a theme 3:Name of theme author */
                esc_attr__( '%1$s %2$s by %3$s', 'onnat' ),
                ONNAT_CONST_THEME,
                ONNAT_CONST_THEME_VERSION,
                'KinForce'
            );

            switch( $type ) {

                case 'html':
                    $gen .= "\n" . '<meta name="generator" content="'.$esc_tag.'">';
                break;

                case 'xhtml':
                    $gen .= "\n" . '<meta name="generator" content="'.$esc_tag.'">';
                break;

            }
            return $gen;
        }

        public function site_icon() {

            if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) {

                $icon_32     = kinfw_onnat_theme_options()->kinfw_get_option( 'favicon_32' );
                $meta_tags[] = sprintf( '<link rel="%s" href="%s" sizes="32x32">', 'icon', esc_url( $icon_32['url'] ) );

                $icon_192    = kinfw_onnat_theme_options()->kinfw_get_option( 'favicon_192' );
                $meta_tags[] = sprintf( '<link rel="%s" href="%s" sizes="192x192">', 'icon', esc_url( $icon_192['url'] ) );

                $icon_180    = kinfw_onnat_theme_options()->kinfw_get_option( 'favicon_180' );
                $meta_tags[] = sprintf( '<link rel="%s" href="%s">', 'apple-touch-icon-precomposed', esc_url( $icon_180['url'] ) );

                $icon_270    = kinfw_onnat_theme_options()->kinfw_get_option( 'favicon_270' );
                $meta_tags[] = sprintf( '<link rel="%s" href="%s">', 'msapplication-TileImage', esc_url( $icon_270['url'] ) );

                $meta_tags = apply_filters( 'kinfw-filter/theme/meta-tag/icons', $meta_tags );
                $meta_tags = array_filter( $meta_tags );

                foreach ( $meta_tags as $meta_tag ) {
                    echo "$meta_tag\n";
                }

            }
        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_wp_head' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_wp_head() {

        return Onnat_Theme_WP_Head::get_instance();
    }
}

kinfw_onnat_theme_wp_head();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */