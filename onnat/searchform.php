<?php
/**
 * The searchform.php template.
 * Used any time that get_search_form() is called.
 *
 */

$unique_id   = esc_attr( uniqid( 'search-form-' ) );
$placeholder = esc_html__("Search &hellip;",'onnat');
$s           = empty($_GET['s']) ? $placeholder : get_search_query();
?>
<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <input
        id          = "<?php echo esc_attr( $unique_id ); ?>"
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