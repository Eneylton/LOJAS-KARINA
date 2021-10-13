<?php

require __DIR__ . '../../../vendor/autoload.php';

$alertaCadastro = '';

define('TITLE', 'Editar Equipamento');
define('BRAND', 'Equipamento');

use App\Entidy\Equipamento;
use  \App\Session\Login;
use   \App\File\Upload;


Login::requireLogin();
$usuariologado = Login:: getUsuarioLogado();
$usuarios_id = $usuariologado['id'];

if (!isset($_POST['id']) or !is_numeric($_POST['id'])) {

    header('location: index.php?status=error');

    exit;
}

$value = Equipamento::getID($_POST['id']);


if (!$value instanceof Equipamento) {
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
           
            $value->nome                     = $_POST['nome'];
            $value->barra                    = $_POST['barra'];
            $value->valor_custo              = $_POST['custo'];
            $value->valor                    = $_POST['valor'];
            $value->fornecedores_id          = $_POST['fornecedores_id'];
            $value->usuarios_id              = $usuarios_id;
            $value->foto                     = $obUpload->getBasename();
            $value->atualizar();

            header('location: equipamento-list.php?status=success');

            exit;
        } 
        }else {

            if (isset($_POST['nome'])) {

                
                $value->nome                     = $_POST['nome'];
                $value->barra                    = $_POST['barra'];
                $value->valor_custo              = $_POST['custo'];
                $value->valor                    = $_POST['valor'];
                $value->fornecedores_id          = $_POST['fornecedores_id'];
                $value->atualizar();

                header('location: equipamento-list.php?status=success');

                exit;
            }
    }
}

