<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( ! class_exists( 'Onnat_Theme_Header_Login_Form' ) ) {

    /**
     * The Onnat header login form class.
     */
    class Onnat_Theme_Header_Login_Form {

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

            printf( '<!-- #kinfw-header-login-form-modal -->
                <div id="kinfw-header-login-form-modal">

                    <div class="kinfw-header-login-form-modal-overlay"></div>

                    <div id="kinfw-header-login-form-modal-content">

                        <a class="kinfw-header-login-form-close" href="javascript:void(0);">%1$s</a>

                        <div class="kinfw-header-login-form-logo">
                            %2$s
                        </div>

                        <div id="kinfw-header-login-form" class="active"> %3$s </div>

                        <div id="kinfw-header-register-form"> %4$s </div>

                        <div id="kinfw-header-reset-pwd-form"> %5$s </div>

                        <div class="kinfw-separator">
                            <span>%6$s</span>
                        </div>

                        <ul class="kinfw-header-login-nav">
                            <li id="kinfw-header-login-form-nav">
                                <a href="#kinfw-header-login-form">
                                    %9$s %7$s
                                </a>
                            </li>

                            <li id="kinfw-header-register-form-nav">
                                <a href="#kinfw-header-register-form">
                                    %8$s %7$s
                                </a>
                            </li>

                            <li id="kinfw-header-reset-pwd-form-nav">
                                <a href="#kinfw-header-reset-pwd-form">
                                </a>
                            </li>
                        </ul>

                    </div>

                </div><!-- / #kinfw-header-login-form-modal -->',
                kinfw_icon( 'math-cross' ), #1
                kinfw_onnat_theme_header()->logo_block( $type = 'logo' ), #2
                $this->login_form(), #3
                $this->registration_form(), #4
                $this->reset_pwd_form(), #5
                apply_filters( 'kinfw-filter/theme/header/action/login-form/separator', esc_html__('or', 'onnat' ) ), #6
                kinfw_icon( 'arrows-simple-right' ), #7
                apply_filters( 'kinfw-filter/theme/header/action/login-form/register', esc_html__('Register', 'onnat' ) ), #8
                apply_filters( 'kinfw-filter/theme/header/action/login-form/back-to-login', esc_html__('Back to login', 'onnat' ) ), #9
            );
        }

        public function login_form() {

            global $wp;

            return sprintf( '<form method="GET">
                    <p class="kinfw-response"></p>
                    <p><input id="%1$s" name="username" type="text" placeholder="%2$s" required/></p>
                    <p><input id="%3$s" name="password" type="password" placeholder="%4$s" required/></p>
                    <div class="kinfw-header-login-links">
                        <div class="kinfw-header-login-remember-me">
                            <label>
                                <input id="%5$s" name="rememberme" type="checkbox" value="forever"/>
                                %6$s
                            </label>
                        </div>
                        <div class="kinfw-header-login-lost-pwd">
                            <a href="javascript:void(0);">%7$s</a>
                        </div>
                    </div>
                    <input type="hidden" name="form-type" value="login"/>
                    <input type="hidden" name="redirect" value="%8$s"/>
                    %9$s
                    <p><button type="submit" data-txt="%10$s">%10$s</button></p>
                </form>',
                esc_attr( uniqid( 'username_' ) ),
                esc_attr__( 'Username', 'onnat' ),
                esc_attr( uniqid( 'password_' ) ),
                esc_attr__( 'Password', 'onnat' ),
                esc_attr( uniqid( 'rememberme_' ) ),
                esc_html__( 'Remember me', 'onnat' ),
                esc_html__( 'Forgot password?', 'onnat' ),
                esc_url( home_url( add_query_arg( [], $wp->request ) ) ),
                wp_nonce_field( 'kinfw-header-login-form-nonce', 'kinfw-header-login-form-nonce', true, false ),
                esc_html__( 'Login', 'onnat' ),
            );
        }

        public function registration_form() {

            global $wp;

            return sprintf( '<form method="GET">
                    <h3>%1$s</h3>
                    <p class="kinfw-response"></p>

                    <p><input id="%2$s" name="username" type="text" placeholder="%3$s" pattern=".{3,}" title="%4$s" required/></p>
                    <p><input id="%5$s" name="email" type="text" placeholder="%6$s" pattern="%7$s" title="%8$s" required/></p>
                    <p><input id="%9$s" name="password" type="password" placeholder="%10$s"  pattern=".{5,}" title="%11$s" required/></p>
                    <p><input id="%12$s" name="confirm-password" type="password" placeholder="%13$s"  pattern=".{5,}" title="%14$s" required/></p>
                    <input type="hidden" name="redirect" value="%15$s"/>
                    <input type="hidden" name="form-type" value="register"/>
                    %16$s
                    <p><button type="submit" data-txt="%17$s">%17$s</button></p>
                </form>',

                esc_html__('Register', 'onnat' ),

                esc_attr( uniqid( 'username_' ) ),
                esc_attr__( 'Username', 'onnat' ),
                esc_attr__( 'Username must contain 3 or more characters.', 'onnat' ),

                esc_attr( uniqid( 'email_' ) ),
                esc_attr__( 'Email', 'onnat' ),
                '[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$',
                esc_attr__( 'The email address isn’t correct.', 'onnat' ),

                esc_attr( uniqid( 'password_' ) ),
                esc_attr__( 'Password', 'onnat' ),
                esc_attr__( 'Password must contain 5 or more characters.', 'onnat' ),

                esc_attr( uniqid( 'confirm_password_' ) ),
                esc_attr__( 'Repeat Password', 'onnat' ),
                esc_attr__( 'Password must contain 5 or more characters.', 'onnat' ),

                esc_url( home_url( add_query_arg( [], $wp->request ) ) ),
                wp_nonce_field( 'kinfw-header-register-form-nonce', 'kinfw-header-register-form-nonce', true, false ),
                esc_html__( 'Register', 'onnat' )
            );

        }

        public function reset_pwd_form() {

            global $wp;

            return sprintf( '<form method="GET">
                    <h3>%1$s</h3>
                    <p class="kinfw-response"></p>
                    <label>%2$s</label>
                    <p><input id="%3$s" name="uname_email" type="text" placeholder="%4$s" required/></p>
                    <input type="hidden" name="form-type" value="reset-pwd"/>
                    <input type="hidden" name="redirect" value="%5$s"/>
                    %6$s
                    <p><button type="submit" data-txt="%7$s">%7$s</button></p>
                </form>',
                esc_html__('Reset Password', 'onnat' ),
                esc_html__('Please enter your username or email address. You will receive an email message with instructions on how to reset your password', 'onnat'),
                esc_attr( uniqid( 'username_email_' ) ),
                esc_html__('User name or email', 'onnat' ),
                esc_url( home_url( add_query_arg( [], $wp->request ) ) ),
                wp_nonce_field( 'kinfw-header-reset-pwd-form-nonce', 'kinfw-header-reset-pwd-form-nonce', true, false ),
                esc_attr__( 'Reset Password', 'onnat' )
            );

        }

    }

    Onnat_Theme_Header_Login_Form::get_instance();

}
/* Omit closing PHP tag to avoid "Headers already sent" issues. */