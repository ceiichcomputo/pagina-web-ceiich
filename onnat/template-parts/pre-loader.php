<?php
/**
 * The template part for displaying preloader.
 *
 */

if( count( $args ) ) {
?>
    <!-- #kinfw-pre-loader -->
    <div id="kinfw-pre-loader">
        <span class="<?php echo esc_attr( $args['name'] );?>"></span>
    </div><!-- /#kinfw-goto-top -->
<?php
}
/* Omit closing PHP tag to avoid "Headers already sent" issues. */