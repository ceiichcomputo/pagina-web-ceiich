<?php
/**
 * The template for displaying all woocommerce pages.
 *
 */

get_header();

$page_settings = kinfw_onnat_theme_blog_utils()->layout( '', '' );

if( is_shop() ) {

    $page_settings = kinfw_onnat_theme_blog_utils()->layout( 'shop_template', 'shop_sidebars' );

} elseif( is_product_category() || is_product_tag() ) {

    $page_settings = kinfw_onnat_theme_blog_utils()->layout( 'woo_archive_template', 'woo_archive_sidebars' );

}

extract( $page_settings );
?>
<!-- #kinfw-main-content -->
<div id="kinfw-main-content" class="<?php echo esc_attr( $class );?>">

    <!-- #primary -->
    <div id="primary" class="kinfw-content-holder">
        <?php
            woocommerce_content();
        ?>
    </div><!-- /#primary -->

    <?php

        /**
         * Loads a sidebar template part.
         */
        get_template_part( 'sidebar', '', [ 'sidebars' => $sidebars ] );

    ?>

</div><!-- /#kinfw-main-content -->

<?php
get_footer();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */