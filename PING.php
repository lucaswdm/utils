<?php

class data2Ping {
    static function ping($ip) {
        $ip = preg_replace('/[^0-9\.\-a-z]/i', '', $ip);
        $SHELL = "ping -W 1 -c 2 " . $ip;
        #$SHELL = "ping -c 2 " . $ip;
        $SHELL_EXEC = trim(shell_exec($SHELL));

        $LATS = array();

        if(preg_match_all('/time\=([0-9\.\,]{1,7})\ ms/', $SHELL_EXEC, $lats))
        {
            foreach($lats[1] as $x) {
                if(is_numeric($x)) {
                    $LATS[] = floatval(str_replace(',','',$x));
                }
            }
        }

       # print_r($LATS);

        if(preg_match('/([0-9\.\,]{1,3})\% packet loss/', $SHELL_EXEC, $dados))
        {
            #print_r($dados);
            if($dados[1] == 0) {
                return array(true,  round( array_sum($LATS) / count($LATS) ,3)  );
            }
        }

        return array(false, 999);
    }
}

// USAGE -->      $STATUS = data2Ping::ping('1.1.1.1'); // returns [status(false,true),latency]
