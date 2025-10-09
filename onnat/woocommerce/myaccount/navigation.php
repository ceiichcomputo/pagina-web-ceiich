<?php
/**
 * My Account navigation
 * The template part for displaying woocommerce my account navigation
 * @version 9.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$icons = apply_filters( 'kinfw-filter/theme/woo/my-account/navigation/nav-icons', [] );
do_action( 'woocommerce_before_account_navigation' );
?>
<div class="kinfw-row">

    <div class="kinfw-col-lg-4 kinfw-col-12">
        <nav class="kinfw-woo-myaccount-navigation">
            <ul>
                <?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
                    <li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
                        <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>">
                            <?php
                                if( !empty( $icons ) && !empty( $icons[ $endpoint ] ) ) {
                                    echo kinfw_icon( $icons[ $endpoint ], 'kinfw-woo-myaccount-nav-icon' );
                                }

                                echo esc_html( $label );
                            ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </div>

<?php
do_action( 'woocommerce_after_account_navigation' );
/* Omit closing PHP tag to avoid "Headers already sent" issues. */