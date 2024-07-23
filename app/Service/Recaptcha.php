<?php

namespace App\Service;

class Recaptcha
{
    public function validate(string $recaptcha_response): bool
    {
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = [
            'secret' => env('RECAPTCHA_SECRET'),
            'response' => $recaptcha_response
        ];

        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data),
            ]
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($url, FALSE, $context);
        $result_json = json_decode($result);

        return $result_json->success;
    }
}
