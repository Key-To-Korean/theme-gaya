<?php
/**
 * Post Format: Link
 * 
 * Get a screenshot of the first link in a post
 * 
 * @global type $post
 * @param type $width
 */
function wprig_link_screenshot( $width = 150, $url = false ) {
  global $post;
  $first_link = substr( $post->post_content, strpos( $post->post_content, '<a>' ), strpos( $post->post_content, '</a>' ) + 4 );

  preg_match_all( '/<a[^>]+href=([\'"])(.+?)\1[^>]*>/i', $first_link, $site );

  if( !empty( $site[2] ) ) {
      $site_url = $site[2][0]; // something like www.example.com
      
      // Return the whole screenshot in an image tag
      if( !$url ) { 
          
          $query_url = 'http://s.wordpress.com/mshots/v1/';
          $image_tag = '<img class="link-screenshot-img" alt="' . $site_url . '" width="' . $width . '" src="' . $query_url . urlencode(  $site_url ) . '?w=' . $width .'">';
          $text = '<a class="link-screenshot" href="' . $site_url . '">' . $image_tag . '<figcaption class="wp-caption-text">' . str_replace( 'http://', '', $site_url ) . '</figcaption></a>';
      
      // Return only the url
      } else {
          $text = '<a class="link-screenshot" href="http://' . $site_url . '">' . $site_url . '</a>';
      }
      
      echo $text;
  }
}