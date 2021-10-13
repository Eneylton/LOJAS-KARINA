<?php

require __DIR__ . '../../../vendor/autoload.php';

use   \App\Entidy\Produto;
use   \App\Entidy\Cliente;
use   \App\Entidy\Servico;
use   \App\Entidy\Mecanico;
use   \App\Entidy\Marca;
use   \App\Db\Pagination;
use   \App\Session\Login;


define('TITLE', 'Caixa');
define('BRAND', 'PDV modulo caixa');

Login::requireLogin();

// USUARIO LOGADO

$usuariologado = Login::getUsuarioLogado();

$usuario = $usuariologado['nome'];

// LISTAR CLIENTES / MECÂNICOS

$clientes  = Cliente ::getList();
$servicos  = Servico ::getList();
$mecanicos = Mecanico::getList();
$marcas    = Marca   ::getList();

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

$pagination = new Pagination($qtd, $_GET['pagina'] ?? 1, 150);

$produtos = Produto::getRelacinadas($where, 'nome ASC', $pagination->getLimit());


if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = array();
  }

  if(isset($codigo)){
   
   $barra = Produto:: getBarra($codigo);

     if($barra != false){
       
      $id =  $barra->id;
     
      if (!isset($_SESSION['carrinho'][$id])) {
  
          $_SESSION['carrinho'][$id] = 1;
      } else {
          $_SESSION['carrinho'][$id] += 1;
      }

     }
     
 

}
  
  
  if(isset($_GET['acao'])){

    if ($_GET['acao'] == 'add2') {
      $id = intval($_GET['id']);
      
      if (!isset($_SESSION['carrinho'][$id])) {
      
        $_SESSION['carrinho'][$id] = 1;
      } else {
        $_SESSION['carrinho'][$id] += 1;
      }
      }
  
  if ($_GET['acao'] == 'add') {
  $id = intval($_GET['id']);
  
  if (!isset($_SESSION['carrinho'][$id])) {
  
    $_SESSION['carrinho'][$id] = 1;
  } else {
    $_SESSION['carrinho'][$id] += 1;
  }
  }
  }

  if(isset($_GET['acao'])){

    if ($_GET['acao'] == 'add') {
      $id = intval($_GET['id']);
      
      if (!isset($_SESSION['carrinho'][$id])) {
  
          $_SESSION['carrinho'][$id] = 1;
      } else {
          $_SESSION['carrinho'][$id] += 1;
      }
  }

    if ($_GET['acao'] == 'up') {
  
      if (is_array($_POST['prod'])) {
  
         foreach ($_POST['prod'] as $id => $qtd) {
  
            $id = intval($id);
            $qtd = intval($qtd);
  
            if (!empty($qtd) || $qtd != 0) {
  
               $_SESSION['carrinho'][$id] = $qtd;
            } else {
  
               unset($_SESSION['carrinho'][$id]);
            }
         }
      }
  
      if (is_array($_POST['val'])) {
  
         foreach ($_POST['val'] as $id => $valor) {
  
            $item = Produto::getID($id);
            $val1              = $valor;
            $val2              = str_replace(".", "", $val1);
            $preco             = str_replace(",", ".",$val2);
  
            $item->valor_venda = $preco;
            $item->atualizar();
         }
      }

     
   }
  
   if ($_GET['acao'] == 'del') {
      $id = intval($_GET['id']);
  
      if (isset($_SESSION['carrinho'][$id])) {
         unset($_SESSION['carrinho'][$id]);
      }
   }
  
  }
  
  if (isset($_POST['submit'])) {
              
   if (isset($_POST['id'])) {
 
     foreach ($_POST['id'] as $id) {
 
       if (isset($_POST['id'])) {
     
         $id  = intval($id);
 
         if (!isset($_SESSION['carrinho'][$id])) {
 
             $_SESSION['carrinho'][$id] = 1;
             
         } else {
 
             $_SESSION['carrinho'][$id] += 1;
         }
       
     }
 
   }
 }

}



include __DIR__.'../../../includes/layout/header.php';
include __DIR__.'../../../includes/layout/top.php';
include __DIR__.'../../../includes/layout/menu.php';
include __DIR__.'../../../includes/layout/content.php';
include __DIR__.'../../../includes/pdv/pdvcaixa-form.php';
include __DIR__.'../../../includes/layout/footer.php';


?>


<script type="text/javascript">
  $(document).ready(function() {
    $("#cpf").mask("000.000.000-00")
    $("#telefone").mask("(00) 0000-0000")
    $("#dinheiro2").mask("999.999.990,00", {
      reverse: true
    })
  })
</script>