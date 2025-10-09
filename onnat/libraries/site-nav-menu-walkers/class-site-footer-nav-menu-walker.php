<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Onnat_Theme_Footer_Nav_Menu_Walker' ) ) {

	/**
	 * The Onnat Theme Footer Bottom Navigation Menu Walker class.
     * Hint: We just removed the id and class attribute for menu item ( <li> )
	 */
    class Onnat_Theme_Footer_Nav_Menu_Walker extends Walker_Nav_Menu {

        public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
            // Restores the more descriptive, specific name for use within this method.
            $menu_item = $data_object;

            if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
                $t = '';
                $n = '';
            } else {
                $t = "\t";
                $n = "\n";
            }
            $indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

            /**
             * Filters the arguments for a single nav menu item.
             *
             * @since 4.4.0
             *
             * @param stdClass $args      An object of wp_nav_menu() arguments.
             * @param WP_Post  $menu_item Menu item data object.
             * @param int      $depth     Depth of menu item. Used for padding.
             */
            $args = apply_filters( 'nav_menu_item_args', $args, $menu_item, $depth );


            $output .= $indent . '<li>';

            $atts           = [];
            $atts['title']  = ! empty( $menu_item->attr_title ) ? $menu_item->attr_title : '';
            $atts['target'] = ! empty( $menu_item->target ) ? $menu_item->target : '';
            if ( '_blank' === $menu_item->target && empty( $menu_item->xfn ) ) {
                $atts['rel'] = 'noopener';
            } else {
                $atts['rel'] = $menu_item->xfn;
            }

            if ( ! empty( $menu_item->url ) ) {
                if ( get_privacy_policy_url() === $menu_item->url ) {
                    $atts['rel'] = empty( $atts['rel'] ) ? 'privacy-policy' : $atts['rel'] . ' privacy-policy';
                }

                $atts['href'] = $menu_item->url;
            } else {
                $atts['href'] = '';
            }

            $atts['aria-current'] = $menu_item->current ? 'page' : '';

            /**
             * Filters the HTML attributes applied to a menu item's anchor element.
             *
             * @since 3.6.0
             * @since 4.1.0 The `$depth` parameter was added.
             *
             * @param array $atts {
             *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
             *
             *     @type string $title        Title attribute.
             *     @type string $target       Target attribute.
             *     @type string $rel          The rel attribute.
             *     @type string $href         The href attribute.
             *     @type string $aria-current The aria-current attribute.
             * }
             * @param WP_Post  $menu_item The current menu item object.
             * @param stdClass $args      An object of wp_nav_menu() arguments.
             * @param int      $depth     Depth of menu item. Used for padding.
             */
            $atts = apply_filters( 'nav_menu_link_attributes', $atts, $menu_item, $args, $depth );

            $attributes = '';
            foreach ( $atts as $attr => $value ) {
                if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
                    $value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }

            /** This filter is documented in wp-includes/post-template.php */
            $title = apply_filters( 'the_title', $menu_item->title, $menu_item->ID );

            /**
             * Filters a menu item's title.
             *
             * @since 4.4.0
             *
             * @param string   $title     The menu item's title.
             * @param WP_Post  $menu_item The current menu item object.
             * @param stdClass $args      An object of wp_nav_menu() arguments.
             * @param int      $depth     Depth of menu item. Used for padding.
             */
            $title = apply_filters( 'nav_menu_item_title', $title, $menu_item, $args, $depth );

            $item_output  = $args->before;
            $item_output .= '<a' . $attributes . '>';
            $item_output .= $args->link_before . $title . $args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;

            /**
             * Filters a menu item's starting output.
             *
             * The menu item's starting output only includes `$args->before`, the opening `<a>`,
             * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
             * no filter for modifying the opening and closing `<li>` for a menu item.
             *
             * @since 3.0.0
             *
             * @param string   $item_output The menu item's starting HTML output.
             * @param WP_Post  $menu_item   Menu item data object.
             * @param int      $depth       Depth of menu item. Used for padding.
             * @param stdClass $args        An object of wp_nav_menu() arguments.
             */
            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $menu_item, $depth, $args );
        }

    }

}
/* Omit closing PHP tag to avoid "Headers already sent" issues. */