<?php

	$INFRA = array();

	foreach(glob('/data/*/') as $dir)
	{
		if(is_file($dir)) continue;
		$DOMINIO = basename($dir);
		if(!validaDominio($DOMINIO)) continue;
		$INFRA['domains'][$DOMINIO] = true;
		#echo $dir . PHP_EOL;
	}

	$INFRA['cores'] = intval(shell_exec('cat /proc/cpuinfo | grep processor | wc -l'));
	$INFRA['processador'] = implode(' - ' , array_slice(array_values(array_filter(array_map('trim', explode(':', @array_shift(@explode(PHP_EOL, shell_exec('cat /proc/cpuinfo | grep "model name"'))))))),1));

	#print_r($INFRA); exit;

	foreach(explode(PHP_EOL, shell_Exec("free -m | grep 'Mem:'")) as $Line) {
		if(strpos($Line, 'Mem:') !== false) {
			#echo $Line . PHP_EOL;
			$EXP = array_values(array_filter(explode(" ", $Line)));
			foreach($EXP as $v) if(is_numeric($v)) $INFRA['memory'] = round($v/1024,2);
			#print_r($EXP);
		}

	}

	#print_r($INFRA);

	#exit;

	$INFRA['alldf'] = explode(PHP_EOL, shell_exec('df'));
	foreach($INFRA['alldf'] as $line) {
		$VET = (explode(" ", trim($line)));
		$PARTICAO = array_pop($VET);
		#echo $PARTICAO . PHP_EOL;
		if(!is_dir($PARTICAO)) continue;
		$INFRA['particoes'][$PARTICAO] = array(
			'total' => round(disk_total_space($PARTICAO)/1000/1000/1000,2),
			'free' => round(disk_free_space($PARTICAO)/1000/1000/1000,2),
		);

		if($INFRA['particoes'][$PARTICAO]['total'] < 6) unset($INFRA['particoes'][$PARTICAO]);
	}

	#print_r($INFRA);

	#exit;

	ksort($INFRA['domains']);

	#print_r($INFRA);

	function validaDominio($domain_name)
{
	if($domain_name != strtolower($domain_name)) return false;
	if(filter_var($domain_name, FILTER_VALIDATE_IP)) return false;
	if(strpos($domain_name, '.') === false) return false;
    return (preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $domain_name) //valid chars check
            && preg_match("/^.{1,253}$/", $domain_name) //overall length check
            && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domain_name)   ); //length of each label
}

function get_data($url, $POST = false, $FLG_FOLLOW_REDIRECT = false)
{
	$ch = curl_init();
	$timeout = 10;
	$header = array();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION , true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36');
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	if($FLG_FOLLOW_REDIRECT)
	{
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	}

	 curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);

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

	$HTML = "<style>* {

		font-family: sans-serif;

	} table {
		border:1px solid #c0c0c0;
		border-collapse: collapse;

	} table tr td {
		border:1px solid #c0c0c0;
		padding: 2px 5px;
		text-align: center;

	}

	 table tr th {
		border:1px solid #c0c0c0;
		padding: 2px 5px;
		text-align: center;
		background: #333;
		color: #fff;
		font-weight: bold;
		font-size: 1.1em;

	}

	</style>";

	$IP = trim(get_data('http://monitor.data2.com.br/centos/meuip.php'));

	$HTML .= "<h1>SERVIDOR: ".$IP."</h1>";


	$HTML .= "<hr>";
	$HTML .= "<h2>PROCESSADOR: ".$INFRA['processador']." &nbsp;&nbsp;&nbsp;&nbsp; NUCLEOS: ".$INFRA['cores']."</h2>";
	$HTML .= "<hr><h2>MEMORIA: ".number_format($INFRA['memory'],2)." GB</h2>";

	$HTML .= "<hr>";
	$HTML .= "<h2>PARTICOES & ESPACO EM DISCO</h2>";
	$HTML .= "<table border='1'>";
	$HTML .= "<tr><th>PARTICAO</th> <th>ESPACO TOTAL</th> <th>UTILIZADO</th> <th>DISPONIVEL</th> <th>PORCENTAGEM UTILIZADO</th></tr>";
	foreach($INFRA['particoes'] as $particao => $dadosparticao) {
		#$dadosparticao['total'] = 200;
		#$dadosparticao['free'] = 50;
		$ESPACO_UTILIZADO = abs($dadosparticao['total'] - $dadosparticao['free']);
		$PCT_UTILIZADO =  abs(($ESPACO_UTILIZADO / $dadosparticao['total']))*100;
		#$PCT_UTILIZADO =  abs(1 - ($ESPACO_UTILIZADO / $dadosparticao['total']))*100;
		#echo $particao . "\t" . $PCT_UTILIZADO . PHP_EOL;
		$HTML .= "<tr>";
		$HTML .= "<td  align='center'>" . $particao . "</td>";
		$HTML .= "<td align='center'>" . round($dadosparticao['total'],2) . " GB</td>";
		$HTML .= "<td align='center'>" . round($ESPACO_UTILIZADO,2) . " GB</td>";
		$HTML .= "<td align='center'>" . round($dadosparticao['free'],2) . " GB</td>";
		$HTML .= "<td align='center'>" . round($PCT_UTILIZADO,2) . " %</td>";
		$HTML .= "</tr>";
		#$HTML .= "<h4>PARTICAO " . $particao . " - ESPACO TOTAL: " . round($dadosparticao['total'],2) . ' GB &nbsp;&nbsp;&nbsp;&nbsp; ESPACO LIVRE: ' . round($dadosparticao['free'],2) . ' - &nbsp;&nbsp;&nbsp;&nbsp; ESPACO SOBRANDO: ' . round($ESPACO_UTILIZADO,2) . ' GB';
	}
	$HTML .= "</table>";
	$HTML .= "<hr>";

	$HTML .= "<h2>".count($INFRA['domains'])." DOMINIOS</h2>";
	foreach($INFRA['domains'] as $domain => $xxxx)
	{
		$PATH = '/data/' . $domain . '/';
		$ESPACO = trim(shell_exec("du -s '".$PATH."'"));
		$HTML .= "<div>{$ESPACO} <a href='http://".$domain."/' target='_blank'>".$domain."</a></div>";
		break;
	}

	$HTML .= "<style></style>";

	#exit;

	$REPORT = '/data/default/data2-report-' . date('Y-m-d_H-i-s') . '-'.rand().'.html';

	if(file_put_contents($REPORT, $HTML))
	{
		$url = "http://" . $IP . "/" . basename($REPORT);
		echo PHP_EOL;
		echo PHP_EOL;
		echo PHP_EOL;
		echo PHP_EOL;
		echo PHP_EOL;
		echo PHP_EOL;
		echo PHP_EOL;
		echo PHP_EOL;
		echo PHP_EOL;
		echo $url;
		echo PHP_EOL;
		echo PHP_EOL;
		echo PHP_EOL;
		echo PHP_EOL;
		echo PHP_EOL;
		echo PHP_EOL;
		echo PHP_EOL;
		echo PHP_EOL;
		echo PHP_EOL;
	}

 ?>
