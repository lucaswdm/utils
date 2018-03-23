<?php

function depura()
{
		if(isset($_SERVER['SHELL']))
		{
			foreach(func_get_args() as $arg)
			{
				echo PHP_EOL . "----------------------------------------------------------" . PHP_EOL;
				print_r($arg);
				echo PHP_EOL . "----------------------------------------------------------" . PHP_EOL . PHP_EOL;
			}
		}
		else
		{
			foreach(func_get_args() as $arg)
			{
				echo "<div style=\"text-align:left;border:1px dashed #c20000;background-color:#FFFEAD;color:#c20000;font-weight:bold;margin:5px;padding:4px;padding-left:15px;font-size:12px;\"><pre style=\"font-family:verdana;\">";print_r($arg);echo "</pre></div>";
			}
		}
}


$t0 = null;
$m0 = 0;

function t0()
{
	global $t0;
	$t0 = microtime(true);
}

function t1()
{
	global $t0;
	depura( number_format( (microtime(true) - $t0) ,10) );
}




function get_data($url, $POST = false, $FLG_FOLLOW_REDIRECT = false)
{
	$ch = curl_init();
	$timeout = 10;
	$header = array();

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

	curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36');

	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

	if($FLG_FOLLOW_REDIRECT)
	{
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	}
  
  if($POST && is_array($POST))
  {
      curl_setopt($ch,CURLOPT_POST, true);
      curl_setopt($ch,CURLOPT_POSTFIELDS, http_build_query($POST));
  }

	#curl_setopt($ch, CURLOPT_COOKIEJAR, APP_PATH . 'cookie.cookie');
    #curl_setopt($ch, CURLOPT_COOKIEFILE, APP_PATH . 'cookie.cookie');

	$data = curl_exec($ch);
	curl_close($ch);

	return $data;
}
