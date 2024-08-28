<?php

$RURI = strtok($_SERVER['REQUEST_URI'],'?');

$SECOES = array_values(array_filter(array_map(function($item){
    return preg_replace('/[^0-9a-z\-\.\_\%]/i','', $item);
}, explode('/', $RURI)), function($item){
    return $item != '';
}));


$SECAO = $SECOES[0];

if(empty($SECAO) || !is_file(__DIR__ . '/' . $SECAO . '.php')) $SECAO = 'home';
