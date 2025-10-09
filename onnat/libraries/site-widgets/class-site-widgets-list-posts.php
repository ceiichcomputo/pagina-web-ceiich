<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( ! class_exists( 'Onnat_Theme_Widget_List_Posts' ) ) {

    /**
     * The Onnat Theme list post items widgets setup class.
     */
    class Onnat_Theme_Widget_List_Posts {

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

            $this->widget_id        = 'onnat_widgets_list_posts';
            $this->widget_title     = sprintf( esc_html_x( '%1$s List Posts', 'admin-widget-view', 'onnat' ), ONNAT_CONST_THEME );
            $this->widget_desc      = esc_html_x( 'A handy widget designed to easily display list of post\'s title from your wbsite, including posts, pages or custom post types.', 'admin-widget-view', 'onnat' );
            $this->widget_css_class = 'kinfw-widgets kinfw-widget-list-posts';
            $this->blog_name        = get_bloginfo( 'name', 'display' );

            $this->settings();
            do_action( 'kinfw-action/theme/widgets/list-posts/loaded' );
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
                        'type'        => 'select',
                        'id'          => 'post_type',
                        'title'       => esc_html_x( 'Select Post Type', 'admin-widget-field-view', 'onnat' ),
                        'placeholder' => esc_html_x( 'Select a post type', 'admin-widget-field-view', 'onnat' ),
                        'attributes'  => [ 'style' => 'width:100%;' ],
                        'options'     => 'post_types',
                    ],
                    [
                        'type'        => 'select',
                        'id'          => 'post',
                        'title'       => esc_html_x( 'Select Posts', 'admin-widget-field-view', 'onnat' ),
                        'placeholder' => esc_html_x( 'Select posts', 'admin-widget-field-view', 'onnat' ),
                        'dependency'  => [ 'post_type', '==', 'post' ],
                        'options'     => 'posts',
                        'chosen'      => true,
                        'multiple'    => true,
                        'sortable'    => true,
                        'ajax'        => true,
                    ],
                    [
                        'type'        => 'select',
                        'id'          => 'page',
                        'title'       => esc_html_x( 'Select Pages', 'admin-widget-field-view', 'onnat' ),
                        'placeholder' => esc_html_x( 'Select pages', 'admin-widget-field-view', 'onnat' ),
                        'dependency'  => [ 'post_type', '==', 'page' ],
                        'options'     => 'pages',
                        'chosen'      => true,
                        'multiple'    => true,
                        'sortable'    => true,
                        'ajax'        => true,
                    ],
                    [
                        'type'        => 'select',
                        'id'          => 'product',
                        'title'       => esc_html_x( 'Select Products', 'admin-widget-field-view', 'onnat' ),
                        'placeholder' => esc_html_x( 'Select products', 'admin-widget-field-view', 'onnat' ),
                        'dependency'  => [ 'post_type', '==', 'product' ],
                        'options'     => 'posts',
                        'query_args'  => [
                            'post_type' => 'product'
                        ],
                        'chosen'      => true,
                        'multiple'    => true,
                        'sortable'    => true,
                        'ajax'        => true,
                    ],
                    [
                        'type'        => 'select',
                        'id'          => 'kinfw-team-member',
                        'title'       => esc_html_x( 'Select Team Members', 'admin-widget-field-view', 'onnat' ),
                        'placeholder' => esc_html_x( 'Select Team Members', 'admin-widget-field-view', 'onnat' ),
                        'dependency'  => [ 'post_type', '==', 'kinfw-team-member' ],
                        'options'     => 'posts',
                        'query_args'  => [
                            'post_type' => 'kinfw-team-member'
                        ],
                        'chosen'      => true,
                        'multiple'    => true,
                        'sortable'    => true,
                        'ajax'        => true,
                    ],
                    [
                        'type'        => 'select',
                        'id'          => 'kinfw-service',
                        'title'       => esc_html_x( 'Select Services', 'admin-widget-field-view', 'onnat' ),
                        'placeholder' => esc_html_x( 'Select Services', 'admin-widget-field-view', 'onnat' ),
                        'dependency'  => [ 'post_type', '==', 'kinfw-service' ],
                        'options'     => 'posts',
                        'query_args'  => [
                            'post_type' => 'kinfw-service'
                        ],
                        'chosen'      => true,
                        'multiple'    => true,
                        'sortable'    => true,
                        'ajax'        => true,
                    ],
                ],
            ]);
        }

        public function widget ( $args, $instance ) {
            echo kinfw_onnat_theme_widgets()->widget_wp_kses( $args['before_widget'] );

            $instance = array_filter( $instance );

            $items = [];

            $title = isset( $instance['title'] ) ? $instance['title'] : '';
            $title = apply_filters( 'widget_title', $title, $instance, $this->widget_id );

            echo kinfw_onnat_theme_widgets()->widget_title_wp_kses(
                $args['before_title'] . trim( $title ) . $args['after_title']
            );

            $post_type = $instance['post_type'];
            if( !empty( $post_type ) && isset( $instance[$post_type] ) ) {
                $items = $instance[$post_type];

                $query = [
					'post_type'           => $post_type,
					'post__in'            => $items,
					'post_status'         => 'publish',
					'ignore_sticky_posts' => true,
                ];

                $r = new WP_Query( $query );
                if ( $r->have_posts() ) {

                    printf( '<ul class="kinfw-widget-list-items kinfw-widget-list-%1$s-items">', $post_type  );

                    foreach ( $r->posts as $post ) {

                        $post_id    = $post->ID;
                        $post_title = get_the_title( $post_id );
                        $post_link  = get_the_permalink( $post_id );

                        $title = ( ! empty( $post_title ) ) ? $post_title : esc_html__( '(no title)', 'onnat' );
                        $class = ( get_queried_object_id() === $post_id ) ? 'current_page_item' : '';

                        printf(
                            '<li class="kinfw-widget-list-item %1$s">
                                <a href="%2$s" title="%3$s">%3$s</a>
                            </li>',
                            $class,
                            esc_url( $post_link ),
                            $title
                        );

                    }

                    printf( '</ul>' );
                }

            }

            echo kinfw_onnat_theme_widgets()->widget_wp_kses( $args['after_widget'] );
        }
    }

}

if( !function_exists( 'kinfw_onnat_theme_widget_list_posts' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_widget_list_posts() {

        return Onnat_Theme_Widget_List_Posts::get_instance();
    }

}

kinfw_onnat_theme_widget_list_posts();

if( !function_exists( 'onnat_widgets_list_posts' ) ) {

    function onnat_widgets_list_posts( $args, $instance ) {

        kinfw_onnat_theme_widget_list_posts()->widget( $args, $instance );
    }
}
/* Omit closing PHP tag to avoid "Headers already sent" issues. */
