<?php 
/**
 * Plugin Name: Two column content
 * Plugin URI: ...
 * Description: Display content posts in a category.
 * Version: 1.0
 * Author: KengLife
 * Author URI: quocthinh.site88.net
 * License: GPLv2 or later
 */
?>

<?php
	/**
	* Register widget one_column_content
	*/
	add_action('widgets_init', 'create_two_column_content');
	function create_two_column_content(){
		register_widget('Widget_two_column_content');
	}
	
	/*
	* Create class Widget_one_column_content
	*/
	class Widget_two_column_content extends WP_Widget{
		/*
		* Configuration Widget_two_column_content: Name, base ID
		*/
		function __construct(){
			parent::__construct(
				'widget_two_column_content', // ID
				'Two column content', // Name
				array('description' => 'Description of Widget display content a category - two column')
			);
		}
		
		/*
		* Create FORM option
		*/
		function form($instance){
			$default = array(
				'number_post_1' => '5',
				'current_category_1' => '',
				'number_post_2' => '5',
				'current_category_2' => ''
			);
			// Initilize default values ($instance)
			$instance = wp_parse_args((array)$instance, $default);
			
			// Create param, method esc_attr($instance['number_post_1']) : get value number_post_1
			$number_post_1 = esc_attr($instance['number_post_1']);
			$number_post_2 = esc_attr($instance['number_post_2']);
			
			/* Display column 1  */
			// Select category
			$all_categories = get_all_category_ids();
			echo "<p><strong>COLUMN 1:</strong></p>";
			echo "<p>Category:</p>";
			echo "<p><select id=\"".$this->get_field_id('current_category_1')."\" name=\"".$this->get_field_name('current_category_1')."\" >";
			foreach ($all_categories as $category)
			{
				if ($category == $instance['current_category_1'])
					echo "<option value=\"". $category ."\" selected=\"selected\">".get_cat_name($category)."</option>";
				else
					echo "<option value=\"". $category ."\">".get_cat_name($category)."</option>";
			}
			echo "</select></p>";
			// Display number post in a category
			echo "<p>Show number posts:</p>";
			echo "<p><input type=\"text\" name=\"".$this->get_field_name('number_post_1')."\" value=\"".$number_post_1."\" /></p>";

			/* Display column 2  */
			// Select category
			echo "<p><strong>COLUMN 2:</strong></p>";
			echo "<p>Category:</p>";
			echo "<p><select id=\"".$this->get_field_id('current_category_2')."\" name=\"".$this->get_field_name('current_category_2')."\" >";
			foreach ($all_categories as $category)
			{
				if ($category == $instance['current_category_2'])
					echo "<option value=\"". $category ."\" selected=\"selected\">".get_cat_name($category)."</option>";
				else
					echo "<option value=\"". $category ."\">".get_cat_name($category)."</option>";
			}
			echo "</select></p>";
			// Display number post in a category
			echo "<p>Show number posts:</p>";
			echo "<p><input type=\"text\" name=\"".$this->get_field_name('number_post_2')."\" value=\"".$number_post_2."\" /></p>";
		}
		
		/*
		* Save values in DB (update values in DB)
		*/
		function update($new_instance, $old_instance){
			parent::update($new_instance, $old_instance);
			$instance = $old_instance;
			$instance['number_post_1'] = strip_tags($new_instance['number_post_1']);
			$instance['current_category_1'] = strip_tags($new_instance['current_category_1']);
			$instance['number_post_2'] = strip_tags($new_instance['number_post_2']);
			$instance['current_category_2'] = strip_tags($new_instance['current_category_2']);
			return $instance;
		}
		
		/*
		* Show Widget Two column content
		*/
		function widget($args, $instance){
			extract($args);
			echo $before_widget;
			
			// Display content in Widget
			$my_query = quocthinh_get_post_categoryID($instance['current_category_1'], $instance['number_post_1']);
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