<?php

require __DIR__ . '../../../vendor/autoload.php';

use \App\Entidy\Entrega;
use App\Entidy\Orcamento;
use App\Entidy\Produto;
use  \App\Session\Login;


Login::requireLogin();


$value = Entrega::getID($_GET['id']);


if (!$value instanceof Entrega) {
    header('location: index.php?status=error');

    exit;
}

if (isset($_GET['id'])) {

    $id = $_GET['codigo'];
    $listar_produtos = Orcamento::getPedidosID($id);

    foreach ($listar_produtos as $item) {
        $qtd = $item->qtd;
        $produtos_id = $item->produtos_id;

        $produto  = Produto::getID($produtos_id);
        $total_qtd = $produto->estoque - $qtd;
        $produto->estoque = $total_qtd;
        $produto->atualizar();
    }
}

if (isset($_GET['id'])) {

    $value->status = 0;
    $value->atualizar();

    header('location: entrega-list.php?status=success');

    exit;
}

unset($_SESSION['compras']);
unset($_SESSION['carrinho']);
unset($_SESSION['dados-venda']);
unset($_SESSION['forma-pagamento']);
unset($_SESSION['dados-serv']);
