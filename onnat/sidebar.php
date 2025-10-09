<?php
/**
 * The template part for displaying widget areas.
 */

if( count( $args['sidebars'] ) ) {
?>
    <!-- #secondary -->
    <div id="secondary" class="kinfw-sidebar-holder">
        <?php
            foreach( $args['sidebars'] as $sidebar ) {

                dynamic_sidebar( $sidebar );

            }
        ?>
    </div><!-- /#secondary -->
<?php
}
/* Omit closing PHP tag to avoid "Headers already sent" issues. */