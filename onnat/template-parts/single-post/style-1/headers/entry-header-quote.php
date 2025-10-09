<?php
/**
 * The template part for displaying header section in single posts for quote format.
 *
 */

$post_id      = get_the_ID();
$meta         = get_post_meta( $post_id, '_kinfw_quote_post', true );
$quote        = ( isset( $meta['quote'] ) && !empty( $meta['quote'] ) ) ? $meta['quote'] : '';
$quote_author = ( isset( $meta['author'] ) && !empty( $meta['author'] ) ) ? $meta['author'] : '';

if( !empty( $quote )  ) :
?>

<!-- .kinfw-blog-single-fw -->
<div class="kinfw-blog-single-fw">

    <header class="kinfw-entry-header">

        <?php

            $inline_style = '';

            if( has_post_thumbnail() ) {
                $bg           = wp_get_attachment_url ( get_post_thumbnail_id() );
                $inline_style = 'style="background:url('. esc_url( $bg ) .') center center no-repeat"';
            }

            printf(
                '<div class="kinfw-entry-media-wrap kinfw-blog-single-format-quote" %1$s>
                    <div class="kinfw-entry-format-quote-wrap">
                        <blockquote>
                            <q>%2$s</q>
                            %3$s
                        </blockquote>
                    </div>
                </div>',
                $inline_style,
                esc_html( $quote ),
                !empty( $quote_author ) ? sprintf( '<cite>%1$s</cite>', esc_html( $quote_author ) ) : ''
            );

            get_template_part( 'template-parts/single-post/style-1/headers/entry-header-overlay' );
        ?>

    </header>

</div><!-- /.kinfw-blog-single-fw -->
<?php
else:
    get_template_part( 'template-parts/single-post/style-1/headers/entry-header' );
endif;