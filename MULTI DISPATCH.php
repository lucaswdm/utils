<?php



function D2DISPATCH($nodes, $CONF = array(), $POST = array()){

    $mh = curl_multi_init();
$curl_array = array();

    #depura(func_get_args()); exit;

foreach($nodes as $i => $url)
{

            $TIMEOUT = $CONF['timeout'] ?? 60;

            $HEADER = array();

            #if(isset($CONF['header']))


    $curl_array[$i] = curl_init($url);

            {
                    curl_setopt($curl_array[$i], CURLOPT_HTTPHEADER, $CONF['header'] ?? array());
            }

    curl_setopt($curl_array[$i], CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_array[$i], CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36 @ Check.Dataraw.net");
    curl_setopt($curl_array[$i], CURLOPT_CONNECTTIMEOUT, $TIMEOUT);
    curl_setopt($curl_array[$i], CURLOPT_TIMEOUT,  $TIMEOUT);
    curl_setopt($curl_array[$i], CURLOPT_FOLLOWLOCATION,  $TIMEOUT);

            #if(isset($CONF['insecure']))
            {
                    curl_setopt($curl_array[$i], CURLOPT_SSL_VERIFYHOST, false);
                    curl_setopt($curl_array[$i], CURLOPT_SSL_VERIFYPEER, false);
            }

            if($POST)
            {
                    curl_setopt($curl_array[$i],CURLOPT_POST, true);
                    curl_setopt($curl_array[$i],CURLOPT_POSTFIELDS, ($POST));
            }

    curl_multi_add_handle($mh, $curl_array[$i]);
}
$running = NULL;
do {
    usleep(50000);
    curl_multi_exec($mh,$running);
} while($running > 0);

$res = array();
foreach($nodes as $i => $url)
{
    $res[$i] = array(curl_getinfo($curl_array[$i]), curl_multi_getcontent($curl_array[$i]));
}

foreach($nodes as $i => $url){
    curl_multi_remove_handle($mh, $curl_array[$i]);
}



curl_multi_close($mh);

return $res;
}
