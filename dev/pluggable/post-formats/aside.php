<?php
/**
 * Filter added to the content for Asides, Links, Quotes, and Statuses to append
 * an infinity sign to the end of that content
 * 
 * @link http://justintadlock.com/archives/2012/09/06/post-formats-aside
 */
// Add infinity link to content - where required
function wprig_infinity_link_content( $content ) {
  if( (   has_post_format( 'aside' ) ||
          has_post_format( 'status' ) ) && !is_singular() ) {
      $content .= '<a class="infinity-link" href="' . esc_url( get_permalink() ) . '">&#8734;</a>';
  } 
  return $content;
}
// Add infinity link to excerpt - where required
function wprig_infinity_link_excerpt( $excerpt ) {
  if( (   has_post_format( 'quote' ) ||
          has_post_format( 'link' ) ) && !is_singular() ) {
      $excerpt .= '<a class="infinity-link" href="' . esc_url( get_permalink() ) . '">&#8734;</a>';
  } 
  return $excerpt;
}
// There are two separate function calls for each filter to avoid doubling up the infinity link in some cases where the excerpt IS the content
add_filter( 'the_content', 'wprig_infinity_link_content', 9 ); // run before wpautop
add_filter( 'the_excerpt', 'wprig_infinity_link_excerpt', 9 );