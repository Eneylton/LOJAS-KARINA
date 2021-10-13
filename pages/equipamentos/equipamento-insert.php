<?php 

require __DIR__.'../../../vendor/autoload.php';

define('TITLE','Novo Equipamento');
define('BRAND','Cadastrar Equipamento');

use \App\Entidy\Equipamento;
use  \App\Session\Login;
use   \App\File\Upload;

$alertaLogin  = '';
$alertaCadastro = '';

$usuariologado = Login:: getUsuarioLogado();
$usuarios_id = $usuariologado['id'];

$List = Equipamento::getList(null,null,null);

Login::requireLogin();

if(isset($_FILES['arquivo'])){
    $obUpload = new Upload ($_FILES['arquivo']);
    $sucesso = $obUpload->upload(__DIR__.'../../../imgs',false);
    $obUpload->gerarNovoNome();

    if($sucesso){

        echo 'Arquivo Enviado ' .$obUpload->getBasename(). "com Sucesso" ;

        if(isset($_POST['nome'])){


            $item = new Equipamento;
            $item->data                     = $_POST['data'];
            $item->nome                     = $_POST['nome'];
            $item->barra                    = $_POST['barra'];
            $item->valor_custo              = $_POST['custo'];
            $item->valor                    = $_POST['valor'];
            $item->fornecedores_id          = $_POST['fornecedores_id'];
            $item->usuarios_id              = $usuarios_id;
            $item->foto                     = $obUpload->getBasename();
            $item->cadastar();
    
            header('location: equipamento-list.php?status=success');
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