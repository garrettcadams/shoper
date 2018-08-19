<?php
// Third Party Mega Menu Supports
require_once get_parent_theme_file_path('/includes/menus/maxmegamenu.php'); // Max Mega Menu Support

function ciyashop_add_burger_to_wp_menu ( $items, $args ) {
	
	if( 'primary' !== $args->theme_location ) {
		return $items;
	}
	
	// Add "Burger" to nav menus
	if( ciyashop_header_type() == 'burger-menu' ){
		ob_start();
		?>
		<li class="menu-item menu-item-burger-toggle">
			<?php get_template_part( 'template-parts/header/header-elements/burger-icon' );?>
		</li>
		<?php
		$burger_item = ob_get_clean();
		$items = $items . $burger_item;
	}
	
	// Add "Cart" to nav menus
	if(  ciyashop_header_type() == 'burger-menu' ){
		$search_items = '';
		ob_start();
		?>
		<li class="menu-item menu-item-cart">
			<?php get_template_part( 'woocommerce/custom/minicart-ajax' );?>
		</li>
		<?php
		$search_item = ob_get_clean();
		
		$items = $items . $search_item;
	}
	return $items;
}
add_filter( 'wp_nav_menu_items', 'ciyashop_add_burger_to_wp_menu', 100, 2 );

/*
 * CiyaShop page nav walker for set the default meny without any broken
 */
class CiyaShop_Page_Nav_Walker extends Walker_Page {
	/**
	 * Outputs the beginning of the current element in the tree.
	 *
	 * @see Walker::start_el()
	 * @since 2.1.0
	 * @access public
	 *
	 * @param string  $output       Used to append additional content. Passed by reference.
	 * @param WP_Post $page         Page data object.
	 * @param int     $depth        Optional. Depth of page. Used for padding. Default 0.
	 * @param array   $args         Optional. Array of arguments. Default empty array.
	 * @param int     $current_page Optional. Page ID. Default 0.
	 */
	public function start_el( &$output, $page, $depth = 0, $args = array(), $current_page = 0 ) {
		if ( isset( $args['item_spacing'] ) && 'preserve' === $args['item_spacing'] ) {
			$t = "\t";
			$n = "\n";
		} else {
			$t = '';
			$n = '';
		}
		if ( $depth ) {
			$indent = str_repeat( $t, $depth );
		} else {
			$indent = '';
		}

		$css_class = array( 'menu-item', 'page_item', 'page-item-' . $page->ID );

		if ( isset( $args['pages_with_children'][ $page->ID ] ) ) {
			$css_class[] = 'menu-item-has-children page_item_has_children';
		}

        if ( ! empty( $current_page ) ) {
			$_current_page = get_post( $current_page );
			if ( $_current_page && in_array( $page->ID, $_current_page->ancestors ) ) {
				$css_class[] = 'current-menu-ancestor current_page_ancestor';
			}
			if ( $page->ID == $current_page ) {
				$css_class[] = 'current_page_item';
			} elseif ( $_current_page && $page->ID == $_current_page->post_parent ) {
				$css_class[] = 'current-menu-parent current_page_parent';
			}
		} elseif ( $page->ID == get_option('page_for_posts') ) {
			$css_class[] = 'current-menu-parent current_page_parent';
		}

        /**
		 * Filters the list of CSS classes to include with each page item in the list.
		 *
		 * @since 2.8.0
		 *
		 * @see wp_list_pages()
		 *
		 * @param array   $css_class    An array of CSS classes to be applied
		 *                              to each list item.
		 * @param WP_Post $page         Page data object.
		 * @param int     $depth        Depth of page, used for padding.
		 * @param array   $args         An array of arguments.
		 * @param int     $current_page ID of the current page.
		 */
		$css_classes = implode( ' ', apply_filters( 'page_css_class', $css_class, $page, $depth, $args, $current_page ) );

		if ( '' === $page->post_title ) {
			/* translators: %d: ID of a post */
			$page->post_title = sprintf( esc_html__( '#%d (no title)', 'ciyashop' ), $page->ID );
		}

        $args['link_before'] = empty( $args['link_before'] ) ? '' : $args['link_before'];
		$args['link_after'] = empty( $args['link_after'] ) ? '' : $args['link_after'];

        $output .= $indent . sprintf(
			'<li class="%s"><a href="%s">%s%s%s</a>',
			$css_classes,
			get_permalink( $page->ID ),
			$args['link_before'],
			/** This filter is documented in wp-includes/post-template.php */
			apply_filters( 'the_title', $page->post_title, $page->ID ),
			$args['link_after']
		);

        if ( ! empty( $args['show_date'] ) ) {
            if ( 'modified' == $args['show_date'] ) {
                $time = $page->post_modified;
            } else {
                $time = $page->post_date;
            }

            $date_format = empty( $args['date_format'] ) ? '' : $args['date_format'];
            $output .= " " . mysql2date( $date_format, $time );
        }
    }
	/**
	 * Outputs the beginning of the current level in the tree before elements are output.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @see Walker::start_lvl()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Optional. Depth of page. Used for padding. Default 0.
	 * @param array  $args   Optional. Arguments for outputting the next level.
	 *                       Default empty array.
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		if ( isset( $args['item_spacing'] ) && 'preserve' === $args['item_spacing'] ) {
			$t = "\t";
			$n = "\n";
		} else {
			$t = '';
			$n = '';
		}
		$indent = str_repeat( $t, $depth );
		$output .= "{$n}{$indent}<ul class='sub-menu'>{$n}";
	}
}