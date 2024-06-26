class GoogleSheets
    {

        var $extensao = '';
        var $filename = "";

        static function id2CsvArray($ID)
        {
            $URL = "https://docs.google.com/spreadsheets/d/".$ID."/export?format=csv";

            $TMPFILE = tempnam(sys_get_temp_dir(), 'csv');
            
            $CONTENTS = self::request($URL, []);

            file_put_contents($TMPFILE, $CONTENTS);

            $CSV = [];

            $file = fopen($TMPFILE, 'r');
            while (($line = fgetcsv($file)) !== FALSE) {
                //$line is an array of the csv elements
                $CSV[] = $line;
            }
            fclose($file);

            unlink($TMPFILE);

            return $CSV;
        }

        static function request($url, $POST)
        {
            $ch = curl_init();
            $timeout = 30;
            $header = array();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

            curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36');

            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

            #if($FLG_FOLLOW_REDIRECT)
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
    }
