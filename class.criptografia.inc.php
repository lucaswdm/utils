<?php

class Criptografia {

    private $password = '@535sjfsjnfwihf8ybf80niosdjkgbsiooCf6QR=A9=a+8%b2p?_6g@HfvETu=a+8%b2p?MH*=a+8%b2pKKHRw6JG-Z=a+8%b2p*Q=a+8%b2p=5attXxt!8-xC*hM2-Br!&RYAX%6t8K@?g5%+ArwT8e3JDqxerUxdAZpM8a&WWp';

    function setKey($password) {
        $this->password = $password;
    }

    function get_rnd_iv($iv_len) {
        $iv = '';
        while ($iv_len-- > 0) {
            $iv .= chr(mt_rand() & 0xff);
        }
        return $iv;
    }

    function encripta($plain_text, $iv_len = 16) {
        $plain_text .= "\x13";

        $n = strlen($plain_text);
        if ($n % 16) $plain_text .= str_repeat("\0", 16 - ($n % 16));
            $i = 0;
            $enc_text = Criptografia::get_rnd_iv($iv_len);
            $iv = substr($this->password ^ $enc_text, 0, 512);
            while ($i < $n) {
                $block = substr($plain_text, $i, 16) ^ pack('H*', sha1($iv));
                $enc_text .= $block;
                $iv = substr($block . $iv, 0, 512) ^ $this->password;
                $i += 16;
            }
            return base64_encode($enc_text);
    }

    function decripta($enc_text, $iv_len = 16) {
        $enc_text = base64_decode($enc_text);
        $n = strlen($enc_text);
        $i = $iv_len;
        $plain_text = '';
        $iv = substr($this->password ^ substr($enc_text, 0, $iv_len), 0, 512);
        while ($i < $n) {
            $block = substr($enc_text, $i, 16);
            $plain_text .= $block ^ pack('H*', sha1($iv));
            $iv = substr($block . $iv, 0, 512) ^ $this->password;
            $i += 16;
        }
        return stripslashes(preg_replace('/\\x13\\x00*$/', '', $plain_text));
    }

}
