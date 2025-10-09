<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( ! class_exists( 'Onnat_Theme_Plugins_Screen' ) ) {

    /**
     * The Onnat admin plugins screen setup class.
     */
    class Onnat_Theme_Plugins_Screen {

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

            $header  = kinfw_onnat_theme_admin()->header();
            $nav     = kinfw_onnat_theme_admin()->nav();
            $plugins = TGM_Plugin_Activation::$instance->plugins;

            echo '<div class="wrap kinfw-admin-wrap kinfw-admin-plugin-screen-wrap">';

                printf('<!-- Header Wrap --> %s %s <!-- /Header Wrap -->', $header, $nav  );

                echo '<div class="kinfw-admin-content-wrap">';

                    echo '<div class="theme-browser rendered">';
                        echo '<div class="themes wp-clearfix">';
                            foreach ($plugins as $plugin ) {
                                $class         = '';
                                $plugin_status = '';
                                $file_path     = $plugin['file_path'];
                                $plugin_action = kinfw_onnat_theme_plugins()->plugin_link( $plugin );

                                if ( ! $plugin['version'] ) {
                                    $plugin['version'] = TGM_Plugin_Activation::$instance->does_plugin_have_update( $plugin['slug'] );
                                }

                                if( call_user_func( 'is_plugin'.'_active', $file_path ) ) {
                                    $class         = 'active';
                                    $plugin_status = 'active';
                                }

                                if ( isset( $_GET['activate-it'] ) && ( $plugin['slug'] === $_GET['activate-it'] ) ) {
                                    $class .= ' activate-it';
                                }

                                echo '<div class="theme '.esc_attr( $class ).'">';
                                    echo '<div class="theme-screenshot">';
                                        echo '<img src="'.esc_url( $plugin['image_url'] ).'" alt="" width="800" height="800"/>';
                                    echo '</div>';

                                    if ( isset( $plugin_action['update'] ) && $plugin_action['update'] ) {
                                        echo '<div class="update-message notice inline notice-warning notice-alt" style="display:block!important;">';
                                            echo '<p>'.esc_html__('New version available.', 'onnat').'</p>';
                                        echo '</div>';
                                    }

                                    echo '<div class="theme-id-container">';
                                        echo '<h2 class="theme-name">';
                                            echo esc_html( $plugin['name'] );
                                        echo '</h2>';

                                        echo '<div class="theme-actions">';
                                            foreach ( $plugin_action as $action ) {
                                                echo "{$action}";
                                            }
                                        echo '</div>';
                                    echo '</div>';

                                echo '</div>';

                            }
                        echo '</div>';
                    echo '</div>';

                echo '</div>';

            echo '</div>';

        }

    }

}

if( !function_exists( 'kinfw_onnat_admin_plugin_screen' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_admin_plugin_screen() {

        return Onnat_Theme_Plugins_Screen::get_instance();
    }

}

kinfw_onnat_admin_plugin_screen();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */