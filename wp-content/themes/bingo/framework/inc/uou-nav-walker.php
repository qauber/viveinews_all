<?php

class uou_walker_nav_menu extends Walker_Nav_Menu
{

    /**
     * Starts the list before the elements are added.
     *
     * @see Walker::start_lvl()
     *
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
    }


    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0)
      {
           global $wp_query,$wpdb;
           $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

           $class_names = $value = '';

           $classes = empty( $item->classes ) ? array() : (array) $item->classes;

          $has_children = $wpdb -> get_var( "SELECT COUNT(meta_id) FROM {$wpdb->prefix}postmeta WHERE meta_key='_menu_item_menu_item_parent' AND meta_value='" . $item->ID . "'" );

          if ( $has_children > 0 )
          {
              array_push( $classes, "has-submenu" );
          }
          if ($has_children > 0 && $depth >=1){
              array_push( $classes, "dropdown-submenu" );
              
          }
          //current-menu-ancestor

          if (in_array('current-menu-item', $classes, true) || in_array('current_page_item', $classes, true) || in_array('current-menu-ancestor', $classes, true) ) {
              $classes = array_diff($classes, array('current-menu-item', 'current_page_item', 'active'));

              array_push( $classes, "m-active" );
          }


           $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
           $class_names = ' class="'. esc_attr( $class_names ) . '"';



           $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

           $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
           $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
           $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';

           if($item->hash == 1){
            $attributes .= ' data-hover="'. $item->title.'" href="'.get_site_url().'/#'. esc_attr( $item->subtitle ).'" class="scroll"';
           }else{
            $attributes .= ! empty( $item->url )        ? ' data-hover="'. $item->title.'" href="'. esc_attr( $item->url) .'" class="scroll"' : '';
           }


           $prepend = '';
           $append = '';
           $description  = ! empty( $item->description ) ? '<span>'.esc_attr( $item->description ).'</span>' : '';

           if($depth != 0)
           {
             $description = $append = $prepend = "";
           }

            $item_output = $args->before;
            $item_output .= '<a'. $attributes .'>';
            $item_output .= $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;
            $item_output .= $description.$args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
            }
}