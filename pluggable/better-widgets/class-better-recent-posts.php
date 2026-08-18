<?php
/**
 * Recent Posts Widget Class
 *
 * @package gaya
 */

/**
 * Better Recent Posts widget.
 *
 * This code adds a new widget that shows the featured image, post title, and publishing date.
 * Gently lifted and reworked from Anders Norén's Lovecraft theme: http://www.andersnoren.se/teman/popper-wordpress-theme/
 *
 * @source https://github.com/mor10/popper/blob/master/widgets/recent-posts.php
 */
class Better_Recent_Posts extends WP_Widget {

	/**
	 * Sets up a new Recent Posts widget instance.
	 *
	 * @since 0.0.2
	 */
	public function __construct() {

			$widget_ops = array(
				'classname'   => 'widget_recent_entries',
				'description' => __( 'Displays most recent posts with featured image and publishing date.', 'gaya' ),
			);
			parent::__construct(
				'better_recent_posts',
				__( 'Better Recent Posts', 'gaya' ),
				$widget_ops
			);

	}

	/**
	 * Outputs the content for the current Recent Posts widget instance.
	 *
	 * @since 0.0.2
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Archives widget instance.
	 */
	public function widget( $args, $instance ) {
		// Outputs the content of the widget.
		$widget_title    = ! empty( $instance['widget_title'] ) ? esc_attr( apply_filters( 'widget_title', $instance['widget_title'] ) ) : '';
		$number_of_posts = ! empty( $instance['number_of_posts'] ) ? (int) $instance['number_of_posts'] : 4;

		echo esc_html( $args['before_widget'] );

		if ( ! empty( $widget_title ) ) {
			echo esc_html( $args['before_title'] . $widget_title . $args['after_title'] );
		} else {
			echo esc_html( $args['before_title'] . __( 'Better Posts', 'gaya' ) . $args['after_title'] );
		}
		?>

		<ul class="gaya-widget-list">

		<?php
		$recent_posts = new WP_Query(
			apply_filters(
				'gaya_recent_posts_args',
				array(
					'posts_per_page'      => $number_of_posts,
					'post_status'         => 'publish',
					'ignore_sticky_posts' => true,
				)
			)
		);

		if ( $recent_posts->have_posts() ) :
			$count = 1;
			while ( $recent_posts->have_posts() && $count <= $number_of_posts ) :
				$recent_posts->the_post();
				?>

			<li class="<?php echo 0 === $count % 2 ? 'even' : 'odd'; ?>">
				<?php global $post; ?>

					<?php if ( has_post_thumbnail() ) : ?>
						<div class="post-icon" aria-hidden="true" style="background-image: url('<?php the_post_thumbnail_url(); ?>')">
						</div>
					<?php endif; ?>

					<div class="entry-header">
						<!-- <div class="cat-links"> -->
							<?php // gaya_post_categories();. ?>
						<!-- </div> -->
						<a class="rsswidget" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
							<h4 class="title"><?php the_title(); ?></h4>
						</a>
					</div>

					<div class="entry-meta">
						<p class="entry-excerpt"><?php the_excerpt(); ?></p>
						<span class="meta rss-date"><?php gaya_posted_on(); ?></span>
					</div>

			</li>

				<?php
				$count++;
			endwhile;
			?>

		<?php endif; ?>

		</ul><!-- .gaya-recent-posts-list -->

		<?php
		echo esc_html( $args['after_widget'] );

	} // end function widget().

	/**
	 * Handles updating settings for the current Recent Posts widget instance.
	 *
	 * @since 0.0.2
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget_Subscribe::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance                 = $old_instance;
		$instance['widget_title'] = wp_strip_all_tags( $new_instance['widget_title'] );

		// make sure we are getting a number.
		$instance['number_of_posts'] = is_int( intval( $new_instance['number_of_posts'] ) ) ? intval( $new_instance['number_of_posts'] ) : 5;

		// update and save the widget.
		return $instance;

	} // end function update().

	/**
	 * Outputs the settings form for the Recent Posts widget.
	 *
	 * @since 0.0.2
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {

		// Set defaults.
		if ( ! isset( $instance['widget_title'] ) ) {
			$instance['widget_title'] = '';
		}
		if ( ! isset( $instance['number_of_posts'] ) ) {
			$instance['number_of_posts'] = '5';
		}

		// Get the options into variables, escaping html characters on the way.
		$widget_title    = esc_attr( $instance['widget_title'] );
		$number_of_posts = esc_attr( $instance['number_of_posts'] );
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'widget_title' ) ); ?>"><?php esc_attr_e( 'Title', 'gaya' ); ?>:
			<input id="<?php echo esc_attr( $this->get_field_id( 'widget_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'widget_title' ) ); ?>" type="text" class="widefat" value="<?php echo esc_attr( $widget_title ); ?>" /></label>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number_of_posts' ) ); ?>"><?php esc_attr_e( 'Number of posts to display', 'gaya' ); ?>:
			<input id="<?php echo esc_attr( $this->get_field_id( 'number_of_posts' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number_of_posts' ) ); ?>" type="text" class="widefat" value="<?php echo esc_attr( $number_of_posts ); ?>" /></label>
			<small>(<?php esc_attr_e( 'Defaults to 5 if empty', 'gaya' ); ?>)</small>
		</p>

		<?php

	} // end function form().
}
register_widget( 'better_recent_posts' );

/*
@TODO Add a Customizer Option for this
 * Replace Recent Posts Widget with a Better Recent Posts Widget
 * (It includes thumbnails and publishing date)
 *
 * @source https://github.com/mor10/popper/blob/master/widgets/recent-posts.php
 *
function gaya_posts_widget_registration() {
				unregister_widget( 'WP_Widget_Recent_Posts' );
				register_widget( 'gaya_recent_posts' );
}
add_action( 'widgets_init', 'gaya_posts_widget_registration' );
*/
