<?php
/**
 * My Addresses
 * The template part for displaying woocommerce my addresses
 * @version 9.3.0
 */

defined( 'ABSPATH' ) || exit;

$customer_id      = get_current_user_id();
$kinfw_condition  = ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) ? true : false;
$kinfw_enable_row = $kinfw_condition ? true : false;

if ( $kinfw_condition ) {

	$get_addresses = apply_filters( 'woocommerce_my_account_get_addresses', [
        'billing'  => esc_html__( 'Billing address', 'onnat' ),
        'shipping' => esc_html__( 'Shipping address', 'onnat' ),
    ], $customer_id );

} else {

	$get_addresses = apply_filters( 'woocommerce_my_account_get_addresses', [
        'billing' => esc_html__( 'Billing address', 'onnat' ),
    ], $customer_id );

}

printf( '<p> %1$s </p>',
    apply_filters( 'woocommerce_my_account_my_address_description', esc_html__( 'The following addresses will be used on the checkout page by default.', 'onnat' ) )
);

if( $kinfw_condition ) {

    print( '<div class="kinfw-row kinfw-woo-addresses">' );
}

    foreach ( $get_addresses as $name => $address_title ) :
        $address = wc_get_account_formatted_address( $name );
        ?>
            <div class="kinfw-col-12 kinfw-col-sm-6">
                <div class="kinfw-woo-inner-address">
                    <div class="kinfw-woo-address-title">
                        <h3><?php echo esc_html( $address_title ); ?></h3>
                        <a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address', $name ) ); ?>" class="edit">
                            <?php
                                if( $address ) {
                                    echo esc_html__( 'Edit', 'onnat' );
                                } else {
                                    echo esc_html__( 'Add', 'onnat' );
                                }
                            ?>
                        </a>
                    </div>
                    <address>
                        <?php 
                            if( $address ) {
                                echo  wp_kses_post( $address );
                            } else {
                                esc_html_e( 'You have not set up this type of address yet.', 'onnat' );
                            }
                        ?>
                    </address>
                </div>
            </div>
        <?php
    endforeach;

if( $kinfw_condition ) {

    print( '</div>' );
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */