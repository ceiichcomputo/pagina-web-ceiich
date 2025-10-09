<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Nav_Menu' ) ) {

	/**
	 * The Onnat Theme navigation menu config setup class.
	 */
    class Onnat_Theme_Nav_Menu {

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

            if( !function_exists( 'kf_onnat_extra_plugin' ) ) {

                return;
            }

            $this->init();
            $this->settings();

            $hook = sprintf( 'csf_%s_save', ONNAT_CONST_THEME_NAV_MENU_PREFIX );

            add_filter( $hook, [ $this, 'save' ], 10, 3 );

            do_action( 'kinfw-action/theme/nav-menu/loaded' );

        }

        public function init() {

            CSF::createNavMenuOptions( ONNAT_CONST_THEME_NAV_MENU_PREFIX, [
                'data_type' => 'serialize'
            ] );

        }

        public function settings() {

            $labels = [
                'title'  => esc_html_x( 'Label', 'admin-nav-menu-settings-field-view', 'onnat' ),
                'fields' => $this->labels()
            ];

            $tabs = apply_filters( 'kinfw-filter/theme/nav-menu/settings/tabs',  [ 0 => $labels ] );

            CSF::createSection( ONNAT_CONST_THEME_NAV_MENU_PREFIX, [
                'fields' => [
                    [
                        'id'    => 'settings',
                        'type'  => 'tabbed',
                        'title' => '',
                        'tabs'  => $tabs
                    ]
                ]
            ] );
        }

        public function labels() {

            $fields      = [
                [
                    'type'     => 'switcher',
                    'id'       => 'use_label',
                    'title'    => esc_html_x( 'Use Label', 'admin-nav-menu-settings-field-view', 'onnat' ),
                    'default'  => false
                ],
            ];

            $label_field = [];

            $labels = kinfw_onnat_theme_options()->kinfw_get_option( 'menu_labels' );
            foreach( $labels as $key => $label ) {
                $label_field[ $key ] = $label['label'];
            }

            if( count( $label_field ) ) {

                array_push( $fields, [
                    'type'       => 'select',
                    'id'         => 'label',
                    'title'      => esc_html_x( 'Choose Label', 'admin-nav-menu-settings-field-view', 'onnat' ),
                    'dependency' => [ 'use_label', '==', 'true' ],
                    'attributes' => [ 'class' => 'description-thin' ],
                    'options'    => $label_field
                ] );

            } else {
                array_push( $fields, [
                    'type'    => 'notice',
                    'style'   => 'info',
                    'content' => esc_html_x( 'Add labels in Theme Option panel.', 'admin-nav-menu-settings-field-view', 'onnat' ),
                ] );
            }

            return $fields;
        }

        public function save( $data, $menu_item_db_id, $menu_item_args ) {

            /**
             * Labels
             */
                if( empty( $data['settings']['use_label'] ) ) {
                    unset( $data['settings']['use_label'] );
                    unset( $data['settings']['label'] );
                } else {
                    $labels = kinfw_onnat_theme_options()->kinfw_get_option( 'menu_labels' );
                    $data['settings']['label_field'] = $labels[ $data['settings']['label'] ]['label'];
                }

            return $data;

        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_nav_menu' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_nav_menu() {

        return Onnat_Theme_Nav_Menu::get_instance();
    }
}

kinfw_onnat_theme_nav_menu();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */