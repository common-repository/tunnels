<?php
function tunnels_inner_meta_box(){
  $tunnels_opts = get_option(TU_OPTIONS);
  if(isset($tunnels_opts['verified']) && $tunnels_opts['verified'] == 'true'){
   $new = ( !isset($_GET['action']) || $_GET['action'] != 'edit' );  
?>
  <input type="checkbox" name="tunnels_tw" value="true" <?php if($new){echo 'checked="checked"'; }?> /> publish on twitter<br />
  <input type="checkbox" name="tunnels_fb" value="true" <?php if($new){echo 'checked="checked"'; }?> /> publish on facebook
<?php      	  
  }else{
?>	  
  <p><a href='./admin.php?page=tunnels'>Please verify your tunnels API key.</a>.</p>
<?php  
  }	  	
}
function tunnels_api_meta_box(){
  $tunnels_opts = get_option(TU_OPTIONS);
  if(isset($tunnels_opts['verified']) && $tunnels_opts['verified'] == 'true'){
	  echo "Your API has been verified!"; 
  }else{
?>
  <form method='post' action=''>
    <input name="api_key" value="" type="text" size="25">
    <input name="verify" value="1" type="hidden">
    <input type="submit" name="Submit"  class="button-primary" value="Verify" />
    <br><br>
    <a href="http://tunnels.me">Click here to signup on tunnels.me and get an API key</a>
  </form>
<?php   
  }	
}
function tunnels_twitter_meta_box(){
	$tunnels_opts = get_option(TU_OPTIONS);
	$format = $tunnels_opts['tw_format'];	
?>
<form method="post" action="">
  <table class="form-table">
		<tr>
			<th>
            	<label for="tw_format"><?php _e( 'Tweet Format:', 'auto-social' ); ?></label> 
            </th>
            <td>
            	<input id="tw_format" name="tw_format" type="text" value="<?php echo $format; ?>" />
            </td>
		</tr>	
		<tr>
		  <th></th>
		  <td>
		  <ul>
		  <li>%title : Post title</li>
          <li>%link : Link to the post</li>
          <li>%excerpt : Excerpt from the post</li>
          </ul>
          <td>
         </tr>
	</table><!-- .form-table -->
    <input name="twitter" value="1" type="hidden">
    <input type="submit" name="Submit"  class="button-primary" value="Save" />
</form>	
<?php
}
?>
