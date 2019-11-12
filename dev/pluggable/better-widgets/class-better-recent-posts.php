<?php
/**
 * Recent Posts Widget Class
 *
 * @package wprig
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
				'classname'    => 'widget_recent_entries',
				'description'  => __( 'Displays most recent posts with featured image and publishing date.', 'wprig' ),
				'before_title' => '<h2 class="widget-title">',
				'after_title'  => '</h2>',
			);
			parent::__construct(
				'better_recent_posts',
				__( 'Better Recent Posts', 'wprig' ),
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
		$args['widget_title']    = null;
		$args['number_of_posts'] = null;
		$args['before_title']    = '<h2 class="widget-title">';

		// Old code.
		$args['widget_title']    = ! empty( $args['widget_title'] )
			? esc_attr( apply_filters( 'widget_title', $instance['widget_title'] ) )
			: esc_html__( 'Recent Posts', 'wprig' );
		$args['number_of_posts'] = ! empty( $args['number_of_posts'] )
			? esc_attr( $instance['number_of_posts'] )
			: 0;

		echo wp_kses_post( $args['before_widget'] );

		if ( ! empty( $args['widget_title'] ) ) {
			echo wp_kses_post( $args['before_title'] . $args['widget_title'] . $args['after_title'] );
		} else {
			echo wp_kses_post( $args['before_title'] . __( 'Recent Posts', 'wprig' ) . $args['after_title'] );
		}
		?>

		<ul class="wprig-widget-list">

		<?php
		if ( 0 === $args['number_of_posts'] ) {
			$args['number_of_posts'] = 4;
		}

		$recent_posts = new WP_Query(
			apply_filters(
				'wprig_recent_posts_args',
				array(
					'posts_per_page'      => $args['number_of_posts'],
					'post_status'         => 'publish',
					'ignore_sticky_posts' => true,
				)
			)
		);

		if ( $recent_posts->have_posts() ) :
			$count = 1;
			while ( $recent_posts->have_posts() && $count <= $args['number_of_posts'] ) :
				$recent_posts->the_post();
				?>

			<li class="<?php echo 0 === $count % 2 ? 'even' : 'odd'; ?>">
				<?php global $post; ?>

				<?php wprig_archive_thumbnails(); ?>

					<div class="entry-header">
						<!-- <div class="cat-links"> -->
							<?php // wprig_post_categories();. ?>
						<!-- </div> -->
						<a class="rsswidget" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
							<h4 class="entry-title"><?php the_title(); ?></h4>
						</a>
					</div>

					<div class="entry-content">
						<p class="entry-excerpt"><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
						<span class="meta rss-date"><?php wprig_posted_on(); ?></span>
					</div>

			</li>

				<?php
				$count++;
			endwhile;
			?>

		<?php endif; ?>

		</ul><!-- .wprig-recent-posts-list -->

		<?php
		echo wp_kses_post( $args['after_widget'] );

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
		$instance['widget_title'] = wp_string_all_tags( $new_instance['widget_title'] );

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
			<label for="<?php echo esc_attr( $this->get_field_id( 'widget_title' ) ); ?>"><?php esc_attr_e( 'Title', 'wprig' ); ?>:
			<input id="<?php echo esc_attr( $this->get_field_id( 'widget_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'widget_title' ) ); ?>" type="text" class="widefat" value="<?php echo esc_attr( $widget_title ); ?>" /></label>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number_of_posts' ) ); ?>"><?php esc_attr_e( 'Number of posts to display', 'wprig' ); ?>:
			<input id="<?php echo esc_attr( $this->get_field_id( 'number_of_posts' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number_of_posts' ) ); ?>" type="text" class="widefat" value="<?php echo esc_attr( $number_of_posts ); ?>" /></label>
			<small>(<?php esc_attr_e( 'Defaults to 5 if empty', 'wprig' ); ?>)</small>
		</p>

		<?php

	} // end function form().
}
register_widget( 'better_recent_posts' );

/**
 * Replace Recent Posts Widget with a Better Recent Posts Widget
 * (It includes thumbnails and publishing date)
 *
 * @TODO Add a Customizer Option for this
 *
 * @source https://github.com/mor10/popper/blob/master/widgets/recent-posts.php
 *
function wprig_posts_widget_registration() {
				unregister_widget( 'WP_Widget_Recent_Posts' );
				register_widget( 'wprig_recent_posts' );
}
add_action( 'widgets_init', 'wprig_posts_widget_registration' );
*/
