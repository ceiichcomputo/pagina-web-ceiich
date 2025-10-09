<?php
/**
 * The template for displaying post content in style-2.
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'kinfw-blog-single kinfw-single-post' ); ?>>

    <?php
        /**
         * Include the post format-specific template for the header content.
         */
        get_template_part( 'template-parts/single-post/style-2/headers/entry-header', get_post_format() );
    ?>

    <div class="kinfw-entry-content-wrap">

        <?php
            /**
             * Include Meta
             */
            get_template_part( 'template-parts/single-post/style-2/entry-meta' );
        ?>

        <header class="kinfw-entry-header">
            <?php
                /**
                 * Title
                 */
                the_title( '<h4><a href="' . esc_url( get_permalink() ) . '">', '</a></h4>' );
            ?>
        </header>

        <?php
            /**
             * Include Content
             */
            get_template_part( 'template-parts/single-post/style-2/entry-content' );

            /**
             * Include Footer
             */
            get_template_part( 'template-parts/single-post/style-2/entry-footer' );
        ?>
    </div>

</article>
<?php
    /**
     * Include Author Bibiographical Info
     */
        $author_bio = kinfw_onnat_theme_options()->kinfw_get_option( 'show_author_bio' );
        if( $author_bio ) {

            get_template_part( 'template-parts/single-post/entry-author-bio' );
        }

    /**
     * Include Navigation
     */
        get_template_part( 'template-parts/single-post/entry-navigation' );

    /**
     * Include Related Posts
     */
        $related_posts = kinfw_onnat_theme_options()->kinfw_get_option( 'show_related_posts' );
        if( $related_posts ) {

            $style          = kinfw_onnat_theme_options()->kinfw_get_option( 'related_posts_type' );
            $posts_per_page = isset( $args[ 'related_posts_count' ] ) ? $args[ 'related_posts_count' ] : 2;

            get_template_part( 'template-parts/single-post/entry-related-posts', $style, [ 'post_id' => get_the_ID(), 'posts_per_page' => $posts_per_page ] );
        }

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
