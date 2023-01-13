<?php 

class Mailgun {
    const API_KEY = 'xxxxxxxxxxxxxx-xxxxxxxxxxxx-xxxxxxxxxxxxxxx-xxxxxxxxxxxx';
    const API_ENDPOINT = 'https://api.mailgun.net';
    const DOMAIN = 'mg.domain.org';
    const FROM = APP_NAME . '<' .       'nao-responda@mg.domain.org'        . '>';

    static function send($TO, $SUBJECT, $HTML) {
        $ch = curl_init();
        $POST = [
            'from' => self::FROM,
            'to' => $TO,
            'subject' => $SUBJECT,
            'html' => $HTML,
        ];

        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, 'api:' . self::API_KEY);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_URL, self::API_ENDPOINT . '/v3/'.self::DOMAIN.'/messages');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($POST));

        $result = curl_exec($ch);

        return json_decode($result, true);
    }
}
