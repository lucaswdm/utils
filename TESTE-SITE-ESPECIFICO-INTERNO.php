<?php
  
  function validacao()
  {
      $url = 'https://comidinhasdochef.com/';
      $dados = get_data($url);
      print_r($dados);
      return true;
  }
  
  
  if(!validacao()) geraErro("X");
  
  function geraErro($erro)
  {
      header('HTTP/1.1 500 Internal Server Error', true, 500);
      echo $erro;
      exit;
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
  $info = curl_getinfo($ch);
	curl_close($ch);

	return array($info, $data);
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello World! Site Title</title>
  </head>
  <body>
    <h1><?php echo $STATUS; ?></h1>
  </body>
</html>
