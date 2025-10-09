<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( ! class_exists( 'Onnat_Theme_Widget_Elementor_Template' ) ) {

    /**
     * The Onnat Theme Elementor Template widgets setup class.
     */
    class Onnat_Theme_Widget_Elementor_Template {

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

            $this->widget_id        = 'onnat_widgets_elementor_template';
            $this->widget_title     = sprintf( esc_html_x( '%1$s Elementor Template', 'admin-widget-view', 'onnat' ), ONNAT_CONST_THEME );
            $this->widget_desc      = esc_html_x( 'A handy widget designed to easily display elementor template.', 'admin-widget-view', 'onnat' );
            $this->widget_css_class = 'kinfw-widgets kinfw-widget-elementor-tpl';
            $this->blog_name        = get_bloginfo( 'name', 'display' );

            $this->settings();
            do_action( 'kinfw-action/theme/widgets/elementor-template/loaded' );
        }

        public function settings() {
            $fields = [
                [
                    'type'    => 'notice',
                    'style'   => 'danger',
                    'content' => esc_html_x( 'Please ensure that Elementor is installed and activated before using this widget.', 'admin-widget-field-view', 'onnat' ),
                ],
            ];

            if( kinfw_is_elementor_callable() ) {
                $fields = [
                    [
                        'type'  => 'text',
                        'id'    => 'title',
                        'title' => esc_html_x( 'Title', 'admin-widget-field-view', 'onnat' )
                    ],
                    [
                        'type'       => 'switcher',
                        'id'         => 'style',
                        'title'      => esc_html_x( 'Widget Style?', 'admin-widget-field-view', 'onnat' ),
                        'text_on'    => esc_html_x( 'Enabled', 'admin-widget-field-view', 'onnat' ),
                        'text_off'   => esc_html_x( 'Disabled', 'admin-widget-field-view', 'onnat' ),
                        'text_width' => 100,
                    ],
                    [
                        'type'        => 'select',
                        'id'          => 'kinfw-elementor-template',
                        'title'       => esc_html_x( 'Select Template', 'admin-widget-field-view', 'onnat' ),
                        'placeholder' => esc_html_x( 'Select Template', 'admin-widget-field-view', 'onnat' ),
                        'options'     => 'posts',
                        'ajax'        => true,
                        'chosen'      => true,
                        'query_args'  => [
                            'post_type'      => 'elementor_library',
                            'posts_per_page' => -1
                        ],
                    ],
                ];
            }

            CSF::createWidget( $this->widget_id, [
                'title'       => $this->widget_title,
                'classname'   => $this->widget_css_class,
                'description' => $this->widget_desc,
                'fields'      => $fields,
            ]);
        }

        public function widget ( $args, $instance ) {
            $instance = array_filter( $instance );

            echo kinfw_onnat_theme_widgets()->widget_wp_kses( $args['before_widget'] );

            $title = isset( $instance['title'] ) ? $instance['title'] : '';
            $title = apply_filters( 'widget_title', $title, $instance, $this->widget_id );

            $after_title = '</span> <div class="kinfw-widget-content kinfw-widget-has-no-style">';
            if( isset( $instance['style'] ) ) {
                $after_title = '</span> <div class="kinfw-widget-content kinfw-widget-has-style">';
            }            

            echo kinfw_onnat_theme_widgets()->widget_title_wp_kses(
                $args['before_title'] . trim( $title ) . $after_title
            );

            $tpl_id = isset( $instance['kinfw-elementor-template'] ) ? $instance['kinfw-elementor-template'] : 0;
            
            if( !empty( $tpl_id ) ) {
                $elementor        = \Elementor\Plugin::instance();
                $is_elementor_doc = $elementor->documents->get( $tpl_id )->is_built_with_elementor();

                $template = $is_elementor_doc
                    ? $elementor->frontend->get_builder_content_for_display( $tpl_id )
                    : get_the_content( null, false, $tpl_id );

                echo apply_filters( 'kinfw-filter/theme/widgets/elementor-template', $template );
            }

            echo kinfw_onnat_theme_widgets()->widget_wp_kses( $args['after_widget'] );
        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_widget_elementor_template' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_widget_elementor_template() {

        return Onnat_Theme_Widget_Elementor_Template::get_instance();
    }

}

kinfw_onnat_theme_widget_elementor_template();

if( !function_exists( 'onnat_widgets_elementor_template' ) ) {

    function onnat_widgets_elementor_template( $args, $instance ) {

        kinfw_onnat_theme_widget_elementor_template()->widget( $args, $instance );
    }
}
/* Omit closing PHP tag to avoid "Headers already sent" issues. */