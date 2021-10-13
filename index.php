<?php

require __DIR__ . '/vendor/autoload.php';

use App\Entidy\Produto;
use App\Entidy\Venda;
use   \App\Session\Login;

define('TITLE', 'Painel de controle');
define('BRAND', 'Painel de controle ');

$vendas  = Venda ::getVendasDiaria();

$estoqueBaixo = Produto:: getBaixoEstoque();


Login::requireLogin();


include __DIR__ . '/includes/dashboard/header.php';
include __DIR__ . '/includes/dashboard/top.php';
include __DIR__ . '/includes/dashboard/menu.php';
include __DIR__ . '/includes/dashboard/content.php';
include __DIR__ . '/includes/dashboard/box-infor.php';
include __DIR__ . '/includes/dashboard/footer.php';
