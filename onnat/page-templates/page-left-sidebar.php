<?php
/**
 * Template Name: Left Sidebar Template
 * Template Post Type: page
 *
 * The template for page with left sidebar layout.
 */
get_header();

$sidebars = [];
$slug     = get_page_template_slug();
$meta     = get_post_meta( get_the_ID(), '_kinfw_page_template', true );
$meta     = apply_filters( 'kinfw-filter/theme/util/is-array', $meta );

if( $slug == 'theme_global_template' ) {

    $meta['sidebars'] = kinfw_onnat_theme_options()->kinfw_get_option( 'single_page_sidebars' );

}

/**
 * Tweak to show default widget area, if our core plugin is not activated.
 */
if( !function_exists( 'kf_onnat_extra_plugin' ) ) {
    $meta['sidebars'] = ['default-widget-area'];
}

if( isset( $meta['sidebars'] ) && is_array( $meta['sidebars'] ) ) {

    $sidebars = kinfw_onnat_theme_widget_areas()->active_widget_areas( $meta['sidebars'] );
}

$class = count( $sidebars ) ? 'kinfw-has-sidebar kinfw-sidebar-left' : 'kinfw-has-no-sidebar';
?>

<!-- #kinfw-main-content -->
<div id="kinfw-main-content" class="<?php echo esc_attr( $class ); ?>">

    <!-- #primary -->
    <div id="primary" class="kinfw-content-holder">

        <?php
            // Start the loop.
            while( have_posts() ) :

                the_post();

                // Include the page content template.
                get_template_part( 'content', 'page' );

                // If comments are open or we have at least one comment, load up the comment template.
                if ( comments_open() || get_comments_number() ) :

                    comments_template();
                endif;

            endwhile;
            // End the loop.
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