<?php
$despesa  = 0;
$receita  = 0;
$valor1  = 0;
$total = 0;
$resultados = '';
$list = '';
$status1 = '';
$total = 0;

$id = '';

foreach ($movimentacao as $item) {
   $total = $item->valor;
   $status1 = $item->status;

   if ($item->status <= 0) {
      $valor1 = 0;
      if ($item->tipo == 0) {

         $despesa += $valor1;
      } else {

         $receita += $valor1;
      }
   } else {
      if ($item->tipo == 0) {

         $despesa += $item->valor;
      } else {

         $receita += $item->valor;
      }
   }

   $total = ($receita - $despesa);

   $resultados .= '<tr>
   <td style="display:none">' . $item->id . '</td>
   <td style="display:none">' . $item->status . '</td>
   <td style="display:none">' . $item->categoria . '</td>
   <td style="display:none">' . ($status1 == 0 ? 'EM ABERTO' : 'PAGO') . '</td>
   <td style="display:none">' . date('d/m/Y à\s H:i:s ', strtotime($item->data)) . '</td>
   <td style="display:none"> R$ ' . number_format($item->valor, "2", ",", ".") . '</td>
   <td>
   
   <span style="color:' . ($item->status <= 0 ? '#ff0000' : '#00ff00') . '"> 
   <i class="fa fa-circle" aria-hidden="true"></i> 
   </span>
   
   </td>
   
                      <td>
                      
                      <span style="color:' . ($item->status <= 0 ? '#ff0000' : '#00ff00') . '">
                      ' . ($item->status <= 0 ? 'EM ABERTO' : 'PAGO') . '
                      </span>
                      
                      </td>
                      <td>
                      
                      <span style="color:' . ($item->tipo <= 0 ? '#f2a9a9 ' : '#48da59 ') . '">
                      ' . ($item->tipo <= 0 ? 'DESPESA' : 'RECEITA') . '
                      </span>
                      
                      </td>
                      <td>' . date('d/m/Y à\s H:i:s ', strtotime($item->data)) . '</td>
                      <td style="text-transform: uppercase; font-weight: 600;">' . $item->categoria . '</td>
                      <td style="text-transform: uppercase; ">' . $item->pagamento . '</td>
                      <td style="text-transform: uppercase; ">' . $item->usuario . '</td>
                      <td style="text-transform: uppercase; font-weight: 600;"> R$ ' . number_format($item->valor, "2", ",", ".") . '</td>
                      <td style="text-align: center;">
                        
                      
                      <button type="submit" class="btn btn-secondary editbtn" ' . ($status1 == 1 ? 'disabled' : '') . '> <i class="fa fa-credit-card" aria-hidden="true"></i> </button>
                      &nbsp;

                      </td>
                      </tr>

                      ';
}

$resultados = strlen($resultados) ? $resultados : '<tr>
                                                     <td colspan="9" class="text-center" > Nenhuma movimentação financeira !!!!! </td>
                                                     </tr>';


foreach ($categorias as $item) {

   $list .= '<option value="' . $item->id . '">' . $item->nome . '</option>';
}


unset($_GET['status']);
unset($_GET['pagina']);
$gets = http_build_query($_GET);

//PAGINAÇÂO

$paginacao = '';
$paginas = $pagination->getPages();

foreach ($paginas as $key => $pagina) {
   $class = $pagina['atual'] ? 'btn-primary' : 'btn-secondary';
   $paginacao .= '<a href="?pagina=' . $pagina['pagina'] . '&' . $gets . '">

                  <button type="button" class="btn ' . $class . '">' . $pagina['pagina'] . '</button>
                  </a>';
}

unset($_GET['status']);
unset($_GET['pagina']);
$gets = http_build_query($_GET);

?>

<section class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="card card-purple">
               <div class="card-header">

                  <form method="get">
                     <div class="row">
                        <div class="col-4">

                           <label>Buscar por Nome</label>
                           <input type="text" class="form-control col-12" name="buscar" placeholder="Pesquisar" value="<?= $buscar ?>">

                        </div>
                        <div class="col-4">
                           <div class="row">
                            <div class="col-8">
                            <label>Status</label>

                           <select name="filtroStatus" class="form-control col-12">
                              <option value="">Em aberto / Pago</option>
                              <option value="0" <?= $filtroStatus == '0' ? 'selected' : '' ?>>Em aberto</option>
                              <option value="1" <?= $filtroStatus == '1' ? 'selected' : '' ?>>Pago</option>
                           </select>
                            </div>
                           
                            <div class="col-4">
                            <button style="margin-top: 30px; text-align:left" type="submit" class="btn btn-warning  float-left" name="">
                              <i class="fas fa-search"></i> Pesquisar

                           </button>
                            </div>
                           
                           </div>

                        </div>
                     </div>

                  </form>
               </div>
              
            
               <div class="table-responsive">

                  <table class="table table-bordered table-dark table-bordered table-hover table-striped">
                     <thead>
                     <tr>
                        <td colspan="9"> 
                        <button type="submit" class="btn btn-success" data-toggle="modal" data-target="#modal-default"> <i class="fas fa-plus"></i> &nbsp; Nova</button>
                        <button style="margin-right:50px; font-weight:600; font-size:x-large" type="submit" class="<?= $total <= 0 ? 'btn btn-danger' : 'btn btn-primary' ?> float-right btn-lg"> <i class="fas fa-money"></i>
                     R$ <?= number_format($total, "2", ",", ".")  ?></button>
                        </td>
                        </tr>
                        <tr>
                           <th style="text-align: center; width:10px"> <i class="fa fa-align-justify" aria-hidden="true"></i> </th>

                           <th style="text-align: center; width:200x;"> STATUS </th>
                           <th style="text-align: center; width:50px"> TIPO </th>
                           <th style="text-align: left; width:250px"> DATA </th>
                           <th style="text-align: left;"> CATEGORIA </th>
                           <th style="text-align: left; width:350px"> FORMA DE PAGAMENTO </th>
                           <th style="text-align: left; width:250px"> USUÁRIO </th>
                           <th style="text-align: left; width:250px"> VALOR </th>
                           <th style="text-align: center; width:200px"> AÇÃO </th>
                        </tr>

                     </thead>
                     <tbody>
                        <?= $resultados ?>
                     </tbody>
                     <tr>
                        <td colspan="7" style="text-align: right;">
                           <span style="font-size: 20px; font-weight:600"> TOTAL</span>
                        </td>
                        <td colspan="2">
                           <span style="font-size: 20px; font-weight:600">R$ <?= number_format($total, "2", ",", "."); ?></span>
                        </td>
                     </tr>

                  </table>

               </div>


            </div>

         </div>

      </div>

   </div>

</section>

<?= $paginacao ?>


<div class="modal fade" id="modal-default">
   <div class="modal-dialog">
      <div class="modal-content">
         <form action="./movimentacao-insert.php" method="post">

            <div class="modal-header">
               <h4 class="modal-title">ADICIONAR DESPESA
               </h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="card-body">

               <div class="form-group">

                  <div class="row">

                     <div class="col-lg-12 col-12">
                        <div class="form-group">
                           <label>Categoria</label>
                           <select class="form-control select2bs4" style="width: 100%;" name="catdesp_id">
                              <option value="">Selecione uma categoria !!!</option>

                              <?= $list ?>

                           </select>
                        </div>
                     </div>
                     <div class="col-lg-12 col-12">
                        <div class="form-group">
                           <label>Forma de pagamento</label>
                           <select class="form-control" name="form_pagamento">
                              <option value="Forma de pagamento"></option>
                              <option value="Dinheiro">Dinheiro</option>
                              <option value="Credito">Cartão de Crédito</option>
                              <option value="Debito">Cartão de Débito</option>

                           </select>
                        </div>
                     </div>

                     <div class="col-lg-6 col-6">

                        <div class="form-group">
                           <label>Privião de pagamento:</label>

                           <div class="input-group">
                              <div class="input-group-prepend">
                                 <span class="input-group-text"><i class="far fa-clock"></i></span>
                              </div>
                              <input type="datetime-local" name="data" class="form-control">
                           </div>
                           <!-- /.input group -->
                        </div>
                     </div>
                     <div class="col-lg-6 col-6">

                        <div class="form-group">

                           <label>Status</label>
                           <div>
                              <div class="form-check form-check-inline">
                                 <label class="form-control">
                                    <input type="radio" name="status" value="1" checked> Pago
                                 </label>
                              </div>

                              <div class="form-check form-check-inline">
                                 <label class="form-control">
                                    <input type="radio" name="status" value="0"> Em aberto
                                 </label>
                              </div>
                           </div>
                        </div>
                     </div>

                     <div class="col-lg-6 col-6">
                        <div class="form-group">
                           <label>Valor</label>
                           <input placeholder="R$" style="border:none !important; background-color:#a20808;color:#fff;font-size:26px;font-weight:600 " type="text" class="form-control" name="valor" id="dinheiro" required>
                        </div>
                     </div>

                  </div>
               </div>

            </div>
            <div class="modal-footer justify-content-between">
               <button type="button" class="btn btn-default" data-dismiss="modal">FECHAR</button>
               <button type="submit" class="btn btn-primary">SALVAR</button>
            </div>

         </form>

      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>

<!-- EDITAR -->

<div class="modal fade" id="editmodal">
   <div class="modal-dialog">
      <form action="./movimentacao-edit.php" method="GET">
         <input type="hidden" name="id" id="id">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title" style="font-weight:600; text-transform:uppercase; font-size:22px">Pagamento
               </h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">

               <div class="form-group">

                  <div class="row">
                     <div class="col-lg-2 col-2">
                        <div class="form-group">
                           <i style="color:#ff0000; margin-top:10px" class="fa fa-circle"></i>
                        </div>
                     </div>
                     <div class="col-lg-9 col-9">
                        <div class="form-group">

                           <input style="border:none !important; background-color:#fff;color:#000;" type="text" class="form-control" name="status" id="status1">

                        </div>
                     </div>

                     <div class="col-lg-12 col-12">
                        <div class="form-group">
                           <input style="background-color:#f2f0f0;color:#121212;border:none;font-weight:600; text-transform:uppercase; font-size:27px" type="text" class="form-control" name="data" id="data" required disabled>

                        </div>
                     </div>
                     <div class="col-lg-8 col-8">
                        <div class="form-group">
                           <label>Despesa</label>
                           <input style="background-color:#ffca10;color:#121212;border:none;font-weight:600; text-transform:uppercase; font-size:33px" type="text" class="form-control" name="categoria" id="categoria" required disabled>

                        </div>
                     </div>
                     <div class="col-lg-4 col-4">
                        <div class="form-group">
                           <label>Valor </label>
                           <input style="border:none !important; background-color:#a20808;color:#fff;font-size:26px;font-weight:600 " type="text" class="form-control" name="valor" id="valor" required disabled>
                        </div>
                     </div>

                     <div class="col-lg-12 col-12">
                        <div class="form-group">
                           <label>Forma de pagamento</label>
                           <select class="form-control" name="form_pagamento">
                              <option value="Forma de pagamento"></option>
                              <option value="Dinheiro">Dinheiro</option>
                              <option value="Credito">Cartão de Crédito</option>
                              <option value="Debito">Cartão de Débito</option>

                           </select>
                        </div>
                     </div>

                  </div>
               </div>
            </div>
            <div class="modal-footer justify-content-between">
               <button type="button" class="btn btn-default" data-dismiss="modal">FECHAR</button>
               <button type="submit" class="btn btn-primary">PAGAR
               </button>
            </div>
         </div>
      </form>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>