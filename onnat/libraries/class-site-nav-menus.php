<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Nav_Menus' ) ) {

	/**
	 * The Onnat Theme navigation menus setup class.
	 */
    class Onnat_Theme_Nav_Menus {

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

            add_action( 'after_setup_theme', [ $this, 'register_nav_menus' ] );
            add_filter( 'nav_menu_item_attributes', [ $this, 'nav_menu_item_attr' ], 10, 4 );
            add_filter( 'walker_nav_menu_start_el', [ $this, 'nav_menu_start_el' ] , 10, 4 );

            $this->load_walkers();

            do_action( 'kinfw-action/theme/nav-menus/loaded' );

        }

        /**
         * Registers navigation menu locations.
         */
        public function register_nav_menus() {

            register_nav_menus([
                'primary' => esc_html__( 'Primary Menu', 'onnat' ),
            ]);

        }

        /**
         * To remove menu item id attribute
         */
        public function nav_menu_item_attr( $li_atts, $menu_item, $args, $depth ) {

            if( isset( $li_atts['id'] ) ) {
                unset( $li_atts['id'] );
            }

            return $li_atts;

        }

        public function nav_menu_start_el( $item_output, $item, $depth, $args ) {

            if( is_a( $args->walker, 'Onnat_Theme_Footer_Nav_Menu_Walker' ) ) {

                return $item_output;

            }

            $link_after = '';

            $meta       = get_post_meta( $item->ID, ONNAT_CONST_THEME_NAV_MENU_PREFIX, true );
            $meta       = is_array( $meta ) ? array_filter( $meta ) : [];
            $settings   = isset( $meta['settings'] ) ? $meta['settings'] : [];

            if( !empty( $settings ) && isset( $settings['use_label'] ) ) {

                $link_after .= sprintf( '<span class="kinfw-menu-label kinfw-menu-label-%1$s">%2$s</span>',
                    $settings[ 'label' ],
                    $settings[ 'label_field' ]
                );
            }

            if ( !empty( $item->description ) ) {

                $link_after .= sprintf( '<span class="menu-item-description kinfw-menu-item-description ">%1$s</span>', $item->description );
            }

            if( !empty( $link_after ) ) {

                $item_output = str_replace( $args->link_after . '</a>',  $link_after . $args->link_after . '</a>',  $item_output );
            }

            return $item_output;
        }

        public function load_walkers() {
            require_once get_theme_file_path( 'libraries/site-nav-menu-walkers/class-site-footer-nav-menu-walker.php' );
            require_once get_theme_file_path( 'libraries/site-nav-menu-walkers/class-site-mobile-nav-menu-walker.php' );

            /**
             * For Unit Test fix.
             */
            require_once get_theme_file_path( 'libraries/site-nav-menu-walkers/class-site-wp-list-page-nav-menu-walker.php' );
            require_once get_theme_file_path( 'libraries/site-nav-menu-walkers/class-site-wp-list-page-nav-menu-mobile-walker.php' );
        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_nav_menus' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_nav_menus() {

        return Onnat_Theme_Nav_Menus::get_instance();
    }
}

kinfw_onnat_theme_nav_menus();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */