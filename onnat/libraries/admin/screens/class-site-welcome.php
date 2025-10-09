<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( ! class_exists( 'Onnat_Theme_Welcome_Screen' ) ) {

    /**
     * The Onnat admin welcome screen setup class.
     */
    class Onnat_Theme_Welcome_Screen {

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

            echo '<div class="wrap kinfw-admin-wrap kinfw-admin-welcome-screen-wrap">';

                printf('<!-- Header Wrap --> %s %s <!-- /Header Wrap -->', $header, $nav  );

                echo '<div class="kinfw-admin-content-wrap">';

                    echo '<p>';
                        printf(
                            esc_html__( 'Welcome to %1$s, your go-to source for top-notch WordPress themes for over 10 years. With a decade of experience, we\'ve become experts in creating and customising premium WordPress themes to meet our clients\' diverse needs.', 'onnat' ),
                            sprintf(
                                '<a href="%1$s" target="_blank">%2$s</a>',
                                esc_url( 'https://kinforce.net/' ),
                                esc_html__( 'KIN FORCE', 'onnat' )
                            )
                        );
                    echo '</p>';

                    echo '<div class="kinfw-admin-profile-img">';
                        printf(
                            '<img src="%1$s" alt="%2$s" title="%3$s"/>',
                            ONNAT_CONST_THEME_DIR_URI . '/assets/image/admin/screens/author-profile.jpg',
                            esc_html__( 'KIN FORCE', 'onnat' ),
                            esc_html__( 'KIN FORCE', 'onnat' ),
                        );
                    echo '</div>';

                    echo '<p>';
                        printf(
                            esc_html__( 'At %1$s, we take pride in developing themes that perfectly balance simplicity and power. Our user-friendly designs make it easy for beginners to navigate and customise, while the strength and versatility of our products provide seasoned users with the tools they need for seamless customisation.', 'onnat' ),
                            sprintf(
                                '<a href="%1$s" target="_blank">%2$s</a>',
                                esc_url( 'https://kinforce.net/' ),
                                esc_html__( 'KIN FORCE', 'onnat' )
                            )
                        );
                    echo '</p>';

                    echo '<p>';
                        printf(
                            esc_html__( 'Explore a world of possibilities with our premium WordPress themes - crafted for simplicity, engineered for customisation, and trusted by thousands who appreciate the perfect blend of ease and power. Welcome to %1$s, where each theme reflects our commitment to excellence and years of experience.', 'onnat' ),
                            sprintf(
                                '<a href="%1$s" target="_blank">%2$s</a>',
                                esc_url( 'https://kinforce.net/' ),
                                esc_html__( 'KIN FORCE', 'onnat' )
                            )
                        );
                    echo '</p>';

                    echo '<p>';
                        printf(
                            esc_html__( 'Thank you for choosing the %1$s premium WordPress theme. It\'s installed and ready to roll! If you have any questions or need assistance, we\'re here to help.', 'onnat' ),
                            ONNAT_CONST_THEME
                        );
                    echo '</p>';

                echo '</div>';

            echo '</div>';

        }

    }

}

if( !function_exists( 'kinfw_onnat_admin_welcome_screen' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_admin_welcome_screen() {

        return Onnat_Theme_Welcome_Screen::get_instance();
    }

}

kinfw_onnat_admin_welcome_screen();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */