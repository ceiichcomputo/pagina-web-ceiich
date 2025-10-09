<?php
/**
 * Lost password form
 * The template part for displaying woocommerce lost password Form
 * @version 9.2.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_lost_password_form' );
?>

<!-- #kinfw-woo-lost-password-form-wrap -->
<div id="kinfw-woo-lost-password-form-wrap">

    <!-- #kinfw-woo-lost-password-header -->
    <div id="kinfw-woo-lost-password-form-header">
        <?php
            printf( '%1$s
                <h2> %2$s </h2>
                <p> %3$s </p>
                ',
                kinfw_icon( 'user-single' ),
                esc_html__( 'Lost Password', 'onnat' ),
                apply_filters( 'woocommerce_lost_password_message', esc_html__( 'Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'onnat' ) )
            );
        ?>
    </div><!-- /#kinfw-woo-lost-password-header -->

    <form method="post">
        <div class="kinfw-field-wrapper">
            <input type="text" name="user_login" id="user_login" autocomplete="username"/>
            <div class="kinfw-field-placeholder">
                <span><?php esc_html_e('Username or email address', 'onnat'); ?></span>
			</div>
        </div>

        <?php do_action( 'woocommerce_lostpassword_form' ); ?>

		<div class="kinfw-field-wrapper">
            <?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>
            <input type="hidden" name="wc_reset_password" value="true" />
            <button type="submit" value="<?php esc_attr_e( 'Reset password', 'onnat' ); ?>"><?php esc_html_e( 'Reset password', 'onnat' ); ?></button>
        </div>
    </form>

</div><!-- #kinfw-woo-lost-password-form-wrap -->

<?php
do_action( 'woocommerce_after_lost_password_form' );
/* Omit closing PHP tag to avoid "Headers already sent" issues. */