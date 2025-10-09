<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Options_Sidebars' ) ) {

	/**
	 * The Onnat theme sidebars options setup class.
	 */
    class Onnat_Theme_Options_Sidebars {

		/**
		 * A reference to an instance of this class.
		 */
		private static $instance = null;

        /**
         * Contains default values of settings.
         */
        private $default = [];

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

            add_filter( 'kinfw-filter/theme/site-options/default', [ $this, 'defaults' ] );


            if( !function_exists( 'kf_onnat_extra_plugin' ) ) {

                return;
            }

            $this->default = $this->defaults();
            $this->settings();

            do_action( 'kinfw-action/theme/site-options/sidebars/loaded' );

        }

        public function settings() {

            CSF::createSection( ONNAT_CONST_THEME_OPTION_PREFIX, [
                'id'     => 'theme_options_sidebars_section',
                'title'  => esc_html__( 'Widget Areas', 'onnat' ),
                'fields' => [
                    [
                        'id'         => 'widget_style',
                        'title'      => esc_html__( 'Widget Style', 'onnat' ),
                        'subtitle'   => esc_html__( 'Select widget style type.','onnat' ),
                        'type'       => 'select',
                        'attributes' => [ 'style' => 'width:25%' ],
                        'default'    => $this->default['widget_style'],
                        'options'    => [
                            'kinfw-widget-style-1' => esc_html__( 'Style 1','onnat' ),
                            'kinfw-widget-style-2' => esc_html__( 'Style 2','onnat' ),
                        ],
                    ],
                    [
                        'id'           => 'custom_sidebars',
                        'title'        => esc_html__( 'Register Widget Area(s)', 'onnat' ),
                        'type'         => 'repeater',
                        'button_title' => esc_html__( 'Add Widget Area', 'onnat' ),
                        'clone'        => false,
                        'fields'       => [
                            [
                                'id'    => 'name',
                                'type'  => 'text',
                                'title' => esc_html__( 'Widget Area', 'onnat' )
                            ]
                        ],
                    ]
                ]
            ] );

        }

        public function defaults( $defaults = [] ) {

            $defaults['widget_style'] = 'kinfw-widget-style-1';

            return $defaults;
        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_options_sidebars' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_options_sidebars() {

        return Onnat_Theme_Options_Sidebars::get_instance();
    }
}

kinfw_onnat_theme_options_sidebars();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */