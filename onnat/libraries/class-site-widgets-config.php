<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( ! class_exists( 'Onnat_Theme_Widgets' ) ) {

    /**
     * The Onnat Theme widgets setup class.
     */
    class Onnat_Theme_Widgets {

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

            /**
             * WordPress Block widget filter.
             */
            add_filter( 'widget_block_content', [ $this, 'widget_block_content' ], 10, 3 );

            /**
             * WordPress Widget Display Callback
             */
            add_filter('widget_display_callback', [ $this, 'widget_display_callback' ], 10, 2);

            /**
             * WordPress category and archive widget filters.
             */
            add_filter( 'wp_list_categories', [ $this, 'category_widget_span_count' ] );
            add_filter( 'get_archives_link', [ $this, 'archive_widget_span_count' ] );

            /**
             * Elementor WordPress Widgets
             */
            add_filter( 'elementor/widgets/wordpress/widget_args', [ $this, 'ele_wp_widget_args' ], 10, 2 );

            if( !function_exists( 'kf_onnat_extra_plugin' ) ) {
                return;
            }

            $this->load_modules();

            do_action( 'kinfw-action/theme/widgets/loaded' );

        }

        /**
         * Filters the content of the Block widget before output.
         */
        public function widget_block_content( $content, $instance, $thisObj ) {
            return '<div class="kinfw-widget-content">'. $content;
        }

        public function widget_display_callback( $instance, $widget ) {
            if( empty( $instance['title'] ) ) {
                if (isset($widget->id_base) && 'calendar' == $widget->id_base) {
                    $instance['title'] = esc_html__('Calendar', 'onnat' );
                }

                if (isset($widget->id_base) && 'custom_html' == $widget->id_base) {
                    $instance['title'] = ' ';
                }

                if (isset($widget->id_base) && 'kfwoo_wc_widget_swatch_filter' == $widget->id_base) {
                    $instance['title'] = esc_html__('Filter By Swatch', 'onnat' );
                }

            }
            return $instance;
        }        

        /**
         * Filter to modify the category widget output.
         */
        public function category_widget_span_count( $output ) {
            $output = str_replace( '&nbsp;', ' ',$output );
            return preg_replace( '#</a>\s*\(([^\)]*)\)#', '<span>($1)</span></a>', $output );
        }

        /**
         * Filter to modify the archive widget link.
         */
        public function archive_widget_span_count( $link_html ) {
            $link_html = str_replace( '&nbsp;', ' ',$link_html );
            return preg_replace( '#</a>\s*\(([^\)]*)\)#', '<span>($1)</span></a>', $link_html );
        }

        public function ele_wp_widget_args( $default_widget_args, $thisObj ) {
            $instance = $thisObj->get_widget_instance();
            $class    = $instance->widget_options['classname'];

            $default_widget_args['before_widget'] = '<aside class="widget '. $class.'">';
            $default_widget_args['after_widget']  = '</div> </aside>';
            $default_widget_args['before_title']  = '<span class="kinfw-widget-title">';
            $default_widget_args['after_title']   = '</span> <div class="kinfw-widget-content">';

            return $default_widget_args;
        }

        public function load_modules() {

            require_once get_theme_file_path( 'libraries/site-widgets/class-site-widgets-about-author.php' );
            require_once get_theme_file_path( 'libraries/site-widgets/class-site-widgets-blog-posts.php' );
            require_once get_theme_file_path( 'libraries/site-widgets/class-site-widgets-about-site.php' );
            require_once get_theme_file_path( 'libraries/site-widgets/class-site-widgets-media-grid.php' );
            require_once get_theme_file_path( 'libraries/site-widgets/class-site-widgets-list-posts.php' );
            require_once get_theme_file_path( 'libraries/site-widgets/class-site-widgets-elementor-template.php' );

        }

        public function widget_wp_kses( $content ) {

            $attrs = [
                'id'    => [],
                'class' => []
            ];

            return wp_kses( $content, [
                'aside' => $attrs,
                'div'   => $attrs,
            ] );
        }

        public function widget_title_wp_kses( $content ) {

            $attrs = [
                'id'    => [],
                'class' => []
            ];

            return wp_kses( $content, [
                'p'    => $attrs,
                'span' => $attrs,
                'div'  => $attrs,
                'h1'   => $attrs,
                'h2'   => $attrs,
                'h3'   => $attrs,
                'h4'   => $attrs,
                'h5'   => $attrs,
                'h6'   => $attrs,
            ] );
        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_widgets' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_widgets() {

        return Onnat_Theme_Widgets::get_instance();
    }

}

kinfw_onnat_theme_widgets();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */