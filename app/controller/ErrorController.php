<?php

namespace App\Controller;

use App\Core\DefaultController;

class ErrorController extends DefaultController
{
    public function index($data = [])
    {
        $status = (int)$data['status'];
        $this->response([
            "message" => "Houve um problema com a sua requisição.",
            "error" => HTTP_ERRORS[$status]
        ], $status);
    }
}