<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( ! class_exists( 'Onnat_Theme_Widget_Media_Grid' ) ) {

    /**
     * The Onnat Theme widgets setup class.
     */
    class Onnat_Theme_Widget_Media_Grid {

		/**
		 * A reference to an instance of this class.
		 */
		private static $instance = null;

        /**
         * Widget Info Attributes
         */
        private $widget_id        = null;
        private $widget_title     = null;
        private $widget_desc      = null;
        private $widget_css_class = null;

        private $blog_name        = null;

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

            if( !function_exists( 'kf_onnat_extra_plugin' ) ) {

                return;
            }

            $this->widget_id        = 'onnat_widgets_media_grid';
            $this->widget_title     = sprintf( esc_html_x( '%1$s Media Grid', 'admin-widget-view', 'onnat' ), ONNAT_CONST_THEME );
            $this->widget_desc      = esc_html_x( 'It provides dynamic visual solution for showcasing media library images on your website.', 'admin-widget-view', 'onnat' );
            $this->widget_css_class = 'kinfw-widgets kinfw-widget-media-grid';
            $this->blog_name        = get_bloginfo( 'name', 'display' );

            $this->settings();
            do_action( 'kinfw-action/theme/widgets/about-me/loaded' );

        }

        public function settings() {

            CSF::createWidget( $this->widget_id, [
                'title'       => $this->widget_title,
                'classname'   => $this->widget_css_class,
                'description' => $this->widget_desc,
                'fields'      => [
                    [
                        'type'  => 'text',
                        'id'    => 'title',
                        'title' => esc_html_x( 'Title', 'admin-widget-field-view', 'onnat' )
                    ],
                    [
                        'type'    => 'gallery',
                        'id'      => 'media',
                        'title'   => esc_html_x( 'Media', 'admin-widget-field-view', 'onnat' ),
                    ],
                    [
                        'type'    => 'button_set',
                        'id'      => 'layout',
                        'title'   => esc_html_x( 'Layout', 'admin-widget-field-view', 'onnat' ),
                        'default' => '3',
                        'options' => [
                            '2' => esc_html_x( 'Two Column', 'admin-widget-field-view', 'onnat' ),
                            '3' => esc_html_x( 'Three Column', 'admin-widget-field-view', 'onnat' ),
                            '4' => esc_html_x( 'Four Column', 'admin-widget-field-view', 'onnat' ),
                        ]
                    ],
                ]
            ]);

        }

        public function widget ( $args, $instance ) {
            $instance = array_filter( $instance );

            echo kinfw_onnat_theme_widgets()->widget_wp_kses( $args['before_widget'] );

            $title = isset( $instance['title'] ) ? $instance['title'] : '';
            $title = apply_filters( 'widget_title', $title, $instance, $this->widget_id );

            echo kinfw_onnat_theme_widgets()->widget_title_wp_kses(
                $args['before_title'] . trim( $title ) . $args['after_title']
            );

                $layout = isset( $instance['layout'] ) ? $instance['layout'] : '4';
                $media  = isset( $instance['media'] ) ? explode( ',', $instance['media'] ) : [];
                $count  = count( $media );

                $size = '66x66-true';

                switch ( $layout ) {
                    case '2':
                        $size = ['200', '200'];
                    break;

                    case '3':
                        $size = 'thumbnail';
                    break;
                }

                if( $count ) {

                    printf( '<ul class="kinfw-light-box-gallery kinfw-list-col-%1$s">', $layout );

                    foreach( $media as $id ) {
                        $alt       = get_post_meta( $id, '_wp_attachment_image_alt', true );
                        $title     = get_the_excerpt( $id );
                        $permalink = get_permalink( $id );

                        printf(
                            '<li>
                                <a href="%1$s" title="%2$s" data-lightbox="kinfw-gallery-item">
                                    %3$s
                                </a>
                            </li>',
                            wp_get_attachment_image_url( $id, 'full' ),
                            $title,
                            wp_get_attachment_image( $id, $size, [ 'src' => ONNAT_CONST_THEME_DUMMY_IMAGE, 'alt' => $alt ] )
                        );
                    }

                    print( '</ul>' );
                }

            echo kinfw_onnat_theme_widgets()->widget_wp_kses( $args['after_widget'] );

        }
    }

}

if( !function_exists( 'kinfw_onnat_theme_widget_media_grid' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_widget_media_grid() {

        return Onnat_Theme_Widget_Media_Grid::get_instance();
    }

}

kinfw_onnat_theme_widget_media_grid();

if( !function_exists( 'onnat_widgets_media_grid' ) ) {

    function onnat_widgets_media_grid( $args, $instance ) {

        kinfw_onnat_theme_widget_media_grid()->widget( $args, $instance );
    }
}
/* Omit closing PHP tag to avoid "Headers already sent" issues. */