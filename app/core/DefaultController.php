<?php

namespace App\Core;

class DefaultController
{
    public function response(array $data = [], int $responseCode = 200): void
    {
        http_response_code($responseCode);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }
}