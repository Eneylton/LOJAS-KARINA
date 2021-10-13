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

   foreach ($produtos2 as $item) {

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
                        <td>
                        <a href="galeria-list.php?id=' . $item->id . '">
                        <img style="width:80px; heigth:70px" src="../.' . $foto . '" class="img-thumbnail">
                        </a>
                        </td>
                        <td style="text-align:left; width:150px">' . $item->barra . '</td>
                        <td>' . date('d/m/Y à\s H:i:s', strtotime($item->data)) . '</td>
                        <td style="text-transform: uppercase;">' . $item->nome . '</td>
                        <td style="text-transform: uppercase;">' . $item->categoria . '</td>
                        <td>
                        
                        <span style="font-size:16px" class="' . ($item->estoque <= 3 ? 'badge badge-danger' : 'badge badge-primary') . '">' . $item->estoque . '</span>
                        
                        </td>
                        <td> <button type="button" class="btn btn-info"> R$ ' . number_format($item->valor_compra, "2", ",", ".") . '</button></td>
                        <td> <button type="button" class="btn btn-primary"> R$ ' . number_format($item->valor_venda, "2", ",", ".") . '</button></td>
                        <td style="text-align: center;">

                        <a href="galeria-insert.php?id=' . $item->id . '">
                         <button type="button" class="btn btn-warning"> <i class="fas fa-images"></i></button>
                       </a>
                           
                        <button type="submit" class="btn btn-success editbtn" > <i class="fas fa-paint-brush"></i> </button>
                        &nbsp;

                        <a href="produto-delete.php?id=' . $item->id . '">
                        <button type="button" class="btn btn-danger"> <i class="fas fa-trash"></i></button>
                        </a>


                        </td>
                        </tr>

                        ';
   }

   $resultados = strlen($resultados) ? $resultados : '<tr>
                                                      <td colspan="9" class="text-center" > Nenhuma Produto Encontrado !!!!! </td>
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
               <div class="card card-purple">
                  <div class="card-header">

                     <form method="get">
                        <div class="row my-7">
                           <div class="col">

                              <label>Buscar por produtos</label>
                              <input type="text" class="form-control" name="buscar" value="<?= $buscar ?>" autofocus>

                           </div>


                           <div class="col d-flex align-items-end">
                              <button type="submit" class="btn btn-warning" name="">
                                 <i class="fas fa-search"></i>

                                 Pesquisar

                              </button>

                           </div>


                        </div>

                     </form>
                  </div>

                  <div class="table-responsive">

                     <table class="table table-bordered table-dark table-bordered table-hover table-striped">
                        <thead>
                           <tr>
                              <td colspan="9">
                                 <button type="submit" class="btn btn-success" data-toggle="modal" data-target="#modal-default"> <i class="fas fa-plus"></i> &nbsp; Novo</button>
                                 <a href="gerar2-pdf.php" target="_blank">
                                    <button type="submit" class="btn btn-light float-right"> <i class="fas fa-print"></i> &nbsp; &nbsp; IMPRIMIR RELATÓRIO</button>
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


   <div class="modal fade" id="modal-default">
      <div class="modal-dialog modal-xl">
         <div class="modal-content">
            <form action="./produto-insert.php" method="post" enctype="multipart/form-data">

               <div class="modal-header">
                  <h4 class="modal-title">Novo Produto
                  </h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="card-body">
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label>Foto</label>

                           <div class="input-group">
                              <div class="custom-file">
                                 <input type="file" value="<?php echo $foto2 ?>" class="custom-file-input" id="imagem" name="arquivo" onChange="carregarImg();">
                                 <label class="custom-file-label" for="exampleInputFile">Adicionar imagem</label>
                              </div>
                              <div class="input-group-append">
                                 <span class="input-group-text">Upload</span>
                              </div>
                           </div>

                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
                           <label>Nome do Produto</label>
                           <input type="text" class="form-control" name="nome" required>

                        </div>

                        <div class="form-group">
                           <label>Quantidade</label>
                           <div class="range-wrap">
                              <input type="range" class="range" min="1" max="500" name="estoque">
                              <output class="bubble"></output>
                           </div>

                        </div>

                        <div class="form-group">
                           <label>Valor de compra</label>
                           <input type="text" class="form-control" name="valor_compra" required>

                        </div>


                        <div class="form-group">
                           <label>Valor de venda</label>
                           <input type="text" class="form-control" name="valor_venda" required>

                        </div>

                     </div>
                     <!-- /.col -->
                     <div class="col-md-6">
                        <div class="form-group">
                           <label>Categoria</label>
                           <select class="form-control select2" style="width: 100%;" name="categorias_id" required>
                              <option value="">Selecione uma Categoria !!!</option>

                              <?= $list ?>

                           </select>
                        </div>

                        <div class="form-group">
                           <label>Código</label>
                           <input type="text" class="form-control" name="codigo" required>

                        </div>

                        <div class="form-group">
                           <label>Código de Barra</label>
                           <input type="text" class="form-control" name="barra" required>

                        </div>

                        <div class="form-group">
                           <label>Aplicação</label>
                           <textarea class="form-control" name="aplicacao" id="exampleFormControlTextarea1" rows="4"></textarea>

                        </div>
                        <div id="divImgConta">
                           <?php if ($foto2 != "") { ?>
                              <img src="../../imgs/<?php echo $foto2 ?>" width=20%" id="target">
                           <?php  } else { ?>
                              <img src="../../imgs/sem.jpg" width="20%" id="target">
                           <?php } ?>
                        </div>

                     </div>
                     <!-- /.col -->
                  </div>
                  <!-- /.row -->
               </div>
               <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-success" data-dismiss="modal">Fechar</button>
                  <button type="submit" class="btn btn-primary">Salvar</button>
               </div>

            </form>

         </div>
         <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
   </div>

   <!-- EDITAR -->

   <div class="modal fade" id="editmodal">
      <div class="modal-dialog modal-xl">
         <form action="./produto-edit.php" method="POST" enctype="multipart/form-data">
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title">Editar Produto
                  </h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <input type="hidden" name="id" id="id">
               <div class="card-body">
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label>Foto</label>

                           <div class="input-group">
                              <div class="custom-file">
                                 <input type="file" class="custom-file-input" id="exampleInputFile" name="arquivo" id="foto">
                                 <label class="custom-file-label" for="exampleInputFile">Adicionar imagem</label>
                              </div>
                              <div class="input-group-append">
                                 <span class="input-group-text">Upload</span>
                              </div>
                           </div>
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
                           <label>Nome do Produto</label>
                           <input type="text" class="form-control" name="nome" id="nome" required>

                        </div>

                        <div class="form-group">
                           <label>Estoque</label>
                           <input type="text" class="form-control col-2" name="estoque" id="qtd" required>

                        </div>

                        <div class="form-group">
                           <label>Valor de compra</label>
                           <input type="text" class="form-control" name="valor_compra" id="compra" required>

                        </div>


                        <div class="form-group">
                           <label>Valor de venda</label>
                           <input type="text" class="form-control" name="valor_venda" id="venda" required>

                        </div>

                     </div>
                     <!-- /.col -->
                     <div class="col-md-6">
                        <div class="form-group">
                           <label>Categoria</label>
                           <select class="form-control select2" style="width: 100%;" name="categorias_id" id="categorias_id">
                              <?= $list ?>

                           </select>
                        </div>

                        <div class="form-group">
                           <label>Código</label>
                           <input type="text" class="form-control" name="codigo" id="codigo" required>

                        </div>

                        <div class="form-group">
                           <label>Código de Barra</label>
                           <input type="text" class="form-control" name="barra" id="barra" required>

                        </div>

                        <div class="form-group">
                           <label>Aplicação</label>
                           <textarea class="form-control" name="aplicacao" id="aplicacao" rows="4"></textarea>

                        </div>

                     </div>
                     <!-- /.col -->
                  </div>
                  <!-- /.row -->
               </div>
               <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Salvar
                  </button>
               </div>
            </div>
         </form>
         <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
   </div>