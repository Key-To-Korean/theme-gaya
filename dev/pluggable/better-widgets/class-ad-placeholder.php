<?php
/**
 * Ad Placeholders Widget File
 *
 * @package wprig
 */

/**
 * Ad Placeholders widget.
 *
 * This code provides a basic Ad Placeholder - imagining its Google Ads.
 */
class Ad_Placeholder extends WP_Widget {

	/**
	 * Sets up a new Ad widget instance.
	 *
	 * @since 0.0.2
	 */
	public function __construct() {

		$widget_ops = array(
			'classname'   => 'widget_ad_placeholder',
			'description' => __( 'A basic Ad Placeholder.', 'wprig' ),
		);
		parent::__construct( 'ad_placeholder', __( 'Ad Placeholder', 'wprig' ), $widget_ops );

	}

	/**
	 * Outputs the content for the current Ad Placeholder widget instance.
	 *
	 * @since 0.0.2
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Ad Placeholder widget instance.
	 */
	public function widget( $args, $instance ) {

		// $count = ! empty( $instance['count'] ) ? '1' : '0';
		// $dropdown = ! empty( $instance['dropdown'] ) ? '1' : '0';

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? esc_html__( 'Ad', 'wprig' ) : $instance['title'], $instance, $this->id_base );

		echo wp_kses_post( $args['before_widget'] );

		if ( ! empty( $title ) ) {
			echo wp_kses_post( $args['before_title'] . $title . $args['after_title'] );
		} else {
			echo wp_kses_post( $args['before_title'] . __( 'Ad', 'wprig' ) . $args['after_title'] );
		}
		?>

		<div class="adsense adsense-test">
			LEADERBOARD
		</div>

		<?php
		echo wp_kses_post( $args['after_widget'] );

	} // end widget()

	/**
	 * Handles updating settings for the current Ad Placeholder widget instance.
	 *
	 * @since 0.0.2
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget_Ad_Placeholder::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {

		// $instance                 = $old_instance;
		// $instance['widget_title'] = wp_string_all_tags( $new_instance['widget_title'] );

		/*
		Check the checkboxes
		$instance[ 'count' ] = $new_instance[ 'count' ] ? 1 : 0;
		$instance[ 'dropdown' ] = $new_instance[ 'dropdown' ] ? 1 : 0;
		*/

		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? $new_instance['title'] : '';

		// update and save the widget.
		return $instance;

	} // end update()

	/**
	 * Outputs the settings form for the Ad Placeholder widget.
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
register_widget( 'ad_placeholder' );
