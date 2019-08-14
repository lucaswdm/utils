<?php

	define('SERVICEBIN', '/bin/systemctl');

	$SERVICE = preg_replace('/[^0-9a-z\_\-]{3,}/', '', $argv[1]);
	$SHELL = SERVICEBIN . " status ".$SERVICE.".service";
	#$SHELL = "ps -ef | grep -v grep | grep '".$SERVICE."'";
	$t0 = microtime(true);
	$EXEC = strtoupper(trim(shell_exec($SHELL)));
	#echo (microtime(true) - $t0) . PHP_EOL;
	#echo $EXEC . PHP_EOL;
	if(preg_match('/ACTIVE\:\ ([A-Z0-9\.\-]{3,})/', $EXEC, $dados))
	{
		echo $SERVICE . ' SERVICE: ' . $dados[1] . PHP_EOL;

		#if(in_array($dados[1], array('FAILED', 'FAILED')))
		if(!in_array($dados[1], array('ACTIVE')))
		{
			executaRestart($SERVICE);
		}

	}
	else
	{
		echo PHP_EOL;
		print_r($EXEC);
		echo PHP_EOL;
	}

	function executaRestart($SERVICE)
	{
		echo system(SERVICEBIN . " restart " . $SERVICE . ".service") . PHP_EOL;
	}

	#print_r($EXEC);
	#echo $SHELL . PHP_EOL;
 ?>
