<?php

ini_set('session.cookie_samesite', 'None');
@session_start();
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

// Usuários
$router->group("usuario");
$router->get("/{orderColumn}/{orderDirection}/{limit}/{offset}/{justActive}", "UsuarioController:all");
$router->get("/{id}", "UsuarioController:getById");
$router->get("/changeVisibility/{id}/{visibility}", "UsuarioController:changeVisibility");
$router->post("/save", "UsuarioController:save");
$router->put("/update/{id}", "UsuarioController:update");
$router->delete("/delete/{id}", "UsuarioController:delete");

// Animal comportamento
$router->group("animalcomportamento");
$router->get("/", "AnimalComportamentoController:all");
$router->get("/{id}", "AnimalComportamentoController:getById");
$router->get("/changeVisibility/{id}/{visibility}", "AnimalComportamentoController:changeVisibility");
$router->post("/save", "AnimalComportamentoController:save");
$router->put("/update/{id}", "AnimalComportamentoController:update");
$router->delete("/delete/{id}", "AnimalComportamentoController:delete");

// Animal raça
$router->group("raca");
$router->get("/", "AnimalRacaController:all");
$router->get("/{id}", "AnimalRacaController:getById");
$router->get("/changeVisibility/{id}/{visibility}", "AnimalRacaController:changeVisibility");
$router->post("/save", "AnimalRacaController:save");
$router->put("/update/{id}", "AnimalRacaController:update");
$router->delete("/delete/{id}", "AnimalRacaController:delete");

// Animal
$router->group("animal");
$router->get("/{orderColumn}/{orderDirection}/{limit}/{offset}/{justActive}", "AnimalController:all");
$router->get("/{id}", "AnimalController:getById");
$router->get("/changeVisibility/{id}/{visibility}", "AnimalController:changeVisibility");
$router->get("/info/byuser/{idUser}", "AnimalController:getAnimalListByUserId");
$router->get("/info/byanimal/{idAnimal}", "AnimalController:getAnimalListById");
$router->post("/save", "AnimalController:save");
$router->put("/update/{id}", "AnimalController:update");
$router->delete("/delete/{id}", "AnimalController:delete");

// Endereço
$router->group("endereco");
$router->get("/", "EnderecoController:all");
$router->get("/{id}", "EnderecoController:getById");
$router->get("/changeVisibility/{id}/{visibility}", "EnderecoController:changeVisibility");
$router->post("/save", "EnderecoController:save");
$router->put("/update/{id}", "EnderecoController:update");
$router->delete("/delete/{id}", "EnderecoController:delete");

// Vacina
$router->group("vacina");
$router->get("/", "VacinaController:all");
$router->get("/{id}", "VacinaController:getById");
$router->get("/changeVisibility/{id}/{visibility}", "VacinaController:changeVisibility");
$router->post("/save", "VacinaController:save");
$router->put("/update/{id}", "VacinaController:update");
$router->delete("/delete/{id}", "VacinaController:delete");

// Vacinação
$router->group("vacinacao");
$router->get("/", "VacinacaoController:all");
$router->get("/{id}", "VacinacaoController:getById");
$router->get("/changeVisibility/{id}/{visibility}", "VacinacaoController:changeVisibility");
$router->get("/horadevacinar/{idAnimal}", "VacinacaoController:verificarSeEHoraDeVacinar");
$router->post("/save", "VacinacaoController:save");
$router->put("/update/{id}", "VacinacaoController:update");
$router->delete("/delete/{id}", "VacinacaoController:delete");

// Exames
$router->group("exame");
$router->get("/{orderColumn}/{orderDirection}/{limit}/{offset}/{justActive}", "ExameController:all");
$router->get("/{id}", "ExameController:getById");
$router->get("/changeVisibility/{id}/{visibility}", "ExameController:changeVisibility");
$router->post("/save", "ExameController:save");
$router->put("/update/{id}", "ExameController:update");
$router->delete("/delete/{id}", "ExameController:delete");

// Consultas
$router->group("consulta");
$router->get("/{orderColumn}/{orderDirection}/{limit}/{offset}/{justActive}", "ConsultaController:all");
$router->get("/{id}", "ConsultaController:getById");
$router->get("/changeVisibility/{id}/{visibility}", "ConsultaController:changeVisibility");
$router->post("/save", "ConsultaController:save");
$router->put("/update/{id}", "ConsultaController:update");
$router->delete("/delete/{id}", "ConsultaController:delete");

// Agendas
$router->group("agenda");
$router->get("/{orderColumn}/{orderDirection}/{limit}/{offset}/{justActive}", "AgendaController:all");
$router->get("/{id}", "AgendaController:getById");
$router->get("/byuser/{id}/{active}", "AgendaController:getByUser");
$router->get("/changeVisibility/{id}/{visibility}", "AgendaController:changeVisibility");
$router->get("/appointments/{date}/{id}", "AgendaController:listAppointmentByMonth");
$router->post("/save", "AgendaController:save");
$router->put("/update/{id}", "AgendaController:update");
$router->delete("/delete/{id}", "AgendaController:delete");

// Bloqueio
$router->group("bloqueio");
$router->get("/", "BloqueioController:all");
$router->get("/{id}", "BloqueioController:getById");
$router->get("/changeVisibility/{id}/{visibility}", "BloqueioController:changeVisibility");
$router->post("/save", "BloqueioController:save");
$router->put("/update/{id}", "BloqueioController:update");
$router->delete("/delete/{id}", "BloqueioController:delete");

// Agenda Item
$router->group("agendaitem");
$router->get("/{id}", "AgendaItemController:getById");
$router->get("/byuser/{id}/{date}", "AgendaItemController:getByUser");
$router->post("/save", "AgendaItemController:save");
$router->delete("/delete/{id}", "AgendaItemController:delete");

// Avaliação
$router->group("avaliacao");
$router->get("/", "AvaliacaoController:all");
$router->get("/{id}", "AvaliacaoController:getById");
$router->get("/byuser/{id}", "AvaliacaoController:getByUser");
$router->get("/changeVisibility/{id}/{visibility}", "AvaliacaoController:changeVisibility");
$router->post("/save", "AvaliacaoController:save");
$router->put("/update/{id}", "AvaliacaoController:update");
$router->delete("/delete/{id}", "AvaliacaoController:delete");

// Auth
$router->group("auth");
$router->post("/login", "AuthController:login");
$router->get("/islogged", "AuthController:isLogged");
$router->get("/logout", "AuthController:logout");

$router->group("error");
$router->get("/{status}", "ErrorController:index");

$router->dispatch();

if($router->error()) {
    $router->redirect("/error/{$router->error()}");
}
