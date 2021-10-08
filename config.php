<?php

const BASE_PATH = "http://localhost/petlove/api-new";

const DB_HOST = "localhost";
const DB_DATABASE = "db_petlove";
const DB_USER = "root";
const DB_PASSWORD = "11445544";
const DB_OPTIONS = [
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_CASE => PDO::CASE_NATURAL
];

const HTTP_OK = 200;
const HTTP_CREATED = 201;
const HTTP_BAD_REQUEST = 400;
const HTTP_UNAUTHORIZED = 401;
const HTTP_NOT_FOUND = 404;
const HTTP_INTERNAL_SERVER_ERROR = 500;

const HTTP_ERRORS = [
    100 => "Continuar",
    101 => "Mudando protocolos",
    102 => "Processamento (WebDAV)",
    122 => "Pedido-URI muito longo",
    200 => "Requisição bem sucedida",
    201 => "Criado",
    202 => "Aceito",
    203 => "Não-autorizado",
    204 => "Nenhum conteúdo",
    205 => "Reset",
    206 => "Conteúdo parcial",
    207 => "Status multi",
    300 => "Múltipla escolha",
    301 => "Movido",
    302 => "Encontrado",
    303 => "Consulte outros",
    304 => "Não modificado",
    305 => "Use proxy",
    306 => "Proxy switch",
    307 => "Redirecionamento temporário",
    308 => "Redirecionamento permanente",
    400 => "Requisição inválida",
    401 => "Não autorizado",
    402 => "Pagamento necessário",
    403 => "Acesso negado",
    404 => "Conteúdo não encontrado",
    405 => "Método não permitido",
    406 => "Não aceitável",
    407 => "Autenticação de proxy necessária",
    408 => "Tempo de requisição esgotou",
    409 => "Conflito geral",
    410 => "Gone",
    411 => "Comprimento necessário",
    412 => "Pré-condição falhou",
    413 => "Entidade de solicitação muito grande",
    414 => "Pedido-URI too long",
    415 => "Tipo de mídia não suportado",
    416 => "Solicitação de faixa não satisfatória",
    417 => "Falha na expectativa",
    418 => "Eu sou um bule de chá",
    422 => "Entidade improcessável",
    423 => "Fechado (WebDAV)",
    424 => "Falha de Dependência (WebDAV)",
    425 => "Coleção não ordenada",
    426 => "Upgrade obrigatório",
    429 => "Pedidos em excesso",
    450 => "Bloqueado pelo controle de pais do Windows",
    499 => "Cliente fechou Pedido",
    500 => "Erro interno do servidor",
    501 => "Não implementado",
    502 => "Bad Gateway",
    503 => "Serviço indisponível",
    504 => "Gateway Time-Out",
    505 => "HTTP Version not supported"
];