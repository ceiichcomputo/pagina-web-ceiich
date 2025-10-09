<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( ! class_exists( 'Onnat_Theme_Support_Screen' ) ) {

    /**
     * The Onnat admin support system screen setup class.
     */
    class Onnat_Theme_Support_Screen {

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

            $header = kinfw_onnat_theme_admin()->header();
            $nav    = kinfw_onnat_theme_admin()->nav();

            echo '<div class="wrap kinfw-admin-wrap kinfw-admin-support-screen-wrap">';

                printf('<!-- Header Wrap --> %s %s <!-- /Header Wrap -->', $header, $nav  );

                echo '<div class="kinfw-admin-content-wrap">';

                    echo '<p>';
                        printf(
                            esc_html__('Before diving into the %1$s, make sure to take a look at the %2$s. We have laid out a wealth of information, offering all the details you need to navigate and utilize our theme effectively.', 'onnat' ),
                            ONNAT_CONST_THEME,
                            sprintf( '<a href="%1$s" target="_blank">%2$s</a>', esc_url( 'https://docs.kinforce.net/onnat' ), esc_html__( 'documentation', 'onnat' ) )
                        );
                    echo '</p>';

                    echo '<p>';
                        printf(
                            esc_html__('If you can not find the answer you are looking for in %1$s, feel free to reach out to us. You can use the contact form at the bottom right of %2$s or leave a comment in the discussion section of %3$s on ThemeForest.We are here to help!', 'onnat'),
                            sprintf( '<a href="%1$s" target="_blank">%2$s</a>', esc_url( 'https://docs.kinforce.net/onnat' ), esc_html__( 'our documentation', 'onnat' ) ),
                            sprintf( '<a href="%1$s" target="_blank">%2$s</a>', ONNAT_CONST_THEME_AUTHOR_URL, esc_html__( 'our profile page', 'onnat' ) ),
                            ONNAT_CONST_THEME
                        );
                    echo '</p>';

                    echo '<p>';
                        printf(
                            esc_html__( 'Have questions about our products? Need help with customization or have pre-purchase inquiries? Do not hesitate to reach out to us. We are here to assist you!', 'onnat')
                        );
                    echo '</p>';

                echo '</div>';

            echo '</div>';

        }

    }

}

if( !function_exists( 'kinfw_onnat_admin_support_screen' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_admin_support_screen() {

        return Onnat_Theme_Support_Screen::get_instance();
    }

}

kinfw_onnat_admin_support_screen();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */