<?php

$DIR = '/data/';

$SHELL = "find {$DIR} -name 'sess_*' -type f";

$FILES = shell_exec($SHELL);
$FILES = explode(PHP_EOL, $FILES);

foreach($FILES as $FILE)
{
   $FILE = trim($FILE);
  
   $BASENAME = basename($FILE);
   if(preg_match('/^sess\_([a-f0-9]{32})$/', $BASENAME))
   {
          echo '[del] . ' . $FILE . PHP_EOL;
   }
}
