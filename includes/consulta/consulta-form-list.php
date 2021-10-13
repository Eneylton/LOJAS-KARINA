   <?php
   $id = '';
   $compra = '';
   $venda = '';
   $cate = '';
   $codigo = '';
   $qtd = '';
   $aplicacao = '';

   $list = '';

   foreach ($categorias as $item) {

      $list .= '<option value="' . $item->id . '">' . $item->nome . '</option>';
   }


   $resultados = '';

   foreach ($listar as $item) {

      $id  = $item->id;
      $compra = $item->valor_compra;
      $venda =  $item->valor_venda;
      $categorias_id = $item->categorias_id;
      $codigo = $item->codigo;
      $qtd = $item->estoque;
      $aplicacao = $item->aplicacao;

      if (empty($item->foto)) {
         $foto = 'imgs/sem.jpg';
      } else {
         $foto = $item->foto;
      }


      $resultados .= '<tr>
                        <td style="display:none">' . $id . '</td>
                        <td style="display:none">' . $foto . '</td>
                        <td style="display:none">' . $item->nome . '</td>
                        <td style="display:none">' . $qtd . '</td>
                        <td style="display:none">' . $compra . '</td>
                        <td style="display:none">' . $venda . '</td>
                        <td style="display:none">' . $categorias_id . '</td>
                        <td style="display:none">' . $codigo . '</td>
                        <td style="display:none">' . $item->barra . '</td>
                        <td style="display:none">' . $aplicacao . '</td>
                        <td><img style="width:80px; heigth:70px" src="../.' . $foto . '" class="img-thumbnail"></td>
                        <td style="text-align:left; width:150px"> <a type="submit" class="btn btn-default editbtn" >' . $item->barra . '</a></td>
                        <td style="text-align:left; width:220px"> <a type="submit" class="btn btn-default editbtn" >' . date('d/m/Y à\s H:i:s', strtotime($item->data)) . '</a></td>
                        <td style="text-transform: uppercase;"><a type="submit" class="btn btn-default editbtn" >' . $item->nome . '</a></td>
                        <td style="text-transform: uppercase;"><a type="submit" class="btn btn-default editbtn" >' . $item->categoria . '</a></td>
                        <td>
                        
                        <span style="font-size:16px" class="' . ($item->estoque <= 3 ? 'badge badge-danger' : 'badge badge-primary') . '">' . $item->estoque . '</span>
                        
                        </td>
                        <td> <button type="button" class="btn btn-info"> R$ ' . number_format($item->valor_compra, "2", ",", ".") . '</button></td>
                        <td> <button type="button" class="btn btn-primary"> R$ ' . number_format($item->valor_venda, "2", ",", ".") . '</button></td>
                        <td style="text-align: center;">

                      
                           
                        <button type="submit" class="btn btn-warning editbtn" > <i class="fa fa-bars" aria-hidden="true"></i> Aplicações </button>
                       

                       


                        </td>
                        </tr>

                        ';
   }

   $resultados = strlen($resultados) ? $resultados : '<tr>
                                                      <td colspan="9" class="text-center" > Nenhum produto encontrado !!!!! </td>
                                                      </tr>';


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

   ?>

   <section class="content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-12">
               <div class="card card-success">
                  <div class="card-header">

                     <form method="get">
                        <div class="row">
                           <div class="col-4">
                              <label>Marca / Veículo</label>
                              <input placeholder="Marca / veículo" type="text" class="form-control" name="buscar" value="<?= $buscar ?>" autofocus>
                           </div>
                           <div class="col-4">
                              <div class="form-group">
                                 <label>Categorias</label>
                                 <select class="form-control select2" style="width: 100%;" name="buscar2" >
                                    <option value=""> Selecione uma categoria </option>
                                    <?php

                                    foreach ($categorias as $item) {
                                       echo '<option value="'. $item->id . '">' . $item->nome . '</option>';
                                    }
                                    ?>

                                 </select>
                              </div>
                           </div>
                           <div class="col-4">
                              <div class="col d-flex align-items-end">
                                 <button style="margin-top: 30px;" type="submit" class="btn btn-warning" name="">
                                    <i class="fas fa-search"></i>

                                    Pesquisar

                                 </button>

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
                                 <button type="submit" class="btn btn-danger" data-toggle="modal" data-target="#modal-default" disabled> <i class="fas fa-plus"></i> &nbsp; Novo</button>
                                 <a href="gerar-pdf.php" target="_blank">
                                    <button type="submit" class="btn btn-dark float-right"> <i class="fas fa-print"></i> &nbsp; &nbsp; IMPRIMIR RELATÓRIO</button>
                                 </a>
                              </td>
                           </tr>
                           <tr>
                              <th> IMAGEM </th>
                              <th style="text-align:left; width:10px"> BARRA </th>
                              <th style="text-align:left; width:180px"> DATA CADASTRO </th>
                              <th> NOME </th>
                              <th> CATEGORIA </th>
                              <th> QTD </th>
                              <th> COMPRA </th>
                              <th> VENDA </th>
                              <th style="text-align: center; width:200px"> AÇÃO </th>
                           </tr>
                        </thead>
                        <tbody>
                           <?= $resultados ?>
                        </tbody>

                     </table>

                  </div>


               </div>

            </div>

         </div>

      </div>

   </section>

   <?= $paginacao ?>

   <!-- EDITAR -->

   <div class="modal fade" id="editmodal">
      <div class="modal-dialog modal-xl">
         <form action="./produto-edit.php" method="POST" enctype="multipart/form-data">
            <div class="modal-content bg-gray">
               <div class="modal-header">
                  <h4 class="modal-title">Aplicações
                  </h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <input type="hidden" name="id" id="id">
               <div class="card-body">
                  <div class="row">

                     <div class="col-md-12">
                      
                        <div class="form-group">
                           <label>Descrição</label>
                           <textarea style="text-transform: uppercase;" class="form-control" name="aplicacao" id="aplicacao" rows="4"></textarea>

                        </div>

                     </div>
                     <!-- /.col -->
                  </div>
                  <!-- /.row -->
               </div>
               <div class="modal-footer justify-content-between">
                 
                  <button type="button" class="btn btn-primary">Fechar
                  </button>
               </div>
            </div>
         </form>
         <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
   </div>