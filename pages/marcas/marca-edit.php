<?php

require __DIR__ . '../../../vendor/autoload.php';

$alertaCadastro = '';

define('TITLE', 'Editar Marca');
define('BRAND', 'Marca');

use \App\Entidy\Marca;
use  \App\Session\Login;


Login::requireLogin();


$value = Marca::getID($_GET['id']);


if (!$value instanceof Marca) {
    header('location: index.php?status=error');

    exit;
}

        if (isset($_GET['nome'])) {

            $value->nome = $_GET['nome'];
            $value->fabricante = $_GET['fabricante'];
            $value->atualizar();

            header('location: marca-list.php?status=success');

            exit;


        
    }

