<?php

/*
 * Better Recent Posts widget.
 * 
 * This code adds a new widget that shows the featured image, post title, and publishing date.
 * Gently lifted and reworked from Anders Norén's Lovecraft theme: http://www.andersnoren.se/teman/popper-wordpress-theme/
 * 
 * @source https://github.com/mor10/popper/blob/master/widgets/recent-posts.php
 */
class wprig_recent_posts extends WP_Widget {
		
	function __construct() {
						
			$widget_ops = array( 
					'classname' => 'widget_recent_entries', 
					'description' => __( 'Displays most recent posts with featured image and publishing date.', 'wprig' ) 
			);
			parent::__construct( 'widget_wprig_recent_posts', __( 'Better Recent Posts','wprig' ), $widget_ops );
	
	}
				
	function widget( $args, $instance ) {
						
		// Outputs the content of the widget
		extract( $args ); // Make before_widget, etc available.
								
		$widget_title = null;
		$number_of_posts = null;
								
		// $widget_title = esc_attr( apply_filters( 'widget_title', $instance[ 'widget_title' ] ) ) || esc_html__( 'Better Posts', 'wprig' );
		// $number_of_posts = esc_attr( $instance[ 'number_of_posts' ] ) || 0;
								
								
		echo $before_widget;
								
		if ( ! empty( $widget_title ) ) {
			echo $before_title . $widget_title . $after_title;
		} else {
			echo $before_title . esc_html__( 'Better Posts', 'wprig' ) . $after_title;
		}
		?>

		<ul class="wprig-widget-list">

		<?php
		if ( $number_of_posts == 0 ) { $number_of_posts = 4; }
		
		$recent_posts = new WP_Query( apply_filters(
				'wprig_recent_posts_args', array(
						'posts_per_page'			=> $number_of_posts,
						'post_status'				 => 'publish',
						'ignore_sticky_posts' => true
				) 
		) );
		
		if ( $recent_posts->have_posts() ) :
			$count = 1;
			while ( $recent_posts->have_posts() && $count <= $number_of_posts ) : $recent_posts->the_post(); ?>

			<li class="<?php echo $count % 2 == 0 ? 'even' : 'odd'; ?>">
				<?php global $post; ?>
	
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="post-icon" aria-hidden="true" style="background-image: url('<?php the_post_thumbnail_url(); ?>')">
						</div>
					<?php endif; ?>

					<div class="entry-header">
						<!-- <div class="cat-links"> -->
							<?php // wprig_post_categories(); ?>
						<!-- </div> -->
						<a class="rsswidget" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
							<h4 class="title"><?php the_title(); ?></h4>
						</a>
					</div>

					<div class="entry-meta">
						<p class="entry-excerpt"><?php the_excerpt(); ?></p>
						<span class="meta rss-date"><?php wprig_posted_on(); ?></span>
					</div>
		
			</li>

			<?php 
			$count++;
			endwhile; ?>

		<?php endif; ?>
						
		</ul><!-- .wprig-recent-posts-list -->

		<?php echo $after_widget;
								
	} // function widget()
				
	function update( $new_instance, $old_instance ) {
						
		$instance = $old_instance;
		$instance[ 'widget_title' ] = strip_tags( $new_instance[ 'widget_title' ] );
				
								// make sure we are getting a number
								$instance[ 'number_of_posts' ] = is_int( intval( $new_instance[ 'number_of_posts' ] ) ) ? intval( $new_instance[ 'number_of_posts' ] ) : 5;
		
								//update and save the widget
		return $instance;
								
	} // function update()
				
	function form( $instance ) {
						
		// Set defaults
		if ( ! isset( $instance[ "widget_title" ] ) ) { $instance[ "widget_title" ] = ''; }
		if ( ! isset( $instance[ "number_of_posts" ] ) ) { $instance[ "number_of_posts" ] = '5'; }
								
		// Get the options into variables, escaping html characters on the way
		$widget_title = esc_attr( $instance[ 'widget_title' ] );
		$number_of_posts = esc_attr( $instance[ 'number_of_posts' ] );
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'widget_title' ); ?>"><?php	_e( 'Title', 'wprig'); ?>:
			<input id="<?php echo $this->get_field_id( 'widget_title' ); ?>" name="<?php echo $this->get_field_name( 'widget_title' ); ?>" type="text" class="widefat" value="<?php echo esc_attr( $widget_title ); ?>" /></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'number_of_posts' ); ?>"><?php _e( 'Number of posts to display', 'wprig'); ?>:
			<input id="<?php echo $this->get_field_id( 'number_of_posts' ); ?>" name="<?php echo $this->get_field_name( 'number_of_posts' ); ?>" type="text" class="widefat" value="<?php echo esc_attr( $number_of_posts ); ?>" /></label>
			<small>(<?php _e( 'Defaults to 5 if empty','wprig' ); ?>)</small>
		</p>

		<?php
								
	} // function form()
}
register_widget( 'wprig_recent_posts' );

/* @TODO Add a Customizer Option for this
/**
 * Replace Recent Posts Widget with a Better Recent Posts Widget
 * (It includes thumbnails and publishing date)
 * 
 * @source https://github.com/mor10/popper/blob/master/widgets/recent-posts.php
 
function wprig_posts_widget_registration() {
				unregister_widget( 'WP_Widget_Recent_Posts' );
				register_widget( 'wprig_recent_posts' );
}
add_action( 'widgets_init', 'wprig_posts_widget_registration' );
*/