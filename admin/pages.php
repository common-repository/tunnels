<?php
function tunnels_twitter_page(){
   global $tunnels;

	$plugin_data = get_plugin_data( TUNNELS_DIR . 'tunnels.php' ); ?>

	<div class="wrap">
		
        <?php if ( function_exists( 'screen_icon' ) ) screen_icon(); ?>
        
		<h2><?php _e( 'Twitter Settings', 'tunnels' ); ?></h2>
        <?php if ( isset( $_GET['update'] ) && 'true' == esc_attr( $_GET['update'] ) ) tunnels_update_message(); ?>
		     

		<div id="poststuff">			               
				<div class="metabox-holder">
					
					  <div class="post-box-container column-1 twitter"><?php do_meta_boxes( $tunnels->twitter, 'twitter', $plugin_data ); ?></div>
							            
		       	</div>						
		</div><!-- #poststuff -->

	</div><!-- .wrap -->  
<?php		
}
function tunnels_facebook_page(){}
function tunnels_main_page(){
  global $tunnels;

	$plugin_data = get_plugin_data( TUNNELS_DIR . 'tunnels.php' ); ?>

	<div class="wrap">
		
        <?php if ( function_exists( 'screen_icon' ) ) screen_icon(); ?>
        
		<h2><?php _e( 'Social Account Settings', 'tunnels' ); ?></h2>
        <?php if ( isset( $_GET['success'] ) && 'true' == esc_attr( $_GET['success'] ) ) tunnels_success_message(); ?>
		<?php if ( isset( $_GET['error'] ) && 'true' == esc_attr( $_GET['error'] ) ) tunnels_error_message(); ?>       

		<div id="poststuff">			               
				<div class="metabox-holder">
					<div class="post-box-container column-1 api"><?php do_meta_boxes( $tunnels->main_page, 'api', $plugin_data ); ?></div>
					
		            
		       	</div>						
		</div><!-- #poststuff -->

	</div><!-- .wrap -->  	
<?php
}

function tunnels_main_settings(){
   global $tunnels;    
   add_meta_box( 'tunnels-api-meta-box', __( 'API KEY', 'tunnels' ), 'tunnels_api_meta_box', $tunnels->main_page, 'api', 'high' );
   
}

function tunnels_twitter_settings(){
   global $tunnels;
   add_meta_box( 'tunnels-twitter-meta-box', __( 'Twitter', 'tunnels' ), 'tunnels_twitter_meta_box', $tunnels->twitter, 'twitter', 'high' );	
}
?>
