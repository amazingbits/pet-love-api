<?php

namespace App\Core;

class Connection
{
    private static $conn;

    public static function getInstance(): \PDO
    {
        if(empty(self::$conn)) {
            try {
                self::$conn = new \PDO(
                    "mysql:host=".DB_HOST.";dbname=".DB_DATABASE,
                    DB_USER,
                    DB_PASSWORD,
                    DB_OPTIONS
                );
            } catch (\PDOException $e) {
                $view = new DefaultController();
                $status = 500;
                $view->response([
                    "status" => $status,
                    "message" => "Houve um problema ao tentar conectar com o banco de dados!",
                    "error" => $e->getMessage(),
                    "data" => []
                ], $status);
                exit;
            }
        }

        return self::$conn;
    }

    final private function __construct() {}
}