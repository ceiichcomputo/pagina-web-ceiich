<?php
/**
 * The template part for displaying overlay content for header section in all single posts.
 *
 */
?>
<div class="kinfw-entry-media-overlay">

    <?php
        /**
         * Date
         */
        printf( '
            <div class="kinfw-meta-date">
                <time datetime="%1$s"> %2$s </time>
            </div>',
            esc_attr( get_the_date( 'c' ) ),
            get_the_date ( get_option('date_format') )
        );

        /**
         * Title
         */
        the_title( '<h4><a href="' . esc_url( get_permalink() ) . '">', '</a></h4>' );
    ?>

    <div class="kinfw-entry-meta-wrap">

        <div class="kinfw-meta-author">
            <?php

                $author_id        = get_post_field( 'post_author', get_the_ID() );
                $author_name      = get_the_author_meta( 'display_name', $author_id );
                $author_posts_url = get_author_posts_url( $author_id );

                printf(
                    '<a href="%1$s" title="%2$s"> %3$s <span> %4$s </span> </a>',
                    esc_url( $author_posts_url ),
                    sprintf( esc_html__( 'Posted by %1$s', 'onnat' ), $author_name ),
                    kinfw_icon( 'user-single' ),
                    sprintf( esc_html__( 'by %1$s', 'onnat' ), $author_name ),
                );
            ?>
        </div>

        <?php
            /**
             * Category List
             */
            $categories_list = get_the_category_list(', ');
            if ( $categories_list ) {

                printf( '
                    <div class="kinfw-meta-cat">
                        %1$s
                        <ul class="kinfw-post-cats-list">
                            <li>
                                %2$s
                            </li>
                        </ul>
                    </div>',
                    kinfw_icon( 'misc-layers' ),
                    str_replace( ', ', ', </li> <li>', $categories_list )
                );
            }
        ?>

        <?php
            if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {

                $zero = sprintf( '%1$s 0 %2$s', kinfw_icon( 'comment-single' ), esc_html__( 'Comment', 'onnat' ) );
                $one  = sprintf( '%1$s 1 %2$s', kinfw_icon( 'comment-single' ), esc_html__( 'Comment', 'onnat' ) );
                $more = sprintf( '%1$s %2$s', kinfw_icon( 'comment-multiple' ), esc_html__( '% Comments', 'onnat' ) );
                $none = sprintf( '%1$s %2$s', kinfw_icon( 'comment-off' ), esc_html__( 'Comments Off', 'onnat' ) );

                echo '<div class="kinfw-meta-comments">';
                    comments_popup_link( $zero, $one, $more, '', $none );
                echo '</div>';
            }
        ?>

    </div>

</div>