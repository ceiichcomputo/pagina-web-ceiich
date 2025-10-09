<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( ! class_exists( 'Onnat_Theme_System_Info_Screen' ) ) {

    /**
     * The Onnat admin system info screen setup class.
     */
    class Onnat_Theme_System_Info_Screen {

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

            echo '<div class="wrap kinfw-admin-wrap kinfw-admin-sys-info-screen-wrap">';

                printf('<!-- Header Wrap --> %s %s <!-- /Header Wrap -->', $header, $nav  );

                echo '<div class="kinfw-admin-content-wrap">';

                    $this->theme();
                    echo '<br/>';
                    echo '<hr/>';

                    $this->wp_env();
                    echo '<br/>';
                    echo '<hr/>';

                    $this->server_env();
                    echo '<br/>';
                    echo '<hr/>';

                    $this->active_plugins();

                echo '</div>';
            echo '</div>';

        }

        public function theme() {

            printf( '<h3>%1$s</h3>', esc_html__( 'Theme Info', 'onnat' ) );

            echo '<table class="widefat" cellspacing="0">';
                printf( '<tr> <td>%1$s</td> <td>%2$s</td> </tr>', esc_html__( 'Name', 'onnat' ), ONNAT_CONST_THEME  );
                printf( '<tr> <td>%1$s</td> <td>%2$s</td> </tr>', esc_html__( 'Version', 'onnat' ), ONNAT_CONST_THEME_VERSION  );
                printf( '<tr> <td>%1$s</td> <td>%2$s</td> </tr>', esc_html__( 'Author URL', 'onnat' ),
                    sprintf( '<a href="%1$s" target="_blank">%2$s</a>', esc_url_raw( ONNAT_CONST_THEME_AUTHOR_URL ), ONNAT_CONST_THEME_AUTHOR_URL  )
                );
                printf( '<tr> <td>%1$s</td> <td>%2$s</td> </tr>', esc_html__( 'Author Email', 'onnat' ),
                    sprintf( '<a href="mailto:%1$s" target="_blank">%2$s</a>', ONNAT_CONST_THEME_AUTHOR_MAIL, ONNAT_CONST_THEME_AUTHOR_MAIL  )
                );
            echo '</table>';

        }

        public function wp_env() {

            $memory_limit = wp_convert_hr_to_bytes( ini_get( 'memory_limit' ) );
            if( $memory_limit >= 268435456 ) {

                $memory_limit = sprintf( esc_html__( 'Your current memory limit %1$s is sufficient, but we recommend 256 MB.', 'onnat' ), size_format( $memory_limit ) );
            } else {

                $memory_limit = esc_html__( 'Minimum 128 MB is required. but we recommend 256 MB.', 'onnat' );
            }

            printf( '<h3>%1$s</h3>', esc_html__( 'WordPress Environment', 'onnat' ) );

            echo '<table class="widefat" cellspacing="0">';

                printf( '<tr> <td>%1$s</td> <td>%2$s</td> </tr>', esc_html__( 'Home URL', 'onnat' ), home_url('/') );
                printf( '<tr> <td>%1$s</td> <td>%2$s</td> </tr>', esc_html__( 'Site URL', 'onnat' ), call_user_func('site_'.'url', '/') );
                printf( '<tr> <td>%1$s</td> <td>%2$s</td> </tr>', esc_html__( 'WordPress Version', 'onnat' ), esc_html( get_bloginfo('version') ) );
                printf( '<tr> <td>%1$s</td> <td>%2$s</td> </tr>', esc_html__( 'Multisite', 'onnat' ), ( is_multisite() ) ? '&#10004;' : '&ndash;' );
                printf( '<tr> <td>%1$s</td> <td>%2$s</td> </tr>', esc_html__( 'Memory Limit', 'onnat' ), $memory_limit );
                printf( '<tr> <td>%1$s</td> <td>%2$s</td> </tr>', esc_html__( 'WP File System', 'onnat' ), ( call_user_func( 'WP_'.'Filesystem' )  ) ? '&#10004;' : '&ndash;' );
                printf( '<tr> <td>%1$s</td> <td>%2$s</td> </tr>', esc_html__( 'Debug Mode', 'onnat' ), ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? '&#10004;' : '&ndash;' );
                printf( '<tr> <td>%1$s</td> <td>%2$s</td> </tr>', esc_html__( 'Language', 'onnat' ), get_locale() );

            echo '</table>';

        }

        public function server_env() {
            printf( '<h3>%1$s</h3>', esc_html__( 'Server Environment', 'onnat' ) );

            echo '<table class="widefat" cellspacing="0">';

                if( defined( 'STCP_SERVER_SOFTWARE' ) ) {
                    printf( '<tr> <td>%1$s</td> <td>%2$s</td> </tr>', esc_html__( 'Server Info', 'onnat' ), esc_html( STCP_SERVER_SOFTWARE ) );
                }

                $php_requirements = 7.0;
                $php_info         = phpversion();
                if ( version_compare( $php_info, $php_requirements, '<' ) ) {
                    $php_info = sprintf( esc_html__( '%1$s - We recommend a minimum PHP version of %2$s.', 'onnat' ), $php_info, $php_requirements );
                }
                printf( '<tr> <td>%1$s</td> <td>%2$s</td> </tr>', esc_html__( 'PHP Version', 'onnat' ), esc_html( $php_info ) );

                $post_max_size = wp_convert_hr_to_bytes( ini_get( 'post_max_size' ) );
                printf( '<tr> <td>%1$s</td> <td>%2$s</td> </tr>', esc_html__( 'PHP Post Max Size', 'onnat' ), esc_html( size_format( $post_max_size ) ) );

                $max_execution_time = ini_get( 'max_execution_time' );
                printf( '<tr> <td>%1$s</td> <td>%2$s</td> </tr>', esc_html__( 'PHP Max Execution Time', 'onnat' ), esc_html( $max_execution_time ) );

                $max_input_time_requirements = 600;
                $max_input_time              = ini_get( 'max_input_time' );
                if( $max_input_time_requirements > $max_input_time ) {
                    $max_input_time = sprintf( esc_html__( '%1$s - We recommend a minimum PHP max input time of %2$s.', 'onnat' ), $max_input_time, $max_input_time_requirements );
                }
                printf( '<tr> <td>%1$s</td> <td>%2$s</td> </tr>', esc_html__( 'PHP Max Input Time', 'onnat' ), esc_html( $max_input_time ) );

                $max_input_vars_requirements = 3000;
                $max_input_vars              = ini_get( 'max_input_vars' );
                if( $max_input_vars_requirements > $max_input_vars ) {
                    $max_input_time = sprintf( esc_html__( '%1$s - We recommend a minimum PHP max input var value of %2$s.', 'onnat' ), $max_input_vars, $max_input_vars_requirements );
                }
                printf( '<tr> <td>%1$s</td> <td>%2$s</td> </tr>', esc_html__( 'PHP Max Input Vars', 'onnat' ), esc_html( $max_input_vars ) );

                $max_upload_size_requirements = 134217728;
                $max_upload_size              = wp_max_upload_size();
                if( $max_upload_size_requirements > $max_upload_size ) {

                    $max_upload_size = sprintf( esc_html__('Your current WordPress max upload size %1$s is sufficient, but we recommend minimum of 128 MB.', 'onnat' ), size_format( $max_upload_size ) );
                } else {

                    $max_upload_size = size_format( $max_upload_size );
                }
                printf( '<tr> <td>%1$s</td> <td>%2$s</td> </tr>', esc_html__( 'Max upload size', 'onnat' ), esc_html( $max_upload_size ) );

                global $wpdb;
                printf( '<tr> <td>%1$s</td> <td>%2$s</td> </tr>', esc_html__( 'MySQL Version', 'onnat' ), esc_html( $wpdb->db_version() ) );

                printf( '<tr> <td>%1$s</td> <td>%2$s</td> </tr>', esc_html__( 'ZipArchive', 'onnat' ), ( class_exists( 'ZipArchive' ) ) ? '&#10004;' : '&ndash;' );

                printf( '<tr> <td>%1$s</td> <td>%2$s</td> </tr>', esc_html__( 'DOMDocument', 'onnat' ), ( class_exists( 'DOMDocument' ) ) ? '&#10004;' : '&ndash;' );

            echo '</table>';

        }

        public function active_plugins() {

            printf( '<h3>%1$s</h3>', esc_html__( 'Active Plugin(s)', 'onnat' ) );

            $active_plugins = (array) get_option( 'active_plugins', [] );

            if ( is_multisite() ) {

                $active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', [] ) );
            }

            echo '<table class="widefat" cellspacing="0">';

                foreach ( $active_plugins as $plugin ) {

                    $plugin_data = get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );
                    $dirname     = dirname( $plugin );

                    $plugin_name = esc_html( $plugin_data['Name'] );

                    if ( ! empty( $plugin_data['PluginURI'] ) ) {
                        $plugin_name = sprintf( '<a href="%1$s"> %2$s </a>', esc_url( $plugin_data['PluginURI'] ), $plugin_name  );
                    }

                    $plugin_info = sprintf( '%1$s %2$s &ndash; %3$s', esc_html__('by', 'onnat' ), $plugin_data['Author'], esc_html( $plugin_data['Version'] ) );

                    printf( '<tr> <td>%1$s</td> <td>%2$s</td> </tr>', $plugin_name, $plugin_info );

                }

            echo '</table>';

        }        

    }

}

if( !function_exists( 'kinfw_onnat_admin_sys_info_screen' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_admin_sys_info_screen() {

        return Onnat_Theme_System_Info_Screen::get_instance();
    }

}

kinfw_onnat_admin_sys_info_screen();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */