<?php 
/**
 * Show thumbnail image sizes in galleries on index/archive pages
 * 
 * @link http://wordpress.stackexchange.com/questions/125781/changing-gallery-images-size
 */
function wprig_gallery_thumbnails( $output, $pairs, $atts ) {
  if( !is_singular() ) {
      $output[ 'size' ] = 'thumbnail';
  }
  return $output;
}
add_filter( 'shortcode_atts_gallery', 'wprig_gallery_thumbnails', 10, 3 );

/**
 * Post Format: Gallery
 * 
 * Get specified number of Gallery images from the first Gallery in a post
 * Used primarily on index and archive pages
 */
function wprig_get_gallery_images( $num = 3 ) {
    
  // Array to hold all the images we retrieve
  $images = get_post_gallery_images();
  if( !empty( $images ) ) { 
      $size = count( $images ) > $num ? $num : count( $images );
      if( has_post_thumbnail() ) $size--;

      $images = array_slice( $images, 0, $size );
      
  }
  return $images;

}

/**
* Post Format: Gallery (Count)
* 
* Count the number of images in the Gallery (or Galleries)
*/
function wprig_get_gallery_count() {
  
  $images = get_post_galleries_images();  // from WordPress 3.6.0

  $total_galleries[] = count( $images );
  $total_galleries[] = count( $images, COUNT_RECURSIVE ) - $total_galleries[0];
  $image = reset( $images );

  return $total_galleries;
}
