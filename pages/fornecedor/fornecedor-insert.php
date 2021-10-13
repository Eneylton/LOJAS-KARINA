<?php 

require __DIR__.'../../../vendor/autoload.php';

define('TITLE','Novo Fornecedor');
define('BRAND','Cadastrar Fornecedor');

use \App\Entidy\Fornecedor;
use  \App\Session\Login;
use   \App\File\Upload;

$alertaLogin  = '';
$alertaCadastro = '';

$usuariologado = Login:: getUsuarioLogado();

$List = Fornecedor::getList(null,null,null);

Login::requireLogin();

if(isset($_FILES['arquivo'])){
    $obUpload = new Upload ($_FILES['arquivo']);
    $sucesso = $obUpload->upload(__DIR__.'../../../imgs',false);
    $obUpload->gerarNovoNome();

    if($sucesso){

        echo 'Arquivo Enviado ' .$obUpload->getBasename(). "com Sucesso" ;

        if(isset($_POST['nome'])){


            $item = new Fornecedor;
            $item->nome      = $_POST['nome'];
            $item->telefone  = $_POST['telefone'];
            $item->email     = $_POST['email'];
            $item->foto      = $obUpload->getBasename();
            $item->cadastar();
    
            header('location: fornecedor-list.php?status=success');
            exit;
        }

    }

}



include __DIR__.'../../../includes/layout/header.php';
include __DIR__.'../../../includes/layout/top.php';
include __DIR__.'../../../includes/layout/menu.php';
include __DIR__.'../../../includes/layout/content.php';
include __DIR__.'../../../includes/categoria/categoria-form-insert.php';
include __DIR__.'../../../includes/layout/footer.php';