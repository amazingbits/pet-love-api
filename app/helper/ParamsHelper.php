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

    public function validateParams(array $params, array $needle): bool
    {
        if(empty($params) || empty($needle)) return false;
        if(count($params) !== count($needle)) return false;
        $needleKeys = array_keys($needle);
        $needleTypes = [];
        foreach($needle as $key=>$value) {
            array_push($needleTypes, $value);
        }
        $c = 0;
        foreach($params as $key=>$value) {
            $key = mb_strtolower($key);
            $type = gettype($value);
            if(!in_array($key, $needleKeys)) return false;
            if($type !== $needleTypes[$c]) return false;
            $c++;
        }

        return true;
    }
}