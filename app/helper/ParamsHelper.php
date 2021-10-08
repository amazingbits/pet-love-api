<?php

namespace App\Helper;

use App\Core\DefaultController;

class ParamsHelper
{
    public function getJsonParams(): array
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if($data === null) {
            $defaultController = new DefaultController();
            $defaultController->response([
                "message" => "Nenhum parâmetro encontrado!"
            ], HTTP_BAD_REQUEST);
        }
        return $data;
    }
}