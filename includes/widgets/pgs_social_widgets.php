<?php
/**
 * Adds PGS Social Widget.
 * @package CiyaShop
 */
class PGS_social_widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		
		$widget_ops = array(
			'classname'                  => 'widget_pgs_social_profiles',
			'description'                => esc_html__( 'Social profiles.', 'ciyashop' ),
			'customize_selective_refresh'=> true,
		);
		$control_ops = array(
			'width' => 400,
			'height' => 350
		);
		parent::__construct(
			'social_profiles', // Base ID
			esc_html__( 'PGS Social', 'ciyashop' ),      // Name
			$widget_ops,
			$control_ops
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		
		$title = isset( $instance['title'] ) && !empty($instance['title']) ? $instance['title'] : '';
		
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		
		echo $args['before_widget']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
		
		if ( $title  ) {
			echo $args['before_title'] . $title . $args['after_title']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
		}
		
		$widget_content = ! empty( $instance['content'] ) ? $instance['content'] : '';
		
		$ciyashop_social_profiles = ciyashop_social_profiles();
		?>
		<div class="social-profiles-wrapper">
			<div class="social-profiles-wrapper-inner">
				<?php
				if( !empty($widget_content) ){
					?>
					<p><?php echo wp_kses($widget_content, array( 'br' => array() ));?></p>
					<?php
				}
				if( !empty($ciyashop_social_profiles) && is_array($ciyashop_social_profiles) ){
					?>
					<div class="social-profiles">
						<ul>
							<?php
							foreach( $ciyashop_social_profiles as $ciyashop_social_profile ){
								?>
								<li><a href="<?php echo esc_url($ciyashop_social_profile['link']);?>" title="<?php echo esc_attr($ciyashop_social_profile['title'])?>" target="_blank"><?php echo wp_kses( $ciyashop_social_profile['icon'], ciyashop_allowed_html( array('i')) );?></a></li>
								<?php
							}
							?>
						</ul>
					</div>
					<?php
				}
				?>
			</div>
		</div>
		<?php
		
		echo $args['after_widget']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$content = ! empty( $instance['content'] ) ? $instance['content'] :'';                
		?>
		<p>
		  <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'ciyashop' ); ?></label> 
		  <input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'content' )); ?>"><?php esc_html_e('Content:' , 'ciyashop' ); ?></label>
			<textarea class="widefat" id="<?php echo esc_attr($this->get_field_id( 'content' ));?>"  name="<?php echo esc_attr($this->get_field_name( 'content' ));?>"><?php echo esc_html($content);?></textarea>
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['content'] = strip_tags( $new_instance['content'] );
		return $instance;
	}
}