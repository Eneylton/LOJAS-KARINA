<?php
require __DIR__ . '../../../vendor/autoload.php';

use  \App\Db\Pagination;
use   \App\Entidy\Categoria;
use    \App\Entidy\Produto;
use     \App\Session\Login;

define('TITLE', 'Lista de Produtos');
define('BRAND', 'Produtos');

$foto2 ='';

Login::requireLogin();


$buscar = filter_input(INPUT_GET, 'buscar', FILTER_SANITIZE_STRING);

$condicoes = [
    strlen($buscar) ? 'p.nome LIKE "%' . str_replace(' ', '%', $buscar) . '%" 
                       or 
                       p.codigo LIKE "%' . str_replace(' ', '%', $buscar) . '%"
                       or 
                       c.nome LIKE "%' . str_replace(' ', '%', $buscar) . '%"
                       or 
                       p.barra LIKE "%' . str_replace(' ', '%', $buscar) . '%"
                       or 
                       p.aplicacao LIKE "%' . str_replace(' ', '%', $buscar) . '%"
                       or 
                       p.data LIKE "%' . str_replace(' ', '%', $buscar) . '%"' : null
];

$condicoes = array_filter($condicoes);

$where = implode(' AND ', $condicoes);

$qtd = Produto::qtdCount($where);


$pagination = new Pagination($qtd, $_GET['pagina'] ?? 1, 200);

$categorias = Categoria::getList(null,null,null);

$produtos2 = Produto::getRelacinadas($where, 'p.id DESC', $pagination->getLimit());


include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/produto/produto-form-list.php';
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
        $('#nome').val(data[2]);
        $('#qtd').val(data[3]);
        $('#compra').val(data[4]);
        $('#venda').val(data[5]);
        $('#categorias_id').val(data[6]);
        $('#codigo').val(data[7]);
        $('#barra').val(data[8]);
        $('#aplicacao').val(data[9]);
        
    });
});
</script>

<script type="text/javascript">

    function carregarImg() {

        var target = document.getElementById('target');
        var file = document.querySelector("input[type=file]").files[0];
        var reader = new FileReader();

        reader.onloadend = function () {
            target.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);


        } else {
            target.src = "";
        }
    }

</script>