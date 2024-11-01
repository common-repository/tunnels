<?php
require_once('facebook.php');

function tunnels_verify_api($api_key){
  	  		$ch = curl_init();
	//General options
	//curl_setopt($ch, CURLOPT_HEADER, true);
	//Masquerade as Firefox
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); //Follow redirects
	//PHP >= 5.1.0
	curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    curl_setopt($ch, CURLOPT_URL, VERIFY_URL);
	curl_setopt($ch, CURLOPT_POST, true); 
	
	/* The fields of the login form.*/
	$postfields = array(
        'api_key' => $api_key
        		
	 );
   
	$postfields = http_build_query($postfields, '', '&'); //PHP >= 5.1.2
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
	
	$result['EXE'] = curl_exec($ch);
	$result['INF'] = curl_getinfo($ch);
	$result['ERR'] = curl_error($ch);
	$result['ENO'] = curl_errno($ch);	   
    curl_close($ch);
      
    return $result['EXE'];
}

function tunnels_tweet($url, $message, $link, $twitter_name){	 
	$ch = curl_init();
	//General options
	//curl_setopt($ch, CURLOPT_HEADER, true); //For debugging
	//Masquerade as Firefox
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); //Follow redirects
	//PHP >= 5.1.0
	curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, true); 
	
	/* The fields of the login form.*/
	$postfields = array(
        'name' => $twitter_name,
        'message' => $message,
        'link' => $link		
	 );
   
	$postfields = http_build_query($postfields, '', '&'); //PHP >= 5.1.2
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
	
	$result['EXE'] = curl_exec($ch);
	$result['INF'] = curl_getinfo($ch);
	$result['ERR'] = curl_error($ch);
	$result['ENO'] = curl_errno($ch);	   
    curl_close($ch);
      
    return $result;
}

function tunnels_fb_post($url, $name, $title, $link, $content){
    $ch = curl_init();
	//General options
	//curl_setopt($ch, CURLOPT_HEADER, true); //For debugging
	//Masquerade as Firefox
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); //Follow redirects
	//PHP >= 5.1.0
	curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, true); 
	
	/* The fields of the login form.*/
	$postfields = array(
        'name' => $name,
        'title' => $title,
        'link' => $link,
        'content' => $content
     );
   
	$postfields = http_build_query($postfields, '', '&'); //PHP >= 5.1.2
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
	
	$result['EXE'] = curl_exec($ch);
	$result['INF'] = curl_getinfo($ch);
	$result['ERR'] = curl_error($ch);
	$result['ENO'] = curl_errno($ch);	   
    curl_close($ch);
      
    return $result;
}

//create bit.ly url
function tunnels_bitly($url)
{
	//login information
	$login = 'darell';	//your bit.ly login
	$apikey = 'R_7edc48413e51301369ad7a52be587262'; //bit.ly apikey
	$format = 'json';	//choose between json or xml
	$version = '2.0.1';

	//create the URL
	$bitly = 'http://api.bit.ly/shorten?version='.$version.'&longUrl='.urlencode($url).'&login='.$login.'&apiKey='.$apikey.'&format='.$format;

	//get the url
	//could also use cURL here
	$response = file_get_contents($bitly);

	//parse depending on desired format
	if(strtolower($format) == 'json')
	{
		$json = @json_decode($response,true);
		return $json['results'][$url]['shortUrl'];
	}
	else //xml
	{
		$xml = simplexml_load_string($response);
		return 'http://bit.ly/'.$xml->results->nodeKeyVal->hash;
	}
}
?>
