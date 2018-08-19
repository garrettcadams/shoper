<?php

/**
 * Adds PGS Brand Filters widget.
 * @package CiyaShop
 */
class pgs_brand_filters_widget extends WP_Widget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {

        $widget_id = 'pgs_brand_filters_widget';
        $widget_name = esc_html__('PGS Brand Filters', 'ciyashop' );
        $widget_ops = array(
            'classname' => 'woocommerce pgs_brand_filters',
            'description' => esc_html__('Brand filters, for horizontal use only.', 'ciyashop' ),
            'customize_selective_refresh' => true,
        );

        parent::__construct($widget_id, $widget_name, $widget_ops);
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {
        $title = isset($instance['title']) && !empty($instance['title']) ? $instance['title'] : '';
        $count = isset($instance['count']) ? (bool) $instance['count'] : true;
		
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

        $pgs_brands = $this->get_product_brands($count);

        if ($pgs_brands != '') {
            
			echo $args['before_widget']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
			
            ?>
            <div class="brand-filters-widget">
				<?php
				if( $title ){
					?>
					<div class="title-block">
						<?php
						echo $args['before_title'] . $title . $args['after_title']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
						?>
					</div>
					<?php
				}
				?>
                <div class="block-content">
                    <?php echo html_entity_decode(esc_html($pgs_brands)); ?>
                </div>
            </div>
            <?php
			
			echo $args['after_widget']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
			
        }
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $count = isset($instance['count']) ? (bool) $instance['count'] : true;
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'ciyashop' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" type="text" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id('count')); ?>" name="<?php echo esc_attr($this->get_field_name('count')); ?>"<?php checked($count); ?> />
            <label for="<?php echo esc_attr($this->get_field_id('count')); ?>"><?php esc_html_e('Show product counts', 'ciyashop' ); ?></label><br />
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
    public function update($new_instance, $old_instance) {
        return $new_instance;
    }

    /**
     * Get brands.
     * @return $brands
     */
    protected function get_product_brands($count = true) {
        $brands = '';

        $brands_terms = get_terms('yith_product_brand', array(
            'hide_empty' => true,
        ));

        if (is_singular('product')) {
            global $post;
            $brands_term = wp_get_post_terms($post->ID, 'yith_product_brand');
            if (!empty($brands_term)) {
                $brands_term = $brands_term[0];
                $brand_meta = get_term_meta($brands_term->term_id);
                $thumbnail_id = absint($brand_meta['thumbnail_id'][0]);
                if ($thumbnail_id) {
                    $image = wp_get_attachment_image($thumbnail_id, 'ciyashop-brand-logo');
                    if ($image) {
                        $brands .= sprintf('<h5><a href="%s">%s</a></h5>', get_term_link($brands_term->term_id), $image);
                    }
                } else {
                    $brands .= sprintf('<h5><a href="%s">%s</a></h5>', get_term_link($brands_term->term_id), $brands_term->name);
                }
                $brands .= '<a class="brand-products" href="' . get_term_link($brands_term->term_id) . '"> ' . __('View All Products', 'ciyashop' ) . '</a>';
            }
        } else {
            $brands .= '<ul class="pgs-brand-items">';
            foreach ($brands_terms as $brands_term) {
                $brands .= '<li class="pgs-brand-item">';
                $brand_meta = get_term_meta($brands_term->term_id);
                $thumbnail_id = absint($brand_meta['thumbnail_id'][0]);
                if ($thumbnail_id) {
                    $image = wp_get_attachment_image($thumbnail_id, 'ciyashop-brand-logo');
                    if ($image) {
                        $brands .= sprintf('<h5><a href="%s">%s</a></h5>', get_term_link($brands_term->term_id), $image);
                    }
                } else {
                    $brands .= sprintf('<h5><a href="%s">%s</a></h5>', get_term_link($brands_term->term_id), $brands_term->name);
                }
                if ($count)
                    $brands .= '<span class="widget_brand-product-count">(' . $brands_term->count . ')</span>';
                $brands .= '</li>';
            }
            $brands .= '</ul>';
        }
        return $brands;
    }

}
