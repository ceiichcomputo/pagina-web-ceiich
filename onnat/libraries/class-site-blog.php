<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Blog_Utils' ) ) {

	/**
	 * The Onnat Theme basic blog setup class.
	 */
    class Onnat_Theme_Blog_Utils {

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

            add_filter( 'excerpt_more', [ $this, 'alter_excerpt_more' ] );
            add_filter( 'excerpt_length', [ $this, 'alter_excerpt_length' ], 999 );

            add_action( 'navigation_markup_template', [ $this, 'remove_nav_screen_reader_txt' ] );

            do_action( 'kinfw-action/theme/blog-utils/loaded' );

        }

        /**
         * To change excerpt more in in post listing.
         */
        public function alter_excerpt_more( $more ) {

            return '';
        }

        /**
         * To change the excerpt lenth
         */
        public function alter_excerpt_length( $length ) {

            if ( is_tag() || is_category() ) {
                $length = 40;
            }

            return $length;
        }

        /**
         * To remove screen reader text in blog navigation template
         */
        public function remove_nav_screen_reader_txt( $content ) {

            $content = preg_replace('#<h2.*?>(.*?)<\/h2>#si', '', $content);

            return $content;
        }

        public function layout( $option_template, $option_sidebars ) {

            $settings = [
                'sidebars' => []
            ];

            if( empty( $option_template ) || empty( $option_sidebars ) ) {
                return $settings;
            }

            $template = kinfw_onnat_theme_options()->kinfw_get_option( $option_template );

            switch( $template ) {

                case 'left-sidebar':
                    $sidebars = kinfw_onnat_theme_options()->kinfw_get_option( $option_sidebars );
                    $sidebars = apply_filters( 'kinfw-filter/theme/util/is-array', $sidebars );
                    $sidebars = $this->active_widget_areas( $sidebars );

                    $container = count( $sidebars ) ? 'kinfw-has-sidebar kinfw-sidebar-left' : 'kinfw-has-no-sidebar';
                break;

                case 'right-sidebar':
                    $sidebars = kinfw_onnat_theme_options()->kinfw_get_option( $option_sidebars );
                    $sidebars = apply_filters( 'kinfw-filter/theme/util/is-array', $sidebars );
                    $sidebars = $this->active_widget_areas( $sidebars );

                    $container = count( $sidebars ) ? 'kinfw-has-sidebar kinfw-sidebar-right' : 'kinfw-has-no-sidebar';
                break;

                case 'default':
                default:
                    $container = 'kinfw-has-no-sidebar';
                    $sidebars  = [];
                break;

            }

            $settings['class']    = $container;
            $settings['sidebars'] = $sidebars;

            return $settings;
        }

        public function active_widget_areas( $sidebars = [] ) {

            $widget_areas = [];

            $sidebars = array_filter( $sidebars );

            foreach( $sidebars as $sidebar ) {

                $sidebar = str_replace(' ', '_', trim( $sidebar ) );

                if( is_active_sidebar( $sidebar ) ) {

                    $widget_areas[] = $sidebar;
                }
            }

            return $widget_areas;
        }

        /**
         * Map column Class
         */
        public function blog_grid_col_class ( &$size ) {
            array_walk( $size, [ $this, "human_grid_class"] );
        }

        public function human_grid_class( &$size, $key ) {

            $prefix = 'kinfw-col-';

            switch ( $key ) {
                case 'md_portrait':
                    $prefix = 'kinfw-col-md-';
                break;

                case 'md_landscape':
                    $prefix = 'kinfw-col-lg-';
                break;

                case 'sm_portrait':
                break;

                case 'sm_landscape':
                    $prefix = 'kinfw-col-sm-';
                break;

                case 'lg':
                    $prefix = 'kinfw-col-xl-';
                break;
            }

            $size = $prefix.(12/$size);
        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_blog_utils' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_blog_utils() {

        return Onnat_Theme_Blog_Utils::get_instance();
    }
}

kinfw_onnat_theme_blog_utils();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */