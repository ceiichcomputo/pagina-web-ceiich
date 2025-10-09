<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( ! class_exists( 'Onnat_Theme_Widget_Blog_Posts' ) ) {

    /**
     * The Onnat Theme widgets setup class.
     */
    class Onnat_Theme_Widget_Blog_Posts {

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

            $this->widget_id        = 'onnat_widgets_blog_posts';
            $this->widget_title     = sprintf( esc_html_x( '%1$s Blog Posts', 'admin-widget-view', 'onnat' ), ONNAT_CONST_THEME );
            $this->widget_desc      = esc_html_x( 'A handy widget designed to display the blog posts on your website.', 'admin-widget-view', 'onnat' );
            $this->widget_css_class = 'kinfw-widgets kinfw-widget-blog-posts';
            $this->blog_name        = get_bloginfo( 'name', 'display' );

            $this->settings();
            do_action( 'kinfw-action/theme/widgets/blog-posts/loaded' );

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
                        'type'    => 'spinner',
                        'id'      => 'number',
                        'min'     => 1,
                        'step'    => 1,
                        'max'     => 10,
                        'default' => 3,
                        'title'   => esc_html_x( 'Number of posts to show:', 'admin-widget-field-view', 'onnat' )
                    ],
                    [
                        'type'     => 'select',
                        'id'       => 'category',
                        'title'    => esc_html_x( 'Select Category', 'admin-widget-field-view', 'onnat' ),
                        'chosen'   => true,
                        'multiple' => true,
                        'sortable' => true,
                        'ajax'     => true,
                        'options'  => 'category',
                    ],
                    [
                        'type'     => 'switcher',
                        'id'       => 'order',
                        'title'    => esc_html_x( 'Posts Order?', 'admin-widget-field-view', 'onnat' ),
                        'text_on'  => 'ASC',
                        'text_off' => 'DESC',
                    ],
                    [
                        'type'    => 'select',
                        'id'      => 'orderby',
                        'title'   => esc_html_x( 'Post Orderby', 'admin-widget-field-view', 'onnat' ),
                        'default' => 'date',
                        'options' => [
                            'none'          => esc_html_x( 'None', 'admin-widget-field-view', 'onnat' ),
                            'ID'            => esc_html_x( 'Post ID', 'admin-widget-field-view', 'onnat' ),
                            'author'        => esc_html_x( 'Post Author', 'admin-widget-field-view', 'onnat' ),
                            'title'         => esc_html_x( 'Post Title', 'admin-widget-field-view', 'onnat' ),
                            'name'          => esc_html_x( 'Post slug', 'admin-widget-field-view', 'onnat' ),
                            'type'          => esc_html_x( 'Post Type', 'admin-widget-field-view', 'onnat' ),
                            'date'          => esc_html_x( 'Post Date', 'admin-widget-field-view', 'onnat' ),
                            'modified'      => esc_html_x( 'Post Modified Date', 'admin-widget-field-view', 'onnat' ),
                            'rand'          => esc_html_x( 'Rand Order', 'admin-widget-field-view', 'onnat' ),
                            'comment_count' => esc_html_x( 'Number of Comments', 'admin-widget-field-view', 'onnat' ),
                            'menu_order'    => esc_html_x( 'Post Menu Order', 'admin-widget-field-view', 'onnat' ),
                        ]
                    ],
                    [
                        'type'  => 'switcher',
                        'id'    => 'show_date',
                        'title' => esc_html_x( 'Display post date?', 'admin-widget-field-view', 'onnat' )
                    ],
                ],
            ]);

        }

        public function widget ( $args, $instance ) {

            echo kinfw_onnat_theme_widgets()->widget_wp_kses( $args['before_widget'] );

            $title = apply_filters( 'widget_title', $instance['title'], $instance, $this->widget_id );
            echo kinfw_onnat_theme_widgets()->widget_title_wp_kses(
                $args['before_title'] . trim( $title ) . $args['after_title']
            );

            $instance  = array_filter( $instance );
            $number    = isset( $instance['number'] ) ? $instance['number'] : 5;
            $category  = isset( $instance['category'] ) ? $instance['category'] : false;
            $show_date = isset( $instance['show_date'] ) ? true : false;
            $order     = isset( $instance['order'] ) ? 'ASC' : 'DESC';
            $orderby   = $instance['orderby'];

            $query = [
                'posts_per_page'      => $number,
                'post_status'         => 'publish',
                'ignore_sticky_posts' => true,
                'order'               => $order,
                'orderby'             => $orderby,
            ];

            if( $category ) {
                $query[ 'category__in' ] = array_values( $category );
            }

            $r = new WP_Query( $query );

            if ( ! $r->have_posts() ) {
                return;
            }

            echo '<ul>';
                foreach ( $r->posts as $post ) {
                    $post_id    = $post->ID;
                    $post_title = get_the_title( $post_id );
                    $post_link  = get_the_permalink( $post_id );

                    $title = ( ! empty( $post_title ) ) ? $post_title : esc_html__( '(no title)', 'onnat' );

                    echo '<li>';
                        printf( '<article id="kinfw-widget-blog-post-%1$s" class="kinfw-widget-blog-post">', $post_id  );

                        if( has_post_thumbnail( $post_id ) ) {
                            printf(
                                '<div class="entry-item-thumbnail">%1$s</div>',
                                get_the_post_thumbnail( $post_id, '300x170-left-top', [ 'alt' => esc_attr( $title )  ] )
                            );
                        }

                        $date = '';
                        if( $show_date ) {

                            $time = get_post_time( 'G', true, $post_id );
                            if ( ( abs( $t_diff = time() - $time ) ) < DAY_IN_SECONDS ) {
                                if ( $t_diff < 0 ) {
                                    $post_date = sprintf( esc_html_x( '%s from now', '%s = human-readable time difference', 'onnat' ), human_time_diff( $time ) );
                                } else {
                                    $post_date = sprintf( esc_html_x( '%s ago', '%s = human-readable time difference', 'onnat'), human_time_diff( $time ) );
                                }
                            } else {
                                $post_date = get_the_date( get_option('date_format'), $post_id );
                            }

                            $date = sprintf(
                                '<div class="entry-item-date">
                                    %1$s
                                    <time datetime="%2$s"> %3$s </time>
                                </div>',
                                kinfw_icon( 'misc-calendar' ),
                                esc_attr( get_the_date( 'c' ) ),
                                $post_date
                            );
                        }

                        printf(
                            '<div class="entry-item-details">
                                <a href="%1$s">%2$s</a>
                                %3$s
                            </div>',
                            $post_link,
                            $title,
                            $date
                        );

                        printf( '</article>' );
                    echo '</li>';
                }
            echo '</ul>';

            echo kinfw_onnat_theme_widgets()->widget_wp_kses( $args['after_widget'] );

        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_widget_blog_posts' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_widget_blog_posts() {

        return Onnat_Theme_Widget_Blog_Posts::get_instance();
    }

}

kinfw_onnat_theme_widget_blog_posts();


if( !function_exists( 'onnat_widgets_blog_posts' ) ) {

    function onnat_widgets_blog_posts( $args, $instance ) {

        kinfw_onnat_theme_widget_blog_posts()->widget( $args, $instance );
    }
}
/* Omit closing PHP tag to avoid "Headers already sent" issues. */