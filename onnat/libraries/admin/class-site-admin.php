<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Admin' ) ) {

	/**
	 * The Onnat theme admin setup class.
	 */
    class Onnat_Theme_Admin {

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

            add_action('admin_enqueue_scripts', [ $this, 'load_assets' ]);
            add_action( 'admin_print_scripts', [ $this, 'load_scripts' ] );

            add_action( 'admin_init', [ $this, 'about_page_redirect' ] );

            add_filter( 'default_page_template_title', [ $this, 'default_page_template_title' ] );

            add_action( 'admin_menu', [ $this, 'admin_menus' ], 5 );
            add_action( 'admin_menu', [ $this, 'hide_admin_menus' ], 999 );

            add_filter( 'update_footer', [ $this, 'admin_footer' ], 100  );

            do_action( 'kinfw-action/theme/admin/loaded' );

        }

        public function load_assets() {

            $current_screen = get_current_screen()->base;

            wp_localize_script( 'jquery', 'KF_FW_OBJ', [
                'theme'       => ONNAT_CONST_THEME,
                'themeAuthor' => ONNAT_CONST_THEME_AUTHOR
            ] );

            /**
             * Enqueue Custom Admin Style.
             */
            $admin_pages    = [
                'toplevel_page_' . ONNAT_CONST_SAN_THEME,
                ONNAT_CONST_SAN_THEME . '_page_plugins-kinfw-theme',
                ONNAT_CONST_SAN_THEME . '_page_system-info-kinfw-theme',
                ONNAT_CONST_SAN_THEME . '_page_support-system-kinfw-theme',
                ONNAT_CONST_SAN_THEME . '_page_kinfw-onnat-options'
            ];

            $admin_pages = apply_filters( 'kinfw-filter/theme/admin-pages/load-css', $admin_pages );

            $condition = in_array( $current_screen, $admin_pages );

            if( $condition ) {

                wp_enqueue_style( 'kinfw-onnat-main-style',
                    get_theme_file_uri(  'assets/css/admin-style.min.css' ),
                    [],
                    ONNAT_CONST_THEME_VERSION
                );
            }

        }

        public function load_scripts() {

            $current_screen = get_current_screen()->base;

            $admin_pages    = [
                'toplevel_page_' . ONNAT_CONST_SAN_THEME,
                ONNAT_CONST_SAN_THEME . '_page_plugins-kinfw-theme',
                ONNAT_CONST_SAN_THEME . '_page_system-info-kinfw-theme',
                ONNAT_CONST_SAN_THEME . '_page_support-system-kinfw-theme',
                ONNAT_CONST_SAN_THEME . '_page_kinfw-onnat-options'
            ];

            $admin_pages = apply_filters( 'kinfw-filter/theme/admin-pages/load-js', $admin_pages );

            $condition = in_array( $current_screen, $admin_pages );

            if( $condition ) {

                global $wp_filter;

                if (is_user_admin()) {
                    if (isset($wp_filter['user_admin_notices'])) {
                        unset($wp_filter['user_admin_notices']);
                    }
                } elseif (isset($wp_filter['admin_notices'])) {
                    unset($wp_filter['admin_notices']);
                }

                if (isset($wp_filter['all_admin_notices'])) {
                    unset($wp_filter['all_admin_notices']);
                }

            }

        }

        public function about_page_redirect() {

            global $pagenow;

            if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) && $_GET['activated'] == 'true' ) {

                wp_safe_redirect( admin_url( add_query_arg( 'page', ONNAT_CONST_SAN_THEME, 'admin.php') ) );
                exit;
            }

        }

        /**
         * Filters the title of the default page template displayed in the drop-down.
         */
        public function default_page_template_title( $template ) {

            $template = esc_html__( 'Full Width Template', 'onnat' );

            return $template;
        }

        /**
         *  Create new admin menus before the administration menu loads in the admin.
         */
        public function admin_menus() {

            global $submenu;

            if( !current_user_can('manage_options') ) {

                return;
            }

            $add_menu    = 'add_'.'menu_page';
            $add_submenu = 'add_'.'submenu_page';
            $menu_icon   = 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDE2LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPgo8IURPQ1RZUEUgc3ZnIFBVQkxJQyAiLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4iICJodHRwOi8vd3d3LnczLm9yZy9HcmFwaGljcy9TVkcvMS4xL0RURC9zdmcxMS5kdGQiPgo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IgoJIHdpZHRoPSIxMTBweCIgaGVpZ2h0PSIxMTBweCIgdmlld0JveD0iMCAwIDExMCAxMTAiIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDExMCAxMTAiIHhtbDpzcGFjZT0icHJlc2VydmUiPgo8cGF0aCBmaWxsPSIjRkZGRkZGIiBkPSJNMTA1LjMzLDU0LjkyYzAsMjcuNjE0LTIyLjM4Nyw1MC01MCw1MGMtMjcuNjE0LDAtNTAtMjIuMzg2LTUwLTUwczIyLjM4Ni01MCw1MC01MAoJQzgyLjk0Myw0LjkyLDEwNS4zMywyNy4zMDYsMTA1LjMzLDU0LjkyeiBNNTAuNDM4LDgxLjYwOWw5Ljk4NC0xLjkzOFY1LjE3NmMtMy43NjYtMC41MjYtOS45ODQtMC4wMi05Ljk4NC0wLjAyVjgxLjYwOXoKCSBNNjAuNDIyLDI2LjMxM3YxMS4wMzFsMzIuNjkxLTE1LjE3M2MtMC4zODctMC43MzUtNC40ODItNC41NDgtNC40ODItNC41NDhjLTEuMDU3LTAuOTczLTMuNDQyLTIuODEyLTMuNDQyLTIuODEyTDYwLjQyMiwyNi4zMTN6CgkgTTYwLjQyMiw0OC41bDQyLjEwNCwyMi45NjdjMC41Ny0xLjU0NiwxLjUxNi01LjIyMiwxLjUxNi01LjIyMmMwLjQ0OS0xLjc4OSwwLjgzMy00LjU1NCwwLjgzMy00LjU1NEw2MC40MjIsMzcuMzQ0VjQ4LjV6CgkgTTIwLjc2NSw5MS4wNDljMi4yMjgsMi4yNzIsNi41NDMsNS4yODcsNi41NDMsNS4yODdsMjMuMTI5LTQuNTIybDQ2LjQ1My05LjA4NWMwLjQ1NS0wLjY2NiwyLjQxLTMuOTg1LDIuNDEtMy45ODUKCWMxLjI5LTIuMjM2LDMuMjI3LTcuMjc2LDMuMjI3LTcuMjc2TDE3Ljg2Nyw4OC4wMzVDMTkuNDM2LDg5Ljg5NywyMC43NjUsOTEuMDQ5LDIwLjc2NSw5MS4wNDl6IE01MC4yODMsMTA0LjY2OAoJYzIuNzQ2LDAuMzUyLDMuOTI1LDAuMjM5LDMuOTI1LDAuMjM5YzMuMDQyLDAuMTU4LDYuMjE0LTAuMjQ0LDYuMjE0LTAuMjQ0Vjg5Ljg2bC05Ljk4NSwxLjk1M0w1MC4yODMsMTA0LjY2OHogTTM1LjUsMjEuMjUKCWMtMi44MzEsMC01LjEyNSwyLjI5NC01LjEyNSw1LjEyNVMzMi42NjksMzEuNSwzNS41LDMxLjVzNS4xMjUtMi4yOTQsNS4xMjUtNS4xMjVTMzguMzMxLDIxLjI1LDM1LjUsMjEuMjV6Ii8+Cjwvc3ZnPg==';

            call_user_func(
                $add_menu,
                ONNAT_CONST_THEME,
                ONNAT_CONST_THEME,
                'manage_options',
                ONNAT_CONST_SAN_THEME,
                [ $this, 'welcome_screen' ],
                $menu_icon,
                1
            );

            call_user_func(
                $add_submenu,
                ONNAT_CONST_SAN_THEME,
                esc_html__( 'Plugins', 'onnat' ),
                esc_html__( 'Plugins', 'onnat' ),
                'manage_options',
                'plugins-kinfw-theme',
                [ $this, 'plugins_screen' ],
                10
            );

            call_user_func(
                $add_submenu,
                ONNAT_CONST_SAN_THEME,
                esc_html__( 'System Info', 'onnat' ),
                esc_html__( 'System Info', 'onnat' ),
                'manage_options',
                'system-info-kinfw-theme',
                [ $this, 'system_info_screen' ],
                15
            );

            call_user_func(
                $add_submenu,
                ONNAT_CONST_SAN_THEME,
                esc_html__( 'Support', 'onnat' ),
                esc_html__( 'Support', 'onnat' ),
                'manage_options',
                'support-system-kinfw-theme',
                [ $this, 'support_system_screen' ],
                20
            );

            /**
             * Rename first submenu title
             */
            $submenu[ONNAT_CONST_SAN_THEME][0][0] = esc_html__( 'Dashboard', 'onnat' );

        }

        /**
         *  Hide few new admin menus before the administration menu loads in the admin.
         */
        public function hide_admin_menus() {

            global $submenu;

            if( !current_user_can('manage_options') ) {

                return;
            }

            $smenu     = $submenu[ONNAT_CONST_SAN_THEME ];
            $hidemenus = [
                'plugins-kinfw-theme',
                'system-info-kinfw-theme',
                'support-system-kinfw-theme',
            ];

            $hidemenus = apply_filters( 'kinfw-filter/theme/remove/admin-nav', $hidemenus );

            foreach( $smenu as $index => $menu ) {

                if( in_array( $menu[2], $hidemenus ) ) {

                    $classes = key_exists( 4, $menu  ) ? $menu[4] : [];
                    array_push( $classes, 'hidden' );

                    $submenu[ONNAT_CONST_SAN_THEME][$index][4] = implode( " ", $classes );

                }

            }

        }

        /**
         * Filter the version/update text displayed in the admin footer.
         */
        public function admin_footer( $html ) {

            $html = sprintf(' %1$s | <a href="%2$s" target="_blank">%3$s %4$s</a>',
                core_update_footer(),
                ONNAT_CONST_THEME_AUTHOR_URL,
                ONNAT_CONST_THEME,
                ONNAT_CONST_THEME_VERSION
            );

            return $html;
        }

        /**
         * Custom code block to show common sections in our admin screens.
         */
        public function header() {

            if( !current_user_can('manage_options') ) {
                return;
            }

            $content = sprintf('
                <div class="kinfw-admin-header wp-clearfix">
                    <div id="kinfw-admin-logo">
                        <img src="%1$s" alt="%2$s" title="%3$s" />
                    </div>
                    <div id="kinfw-admin-theme-name">
                        %4$s <span class="kinfw-admin-theme-version"> %5$s </span>
                    </div>
                    <div id="kinfw-admin-theme-info">
                        %6$s
                    </div>
                </div>',

                ONNAT_CONST_THEME_DIR_URI . '/assets/image/admin/screens/logo.png',
                esc_html__( 'Theme Logo', 'onnat' ),
                esc_html__( 'Theme Logo', 'onnat' ),
                ONNAT_CONST_THEME,
                ONNAT_CONST_THEME_VERSION,
                esc_html__( "Your website's best friend—easy to use, stylish, and smart. It's super flexible and modern, making your site look great without slowing it down.", 'onnat' )
            );

            return $content;
        }

        public function nav() {

            if( !current_user_can('manage_options') ) {

                return;
            }

            global $current_screen;

            /**
             * Home Menu
             */
                $menus[10] = [
                    'id'    => 'toplevel_page_' . ONNAT_CONST_THEME,
                    'title' => esc_html__( 'Home', 'onnat' ),
                    'href'  => admin_url( add_query_arg('page', ONNAT_CONST_SAN_THEME, 'admin.php' ) ),
                ];

            /**
             * Theme Settings Menu
             */
                if( function_exists( 'kf_onnat_extra_plugin' ) ) {

                    $menus[20] = [
                        'id'    => '',
                        'title' => esc_html__( 'Theme Settings', 'onnat' ),
                        'href'  => admin_url( add_query_arg( 'page', 'kinfw-onnat-options', 'admin.php') )
                    ];
                }

            /**
             * Plugins Menu
             */
                $menus[30] = [
                    'id'    => ONNAT_CONST_THEME . '_page_plugins-kinfw-theme',
                    'title' => esc_html__( 'Plugins', 'onnat' ),
                    'href'  => admin_url( add_query_arg('page', 'plugins-kinfw-theme', 'admin.php' ) )
                ];

            /**
             * System Info Menu
             */
                $menus[40] = [
                    'id'    => ONNAT_CONST_THEME . '_page_system-info-kinfw-theme',
                    'title' => esc_html__( 'System Info', 'onnat' ),
                    'href'  => admin_url( add_query_arg('page', 'system-info-kinfw-theme', 'admin.php' ) )
                ];

            /**
             * Support Menu
             */
                $menus[50] = [
                    'id'    => ONNAT_CONST_THEME . '_page_support-system-kinfw-theme',
                    'title' => esc_html__( 'Support', 'onnat' ),
                    'href'  => admin_url( add_query_arg('page', 'support-system-kinfw-theme', 'admin.php' ) )
                ];

            /**
             * Changelog Menu
             */
                $menus[60] = [
                    'id'     => ONNAT_CONST_THEME . '_page_changelog-kinfw-theme',
                    'title'  => esc_html__( 'Changelog', 'onnat' ),
                    'href'   => ONNAT_CONST_THEME_DOC_URL . 'change-log/',
                    'target' => '_blank',
                ];

            $menus = apply_filters( 'kinfw-filter/theme/admin-screen/menu', $menus );
            ksort($menus);

            $content = '';

            $content .= '<nav class="nav-tab-wrapper wp-clearfix">';

                foreach( $menus as $menu ) {
                    $content .= sprintf('<a href="%1$s" class="nav-tab %2$s"%3$s>%4$s</a>',
                        $menu['href'],
                        ( $current_screen->id == $menu['id'] ) ? "nav-tab-active" : "",
                        isset( $menu['target'] ) ? " target='". $menu['target'] ."'":"",
                        $menu['title'],
                    );
                }

            $content .= '</nav>';

            return $content;
        }

        public function welcome_screen() {
            require_once get_theme_file_path( 'libraries/admin/screens/class-site-welcome.php' );
        }

        public function plugins_screen() {
            require_once get_theme_file_path( 'libraries/admin/screens/class-site-plugins.php' );
        }

        public function system_info_screen() {
            require_once get_theme_file_path( 'libraries/admin/screens/class-site-system-info.php' );
        }

        public function support_system_screen() {
            require_once get_theme_file_path( 'libraries/admin/screens/class-site-support-system.php' );
        }
    }

}

if( !function_exists( 'kinfw_onnat_theme_admin' ) ) {

    /**
     * Returns the instance of a class.
     */
    function kinfw_onnat_theme_admin() {

        return Onnat_Theme_Admin::get_instance();
    }
}

kinfw_onnat_theme_admin();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */