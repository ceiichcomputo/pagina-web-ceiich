<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( ! class_exists( 'Onnat_Theme_Widget_Areas' ) ) {

    /**
     * The Onnat Theme widget area setup class.
     */
    class Onnat_Theme_Widget_Areas {

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

            add_action( 'widgets_init', [ $this, 'register_sidebars' ] );

            do_action( 'kinfw-action/theme/widget-areas/loaded' );
        }

        /**
         * Register default widget area.
         */
        public function register_sidebars() {

            $widget_areas = [
                'default-widget-area' => esc_html__( 'Default Sidebar', 'onnat' ),
            ];

            $widget_areas        = apply_filters( 'kinfw-filter/theme/widget-areas/register', $widget_areas );
            $custom_widget_areas = kinfw_onnat_theme_options()->kinfw_get_option( 'custom_sidebars' );

            if( is_array( $custom_widget_areas ) && count( $custom_widget_areas ) ) {

                foreach( $custom_widget_areas  as $widget_area ) {
                    $id = str_replace(' ', '_', trim( strtolower( $widget_area['name'] ) ) );
                    if( !empty( $id ) ) {
                        $widget_areas[ $id ] = $widget_area['name'];
                    }
                }
            }

            $this->register_widget_areas( $widget_areas );

        }

        public function register_widget_areas( $sidebars ) {

            foreach( $sidebars as $id => $name ) {

                $arg = [
                    'id'            => $id,
                    'name'          => $name,
                    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                    'after_widget'  => '</div> </aside>',
                    'before_title'  => '<span class="kinfw-widget-title">',
                    'after_title'   => '</span> <div class="kinfw-widget-content">',
                ];

                $hook = sprintf( 'kinfw-filter/theme/widget-areas/%s/tag', $id );
                $arg  = apply_filters( $hook, $arg );

                if( is_array( $arg ) ) {
                    register_sidebar( $arg );
                }
            }
        }

        public function display_widget_areas( $sidebars = [] ) {

            $sidebars = array_filter( $sidebars );

            ob_start();

            foreach( $sidebars as $sidebar ) {

                $sidebar = str_replace(' ', '_', trim( $sidebar ) );

                if( is_active_sidebar( $sidebar ) ) {

                    dynamic_sidebar( $sidebars );
                }
            }

            $widget_areas = ob_get_contents();
            ob_end_clean();

            return $widget_areas;

        }

        public function display_widget_area( $sidebar = '' ) {

            $sidebar = str_replace(' ', '_', trim( $sidebar ) );

            ob_start();

            if( is_active_sidebar( $sidebar ) ) {

                dynamic_sidebar( $sidebar );
            }

            $widget_area = ob_get_contents();
            ob_end_clean();

            return $widget_area;

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

    }

}

if( !function_exists( 'kinfw_onnat_theme_widget_areas' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_widget_areas() {

        return Onnat_Theme_Widget_Areas::get_instance();
    }

}

kinfw_onnat_theme_widget_areas();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */