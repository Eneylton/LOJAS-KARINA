<?php 

require __DIR__.'../../../vendor/autoload.php';

define('TITLE','Nova Categoria de Despesas');
define('BRAND','Cadastrar Categoria de despesas');

use  \App\Session\Login;
use App\Entidy\Movimentacao;

$alertaLogin  = '';
$alertaCadastro = '';

$usuariologado = Login:: getUsuarioLogado();
$usuarios_id = $usuariologado['id'];
Login::requireLogin();

if(isset($_POST['catdesp_id'])){

    $val1              = $_POST['valor'];
    $val2              = str_replace(".", "", $val1);
    $preco             = str_replace(",", ".",  $val2);


    $item = new Movimentacao;
    $item->catdesp_id = $_POST['catdesp_id'];
    $item->usuarios_id = $usuarios_id;
    $item->status = $_POST['status'];
    $item->tipo = 0;
    $item->form_pagamento = $_POST['form_pagamento'];
    $item->valor = $preco;
    $item->data = $_POST['data'];
    $item->cadastar();

    header('location: movimentacao-list.php?status=success');
    exit;
}

