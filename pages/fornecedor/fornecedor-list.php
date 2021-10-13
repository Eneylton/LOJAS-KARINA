<?php
require __DIR__.'../../../vendor/autoload.php';

use  \App\Db\Pagination;
use   \App\Entidy\Fornecedor;
use    \App\Session\Login;

define('TITLE','Lista de Fornecedores');
define('BRAND','Fornecedores');


Login::requireLogin();


$buscar = filter_input(INPUT_GET, 'buscar', FILTER_SANITIZE_STRING);

$condicoes = [
    strlen($buscar) ? 'nome LIKE "%'.str_replace(' ','%',$buscar).'%" or 
                       id LIKE "%'.str_replace(' ','%',$buscar).'%"' : null
];

$condicoes = array_filter($condicoes);

$where = implode(' AND ', $condicoes);

$qtd = Fornecedor:: getQtd($where);


$pagination = new Pagination($qtd, $_GET['pagina'] ?? 1, 5);

$List = Fornecedor::getList($where, 'id desc',$pagination->getLimit());


include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/fornecedor/fornecedor-form-list.php';
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
    
        console.log(data);
      
        $('#foto').val(data[0]);
        $('#id').val(data[1]);
        $('#data').val(data[2]);
        $('#telefone').val(data[3]);
        $('#email').val(data[4]);
        $('#nome').val(data[5]);

    });
});
</script>