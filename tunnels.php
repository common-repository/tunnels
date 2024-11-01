<?php
/**
 * Plugin Name: Tunnels
 * Plugin URI: http://tunnels.me
 * Description: Post on your twitter and facebook account when you publish a new post on wordpress. You'll need a API key on <a href="http://tunnels.me">tunnels.me</a> to enable this plugin.
 * Version: 1.0.2
 * Author: Darell Sun
 * Author URI:  http://tunnels.me
 *
 * @package Tunnels
 */

require_once('include/tunnels_config.php');
/* Set up the plugin. */
add_action('plugins_loaded', 'tunnels_setup');  
/* Create wp_tunnels table when admin active this plugin*/
register_activation_hook(__FILE__,'tunnels_activation');

function tunnels_activation()
{
	$tunnels_opts = get_option(TU_OPTIONS);
	if(!empty($tunnels_opts)){
	   $tunnels_opts['version'] = TU_VERSION;
	   update_option(TU_OPTIONS, $tunnels_opts); 	
	}else{
	   $opts = array(
		'version' => TU_VERSION,
		'tw_format' => '%title %link'		
	  );
	  // add the configuration options
	  add_option(TU_OPTIONS, $opts);   	
	}	
	
	tunnels_create_table();
}

/*
 *Create database table for this plugin
*/
function tunnels_create_table(){}

/* 
 * Set up the social server plugin and load files at appropriate time. 
*/
function tunnels_setup(){
   /* Set constant path for the plugin directory */
   define('TUNNELS_DIR', plugin_dir_path(__FILE__));
   define('TUNNELS_ADMIN', TUNNELS_DIR.'/admin/');
   define('TUNNELS_INC', TUNNELS_DIR.'/include/');

   /* Set constant path for the plugin url */
   define('TUNNELS_URL', plugin_dir_url(__FILE__));
   define('TUNNELS_CSS', TUNNELS_URL.'css/');
   define('TUNNELS_JS', TUNNELS_URL.'js/');

   if(is_admin())
      require_once(TUNNELS_ADMIN.'admin.php');

   /*Print style */
   add_action('wp_print_styles', 'tunnels_style');
 
   /* print script */
   add_action('wp_print_scripts', 'tunnels_script');

   /* post action */
   add_action('publish_post', 'tunnels_publish');

}

function tunnels_style(){
  
}
function tunnels_script(){
 
}
function tunnels_publish($postID){
  //get post info
  $post_data = get_post($postID);
  $title = $post_data->post_title;
  $content = $post_data->post_content;
  $link = get_permalink($postID);	
  $bitly_url = tunnels_bitly($link);
  
  $tunnels_opts = get_option(TU_OPTIONS);
  if(isset($tunnels_opts['twitter_name']) && $_POST['tunnels_tw'] == 'true'){
	 $twitter_name = $tunnels_opts['twitter_name'];
	 tunnels_tweet(TWEET_URL, $title, $bitly_url, $twitter_name);
  }
  if(isset($tunnels_opts['fb_name']) && $_POST['tunnels_fb'] == 'true'){
	$fb_name = $tunnels_opts['fb_name'];
	tunnels_fb_post(FB_POST_URL, $fb_name, $title, $link, $content);  
  }
    
  	
}
?>
