<?php
/**
 * Login Form
 * The template part for displaying woocommerce login form
 * @version 9.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

do_action( 'woocommerce_before_customer_login_form' );
?>
<!-- #kinfw-woo-form-login-wrap -->
<div id="kinfw-woo-form-login-wrap">

    <!-- #kinfw-woo-login-form-wrap -->
    <div id="kinfw-woo-login-form-wrap">

        <!-- #kinfw-woo-login-form-header -->
        <div id="kinfw-woo-login-form-header">
            <?php
                printf( '%1$s
                    <h2> %2$s </h2>
                    <p> %3$s </p>
                    ',
                    kinfw_icon( 'user-single' ),
                    esc_html__( 'Welcome Back!', 'onnat' ),
                    sprintf( esc_html__('Use Your %1$s Account', 'onnat' ), get_bloginfo ('name') )
                );
            ?>
        </div><!-- #kinfw-woo-login-form-header -->

        <form method="post">

            <?php do_action( 'woocommerce_login_form_start' ); ?>

			<div class="kinfw-field-wrapper">
				<input type="text" name="username" id="username" autocomplete="username"
					value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>"/>
				<div class="kinfw-field-placeholder">
					<span><?php esc_html_e('Username or email address', 'onnat'); ?></span>
				</div>
			</div>

			<div class="kinfw-field-wrapper">
				<input type="password" name="password" id="password" autocomplete="current-password"/>
				<div class="kinfw-field-placeholder">
					<span><?php esc_html_e('Password', 'onnat'); ?></span>
				</div>
			</div>

			<?php do_action( 'woocommerce_login_form' ); ?>

			<div class="kinfw-field-wrapper">
				<div class="kinfw-field-login-remember-me">
					<input name="rememberme" type="checkbox" id="rememberme" value="forever"/>
					<span><?php esc_html_e( 'Remember me', 'onnat' ); ?></span>
				</div>
				<div class="kinfw-field-lost-pwd">
					<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'onnat' ); ?></a>
				</div>
			</div>

			<div class="kinfw-field-wrapper">
				<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
				<button type="submit" name="login" value="<?php esc_attr_e( 'Log in', 'onnat' ); ?>"><?php esc_html_e( 'Log in', 'onnat' ); ?></button>
			</div>

            <?php do_action( 'woocommerce_login_form_end' ); ?>

        </form>

    </div>

    <?php
        if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) :
    ?>

        <!-- #kinfw-woo-register-form-wrap -->
        <div id="kinfw-woo-register-form-wrap">

            <!-- #kinfw-woo-register-form-header -->
            <div id="kinfw-woo-register-form-header">
                <?php
                    printf( '%1$s
                        <h2> %2$s </h2>
                        <p> %3$s </p>
                        ',
                        kinfw_icon( 'user-single' ),
                        esc_html__( 'Register', 'onnat' ),
                        sprintf( esc_html__('Create Your %1$s Account', 'onnat' ), get_bloginfo ('name') )
                    );
                ?>
            </div><!-- / #kinfw-woo-register-form-header -->

            <form method="post" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

                <?php do_action( 'woocommerce_register_form_start' ); ?>

                <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
                    <div class="kinfw-field-wrapper">
                        <input
                            type="text"
                            name="username"
                            id="reg_username"
                            autocomplete="username"
                            pattern=".{3,}"
                            value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>"
                        />
                        <div class="kinfw-field-placeholder">
                            <span><?php esc_html_e('Username', 'onnat'); ?></span>
						</div>
					</div>
                <?php endif; ?>

                <div class="kinfw-field-wrapper">
                    <input
                        type="text"
                        name="email"
                        id="reg_email"
                        autocomplete="email"
                        value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>"
                    />
                    <div class="kinfw-field-placeholder">
                        <span><?php esc_html_e('Email address', 'onnat'); ?></span>
					</div>
				</div>

                <div class="kinfw-field-wrapper">
                    <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
                        <input type="password" name="password" id="reg_password" autocomplete="current-password"/>
                        <div class="kinfw-field-placeholder">
                            <span><?php esc_html_e('Password', 'onnat'); ?></span>
						</div>
					<?php else: ?>
                        <p><?php esc_html_e( 'A password will be sent to your email address.', 'onnat' ); ?></p>
					<?php endif; ?>
				</div>
                <?php do_action( 'woocommerce_register_form' ); ?>

                <div class="kinfw-field-wrapper">
                    <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                    <button type="submit" name="register" value="<?php esc_attr_e( 'Register', 'onnat' ); ?>"><?php esc_html_e( 'Register', 'onnat' ); ?></button>
				</div>

                <?php do_action( 'woocommerce_register_form_end' ); ?>

            </form>

        </div>

        <div class="kinfw-separator">
            <span>
                <?php esc_html_e('or', 'onnat' ); ?>
            </span>
        </div>

        <ul class="kinfw-woo-login-nav">
            <li id="kinfw-woo-login-form-nav">
                <a href="#kinfw-woo-login-form-wrap">
                    <?php
                        esc_html_e('Back to login', 'onnat' );
                        echo kinfw_icon( 'arrows-simple-right' );
                    ?>
                </a>
            </li>
            <li id="kinfw-woo-register-form-nav">
                <a href="#kinfw-woo-register-form-wrap">
                    <?php
                        esc_html_e('Register', 'onnat' );
                        echo kinfw_icon( 'arrows-simple-right' );
                    ?>
                </a>
            </li>
        </ul>

    <?php
        endif;
    ?>
</div><!-- #kinfw-woo-form-login-wrap -->
<?php
do_action( 'woocommerce_after_customer_login_form' );
/* Omit closing PHP tag to avoid "Headers already sent" issues. */