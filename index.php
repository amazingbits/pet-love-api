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
$router->put("/updatepassword/{userId}", "UsuarioController:updatePassword");
$router->put("/update/{id}", "UsuarioController:update");
$router->delete("/delete/{id}", "UsuarioController:delete");
$router->get("/pesquisarempresas/raio/{latitude}/{longitude}", "UsuarioController:pesquisarEmpresasPorRaio");
$router->get("/pesquisarempresas/byname", "UsuarioController:findCompanies");
$router->get("/pesquisarempresas/byname/{name}", "UsuarioController:findCompaniesByName");
$router->post("/newUserByApp", "UsuarioController:newUserByApp");

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

// Agendas
$router->group("agenda");
$router->get("/{orderColumn}/{orderDirection}/{limit}/{offset}/{justActive}", "AgendaController:all");
$router->get("/{id}", "AgendaController:getById");
$router->get("/byuser/{id}/{active}", "AgendaController:getByUser");
$router->get("/changeVisibility/{id}/{visibility}", "AgendaController:changeVisibility");
$router->get("/appointments/{date}/{id}", "AgendaController:listAppointmentByMonth");
$router->get("/myappointments/{userId}", "AgendaController:getMyAppointments");
$router->post("/save", "AgendaController:save");
$router->put("/update/{id}", "AgendaController:update");
$router->delete("/delete/{id}", "AgendaController:delete");
$router->get("/find/{data}/{idAgenda}", "AgendaController:findByDateAndId");

// Bloqueio
$router->group("bloqueio");
$router->get("/", "BloqueioController:all");
$router->get("/{id}", "BloqueioController:getById");
$router->get("/changeVisibility/{id}/{visibility}", "BloqueioController:changeVisibility");
$router->get("/myblocks/{idUser}", "BloqueioController:meusBloqueios");
$router->post("/save", "BloqueioController:save");
$router->put("/update/{id}", "BloqueioController:update");
$router->delete("/delete/{id}", "BloqueioController:delete");

// Agenda Item
$router->group("agendaitem");
$router->get("/{id}", "AgendaItemController:getById");
$router->get("/byuser/{id}/{date}", "AgendaItemController:getByUser");
$router->post("/save", "AgendaItemController:save");
$router->put("/update/{id}", "AgendaItemController:update");
$router->delete("/delete/{id}", "AgendaItemController:delete");
$router->get("/minhaagenda/{data}/{idAgenda}", "AgendaItemController:minhaAgenda");
$router->get("/agendaproximosdias/{idUsuario}", "AgendaItemController:agendaParaOsProximosDias");

// Auth
$router->group("auth");
$router->post("/login", "AuthController:login");
$router->get("/islogged", "AuthController:isLogged");
$router->get("/logout", "AuthController:logout");
$router->post("/loginbyapp", "AuthController:loginByApp");

// Esqueci a senha
$router->group("forgotpassword");
$router->get("/{email}", "ForgotPasswordController:forgotPassword");
$router->get("/verify/{idUser}/{code}", "ForgotPasswordController:verifyCookie");
$router->post("/changepassword", "ForgotPasswordController:changePassword");

// Vacinação
$router->group("vacinacao");
$router->post("/save", "VacinacaoController:save");
$router->put("/update/{id}", "VacinacaoController:update");
$router->delete("/delete/{id}", "VacinacaoController:delete");
$router->get("/byanimal/{animalId}", "VacinacaoController:getByAnimalId");
$router->get("/byid/{id}", "VacinacaoController:getById");

// Documentos
$router->group("documentos");
$router->post("/save", "DocumentoController:save");
$router->post("/update/{documentId}", "DocumentoController:update");
$router->delete("/delete/{documentId}", "DocumentoController:delete");
$router->get("/byanimal/{animalId}", "DocumentoController:getByAnimalId");
$router->get("/byid/{id}", "DocumentoController:getById");

$router->group("error");
$router->get("/{status}", "ErrorController:index");

$router->dispatch();

if($router->error()) {
    $router->redirect("/error/{$router->error()}");
}
