<?php
require __DIR__.'../../../vendor/autoload.php';

use  \App\Db\Pagination;
use App\Entidy\Catdespesa;
use   \App\Entidy\Movimentacao;
use    \App\Session\Login;

define('TITLE','Movimentações financeiras');
define('BRAND','Movimentações');


Login::requireLogin();


$buscar = filter_input(INPUT_GET, 'buscar', FILTER_SANITIZE_STRING);
$filtroStatus = filter_input(INPUT_GET, 'filtroStatus', FILTER_SANITIZE_STRING);
$filtroStatus = in_array($filtroStatus,['0','1']) ? $filtroStatus : '';

$condicoes = [
    strlen($buscar) ? 'm.tipo LIKE "%'.str_replace(' ','%',$buscar).'%" or
                       m.status LIKE "%'.str_replace(' ','%',$buscar).'%" or 
                       c.nome LIKE "%'.str_replace(' ','%',$buscar).'%"' : null,
                       strlen($filtroStatus) ? 'm.status = "'.$filtroStatus.'"' : null
];

$condicoes = array_filter($condicoes);

$where = implode(' AND ', $condicoes);

$qtd = Movimentacao:: getQtdMov($where);


$pagination = new Pagination($qtd, $_GET['pagina'] ?? 1, 5);

$movimentacao = Movimentacao::getListMov($where, 'm.id desc',$pagination->getLimit());

$categorias = Catdespesa::getList(null,null,null);

include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/movimentacao/movimentacao-form-list.php';
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
        $('#status').val(data[1]);
        $('#categoria').val(data[2]);
        $('#status1').val(data[3]);
        $('#data').val(data[4]);
        $('#valor').val(data[5]);
    });
});
</script>