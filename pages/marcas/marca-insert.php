<?php 

require __DIR__.'../../../vendor/autoload.php';

define('TITLE','Nova Marca');
define('BRAND','Marca');

use  \App\Session\Login;
use   \App\Entidy\Marca;

$alertaLogin  = '';
$alertaCadastro = '';

$usuariologado = Login:: getUsuarioLogado();

Login::requireLogin();

if(isset($_POST['nome'])){


    $item = new Marca;
    $item->nome = $_POST['nome'];
    $item->fabricante = $_POST['fabricante'];
    $item->cadastar();

    header('location: marca-list.php?status=success');
    exit;
}

