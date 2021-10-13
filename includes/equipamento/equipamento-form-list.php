<?php

$resultados = '';

foreach ($List as $item) {

   if (empty($item->foto)) {
      $foto = 'imgs/sem.jpg';
   } else {
      $foto = $item->foto;
   }


   $resultados .= '<tr>
                      <td style="display:none;">' . $item->id . '</td>
                      <td><img style="width:80px; heigth:70px" src="../.' . $foto . '" class="img-thumbnail"></td>
                      <td>' . date('d/m/Y à\s H:i:s', strtotime($item->data)) . '</td>
                      <td>' . $item->nome . '</td>
                      <td>' . $item->barra . '</td>
                      <td>' . $item->custo . '</td>
                      <td>' . $item->valor . '</td>
                      <td style="display:none;">' . $item->fornecedores_id . '</td>
                      <td>' . $item->fornecedor . '</td>
                      <td>' . $item->telefone . '</td>
                      <td>' . $item->email . '</td>
                  
                      <td style="text-align: center;">
                        
                      
                      <button type="submit" class="btn btn-success editbtn" > <i class="fas fa-paint-brush"></i> </button>
                      &nbsp;

                       <a href="equipamento-delete.php?id=' . $item->id . '">
                       <button type="button" class="btn btn-danger"> <i class="fas fa-trash"></i></button>
                       </a>


                      </td>
                      </tr>

                      ';
}

$resultados = strlen($resultados) ? $resultados : '<tr>
                                                     <td colspan="12" class="text-center" > Nenhuma Vaga Encontrada !!!!! </td>
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

                           <label>Buscar por Nome</label>
                           <input type="text" class="form-control" name="buscar" value="<?= $buscar ?>">

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
                           <td colspan="10">
                              <button type="submit" class="btn btn-success" data-toggle="modal" data-target="#modal-default"> <i class="fas fa-plus"></i> &nbsp; Nova</button>
                           </td>
                        </tr>
                        <tr>

                           <th> FOTO </th>
                           <th> DATA </th>
                           <th> NOME </th>
                           <th> BARRA </th>
                           <th> CUSTO </th>
                           <th> VALOR </th>
                           <th> FORNECEDOR </th>
                           <th> TELEFONE </th>
                           <th> EMAIL </th>

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
   <div class="modal-dialog">
      <div class="modal-content bg-gray">
         <form action="./equipamento-insert.php" method="post" enctype="multipart/form-data">

            <div class="modal-header">
               <h4 class="modal-title">Novo Equipamento
               </h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="card-body">

               <div class="form-group">

                  <div class="row">
                     <div class="col-lg-3 col-3">
                        <img src="../../imgs/sem.jpg" style="width: 70px;">
                     </div>
                     <div class="col-lg-8 col-12">
                        <input type="file" name="arquivo" class="form-control">
                        <br>
                     </div>

                     <div class="col-lg-12 col-12">
                        <br>
                        <label>Nome</label>
                        <input style="text-transform: uppercase;" type="text" class="form-control" name="nome" required>
                     </div>
                     <div class="col-lg-12 col-12">
                        <label>Barra</label>
                        <input style="text-transform: uppercase;" type="text" class="form-control" name="barra" required>
                     </div>
                     <div class="col-lg-12 col-12">
                        <label>Data de aquisição>
                           <input style="text-transform: uppercase;" type="datetime-local" class="form-control" name="data" required>
                     </div>
                     <div class="col-lg-12 col-12">
                        <label>Valor de Custo</label>
                        <input type="text" class="form-control" name="custo" required>
                     </div>
                     <div class="col-lg-12 col-12">
                        <label>Valor Estimado</label>
                        <input type="text" class="form-control" name="valor" required>
                     </div>
                     <div class="col-lg-12 col-12">
                        <label>Fornecedor</label>
                        <select class="form-control form-control-lg" name="fornecedores_id" required>
                           <option style="text-transform: uppercase;" value="">SELECIONE UM FORNECEDOR</option>
                           <?php

                           foreach ($fornecedores as $item) {
                              echo '<option style="text-transform: uppercase;" value="' . $item->id . '">' . $item->nome . '</option>';
                           }
                           ?>
                        </select>

                     </div>

                  </div>
               </div>

            </div>
            <div class="modal-footer justify-content-between">
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
   <div class="modal-dialog">
        <form action="./equipamento-edit.php" method="post" enctype="multipart/form-data">
         <div class="modal-content bg-gray">
            <div class="modal-header">
               <h4 class="modal-title">Editar Cliente
               </h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <input type="hidden" name="id" id="id">
               <div class="form-group">

                  <div class="row">
                     <div class="col-lg-3 col-3">
                        <img src="../../imgs/sem.jpg" style="width: 70px;">
                     </div>
                     <div class="col-lg-8 col-12">
                        <input type="file" name="arquivo" class="form-control">
                        <br>
                     </div>

                     <div class="col-lg-12 col-12">
                        <br>
                        <label>Nome</label>
                        <input style="text-transform: uppercase;" type="text" class="form-control" name="nome" id="nome" required>
                     </div>
                     <div class="col-lg-12 col-12">
                        <label>Barra</label>
                        <input style="text-transform: uppercase;" type="text" class="form-control" name="barra" id="barra" required>
                     </div>
                   
                     <div class="col-lg-12 col-12">
                        <label>Valor de Custo</label>
                        <input type="text" class="form-control" name="custo" id="custo" required>
                     </div>
                     <div class="col-lg-12 col-12">
                        <label>Valor Estimado</label>
                        <input type="text" class="form-control" name="valor" id="valor" required>
                     </div>
                     <div class="col-lg-12 col-12">
                        <label>Fornecedor</label>
                        <select class="form-control form-control-lg" name="fornecedores_id" id="fornecedores_id" required>
                          
                           <?php

                           foreach ($fornecedores as $item) {
                              echo '<option style="text-transform: uppercase;" value="' . $item->id . '">' . $item->nome . '</option>';
                           }
                           ?>
                        </select>

                     </div>

                  </div>
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