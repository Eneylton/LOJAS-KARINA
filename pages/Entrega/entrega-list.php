<?php
require __DIR__ . '../../../vendor/autoload.php';

use  \App\Db\Pagination;
use   \App\Entidy\Entrega;
use App\Entidy\Orcamento;
use    \App\Session\Login;

define('TITLE', 'Lista de Pedidos');
define('BRAND', 'Pedidos');


Login::requireLogin();

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $entregas = Orcamento:: getPedidosID($id);

    foreach ($entregas as $item) {
        echo '<option style="text-transform:uppercase" value="' . $item->id . '">
         QTD : &nbsp;'.$item->qtd. ' &nbsp; &nbsp; 
         R$ '.$item->valor.'&nbsp; &nbsp;

         '.$item->categoria.' &nbsp;&nbsp; .............................................  &nbsp;&nbsp; 
         '.$item->nome.'
         
              </option>';
    }
}

$buscar = filter_input(INPUT_GET, 'buscar', FILTER_SANITIZE_STRING);

$condicoes = [
    strlen($buscar) ? 'nome LIKE "%' . str_replace(' ', '%', $buscar) . '%" or 
                       id LIKE "%' . str_replace(' ', '%', $buscar) . '%"' : null
];



$condicoes = array_filter($condicoes);

$where = implode(' AND ', $condicoes);

$qtd = Entrega::getQtdPedidos($where);

$pagination = new Pagination($qtd, $_GET['pagina'] ?? 1, 7);

$listar = Entrega::getListPedidos($where, 'id desc', $pagination->getLimit());

include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/entrega/entrega-form-list.php';
include __DIR__ . '../../../includes/layout/footer.php';


?>


<script>
    $(document).ready(function() {

        $('.editbtn').on('click', function() {
            $('#editmodal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();

            $('#id').val(data[0]);
            $('#status').val(data[1]);
            $('#codigo').val(data[2]);
            $('#data').val(data[3]);
            $('#cliente').val(data[4]);
            $('#mecanico').val(data[5]);

            var idEntrega = $('#codigo').val(data[2]).val();

            $.ajax({
                url: 'entrega-list.php',
                type: 'POST',
                data: {
                    id: idEntrega
                },
                beforeSend: function() {
                    $("#produtos").css({
                        'display': 'block'
                    });
                    $("#produtos").html("carregando....");
                },
                success: function(data) {
                    $("#produtos").css({
                        'display': 'block'
                    });
                    $("#produtos").html(data);
                }


            });

        });
    });
</script>