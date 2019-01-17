<?php
/**
 * Filter a Quote Post Format to add <blockquote> around the whole thing if 
 * no existing tag is found
 * 
 * @link https://github.com/justintadlock/hybrid-core/blob/master/inc/functions-formats.php
 */
function wprig_quote_blockquote( $excerpt ) {
  if( 'quote' === get_post_format() ) {
      preg_match( '/<blockquote.*?>/', $excerpt, $matches );
      
      if( empty( $matches ) ) {
          $excerpt = "<blockquote>{$excerpt}</blockquote>";
      }
  }
  
  return $excerpt;
}
add_filter( 'the_excerpt', 'wprig_quote_blockquote', 8 ); // run before wpautop

/**
 * Post Format: Quote
 * 
 * Get the first <blockquote> from the content, assume this is the quote we want
 */
function wprig_get_the_quote() {
    
  $content = apply_filters( 'the_content', get_the_content() );
  preg_match( '/<blockquote.*?>/', $content, $matches );

  if( empty( $matches ) ) {
      $content = "<blockquote>{$content}</blockquote>";
  } else {
      $content = substr( $content, strpos( $content, '<blockquote>' ), strpos( $content, '</blockquote>' ) + 13 );
  }
  
  echo $content;
}