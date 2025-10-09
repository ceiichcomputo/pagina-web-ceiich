<?php
/**
 * The template for displaying product search form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/product-searchform.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;
$placeholder = esc_html__("Search products &hellip;",'onnat');
$s           = empty($_GET['s']) ? $placeholder : get_search_query();

?>
<form method="get" class="woocommerce-product-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <input type="hidden" name="post_type" value="product" />

    <input
        id          = "woocommerce-product-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>"
        name        = "s"
        type        = "search"
        class       = "kinfw-search-field"
        value       = "<?php echo esc_attr( $s );?>"
        onblur      = "if(this.value===''){this.value='<?php echo esc_attr($s);?>';}"
        onfocus     = "if(this.value ==='<?php echo esc_attr($s);?>') {this.value=''; }"
        placeholder = "<?php echo esc_attr( $placeholder ); ?>"
    />

    <button type="submit" class="kinfw-search-submit">
        <?php echo kinfw_icon( 'misc-search' ); ?>
    </button>
</form>