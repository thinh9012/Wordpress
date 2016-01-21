<?php 
/**
 * Plugin Name: One column content
 * Plugin URI: ...
 * Description: Display content posts in a category.
 * Author: KengLife
 * Author URI: quocthinh.site88.net
 * License: GPLv2 or later
 */
?>

<?php
	/**
	* Register one_column_content
	*/
	add_action('widgets_init', 'create_one_column_content');
	function create_one_column_content(){
		register_widget('Widget_one_column_content');
	}
	
	/*
	* Create class Widget_one_column_content
	*/
	class Widget_one_column_content extends WP_Widget{
		/*
		* Configuration widgetQThinh: Name, base ID
		*/
		function __construct(){
			parent::__construct(
				'widget_one_column_content', // ID
				'One column content', // Name
				array('description' => 'Description of Widget display content a category - one column')
			);
		}
		
		/*
		* Create FORM option
		*/
		function form($instance){
			$default = array(
				'number_post' => '5',
				'current_category' => ''
			);
			// Initilize default values ($instance)
			$instance = wp_parse_args((array)$instance, $default);
			
			// Create param, method esc_attr($instance['number_post']) : get value number_post
			$number_post = esc_attr($instance['number_post']);
			
			// Select category
			$all_categories = get_all_category_ids();
			echo "<p>Category:</p>";
			echo "<p><select id=\"".$this->get_field_id('current_category')."\" name=\"".$this->get_field_name('current_category')."\" >";
			foreach ($all_categories as $category)
			{
				if ($category == $instance['current_category'])
					echo "<option value=\"". $category ."\" selected=\"selected\">".get_cat_name($category)."</option>";
				else
					echo "<option value=\"". $category ."\">".get_cat_name($category)."</option>";
			}
			echo "</select></p>";
			// Get count
			echo "<p>Show number posts:</p>";
			echo "<p><input type=\"text\" name=\"".$this->get_field_name('number_post')."\" value=\"".$number_post."\" /></p>";
		}
		
		/*
		* Save values in DB (update values in DB)
		*/
		function update($new_instance, $old_instance){
			parent::update($new_instance, $old_instance);
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['number_post'] = strip_tags($new_instance['number_post']);
			$instance['current_category'] = strip_tags($new_instance['current_category']);
			return $instance;
		}
		
		/*
		* Show Widget One column content
		*/
		function widget($args, $instance){
			extract($args);
			echo $before_widget;
			
			// Content in Widget
			$my_query = quocthinh_get_post_categoryID($instance['current_category'], $instance['number_post']);
			if ($my_query->have_posts())
			{
				while($my_query->have_posts()) : $my_query->the_post();
					?>
					<p><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></p>
					<?php
				endwhile;
			}
			
			// End content Widget
			echo $after_widget;
		}
	}
?>