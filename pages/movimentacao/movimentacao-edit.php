<?php

require __DIR__ . '../../../vendor/autoload.php';

$alertaCadastro = '';

define('TITLE', 'Editar Categoria');
define('BRAND', 'Categoria');

use \App\Entidy\Categoria;
use App\Entidy\Movimentacao;
use  \App\Session\Login;


Login::requireLogin();

if (!isset($_GET['id']) or !is_numeric($_GET['id'])) {

    header('location: index.php?status=error');

    exit;
}

$value = Movimentacao::getID($_GET['id']);


if (!$value instanceof Movimentacao) {
    header('location: index.php?status=error');

    exit;
}


if (isset($_GET['status'])) {
    date_default_timezone_set('America/Sao_Paulo');
    $value->status = 1;
    $value->data = date('Y-m-d H:i:s');
    $value->form_pagamento = $_GET['status'];
    $value->atualizarstatus();

    header('location: movimentacao-list.php?status=success');

    exit;
}
