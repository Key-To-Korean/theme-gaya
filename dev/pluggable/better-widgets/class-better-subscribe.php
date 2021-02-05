<?php
/**
 * Subscribe Widget File
 *
 * @package wprig
 */

/**
 * Subscribe widget.
 *
 * This code provides a basic Subscribe box - as Jetpack / WP would do.
 */
class Better_Subscribe extends WP_Widget {

	/**
	 * Sets up a new Archives widget instance.
	 *
	 * @since 0.0.2
	 */
	public function __construct() {

		$widget_ops = array(
			'classname'   => 'widget_subscribe',
			'description' => __( 'A basic (non-functional) Subscribe box.', 'wprig' ),
		);
		parent::__construct( 'better_subscribe', __( 'Better Subscribe', 'wprig' ), $widget_ops );

	}

	/**
	 * Outputs the content for the current Subscribe widget instance.
	 *
	 * @since 0.0.2
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Archives widget instance.
	 */
	public function widget( $args, $instance ) {

		// $count = ! empty( $instance['count'] ) ? '1' : '0';
		// $dropdown = ! empty( $instance['dropdown'] ) ? '1' : '0';

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? esc_html__( 'Subscribe', 'wprig' ) : $instance['title'], $instance, $this->id_base );

		echo wp_kses_post( $args['before_widget'] );

		if ( ! empty( $title ) ) {
			echo wp_kses_post( $args['before_title'] . $title . $args['after_title'] );
		} else {
			echo wp_kses_post( $args['before_title'] . __( 'Better Subscribe', 'wprig' ) . $args['after_title'] );
		}
		?>

			<form action="#" method="post" accept-charset="utf-8" id="subscribe-blog-blog_subscription-2">
				<div id="subscribe-text"><p>Enter your email address to subscribe to this blog and receive notifications of new posts by email.</p>
				</div>
				<p>Join 7,900 other subscribers</p>
				<p id="subscribe-email">
					<label id="jetpack-subscribe-label" for="subscribe-field-blog_subscription-2" style="clip: rect(1px, 1px, 1px, 1px); position: absolute; height: 1px; width: 1px; overflow: hidden;">
						Email Address
					</label>
					<input type="email" name="email" required="required" class="required" value="" id="subscribe-field-blog_subscription-2" placeholder="Email Address">
				</p>

				<p id="subscribe-submit">
					<input type="hidden" name="action" value="subscribe">
					<input type="hidden" name="sub-type" value="widget">
					<input type="hidden" name="redirect_fragment" value="blog_subscription-2">
					<input disabled type="submit" value="Subscribe" name="jetpack_subscriptions_widget">
				</p>
			</form>

		<?php
		echo wp_kses_post( $args['after_widget'] );

	} // end widget()

	/**
	 * Handles updating settings for the current Subscribe widget instance.
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

		/*
		Check the checkboxes
		$instance[ 'count' ] = $new_instance[ 'count' ] ? 1 : 0;
		$instance[ 'dropdown' ] = $new_instance[ 'dropdown' ] ? 1 : 0;
		*/

		// update and save the widget.
		return $instance;

	} // end update()

	/**
	 * Outputs the settings form for the Subscribe widget.
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

		/*
		Old code
		// if ( ! isset( $instance[ "count" ] ) ) { $instance[ "count" ] = 0; }
		// if ( ! isset( $instance[ "dropdown" ] ) ) { $instance[ "dropdown" ] = 0; }
		*/

		// Get the options into variables, escaping html characters on the way.
		$widget_title = esc_attr( $instance['widget_title'] );
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'widget_title' ) ); ?>"><?php esc_html_e( 'Title', 'wprig' ); ?>:
			<input id="<?php echo esc_attr( $this->get_field_id( 'widget_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'widget_title' ) ); ?>" type="text" class="widefat" value="<?php echo esc_attr( $widget_title ); ?>" /></label>
		</p>

		<?php
		// @codingStandardsIgnoreStart
		?>
		<!--	<p>
			<input class="checkbox" type="checkbox"<?php // checked( $instance[ 'dropdown' ] ); ?> id="<?php // echo $this->get_field_id( 'dropdown' ); ?>" name="<?php // echo $this->get_field_name( 'dropdown' ); ?>" /> <label for="<?php // echo $this->get_field_id( 'dropdown' ); ?>"><?php // _e( 'Display as dropdown', 'wprig' ); ?></label>
			<br/>
			<input class="checkbox" type="checkbox"<?php // checked( $instance[ 'count' ] ); ?> id="<?php // echo $this->get_field_id( 'count' ); ?>" name="<?php // echo $this->get_field_name( 'count' ); ?>" /> <label for="<?php // echo $this->get_field_id( 'count' ); ?>"><?php // _e( 'Show post counts', 'wprig' ); ?></label>
		</p>
		-->
		<?php
		// @codingStandardsIgnoreEnd
	} // end form()
}
register_widget( 'better_subscribe' );
