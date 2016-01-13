<?php 
	/**
	@ Overload style.css
	@ child style.css first load
	**/
	if (!function_exists('quocthinh_child_style')){
  	function quocthinh_child_style(){
  		wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css' );
  	}
  	add_action( 'wp_enqueue_scripts', 'quocthinh_child_style', PHP_INT_MAX);
  }