<?php 

require __DIR__.'../../../vendor/autoload.php';

$alertaCadastro = '';

define('TITLE','Cadastro Cliente');
define('BRAND','Cliente');

use \App\Entidy\Cliente;
use   \App\Session\Login;

Login::requireLogin();

$usuariologado = Login:: getUsuarioLogado();

$usuario = $usuariologado['id'];

if(isset($_POST['nome'],$_POST['telefone'])){

    $item = new Cliente;
    $item->nome = $_POST['nome'];
    $item->telefone = $_POST['telefone'];
    $item->email = $_POST['email'];
    $item->placa = $_POST['placa'];
    $item->marcas_id = $_POST['marcas_id'];
    $item->usuarios_id = $usuario;
    $item-> cadastar();

    header('location: pdv.php?status=success');

    exit;
}

