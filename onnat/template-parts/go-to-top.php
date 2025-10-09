<?php
/**
 * The template part for displaying go to top.
 *
 */

if( count( $args ) ) {
?>
    <!-- #kinfw-goto-top -->
    <div id="kinfw-goto-top"
        class="kinfw-goto-top-dir-<?php echo esc_attr( $args['dir'] );?>"
        data-speed="<?php echo esc_attr( $args['speed'] );?>">
            <?php echo kinfw_icon( $args['icon'] ); ?>
    </div><!-- /#kinfw-goto-top -->
<?php
}
/* Omit closing PHP tag to avoid "Headers already sent" issues. */