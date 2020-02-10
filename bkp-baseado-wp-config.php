#!/usr/bin/php
<?php

$FILE = $argv[1];

echo PHP_EOL;
echo $FILE;
echo PHP_EOL;

$DIRWP = dirname($FILE) . '/';

if(!is_dir($DIRWP . 'wp-includes/')&&is_dir($DIRWP . 'htdocs/wp-includes/')) $DIRWP .= 'htdocs/';
echo $DIRWP . PHP_EOL;
if(!is_dir($DIRWP . 'wp-includes/')&&is_dir($DIRWP . 'www/wp-includes/')) $DIRWP .= 'www/';
echo $DIRWP . PHP_EOL;
if(!is_dir($DIRWP . 'wp-includes/')&&is_dir($DIRWP . 'public_html/wp-includes/')) $DIRWP .= 'public_html/';

echo $DIRWP . PHP_EOL;

if(is_dir($DIRWP))
{
     if( is_dir($DIRWP . 'wp-includes/') && is_dir($DIRWP . 'wp-admin/') && is_dir($DIRWP . 'wp-content/') )
     {
          $SHELL = "cd ".$DIRWP."; ";
          $SHELL .= "wp-cli db export --allow-root --skip-themes --skip-plugins --path=" . $DIRWP;
          echo $SHELL . ';' . PHP_EOL;
     }
     else
     {
          echo $DIRWP . ' WP BASE DIRS #404' . PHP_EOL;    
     }
}
else
{
     echo $DIRWP . ' #404' . PHP_EOL;
}
