<?php
/**
* Top Bar
* Customize the menu output for use with Foundation
*
* @package Minimus
*/

/**
* Build Top Bar
*/
function minimus_build_topbar() {
	if (has_nav_menu( 'primary' ) ) {
		echo wp_nav_menu( array(
			'theme_location' => 'primary',
			'menu_class' => 'right',
			'walker' => new minimus_topbar_walker(),
			'container' => ''
		));
	}
	else {
		echo '<ul class="right">';
			echo '<li><a href="' . admin_url( 'nav-menus.php' ) . '">Add a menu</a></li>';
		echo '</ul>';
	}
}

/**
* Navigation Menu Walker
*/
class minimus_topbar_walker extends Walker_Nav_Menu {
  function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
    $element->has_children = !empty( $children_elements[$element->ID] );
    $element->classes[] = ( $element->current || $element->current_item_ancestor ) ? 'active' : '';
    $element->classes[] = ( $element->has_children ) ? 'has-dropdown' : '';

    parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
  }

  function start_el( &$output, $object, $depth = 0, $args = array(), $current_object_id = 0 ) {
    $item_html = '';
    parent::start_el( $item_html, $object, $depth, $args );

    $classes = empty( $object->classes ) ? array() : (array) $object->classes;

    if( in_array('label', $classes) ) {
      $output .= '<li class="divider"></li>';
      $item_html = preg_replace( '/<a[^>]*>(.*)<\/a>/iU', '<label>$1</label>', $item_html );
    }
    $output .= $item_html;
  }
  function start_lvl( &$output, $depth = 0, $args = array() ) {
    $output .= "\n<ul class=\"sub-menu dropdown\">\n";
  }
}

/**
 * Fixed Navigation
 */
function minimus_fixed_navigation() {
	if (!empty(get_option('minimus_theme_options')['fixed_nav'])) {
		echo " fixed";
	}
}
