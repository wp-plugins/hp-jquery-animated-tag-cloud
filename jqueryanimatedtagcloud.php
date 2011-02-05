<?php
/**
 * @package jqueryanimatedtagcloud
 * @version 1.0.1
 */
/*
Plugin Name: jQuery Animated Tag Cloud
Plugin URI: http://hardik.me/blog/index.php/2011/02/04/wordpress-jquery-animated-tag-cloud/
Description: Give your tag cloud some nice look and animation, use this plugin to make your tag cloud more attractive. more updates will come soon...
Author: <a href="http://hardik.me">Hardik</a>
Version: 1.0.0
Author URL: http://hardik.me/blog
*/


function jqueryanimatedtagcloud_widget_Init(){
  register_widget('jqueryanimatedtagcloudWidget');
}
	
add_action("widgets_init", "jqueryanimatedtagcloud_widget_Init");
	
class jqueryanimatedtagcloudWidget extends WP_Widget {
     function jqueryanimatedtagcloudWidget() {
       //Widget code
	   parent::WP_Widget(false,$name="Jquery Animated Tag Cloud");
     }

     function widget($args, $instance) {
       //Widget output
	    global $wpdb;
	    $options = $instance;
		$output.= '<b>'.$options['jqueryanimatedtagcloud_widget_title'].':</b>';	
		
		$path = get_option('siteurl')."/wp-content/plugins/hp-jquery-animated-tag-cloud";
		
		$output.= "
		<script type=\"text/javascript\" src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js\">
        </script>
    <script type=\"text/javascript\" src=\"$path/ext/jquery.mousewheel.min.js\"></script>
    <script type=\"text/javascript\" src=\"$path/jquery.tagsphere.min.js\"></script>";
		
		
		$output.= "<script type=\"text/javascript\">
		$(function(){
			$('#ts2').tagcloud({centrex:100,centrey:100,min_font_size:10,max_font_size:16,zoom:100});
		});
		</script>";
		
		$posttags = get_terms('post_tag');
		
		$output.= '
		<style>
		ts2 a{
			color:#'.$options['jqueryanimatedtagcloud_widget_font'].';
		}
		</style>
		
		<div id="ts2" style="width:'.$options['jqueryanimatedtagcloud_widget_width'].'px; height:'.$options['jqueryanimatedtagcloud_widget_height'].'px; background-color:#'.$options['jqueryanimatedtagcloud_widget_bg'].';position:relative;">
    <ul>
	';
	if ($posttags) {
		$i=1;
		foreach($posttags as $tag) {
			$output.='<li><a href="'.get_tag_link($tag->term_id).'" rel="'.$i.'" style="color:#'.$options['jqueryanimatedtagcloud_widget_font'].';">'.$tag->name.'</a></li>';
			$i++;
		}
		
	}
    $output.='</ul>
</div><span style="display:none"><a href="http://hardik.me">php developer india</a></span>';
		
		extract($args);	
		echo $before_widget; 
		echo $before_title . $title . $after_title;
		echo $output; 
		echo $after_widget;
     }

     function update($new_instance, $old_instance) {
       //Save widget options
		$instance = $old_instance;
		foreach($new_instance as $k=>$v){
			$instance[$k] = $new_instance[$k];
		}
		
		return $instance;
     }

     function form($instance) {
       //Output admin widget options form
		$instance = wp_parse_args( (array) $instance, array(
		'jqueryanimatedtagcloud_widget_title'=>"Tag Cloud",
		'jqueryanimatedtagcloud_widget_width'=>'200',
		'jqueryanimatedtagcloud_widget_height'=>'200',
		'jqueryanimatedtagcloud_widget_bg'=>'FFFFFF',
		'jqueryanimatedtagcloud_widget_font'=>'000000'
		) );
		
		 
	   ?>
<script type="text/javascript" src="<?php echo get_option('siteurl');?>/wp-content/plugins/hp-jquery-animated-tag-cloud/jscolor/jscolor.js"></script>
<script type="text/javascript">jscolor.init();</script>

<p><label for="jqueryanimatedtagcloud_widget_title"><?php _e('Title:'); ?> <input  id="<?php echo  $this->get_field_id('jqueryanimatedtagcloud_widget_title');?>" name="<?php echo  $this->get_field_name('jqueryanimatedtagcloud_widget_title');?>" type="text" value="<?php echo $instance['jqueryanimatedtagcloud_widget_title']; ?>" /></label></p>

    
	 
     <p><label for="jqueryanimatedtagcloud_widget_bg"><?php _e('Background Color:'); ?> <input  id="<?php echo  $this->get_field_id('jqueryanimatedtagcloud_widget_bg');?>" name="<?php echo  $this->get_field_name('jqueryanimatedtagcloud_widget_bg');?>" type="text" value="<?php echo $instance['jqueryanimatedtagcloud_widget_bg']; ?>" class="color" style="background-color:#<?php echo $instance['jqueryanimatedtagcloud_widget_bg']; ?>" /></label></p>
     
     <p><label for="jqueryanimatedtagcloud_widget_font" style="display:none"><?php _e('Font Color:'); ?><br /><input  id="<?php echo  $this->get_field_id('jqueryanimatedtagcloud_widget_font');?>" name="<?php echo  $this->get_field_name('jqueryanimatedtagcloud_widget_font');?>" type="text" value="<?php echo $instance['jqueryanimatedtagcloud_widget_font']; ?>" class="color" style="background-color:#<?php echo $instance['jqueryanimatedtagcloud_widget_font']; ?>" /></label></p>
     
     <p><label for="jqueryanimatedtagcloud_widget_plsizewh"><?php _e('Tag Cloud Dimentions:'); ?> <br /><input  id="<?php echo  $this->get_field_id('jqueryanimatedtagcloud_widget_width');?>" name="<?php echo  $this->get_field_name('jqueryanimatedtagcloud_widget_width');?>" type="text" value="<?php echo $instance['jqueryanimatedtagcloud_widget_width']; ?>"  style="width:50px;"/> X <input  id="<?php echo  $this->get_field_id('jqueryanimatedtagcloud_widget_height');?>" name="<?php echo  $this->get_field_name('jqueryanimatedtagcloud_widget_height');?>" type="text" value="<?php echo $instance['jqueryanimatedtagcloud_widget_height']; ?>" style="width:50px;"/></label></p>
     
    
	   <?php
     }
	 
	 function regexEscape( $content ) {
		return strtr($content, array("\\" => "\\\\", "/" => "\\/", "[" => "\\[", "]" => "\\]"));
	}
	 
}


?>
