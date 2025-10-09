<?php
/**
 * The template for product with no sidebar layout.
 *
 */
get_header();
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