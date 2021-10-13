<?php

require __DIR__ . '../../../vendor/autoload.php';

$alertaCadastro = '';

define('TITLE', 'Editar Categoria');
define('BRAND', 'Categoria');

use \App\Entidy\Catdespesa;
use  \App\Session\Login;
use   \App\File\Upload;


Login::requireLogin();


$value = Catdespesa::getID($_GET['id']);


if (!$value instanceof Catdespesa) {
    header('location: index.php?status=error');

    exit;
}

        if (isset($_GET['nome'])) {

            $value->nome = $_GET['nome'];
            $value->atualizar();

            header('location: catedesp-list.php?status=success');

            exit;


        
    }

