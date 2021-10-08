<?php

date_default_timezone_set("America/Sao_Paulo");

require_once "./config.php";
require_once "./vendor/autoload.php";

use CoffeeCode\Router\Router;

$router = new Router(BASE_PATH);
$router->namespace("App\Controller");

$router->group(null);
$router->get("/", "HomeController:index");

// Tipo de Usuário
$router->group("tipousuario");
$router->get("/", "TipoUsuarioController:all");
$router->get("/{id}", "TipoUsuarioController:getById");
$router->get("/changeVisibility/{id}/{visibility}", "TipoUsuarioController:changeVisibility");
$router->post("/save", "TipoUsuarioController:save");
$router->put("/update/{id}", "TipoUsuarioController:update");
$router->delete("/delete/{id}", "TipoUsuarioController:delete");

// Tipo de Animal
$router->group("tipoanimal");
$router->get("/", "TipoAnimalController:all");
$router->get("/{id}", "TipoAnimalController:getById");
$router->get("/changeVisibility/{id}/{visibility}", "TipoAnimalController:changeVisibility");
$router->post("/save", "TipoAnimalController:save");
$router->put("/update/{id}", "TipoAnimalController:update");
$router->delete("/delete/{id}", "TipoAnimalController:delete");

$router->group("error");
$router->get("/{status}", "ErrorController:index");

$router->dispatch();

if($router->error()) {
    $router->redirect("/error/{$router->error()}");
}
