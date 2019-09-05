<?php
/**
 * Class Better Archives
 *
 * @package wprig
 */

/**
 * Better Archives widget.
 *
 * This code breaks up the archives widget by year.
 * Modified from WPBeginner's code: http://www.wpbeginner.com/wp-themes/how-to-customize-the-display-of-wordpress-archives-in-your-sidebar/
 *
 * @source http://floatleft.com/notebook/wordpress-year-month-archives/
 */
class Wprig_Archives extends WP_Widget {

	/**
	 * Sets up a new Archives widget instance.
	 *
	 * @since 0.0.2
	 */
	public function __construct() {

		$widget_ops = array(
			'classname'   => 'widget_archive',
			'description' => __( 'A yearly, then monthly, archive of your site&#8217;s Posts.', 'wprig' ),
		);
		parent::__construct( 'wprig_archives', __( 'Better Archives', 'wprig' ), $widget_ops );

	}

	/**
	 * Outputs the content for the current Archives widget instance.
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
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? esc_html__( 'Archives', 'wprig' ) : $instance['title'], $instance, $this->id_base );

		echo esc_html( $args['before_widget'] );

		if ( ! empty( $title ) ) {
			echo esc_html( $args['before_title'] . $title . $args['after_title'] );
		} else {
			echo esc_html( $args['before_title'] . __( 'Better Archives', 'wprig' ) . $args['after_title'] );
		}

		/**
		 * Divide archives into years/months
		 *
		 * @ref Code for sidebar from WPBeginner - works and modified to fit the widget
		 * http://www.wpbeginner.com/wp-themes/how-to-customize-the-display-of-wordpress-archives-in-your-sidebar/
		 *
		 * @ref Plugin code - helpful to read and understand (doesn't work exactly)
		 * https://plugins.trac.wordpress.org/browser/better-archives-widget/trunk/widget-archives.php
		 */
		global $wpdb;
		// $limit = $num;
		$year_prev = null;
		$sql       = $wpdb->prepare(
			'SELECT DISTINCT MONTH( post_date ) AS month, ' .
			'YEAR( post_date ) AS year, ' .
			'COUNT( id ) as post_count ' .
			'FROM `%1$s` ' .
			"WHERE post_status = 'publish' and post_date <= now() and post_type = 'post' " .
			'GROUP BY month, year ' .
			'ORDER BY post_date DESC',
			esc_sql_name( $wpdb->posts )
		);

		// Old -> $months = $wpdb->get_results( $sql );.
		$months = wp_cache_get( $sql );

		if ( ! empty( $months ) ) :

			echo '<ul class="wprig-widget-list">';

			foreach ( $months as $month ) :

				$year_current = $month->year;

				// If it's not the SAME year as the last one, then output the year AND first Month (the current month).
				if ( $year_current !== $year_prev ) {

					// Check whether this is the FIRST or a later year.
					if ( null === $year_prev ) {
						?>
						<li class="archive-year current-year">
					<?php } else { ?>
								</ul>
						</li>
						<li class="archive-year previous-year">
					<?php } ?>

							<a href="<?php echo esc_url( home_url() ); ?>/<?php echo esc_attr( $month->year ); ?>/"><?php echo esc_attr( $month->year ); ?></a>
							<ul class="children"> 
								<li class="archive-month">
									<a href="<?php echo esc_url( home_url() ); ?>/<?php echo esc_attr( $month->year ); ?>/<?php echo esc_attr( date( 'm', mktime( 0, 0, 0, $month->month, 1, $month->year ) ) ); ?>">
										<span class="archive-month-name"><?php echo esc_attr( date_i18n( 'F', mktime( 0, 0, 0, $month->month, 1, $month->year ) ) ); ?></span>
									</a>
									<span class="archive-month-count post_count"><?php echo esc_attr( $month->post_count ); ?></span>
								</li>

					<?php
				} else {
					// Or, if it IS the same year, output the month.
					?>

					<li class="archive-month">
						<a href="<?php echo esc_url( home_url() ); ?>/<?php echo esc_attr( $month->year ); ?>/<?php echo esc_attr( date( 'm', mktime( 0, 0, 0, $month->month, 1, $month->year ) ) ); ?>">
							<span class="archive-month-name"><?php echo esc_attr( date_i18n( 'F', mktime( 0, 0, 0, $month->month, 1, $month->year ) ) ); ?></span>
						</a>
						<span class="archive-month-count post_count"><?php echo esc_attr( $month->post_count ); ?></span>
					</li>

					<?php
				}
				$year_prev = $year_current;

				// if ( ++$limit >= $num ) { break; }.
				endforeach;

		endif;

		echo esc_html( $args['after_widget'] );

	} // end widget()

	/**
	 * Handles updating settings for the current Archives widget instance.
	 *
	 * @since 0.0.2
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget_Archives::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance                 = $old_instance;
		$instance['widget_title'] = wp_strip_all_tags( $new_instance['widget_title'] );

		/*
		Check the checkboxes
		// $instance[ 'count' ] = $new_instance[ 'count' ] ? 1 : 0;
		// $instance[ 'dropdown' ] = $new_instance[ 'dropdown' ] ? 1 : 0;
		*/

		// update and save the widget.
		return $instance;

	} // end update()

	/**
	 * Outputs the settings form for the Archives widget.
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
		// if ( ! isset( $instance[ "count" ] ) ) { $instance[ "count" ] = 0; }
		// if ( ! isset( $instance[ "dropdown" ] ) ) { $instance[ "dropdown" ] = 0; }
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
		<!--		
		<p>
			<input class="checkbox" type="checkbox"<?php // checked( $instance[ 'dropdown' ] ); ?> id="<?php // echo $this->get_field_id( 'dropdown' ); ?>" name="<?php // echo $this->get_field_name( 'dropdown' ); ?>" /> <label for="<?php // echo $this->get_field_id( 'dropdown' ); ?>"><?php // _e( 'Display as dropdown', 'wprig' ); ?></label>
			<br/>
			<input class="checkbox" type="checkbox"<?php // checked( $instance[ 'count' ] ); ?> id="<?php // echo $this->get_field_id( 'count' ); ?>" name="<?php // echo $this->get_field_name( 'count' ); ?>" /> <label for="<?php // echo $this->get_field_id( 'count' ); ?>"><?php // _e( 'Show post counts', 'wprig' ); ?></label>
		</p>
		-->
		<?php
		// @codingStandardsIgnoreEnd
	} // end form()
}
register_widget( 'wprig_archives' );

/*
@TODO Add a Customizer Option for this
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
