<?php

namespace App\Controller;

use App\Core\DefaultController;

class HomeController extends DefaultController
{
    public function index()
    {
        $this->response([
            "message" => "Bem vindo à API Pet Love."
        ]);
    }
}