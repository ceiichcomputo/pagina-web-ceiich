<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( ! class_exists( 'Onnat_Theme_Widget_About_Site' ) ) {

    /**
     * The Onnat Theme widgets setup class.
     */
    class Onnat_Theme_Widget_About_Site {

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

            $this->widget_id        = 'onnat_widgets_about_site';
            $this->widget_title     = sprintf( esc_html_x( '%1$s About Site', 'admin-widget-view', 'onnat' ), ONNAT_CONST_THEME );
            $this->widget_desc      = esc_html_x( 'It provides an introduction to the website.', 'admin-widget-view', 'onnat' );
            $this->widget_css_class = 'kinfw-widgets kinfw-widget-about-site';
            $this->blog_name        = get_bloginfo( 'name', 'display' );

            $this->settings();
            do_action( 'kinfw-action/theme/widgets/about-site/loaded' );

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
                        'type'    => 'media',
                        'id'      => 'media',
                        'url'     => false,
                        'library' => 'image',
                        'title'   => esc_html_x( 'Media', 'admin-widget-field-view', 'onnat' ),
                        'default' => [
                            'url'       => esc_url( get_theme_file_uri( 'assets/image/public/logo.svg' ) ),
                            'thumbnail' => esc_url( get_theme_file_uri( 'assets/image/public/logo.svg' ) ),
                            'alt'       => $this->blog_name,
                            'title'     => $this->blog_name,
                        ]
                    ],
                    [
                        'type'          => 'wp_editor',
                        'id'            => 'content',
                        'title'         => esc_html_x( 'Content', 'admin-widget-field-view', 'onnat' ),
                        'quicktags'     => false,
                        'media_buttons' => false
                    ],
                    [
                        'type'        => 'select',
                        'id'          => 'menu',
                        'title'       => esc_html_x( 'Social Menu', 'admin-widget-field-view', 'onnat' ),
                        'placeholder' => esc_html_x( 'Select a menu', 'admin-widget-field-view', 'onnat' ),
                        'attributes'  => [ 'style' => 'width:100%;' ],
                        'options'     => 'menus',
                    ],
                ]
            ]);

        }

        public function widget ( $args, $instance ) {

            echo kinfw_onnat_theme_widgets()->widget_wp_kses( $args['before_widget'] );

            $title = apply_filters( 'widget_title', $instance['title'], $instance, $this->widget_id );

            echo kinfw_onnat_theme_widgets()->widget_title_wp_kses(
                $args['before_title'] . trim( $title ) . $args['after_title']
            );

            $media = $instance['media'];
            if( !empty( $media['url'] ) ) {

                $alt   = $media['alt'];
                $title = $media['title'];

                printf(
                    '<div class="kinfw-widgets-about-site-logo">
                        <img src="%1$s" alt="%2$s" title="%3$s" class="%4$s"/>
                    </div>',
                    esc_url( $media['url'] ),
                    !empty( $alt ) ? $alt : $this->blog_name,
                    !empty( $title ) ? $title : $this->blog_name,
                    kinfw_is_svg( $media['url'] ) ? 'kinfw-switch-svg' : '',
                );
            }

            $content = $instance['content'];
            if( !empty( $content ) ) {

                printf( '<div class="kinfw-widgets-about-me-content"> %1$s </div>', $content );
            }

            $menu = $instance['menu'];
            if( !empty( $menu ) ) {

				$nav_menu = wp_get_nav_menu_object( $menu );

                if( $nav_menu ) {

                    $nav_menu_args = [
                        'menu'            => $nav_menu,
                        'container'       => 'div',
                        'container_class' => 'kinfw-social-menu',
                        'fallback_cb'     => false,
                        'echo'            => false,
                        'menu_class'      => '',
                        'items_wrap'      => '<ul class="kinfw-social-links">%3$s</ul>',
                        'depth'           => 1,
                        'link_before'     => '<span class="kinfw-hidden">',
                        'link_after'      => '</span>',
                        'walker'          => new Onnat_Theme_Footer_Nav_Menu_Walker
                    ];

                    print call_user_func( 'wp_nav_menu', $nav_menu_args );

                }

            }

            echo kinfw_onnat_theme_widgets()->widget_wp_kses( $args['after_widget'] );
        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_widget_about_site' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_widget_about_site() {

        return Onnat_Theme_Widget_About_Site::get_instance();
    }

}

kinfw_onnat_theme_widget_about_site();


if( !function_exists( 'onnat_widgets_about_site' ) ) {

    function onnat_widgets_about_site( $args, $instance ) {

        kinfw_onnat_theme_widget_about_site()->widget( $args, $instance );
    }
}
/* Omit closing PHP tag to avoid "Headers already sent" issues. */