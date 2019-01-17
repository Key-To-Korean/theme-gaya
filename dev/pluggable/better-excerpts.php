<?php
/**
 * Better Post Excerpts
 * 
 * Based on Post Format, it trims the excerpt in various ways and returns various pieces of content
 */
function wprig_better_excerpts( $text, $raw_excerpt ) {
    
  /**
   * Post Format: Quote
   * 
   * Only get the first <blockquote> from a Post Format quote (no additional writing) 
   * for the index and archive pages.
   * 
   * @link http://www.codecheese.com/2013/11/get-the-first-paragraph-as-an-excerpt-for-wordpress/
   */
  if( 'quote' === get_post_format() && !$raw_excerpt ) {
      if( !$raw_excerpt ) {
          $content = apply_filters( 'the_content', get_the_content() );
          $text = substr( $content, 0, strpos( $content, '</blockquote>' ) + 13 );
      } else {
          $text = apply_filters( 'the_excerpt', get_the_excerpt() );
      } 
  }
  
  /**
   * Post Format: Chat
   * 
   * Retrieve the first 100 characters of the chat as styled post content (not the unstyled excerpt)
   */
  else if( 'chat' === get_post_format() && !$raw_excerpt ) {
      $content = apply_filters( 'the_content', get_the_content() );
      $text = substr( $content, 0, 500 ) . '…';
  }
      
  // Return the result
  return $text;
  
}
add_filter( 'wp_trim_excerpt', 'wprig_better_excerpts', 5, 2 );

/*
 * Add Excerpts to Pages
 */
function wprig_add_excerpt_to_pages() {
  add_post_type_support( 'page', 'excerpt' );
}
add_action( 'init', 'wprig_add_excerpt_to_pages' );

/**
 * Customize ellipsis at end of excerpts.
 */
function wprig_excerpt_more( $more ) {
  $more_str = "<a class='read-more' href='" . get_permalink() . "'><span class='screen-reader-text'>Continue reading " . get_the_title() . "</span><i class='fa fa-link'></i></a>";
  return $more_str;
}
add_filter( 'excerpt_more', 'wprig_excerpt_more' );

/**
* Filter excerpt length to 100 words.
*/
function wprig_excerpt_length( $length ) {
  return 40;
}
add_filter( 'excerpt_length', 'wprig_excerpt_length' );

/**
* Fancy excerpts
* 
* @link: http://wptheming.com/2015/01/excerpt-versus-content-for-archives/
*/
function wprig_fancy_excerpt() {
	global $post;
  if ( has_excerpt() ) :
      the_excerpt();
  elseif ( @strpos ( $post->post_content, '<!--more-->' ) ) :
      the_content();
  elseif ( str_word_count ( $post->post_content ) < 40 ) :
      the_content();
  else :
      the_excerpt();
  endif;
}

/**
 * Trims the excerpt allowing links.
 *
 * I got this nice funcion from here
 *   https://lewayotte.com/2010/09/22/allowing-hyperlinks-in-your-wordpress-excerpts/
 * If you want to understand this code, you should definitely visit this link
 *
 * @param string $text Text to trim keeping links
 */
function new_wp_trim_excerpt($text)
{
    $raw_excerpt = $text;
    if ('' == $text) {
        $text = get_the_content('');

        $text = strip_shortcodes($text);

        $text = apply_filters('the_content', $text);
        $text = str_replace(']]>', ']]>', $text);
        /*
         * Hi, future...
         *
         * Maybe I should not allow iframes... but I want the videos
         * to show in the excerpt too, maybe I will remove <iframe> from
         * here and add post custom field to add video right after the post content
         */
        $text = strip_tags($text, '<a><iframe><p><br><strong><ul><li>');
        $excerpt_length = apply_filters('excerpt_length', 55);
        $excerpt_length = 155;

        $excerpt_more = apply_filters('excerpt_more', ' '.'[...]');
        $words = preg_split('/(<a.*?a>)|\n|\r|\t|\s/', $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
        if (count($words) > $excerpt_length) {
            array_pop($words);
            $text = implode(' ', $words);
            $text = $text.$excerpt_more;
        } else {
            $text = implode(' ', $words);
        }
    }

    return apply_filters('new_wp_trim_excerpt', $text, $raw_excerpt);
}

// remove_filter('get_the_excerpt', 'wp_trim_excerpt');
// add_filter('get_the_excerpt', 'new_wp_trim_excerpt');
