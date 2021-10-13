<?php

require __DIR__ . '../../../vendor/autoload.php';

$alertaCadastro = '';

define('TITLE', 'Editar Fornecedor');
define('BRAND', 'Fornecedor');

use \App\Entidy\Fornecedor;
use  \App\Session\Login;
use   \App\File\Upload;


Login::requireLogin();

if (!isset($_POST['id']) or !is_numeric($_POST['id'])) {

    header('location: index.php?status=error');

    exit;
}

$value = Fornecedor::getID($_POST['id']);


if (!$value instanceof Fornecedor) {
    header('location: index.php?status=error');

    exit;
}

if (isset($_FILES['arquivo'])) {
    $obUpload = new Upload($_FILES['arquivo']);
    $sucesso = $obUpload->upload(__DIR__ . '../../../imgs', false);
    $obUpload->gerarNovoNome();

    if ($sucesso) {

        echo 'Arquivo Enviado ' . $obUpload->getBasename() . "com Sucesso";

        if (isset($_POST['nome'])) {

            $value->nome     = $_POST['nome'];
            $value->telefone = $_POST['telefone'];
            $value->email    = $_POST['email'];
            $value->foto     = $obUpload->getBasename();
            $value->atualizar();

            header('location: fornecedor-list.php?status=success');

            exit;


        } 
        }else {

            if (isset($_POST['nome'])) {

                $value->nome     = $_POST['nome'];
                $value->telefone = $_POST['telefone'];
                $value->email    = $_POST['email'];
                $value->atualizar();

                header('location: fornecedor-list.php?status=success');

                exit;
            }
    }
}

