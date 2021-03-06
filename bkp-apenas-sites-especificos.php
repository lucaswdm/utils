<?php

$DIRBASE = '/var/www/';

$DOMINIOSTXT = mb_strtolower("
xxx.xxx
xxx.xxx
");

$DOMINIOS = array_filter(array_map('trim', explode(PHP_EOL, $DOMINIOSTXT)));

foreach($DOMINIOS as $dominio)
{
  if(!empty($dominio) && is_dir($DIRBASE . $dominio . '/'))
  {
    echo PHP_EOL . "rsync -avz  /var/www/".$dominio." -e 'ssh -p 22022' root@xxxxx.x.x.x.x.:/data/" . $dominio . "/;" . PHP_EOL;
  }
}
