<?php 
	/**
	* Plugin Name: widgetQThinh
	* Plugin URI: ...
	* Description: Đây là plugin đầu tiên mà tôi viết dành riêng cho WordPress, chỉ để học tập mà thôi.
	* Version: 1.0
	* Author: KengLife
	* Author URI: quocthinh.site88.net
	* License: GPLv2 or later
	*/
?>

<?php
	/**
	* Khởi tạo widgetQThinh
	*/
	add_action('widgets_init', 'create_widgetQThinh');
	function create_widgetQThinh(){
		register_widget('Widget_QThinh');
	}
	
	/*
	* Create class Widget_QThinh
	*/
	class Widget_QThinh extends WP_Widget{
		/*
		* Thiết lập widgetQThinh: Tên, base ID
		*/
		function __construct(){
			parent::__construct(
				'widget_qthinh',
				'Widget Demo',
				array('description' => 'Description of Widget Demo')
			);
		}
		
		/*
		* Create FORM option for widgetQThinh
		*/
		function form($instance){
			$default = array(
				'title' => 'Widget Demo',
				'number_post' => '5',
				'current_category' => ''
			);
			// Gộp các giá trị của $default vào $instance để nó trở thành giá trị mặc định
			$instance = wp_parse_args((array)$instance, $default);
			
			// Gán giá trị ($instance['title'] cho $title (khởi tạo biến $title))
			$title = esc_attr($instance['title']);
			$number_post = esc_attr($instance['number_post']);
			
			// Get title
			echo "<p>Title:</p>";
			echo "<p><input type=\"text\" name=\"".$this->get_field_name('title')."\" value=\"".$title."\" /></p>";
			
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
		* Save Widget_QThinh (update values in DB)
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
		* Show Widget_QThinh
		*/
		function widget($args, $instance){
			extract($args);
			// Khởi tạo biến $title
			$title = apply_filters('widget_title', $instance['title']);
			
			echo $before_widget;
			
			// In tiêu đề cho Widget
			echo $before_title.$title.$after_title;
			
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