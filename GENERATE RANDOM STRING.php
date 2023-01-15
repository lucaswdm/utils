<?php

function randomstr($qtde = 10)
{
		return substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',32)),0,$qtde);
}
