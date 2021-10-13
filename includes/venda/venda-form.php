<?php

$listProdutos  = '';
$resultadosc = '';

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
                        <td style="font-weight:600"> R$ ' . number_format($item->valor_venda, "2", ",", ".") . '</td>
                        <td>

                        <a href="#">
                         <i class="fas fa-plus-circle" style="font-size:28px;color:#d1d1d1"></i>
                       </a>

                  </td>
                </tr>

';
}


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






<section class="content">

  <div class="container-fluid">

  <div class="row">
      <div class="col-4">
      
      </div>

    <div class="col-4">
    <form action="forma_pagamento_insert.php" method="post">
          <input type="hidden" name="total_absoluto" value="<?= $total_absoluto ?>">
          <div class="card card-success">
            <div class="card-header">
              <h1 class="card-title"><span style="font-size: xx-large; font-weight:600;">R$&nbsp;<?= number_format($total_absoluto, "2", ",", ".") ?>

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

              <div class="row">
                <div class="col-6">
                  <span style="font-weight: 600;">CLIENTE: </span>&nbsp; <?= $cliente; ?>
                </div>
                <div class="col-6">
                  <span style="font-weight: 600;">MECÂNICO: </span>&nbsp; <?= $mecanico; ?>
                  <hr>
                </div>

                <div class="col-12">
                  <span style="font-weight: 600;">Total do(s) serviços(s):......................................................... </span>&nbsp;R$ <?= number_format($servicos, "2", ",", ".") ?>
                  <br>
                  <span style="font-weight: 600;">Mão de obra: ...................................................................... </span>&nbsp;R$ <?= number_format($obra, "2", ",", ".") ?>
                  <br>
                  <span style="font-weight: 600;">Total:................................................................................. </span>&nbsp;<span style="font-weight: 600; color:#ff0000"> R$ <?= number_format($total_sub, "2", ",", ".")  ?></span>
                  <hr>
                </div>

                <hr>
                <table class="table  table-dark table-sm">
                  <thead>
                    <tr>
                      <th>PRODUTO(S)</th>
                      <th>UNI</th>
                      <th>SUBTOTAL</th>
                    </tr>

                  </thead>
                  <tbody>

                    <?= $result; ?>

                    <tr>
                      <td colspan="2">TOTAL</td>
                      <td style="font-weight: 600; color:#ff0000">R$ <?= number_format($total_produtos, "2", ",", ".")  ?></td>

                    </tr>

                  </tbody>
                </table>

                <div class="col-6">
                  <input style="background-color:#0a0a0a; color:#ffffff; font-size:x-large; font-weight:600 " type="text" maxlength="100000" 
                         name="valor_receber" class="form-control" placeholder="R$ RECEBER " id="dinheiro" required autofocus>
                </div>
                <div class="col-6">
                  <select name="form_pagamento" id="" class="form-control" required>
                    <option value="">Forma de Pagamento</option>
                    <option value="Dinheiro">Dinheiro</option>
                    <option value="Dinheiro | Cartão">Dinheiro | Cartão </option>
                    <option value="Cartão de Débito">Cartão de Débito</option>
                    <option value="Cartão de Crédito">Cartão de Crédito</option>

                  </select>
                </div>

                <div class="col-12">

                  <button type="submit" class="btn btn-warning btn-lg btn-block swalDefaultError" style="margin-top: 10px;">PAGAR</button>

                </div>


              </div>


            </div>


          </div>
        </form>

    </div>

    <div class="col-4">

    
    
    </div>

  </div>