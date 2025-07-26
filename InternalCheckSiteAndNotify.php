<?php 


error_reporting(E_ALL); ini_set('display_errors', 'on');


$URL = "https://127.0.0.1/xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx/?rnd=" . time();
$HOST = "www.xxxxxxxxxxxxxxxxx.com.br";

$RET = get_data($URL, $HOST, []);

if($RET[0]['http_code'] != 200)
{
    ___RESTART();
    data2Notify("ERROR: HTTP CODE " . $RET[0]['http_code'] . " - " . $URL);    
    exit;
}
else
{
    if(strpos($RET[1], '<html') === false)
    {
        ___RESTART();
        data2Notify("ERROR: HTML START NOT FOUND - " . $URL);
        exit;
    }
    
    if(strpos($RET[1], '</html') === false)
    {
        ___RESTART();
        data2Notify("ERROR: HTML END NOT FOUND - " . $URL);
        exit;
    }

    if(strpos($RET[1], '<body') === false)
    {
        ___RESTART();
        data2Notify("ERROR: BODY END NOT FOUND - " . $URL);
        exit;
    }

    if(strpos($RET[1], '</body') === false)
    {
        ___RESTART();
        data2Notify("ERROR: BODY END NOT FOUND - " . $URL);
        exit;
    }
}

#data2Notify(json_encode($RET[0]));

exit;



function data2Notify($MSG)
{
    $shell = "data2-notify " . escapeshellarg($MSG);
    $output = shell_exec($shell);
    return $output;
}

function ___RESTART()
{
    echo system("systemctl restart php-fpm");    
    echo system("systemctl restart nginx");
    echo system("systemctl restart mysql");
    data2Notify("SERVICES RESTARTED - LOAD: " . @array_shift(sys_getloadavg()) . " - " . date('Y-m-d H:i:s'));
}

print_R($RET);


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




function get_data($url, $host, $POST = false, $FLG_FOLLOW_REDIRECT = false)
{
	$ch = curl_init();
	$timeout = 20;
	$header = array();

    if(!empty($host))
    {
        $header[] = 'Host: ' . $host;
    }

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

	curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36');

	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

    //disable ssl verification
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

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
    $info = curl_getinfo($ch);
	curl_close($ch);

	return [$info, $data];
}
