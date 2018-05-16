<?php

function remove_diacritics($x) {
		return preg_replace(array('/\xc3[\x80-\x85]/', //upper case
								  '/\xc3\x87/',
								  '/\xc3[\x88-\x8b]/',
								  '/\xc3[\x8c-\x8f]/',
								  '/\xc3([\x92-\x96]|\x98)/',
								  '/\xc3[\x99-\x9c]/',
								  '/\xc3[\xa0-\xa5]/', //lower case
								  '/\xc3\xa7/',
								  '/\xc3[\xa8-\xab]/',
								  '/\xc3[\xac-\xaf]/',
								  '/\xc3([\xb2-\xb6]|\xb8)/',
								  '/\xc3[\xb9-\xbc]/'),
							str_split('ACEIOUaceiou', 1),
							$this->is_utf8( $x ) ? $x : utf8_encode($x));
	}


	function slug($x) {
		return preg_replace(array('/[^a-z0-9]/', '/-{2,}/'), '-', strtolower(remove_diacritics($x)));
	}
  
  $SECOES = array_values(array_filter(array_map('slug', explode('/', $_SERVER['REQUEST_URI']))));

  $SECAO = $SECOES[0];

  if(empty($SECAO) || !is_file(__DIR__ . '/' . $SECAO . '.php')) $SECAO = 'home';
