<?php

$listProdutos = '';
$resultados = '';

foreach ($produtos as $item) {

  if (empty($item->foto)) {

    $foto = 'imgs/sem.jpg';
  } else {

    $foto = $item->foto;
  }

  $listProdutos .= '

                <tr>
                  <td>

                        <div class="icheck-red ">
                        <input type="checkbox" value="' . $item->id . '" name="id[]" id="[' . $item->id . ']">
                        <label for="[' . $item->id . ']"></label>
                        </div>
                        </td>

                        <td>

                        <div class="product-img">
                        <img src="../.' . $foto . '" class="img-size-50" class="img-thumbnail">
                        </div>
                        </td>
                        <td style="text-transform:uppercase">' . $item->nome . '</td>
                        <td style="text-align:center">

                        <span style="font-size:16px" class="' . ($item->estoque <= 3 ? 'badge badge-danger' : 'badge badge-success') . '">' . $item->estoque . '</span>

                        </td>
                        <td> R$ ' . number_format($item->valor_compra, "2", ",", ".") . '</td>
                        <td style="font-weight:600; font-size:18px" > R$ ' . number_format($item->valor_venda, "2", ",", ".") . '</td>
                        <td>

                        <a href="#">
                         <i class="fas fa-plus-circle" style="font-size:28px;color:#eeeeee"></i>
                       </a>

                  </td>
                </tr>

';
}

$resultados = strlen($resultados) ? $resultados : '<tr>
                                                     <td colspan="6" class="text-center" > Nenhuma Vaga Encontrada !!!!! </td>
                                                     </tr>';

unset($_GET['pagina']);
$gets = http_build_query($_GET);

//PAGINAÇÂO

$paginacao = '';
$paginas = $pagination->getPages();

foreach ($paginas as $key => $pagina) {
  $class = $pagina['atual'] ? 'btn-primary' : 'btn-dark';
  $paginacao .= '<li class="page-item"><a href="?pagina=' . $pagina['pagina'] . '&' . $gets . '">

                  <button type="button" class=" btn ' . $class . '">' . $pagina['pagina'] . '</button>
                  &nbsp; </a></li>';
}

?>

<div class="container-fluid">

  <div class="row">

    <div class="col-4">
    </div>
    <div class="col-4">


      <form action="finalizar-venda.php" method="post">
        <input type="hidden" name="troco" value="<?= $troco ?>">
        <input type="hidden" name="valor_recebido" value="<?= $val_recebido ?>">
        <div class="card card-primary">
          <div class="card-header">
            <h1 class="card-title"><span style="font-size: xx-large; font-weight:600; color:FFF"> TROCO: R$&nbsp;<?= number_format($troco, "2", ",", ".") ?>

              </span></h1>

            <div class="card-tools">
              <span style="text-transform: uppercase;">
                <?php
                setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
                date_default_timezone_set('America/Sao_Paulo');
                echo strftime('%A, %d de %B de %Y', strtotime('today'));
                ?>
              </span>

            </div>
          </div>

          <div class="card-body">

            <div class="col-12">
              <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-ban"></i> Atenção!</h5>
                Este recibo serve para o cliente como forma de garantia em peças e serviços feita pelo cliente em nossa loja.. .
              </div>

            </div>

          </div>

          <div class="card-body">

            <div class="row">

              <div class="col-6">
                <a href="finalizar-orcamento.php" class="btn btn-danger btn-lg btn-block" target="_blank" rel="noopener noreferrer">IMPRIMIR ORÇAMENTO</a>
              </div>
              <div class="col-6">

              <a href="imprimir-pdv.php" class="btn btn-warning btn-lg btn-block" >NOVA VENDA</a>
              </div>


            </div>
            

          </div>
      </form>
    </div>
    <div class="col-4">
    </div>

  </div>