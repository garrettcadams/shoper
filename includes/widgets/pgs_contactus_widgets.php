<?php
/**
 * Adds PGS Contact Us widget.
 * @package CiyaShop
 */
class PGS_contact_widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'PGS_contact_widget', // Base ID
			esc_html__( 'PGS Contact Us', 'ciyashop' ), // Name
			array( 'description' => esc_html__( 'A Contact Us Sidebar Widget', 'ciyashop' ) ) // Args
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
		
		$title        = isset( $instance['title'] ) && !empty($instance['title']) ? $instance['title'] : '';
		
		$title        = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		
		$allowed_tags = wp_kses_allowed_html('post');
		
        echo $args['before_widget']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
		
		if( $title ){
			echo $args['before_title'] . $title . $args['after_title']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
		}
		
		?>
		<div class="footer-address">
			<ul>
				<?php
				if (!empty($instance['address']) ){
					?>
					<li><i class="fa fa-map-marker"></i><span><?php echo wp_kses($instance['address'], array( 'address' => $allowed_tags['address'], 'a' => $allowed_tags['a'], ));?></span></li>
					<?php
				}
				if( !empty($instance['email']) ){
					?>
					<li class="pgs-contact-email"><i class="fa fa-envelope-o"></i><span><?php echo wp_kses( $instance['email'], array( 'a' => $allowed_tags['a'], ) );?></span></li>
					<?php
				}
				if( !empty($instance['phone']) ){
					?>
					<li><i class="fa fa-phone"></i><span><?php echo wp_kses( $instance['phone'], array( 'a' => $allowed_tags['a'], ) );?></span></li>
					<?php
				}
				?>
			</ul>
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
		$title  = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$address= ! empty( $instance['address'] ) ? $instance['address'] :'';
		$email  = ! empty( $instance['email'] ) ? $instance['email'] :'';
		$phone  = ! empty( $instance['phone'] ) ? $instance['phone'] :'';
		?>
		<p>
		  <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e('Title:', 'ciyashop' ); ?></label>
		  <input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>">
		</p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'address' )); ?>"><?php esc_html_e('Address:', 'ciyashop' ); ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'address' ));?>"  name="<?php echo esc_attr($this->get_field_name( 'address' ));?>" value="<?php echo esc_attr($address);?>"/>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'email' )); ?>"><?php esc_html_e('Email:', 'ciyashop' ); ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'email' ));?>"  name="<?php echo esc_attr($this->get_field_name( 'email' ));?>" value="<?php echo esc_attr($email);?>"/>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'phone' )); ?>"><?php esc_html_e('Phone:', 'ciyashop' ); ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'phone' ));?>"  name="<?php echo esc_attr($this->get_field_name( 'phone' ));?>" value="<?php echo esc_attr($phone);?>"/>
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
		
		$allowed_tags = wp_kses_allowed_html('post');
		
		$instance = array();
		$instance['title']   = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['address'] = wp_kses( $new_instance['address'], array( 'address' => $allowed_tags['address'], 'a' => $allowed_tags['a'], ) );
		$instance['email']   = wp_kses( $new_instance['email'], array( 'a' => $allowed_tags['a'], ) );
		$instance['phone']   = wp_kses( $new_instance['phone'], array( 'a' => $allowed_tags['a'], ) );
		return $instance;
	}

} // class PGS_contact_widget
?>