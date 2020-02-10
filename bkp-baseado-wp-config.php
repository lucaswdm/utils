#!/usr/bin/php
<?php
error_reporting(E_ALL);
ini_set('display_errors', true);

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
     echo __FILE__ . "\t" . __LINE__ . "\t" . rand();
     if( is_dir($DIRWP . 'wp-includes/') && is_dir($DIRWP . 'wp-admin/') && is_dir($DIRWP . 'wp-content/') )
     {
          echo __FILE__ . "\t" . __LINE__ . "\t" . rand();
          $SHELL = "cd ".$DIRWP."; ";
          $SHELL .= "wp-cli db export --allow-root --skip-themes --skip-plugins --path=" . $DIRWP;
          echo $SHELL . ';' . PHP_EOL;
     }
     else
     {
          echo __FILE__ . "\t" . __LINE__ . "\t" . rand();
          echo $DIRWP . ' WP BASE DIRS #404' . PHP_EOL;    
     }
}
else
{
     echo __FILE__ . "\t" . __LINE__ . "\t" . rand();
     echo $DIRWP . ' #404' . PHP_EOL;
}
