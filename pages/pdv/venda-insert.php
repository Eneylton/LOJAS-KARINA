<?php

require __DIR__.'../../../vendor/autoload.php';

use   \App\Entidy\Produto;
use   \App\Entidy\Cliente;
use   \App\Entidy\Mecanico;
use   \App\Entidy\Entrega;
use   \App\Db\Pagination;
use   \App\Session\Login;

$usuariologado = Login::getUsuarioLogado();

$usuario = $usuariologado['nome'];
$usuario_id = $usuariologado['id'];

define('TITLE', 'Caixa');
define('BRAND', 'Atendente: '. $usuario);

Login::requireLogin();

$total_absoluto = 0;

if(isset($_SESSION['dados-serv'])){

  if(empty($_SESSION['dados-serv'] )){

    echo ("<script LANGUAGE='JavaScript'>
    window.alert('Você precisa adicionar no minimo um serviço...');
    window.location.href='pdv.php';
    </script>");

    exit;


  }else{

    foreach ($_SESSION['dados-serv'] as $item) {
           
      $cliente_id = $item['cliente'];

      $buscar_cliente = Cliente:: getID($cliente_id);
      
      $cliente = $buscar_cliente->nome;


      $mec_id = $item['mecanico'];

      $buscar_mec = Mecanico:: getID($mec_id);
      
      $mecanico = $buscar_mec->nome;

      $obra         = $item['obra'];
      $servicos     = $item['servico'];
      $total_sub    = $item['total'];
}

  }


 

}

//CARRINHO

$result = '';
$total_produtos = '0';



if(isset($_SESSION['dados-venda'])){
  foreach ($_SESSION['dados-venda'] as $item) {

    $produto         = $item['nome'];
    $codigo_prod     = $item['codigo'];
    $barra           = $item['barra'];
    $produtos_id     = $item['produtos_id'];
    $qtd             = $item['qtd'];
    $uni             = $item['valor_venda'];
    $sub             = $item['subtotal'];
    $total_produtos += $sub; 

    $result .= '
    <tr>
    <td>'.$produto.' - Qtd: ('.$qtd.') </td>
    <td> R$ '.number_format($uni,"2",",",".").' </td>
    <td> R$ '.number_format($sub,"2",",",".").' </td>
    </tr>
    ';

  }

}

$total_absoluto = $total_sub + $total_produtos;

// LISTAR PRODUTOS
$codigo = filter_input(INPUT_GET, 'buscar', FILTER_SANITIZE_STRING);
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
                       p.data LIKE "%' . str_replace(' ', '%', $buscar) . '%"' : null
];

$condicoes = array_filter($condicoes);

$where = implode(' AND ', $condicoes);

$qtd = Produto::qtdCount($where);

$pagination = new Pagination($qtd, $_GET['pagina'] ?? 1, 200);

$produtos = Produto::getRelacinadas($where, 'nome ASC', $pagination->getLimit());

  
include __DIR__.'../../../includes/layout/header.php';
include __DIR__.'../../../includes/layout/top.php';
include __DIR__.'../../../includes/layout/menu.php';
include __DIR__.'../../../includes/layout/content.php';
include __DIR__.'../../../includes/venda/venda-form.php';
include __DIR__.'../../../includes/layout/footer.php';


?>