<?php
/*
 * Better Recent Comments widget.
 * 
 * This code adds a new widget that shows commenter avatar, and comment excerpt.
 * Gently lifted and reworked from Anders Norén's Lovecraft theme: http://www.andersnoren.se/teman/lovecraft-wordpress-theme/
 * 
 * @source https://github.com/mor10/popper/blob/master/widgets/recent-comments.php
 */

class wprig_recent_comments extends WP_Widget {
    
	function __construct() {
            
                $widget_ops = array( 
                        'classname' => 'widget_recent_comments', 
                        'description' => __( 'Displays recent comments with user avatar and excerpt.', 'wprig' ) 
                );
                parent::__construct( 'widget_wprig_recent_comments', __( 'Better Recent Comments', 'wprig' ), $widget_ops );
        
        } // __construct()
        
	function widget( $args, $instance ) {
            
		// Outputs the content of the widget
		extract( $args ); // Make before_widget, etc available.
                
		$widget_title = null;
		$number_of_comments = null;
                
		$widget_title = esc_attr( apply_filters( 'widget_title', $instance[ 'widget_title' ] ) );
		$number_of_comments = esc_attr( $instance[ 'number_of_comments' ] );
                
		echo $before_widget;
                
		if ( ! empty( $widget_title ) ) {
			echo $before_title . $widget_title . $after_title;
		} else {
			echo $before_title . esc_html__( 'Better Comments', 'wprig' ) . $after_title;
		}
		?>

			<ul class="wprig-widget-list">

				<?php
                                        if ( $number_of_comments == 0 ) { $number_of_comments = 6; }
                                        
					$args = array(
                                                'orderby'   => 'date',
                                                'number'    => $number_of_comments,
                                                'status'    => 'approve',
                                                'type'      => 'comment'
					);
                                        
					global $comment;
                                        
					// The Query
					$comments_query = new WP_Comment_Query;
					$comments = $comments_query->query( $args );
                                        
					// Comment Loop
					if ( $comments ) : $count = 1;
						foreach ( $comments as $comment ) : ?>

							<li class="recentcomments <?php echo $count % 2 == 0 ? 'even' : 'odd'; ?>">
								<div class="post-icon">
									<?php echo get_avatar( get_comment_author_email( $comment->comment_ID ), $size = '60' ); ?>
								</div>
								<div class="comment-meta">
									<span class="comment-author-link"><?php comment_author_link(); ?></span> <?php _e( 'said:', 'wprig' ); ?> 
									<p class="excerpt rssSummary"><?php echo esc_attr( comment_excerpt( $comment->comment_ID ) ); ?></p>	
								</div>
								<a href="<?php echo get_permalink( $comment->comment_post_ID ); ?>#comment-<?php echo $comment->comment_ID; ?>">
									<h4 class="title"><?php the_title_attribute( array( 'post' => $comment->comment_post_ID ) ); ?></h4>
								</a>
							</li>

						<?php 
						$count++;
						endforeach;
					endif;
				?>

			</ul><!-- .wprig-widget-list -->

		<?php echo $after_widget;
                
	} // function widget()
        
	function update( $new_instance, $old_instance ) {
            
		$instance = $old_instance;
		$instance[ 'widget_title' ] = strip_tags( $new_instance[ 'widget_title' ] );
                
                // make sure we are getting a number
                $instance[ 'number_of_comments' ] = is_int( intval( $new_instance[ 'number_of_comments' ] ) ) ? intval( $new_instance[ 'number_of_comments' ] ) : 5;
                
		//update and save the widget
		return $instance;
                
	}// function update()
        
	function form( $instance ) {
            
		// Set defaults
		if ( ! isset( $instance[ "widget_title" ] ) ) { $instance[ "widget_title" ] = ''; }
		if ( ! isset( $instance[ "number_of_comments" ] ) ) { $instance[ "number_of_comments" ] = '5'; }
                
		// Get the options into variables, escaping html characters on the way
		$widget_title = esc_attr( $instance[ 'widget_title' ] );
		$number_of_comments = esc_attr( $instance[ 'number_of_comments' ] );
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'widget_title' ) ); ?>"><?php  _e( 'Title', 'wprig' ); ?>:
			<input id="<?php echo esc_attr( $this->get_field_id( 'widget_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'widget_title' ) ); ?>" type="text" class="widefat" value="<?php echo esc_attr( $widget_title ); ?>" /></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'number_of_comments' ); ?>"><?php _e( 'Number of comments to display', 'wprig' ); ?>:
			<input id="<?php echo $this->get_field_id( 'number_of_comments' ); ?>" name="<?php echo $this->get_field_name( 'number_of_comments' ); ?>" type="text" class="widefat" value="<?php echo esc_attr( $number_of_comments ); ?>" /></label>
			<small>(<?php _e( 'Defaults to 5 if empty', 'wprig' ); ?>)</small>
		</p>

		<?php
                
	} // function form()
}
register_widget( 'wprig_recent_comments' );

/* @TODO Add a Customizer option for this
/**
 * Replace Recent Comments Widget with a Better Recent Comments Widget
 * (It includes gravatar author image)
 * 
 * @source https://github.com/mor10/popper/blob/master/widgets/recent-comments.php
 
function wprig_comments_widget_registration() {
	unregister_widget( 'WP_Widget_Recent_Comments' );
	register_widget( 'wprig_recent_comments' );
}
add_action( 'widgets_init', 'wprig_comments_widget_registration' );
*/