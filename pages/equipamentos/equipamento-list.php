<?php
require __DIR__.'../../../vendor/autoload.php';

use  \App\Db\Pagination;
use   \App\Entidy\Equipamento;
use App\Entidy\Fornecedor;
use    \App\Session\Login;

define('TITLE','Lista de Equipamentos');
define('BRAND','Equipamento');


Login::requireLogin();


$buscar = filter_input(INPUT_GET, 'buscar', FILTER_SANITIZE_STRING);

$condicoes = [
    strlen($buscar) ? 'nome LIKE "%'.str_replace(' ','%',$buscar).'%" or 
                       id LIKE "%'.str_replace(' ','%',$buscar).'%"' : null
];

$condicoes = array_filter($condicoes);

$where = implode(' AND ', $condicoes);

$qtd = Equipamento:: getListEqipID($where);


$pagination = new Pagination($qtd, $_GET['pagina'] ?? 1, 7);

$List = Equipamento::getListEquipamentos($where, 'id desc',$pagination->getLimit());

$fornecedores = Fornecedor::getList(null,null,null);

include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/equipamento/equipamento-form-list.php';
include __DIR__ . '../../../includes/layout/footer.php';


?>
<script>
$(document).ready(function(){
    $('.editbtn').on('click', function(){
        $('#editmodal').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function(){
            return $(this).text();
        }).get();

        $('#id').val(data[0]);
        $('#foto').val(data[1]);
        $('#data').val(data[2]);
        $('#nome').val(data[3]);
        $('#barra').val(data[4]);
        $('#custo').val(data[5]);
        $('#valor').val(data[6]);
        $('#fornecedores_id ').val(data[7]);
        
    });
});
</script>