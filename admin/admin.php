<?php
/* Admin functions to set and save settings of the 
 * @package PostSync
*/
require_once('pages.php');
require_once('meta_box.php');
require_once(TUNNELS_INC.'tools.php');
/* Initialize the theme admin functions */
add_action('init', 'tunnels_admin_init');

function tunnels_admin_init(){
			
    add_action('admin_menu', 'tunnels_settings_init');
    add_action('admin_init', 'tunnels_actions_handler');
    add_action('admin_init', 'tunnels_admin_style');
    add_action('admin_init', 'tunnels_admin_script');
    add_action('admin_notices', 'tunnels_require_verify');
    add_action('add_meta_boxes', 'tunnels_add_meta_box'); 
}

function tunnels_require_verify(){
   $tunnels_opts = get_option(TU_OPTIONS);	
   if ( $tunnels_opts['verified'] == 'true' ) { return; } 
   echo '<div class="error"><p>You need to signup on <a href="http://tunnels.me">tunnels.me</a> to get a API key to enable Tunnels.</p></div>';	
}

function tunnels_settings_init(){
   global $tunnels; 
   $tunnels->main_page = add_menu_page( 'Tunnels', 'Tunnels', 0, 'tunnels', 'tunnels_main_page' );
   $tunnels->twitter = add_submenu_page('tunnels', 'Twitter', 'Twitter', 0, 'auto-twitter', 'tunnels_twitter_page' );
   $post_sync->facebook = add_submenu_page('tunnels', 'Facebook', 'Facebook', 0, 'auto-facebook', 'tunnels_facebook_page');
   /* Make sure the settings are saved. */
   add_action( "load-{$tunnels->main_page}", 'tunnels_main_settings');
   add_action("load-{$tunnels->twitter}", 'tunnels_twitter_settings');
}

function tunnels_add_meta_box(){
    $pp = array('post', 'page');
	foreach($pp as $p)
	{
		add_meta_box( 
			'tunnels',
			__( 'Tunnels', 'tunnels' ),
			'tunnels_inner_meta_box',
			$p,
			'side',
			'core'
		);
	}	
}
function tunnels_admin_style(){
  $plugin_data = get_plugin_data( TUNNELS_DIR . 'tunnels.php' );
	
	wp_enqueue_style( 'tunnels-admin', TUNNELS_CSS . 'style.css', false, $plugin_data['Version'], 'screen' );	
    wp_enqueue_style( 'tunnels-new', TUNNELS_CSS . 'new.css', false, $plugin_data['Version'], 'screen' );       
}
function tunnels_admin_script(){}
function tunnels_actions_handler(){
  if($_POST['verify']){
	 $result = tunnels_verify_api($_POST['api_key']);
     //var_dump($result);
	 if($result == 'failed'){
	  $redirect = admin_url( 'admin.php?page=tunnels&error=true' );
       wp_redirect($redirect); 
	 }else{
	   $verify_result = json_decode($result);
	   //var_dump($verify_result);
	   $twitter_info = $verify_result->twitter;
	   $fb_info = $verify_result->fb;
	   $tunnels_opts = get_option(TU_OPTIONS);
	   $tunnels_opts['verified'] = 'true';
	   $tunnels_opts['twitter_name'] = $twitter_info->username;
	   $tunnels_opts['fb_name'] = $fb_info->username;
	   update_option(TU_OPTIONS, $tunnels_opts);
	   $redirect = admin_url( 'admin.php?page=tunnels&success=true' );
       wp_redirect($redirect);
	 }   
  }
  
  if($_POST['twitter']){
	 $tunnels_opts = get_option(TU_OPTIONS);
	 $tunnels_opts['tw_format'] = $_POST['tw_format'];
	 update_option(TU_OPTIONS, $tunnels_opts); 
	 $redirect = admin_url( 'admin.php?page=auto-twitter&update=true' );
     wp_redirect($redirect);  
  }
}
function tunnels_error_message(){
   echo '<div class="error">
		<p>API is wrong</p>
  </div>';  
}
function tunnels_success_message(){
  echo '<div class="updated fade">
		<p>API is ok</p>
  </div>';  
}
function tunnels_update_message(){
   echo '<div class="updated fade">
		<p>Settings Updated</p>
  </div>';  	
}
?>
