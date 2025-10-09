<?php
/**
 * Template Name: Fluid Width Template
 * Template Post Type: Product
 *
 * The template for woo product post type with container fluid layout
 *
 */
get_header( 'fluid' );
?>
<!-- #kinfw-main-content -->
<div id="kinfw-main-content" class="kinfw-has-no-sidebar">

    <!-- #primary -->
    <div id="primary" class="kinfw-content-holder">
        <?php
            woocommerce_content();
        ?>
    </div><!-- /#primary -->

</div><!-- /#kinfw-main-content -->
<?php
get_footer();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */