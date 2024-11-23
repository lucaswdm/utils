<?php

$DIR = '/data/';

$SHELL = "find {$DIR} -name 'sess_*' -type f";

$FILES = shell_exec($SHELL);
$FILES = explode(PHP_EOL, $FILES);

foreach($FILES as $FILE)
{
   $FILE = trim($FILE);
   echo $FILE . PHP_EOL;
}
