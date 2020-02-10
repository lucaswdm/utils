#!/usr/bin/php
<?php

$FILE = $argv[1];

echo PHP_EOL;
echo $FILE;
echo PHP_EOL;

$DIRWP = dirname($FILE) . '/';

if(is_dir($DIRWP))
{
     if( is_dir($DIRWP . 'wp-includes/') && is_dir($DIRWP . 'wp-admin/') && is_dir($DIRWP . 'wp-content/') )
     {
        $SHELL = "cd ".$DIRWP."; wp-cli db export --allow-root --skip-themes --skip-plugins --path=" . $DIRWP . " " . $DIRWP . ";" . PHP_EOL;
     }
}