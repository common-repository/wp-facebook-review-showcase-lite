<?php
defined('ABSPATH') or die('No script kidding please!');
/*
 * Register Plugin Widget : WPFRSL_Widget
 */
if (!class_exists('WPFRSL_Widget')) {

    class WPFRSL_Widget extends WP_Widget {

        public function __construct() {
            parent::__construct('WPFRSL_Widget', 'Social Review', array('description' => __('Display FB User Reviews, Business Information.', WPFRSL_TD)));
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

            echo $args['before_widget'];
            echo '<div class="wpfrsl-widget-wrap">';
            if (!empty($instance['title'])) {
                echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
            }
            $wpfrsl_id = isset($instance['wpfrsl_id']) ? $instance['wpfrsl_id'] : '';
            echo do_shortcode("[wpfrsl_reviews id='" . $wpfrsl_id . "' position='hide']");
            echo '</div>';
            echo $args['after_widget'];
        }

        /**
         * Back-end widget form.
         *
         * @see WP_Widget::form()
         *
         * @param array $instance Previously saved values from database.
         */
        public function form($instance) {
            global $post;
            $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
            $id = isset($instance['wpfrsl_id']) ? esc_attr($instance['wpfrsl_id']) : '';
            ?>
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', WPFRSL_TD); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>"/>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('wpfrsl_id'); ?>"><?php _e('Select Review:', WPFRSL_TD); ?></label>
                <select name="<?php echo $this->get_field_name('wpfrsl_id'); ?>" class='widefat' id="<?php echo $this->get_field_id('wpfrsl_id'); ?>" type="text">
                    <?php
                    $args = array(
                        'post_type' => 'wpfrslreviews',
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                        'order' => 'ASC', 
                        'orderby' => 'id'
                    );
                    $posts = get_posts($args);
                    if (!empty($posts)) {

                        foreach ($posts as $post) {
                            ?>

                            <option value="<?php echo $post->ID; ?>" <?php if ($post->ID == $id) { ?>selected="selected"<?php } ?>><?php echo $post->post_title; ?></option>

                            <?php
                        }
                    }
                    ?>
                </select>
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

            $instance = $old_instance;
            $instance['title'] = isset($new_instance['title']) ? strip_tags(esc_attr($new_instance['title'])) : '';
            $instance['wpfrsl_id'] = isset($new_instance['wpfrsl_id']) ? strip_tags(esc_attr($new_instance['wpfrsl_id'])) : '';
            return $instance;
        }

    }

}

