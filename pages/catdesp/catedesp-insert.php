<?php 

require __DIR__.'../../../vendor/autoload.php';

define('TITLE','Nova Categoria de Despesas');
define('BRAND','Cadastrar Categoria de despesas');

use  \App\Session\Login;
use   \App\File\Upload;
use   \App\Entidy\Catdespesa;

$alertaLogin  = '';
$alertaCadastro = '';

$usuariologado = Login:: getUsuarioLogado();

Login::requireLogin();

if(isset($_POST['nome'])){


    $item = new Catdespesa;
    $item->nome = $_POST['nome'];
    $item->cadastar();

    header('location: catedesp-list.php?status=success');
    exit;
}

