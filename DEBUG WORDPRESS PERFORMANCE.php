if(!function_exists('depura'))
{
	$_SERVER['t0'] = microtime(true);

	function depura()
	{
		if(!isset($_GET['data2'])) return false;

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
	function t1($TEXTO = "")
	{
		global $t0;
		$diff = microtime(true) - $_SERVER['t0'];
		depura( $TEXTO . "\t" . number_format( (microtime(true) - $t0) ,10) . " // " . number_format($diff,3) . 's total' );
	}
}
