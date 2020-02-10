<?php

$DIRBASE = '/var/www/';

$DOMINIOSTXT = mb_strtolower("cartaodecreditoonline.org
beautyblog.com.br
creditoparatodos.org
ideabrasil.com.br
simpatiaspoderosas.org
101receitasdegeleia.com
jeitofitness.com
blogdakamaleoah.com");

$DOMINIOS = array_filter(array_map('trim', explode(PHP_EOL, $DOMINIOSTXT)));

foreach($DOMINIOS as $dominio)
{
  if(!empty($dominio) && is_dir($DIRBASE . $dominio . '/'))
  {
    echo PHP_EOL . "rsync -avz  /var/www/".$dominio." -e 'ssh -p 22022' root@104.225.219.152:/data/" . $dominio . "/;" . PHP_EOL;
  }
}
