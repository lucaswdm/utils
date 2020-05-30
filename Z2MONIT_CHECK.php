<?php

    $IP = trim(@file_get_contents('/root/ip.txt'));

    if(!filter_var($IP, FILTER_VALIDATE_IP))
    {
        exit(PHP_EOL . $IP . ' IP INVALIDO!' . PHP_EOL);
    }

    $A = rand(1,9999);
    $B = rand(1,9999);
    $C = rand(1,9999);

    $URL = "http://".$IP."/Z2MONIT_VERIFY.php?a=" . $A . '&b=' . $B . '&c=' . $C;

    $RESULTADO_REAL = get_data($URL);

    $RESULTADO = $A + $B + $C;

    if($RESULTADO_REAL[0]['http_code'] != 200 || $RESULTADO_REAL[1] != $RESULTADO)
    {
            system('service nginx restart');
            system('service php-fpm restart');
            system('service nginx restart');
    }

        #print_r($html);

function get_data_d2_verify($url, $POST = false, $FLG_FOLLOW_REDIRECT = false)
{
    $ch = curl_init();
    $timeout = 4;
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
    $info = curl_getinfo($ch);
    curl_close($ch);

    return array($info,$data);
}
