<?php


function aplicaMascara($valor, $mascara, $mascarador = '#')
		{
			#return $valor;

			$RETORNO = [];

			$VALOR = str_split($valor);

			$MASCARA = str_split($mascara);

			foreach($MASCARA as $v)
			{
				if($v == $mascarador)
				{
					$RETORNO[] = array_shift($VALOR) ?? '';
				}
				else
				{
					$RETORNO[] = $v;
				}
			}

			return implode('', $RETORNO);
		}

