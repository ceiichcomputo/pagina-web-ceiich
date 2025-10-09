<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( ! class_exists( 'Onnat_Theme_Plugins' ) ) {

    /**
     * The Onnat Theme plugins via tgm setup class.
     */
    class Onnat_Theme_Plugins {

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

            if ( !function_exists( 'tgmpa' ) ) {
                return;
            }

            add_action( 'tgmpa_register', [ $this, 'required_plugins' ] );
            add_action( 'admin_init', [ $this, 'init' ] );

            do_action( 'kinfw-action/theme/tgm-plugins/loaded' );

        }

        public function init() {

            if( current_user_can( 'edit_theme_options' )  ) {

                $plugins = TGM_Plugin_Activation::$instance->plugins;

                // Activation
                if ( isset( $_GET['kinfw-onnat-activate-plugin'] ) && 'activate-plugin' == $_GET['kinfw-onnat-activate-plugin'] ) {

                    check_admin_referer( 'kinfw-onnat-activate-plugin-nonce', 'kinfw-onnat-activate-plugin-nonce' );

                    foreach ( $plugins as $plugin ) {

                        if ( isset( $_GET['plugin'] ) && $plugin['slug'] == $_GET['plugin'] ) {

                            activate_plugin( $plugin['file_path'] );

                            wp_safe_redirect( admin_url( add_query_arg( 'page', 'plugins-kinfw-theme', 'admin.php') ) );
                            exit;

                        }

                    }

                }

                // Deactivation
                if ( isset( $_GET['kinfw-onnat-deactivate-plugin'] ) && 'deactivate-plugin' == $_GET['kinfw-onnat-deactivate-plugin'] ) {

                    check_admin_referer( 'kinfw-onnat-deactivate-plugin-nonce', 'kinfw-onnat-deactivate-plugin-nonce' );

                    foreach ( $plugins as $plugin ) {

                        if ( isset( $_GET['plugin'] ) && $plugin['slug'] == $_GET['plugin'] ) {

                            deactivate_plugins( $plugin['file_path'] );

                            wp_safe_redirect( admin_url( add_query_arg( 'page', 'plugins-kinfw-theme', 'admin.php') ) );
                            exit;

                        }

                    }

                }

            }

        }

        public function required_plugins() {

            $plugins = [
                [
                    'name'      => 'Revolution Slider',
                    'slug'      => 'revslider',
                    'required'  => false,
                    'version'   => '6.7.30',
                    'image_url' => get_theme_file_uri( 'assets/image/admin/screens/revolution-slider.jpg' ),
                    'source'    => get_theme_file_uri( 'assets/plugins/revslider.zip' ),
                ],
                [
                    'name'      => 'Elementor',
                    'slug'      => 'elementor',
                    'required'  => false,
                    'image_url' => get_theme_file_uri( 'assets/image/admin/screens/elementor.jpg' )
                ],
                [
                    'name'      => 'Onnat Extra',
                    'slug'      => 'onnat-extra',
                    'required'  => false,
                    'version'   => '1.0.1',
                    'image_url' => get_theme_file_uri( 'assets/image/admin/screens/theme-plugin.jpg' ),
                    'source'    => get_theme_file_uri( 'assets/plugins/onnat-extra.zip' ),
                ],
                [
                    'name'      => 'FontFlow Custom Icons for Elementor',
                    'slug'      => 'fontflow-custom-icons-for-elementor',
                    'required'  => false,
                    'image_url' => get_theme_file_uri( 'assets/image/admin/screens/fontflow-custom-icons-for-elementor.jpg' )
                ],
                [
                    'name'      => 'Contact Form 7',
                    'slug'      => 'contact-form-7',
                    'required'  => false,
                    'image_url' => get_theme_file_uri( 'assets/image/admin/screens/contact-form-7.jpg' )
                ],
                [
                    'name'      => 'MetForm',
                    'slug'      => 'metform',
                    'required'  => false,
                    'image_url' => get_theme_file_uri( 'assets/image/admin/screens/metform.jpg' )
                ],
                [
                    'name'      => 'WooCommerce',
                    'slug'      => 'woocommerce',
                    'required'  => false,
                    'image_url' => get_theme_file_uri( 'assets/image/admin/screens/woocommerce.jpg' )
                ],
                [
                    'name'      => 'YITH WooCommerce Quick View',
                    'slug'      => 'yith-woocommerce-quick-view',
                    'required'  => false,
                    'image_url' => get_theme_file_uri( 'assets/image/admin/screens/yith-woo-quick-view.jpg' )
                ],
                [
                    'name'      => 'YITH WooCommerce Quick Wishlist',
                    'slug'      => 'yith-woocommerce-wishlist',
                    'required'  => false,
                    'image_url' => get_theme_file_uri( 'assets/image/admin/screens/yith-woo-wishlist.jpg' )
                ]
            ];

            $config  = [
                'id'           => 'kinfw_theme',
                'default_path' => '',
                'menu'         => 'tgmpa-install-plugins',
                'has_notices'  => true,
                'dismissable'  => true,
                'dismiss_msg'  => '',
                'is_automatic' => false,
                'message'      => '',
                'strings'      => [
                    'kinfw_return' => esc_html__( 'Back to Plugins Overview in Theme Dashboard.', 'onnat' ),
                ],
            ];

            tgmpa( $plugins, $config );

        }

        public function plugin_link( $item ) {

            $actions           = array();
            $installed_plugins = get_plugins();

            $item['sanitized_plugin'] = $item['name'];

            // We have a repo plugin.
            if ( ! $item['version'] ) {
                $item['version'] = TGM_Plugin_Activation::$instance->does_plugin_have_update( $item['slug'] );
            }

            // We need to display the 'Install' link.
            if ( ! isset( $installed_plugins[ $item['file_path'] ] ) ) {

                $install = sprintf('<a href="%1$s" class="button button-primary" title="%2$s %3$s">%2$s</a>',
                    esc_url( wp_nonce_url(
                        add_query_arg(
                            array(
                                'page' 			=> urlencode( TGM_Plugin_Activation::$instance->menu ),
                                'plugin'        => urlencode( $item['slug'] ),
                                'plugin_name'   => urlencode( $item['sanitized_plugin'] ),
                                'tgmpa-install' => 'install-plugin',
                                'return_url' 	=> 'plugins-kinfw-theme'
                            ),
                            TGM_Plugin_Activation::$instance->get_tgmpa_url()
                        ),
                        'tgmpa-install',
                        'tgmpa-nonce'
                    ) ),
                    esc_html__('Install','onnat'),
                    $item['sanitized_plugin']
                );

                $actions['install'] = $install;
            }

            // We need to display the 'Activate' link.
            if ( isset( $installed_plugins[ $item['file_path'] ] ) && is_plugin_inactive( $item['file_path'] ) ) {

                $activate = sprintf('<a href="%1$s" class="button button-primary" title="%2$s %3$s">%2$s</a>',
                    esc_url( add_query_arg(
                        array(
                            'plugin'                           => urlencode( $item['slug'] ),
                            'plugin_name'                      => urlencode( $item['sanitized_plugin'] ),
                            'kinfw-onnat-activate-plugin'       => 'activate-plugin',
                            'kinfw-onnat-activate-plugin-nonce' => wp_create_nonce( 'kinfw-onnat-activate-plugin-nonce' )
                        ),
                        admin_url( add_query_arg('page', 'plugins-kinfw-theme', 'admin.php' ) )
                    ) ),
                    esc_html__('Activate','onnat'),
                    $item['sanitized_plugin']
                );

                $actions['activate'] = $activate;
            }

            // We need to display the 'Update' link.
            if ( isset( $installed_plugins[ $item['file_path'] ] ) && version_compare( $installed_plugins[ $item['file_path'] ]['Version'], $item['version'], '<' ) ) {

                $update = sprintf('<a href="%1$s" class="button button-primary" title="%2$s %3$s">%2$s</a>',
                    esc_url( wp_nonce_url(
                        add_query_arg(
                            array(
                                'page' 			=> urlencode( TGM_Plugin_Activation::$instance->menu ),
                                'plugin'        => urlencode( $item['slug'] ),
                                'plugin_name'   => urlencode( $item['sanitized_plugin'] ),
                                'tgmpa-update'  => 'update-plugin',
                                'version'       => urlencode( $item['version'] ),
                                'return_url' 	=> 'plugins-kinfw-theme'
                            ),
                            TGM_Plugin_Activation::$instance->get_tgmpa_url()
                        ),
                        'tgmpa-update',
                        'tgmpa-nonce'
                    ) ),
                    esc_html__('Update','onnat'),
                    $item['sanitized_plugin']
                );
                $actions['update'] = $update;
            }

            // We need to display the 'Deactivate' link.
            if( call_user_func( 'is_plugin'.'_active', $item['file_path']  ) ) {

                $deactivate = sprintf('<a href="%1$s" class="button button-primary" title="%2$s %3$s">%2$s</a>',
                    esc_url( add_query_arg(
                        array(
                            'plugin'                             => urlencode( $item['slug'] ),
                            'plugin_name'                        => urlencode( $item['sanitized_plugin'] ),
                            'kinfw-onnat-deactivate-plugin'       => 'deactivate-plugin',
                            'kinfw-onnat-deactivate-plugin-nonce' => wp_create_nonce( 'kinfw-onnat-deactivate-plugin-nonce' )
                        ),
                        admin_url( add_query_arg('page', 'plugins-kinfw-theme', 'admin.php' ) )
                    ) ),
                    esc_html__('Deactivate','onnat'),
                    $item['sanitized_plugin']
                );

                $actions['deactivate'] = $deactivate;
            }

            return $actions;

        }

    }

}

if( !function_exists( 'kinfw_onnat_theme_plugins' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_plugins() {

        return Onnat_Theme_Plugins::get_instance();
    }

}

kinfw_onnat_theme_plugins();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */