<?php

$resultados = '';

foreach ($List as $item) {

   $resultados .= '<tr>
                      <td><img style="width:80px; heigth:70px" src="../.' . $item->foto . '" class="img-thumbnail"></td>
                      <td> '. $item->id . '</td>
                      <td>' . date('d/m/Y à\s H:i:s', strtotime($item->data)) . '</td>
                      <td>' . $item->telefone . '</td>
                      <td>' . $item->email . '</td>
                      <td>' . $item->nome . '</td>
                      <td style="text-align: center;">
                        
                      
                      <button type="submit" class="btn btn-success editbtn" > <i class="fas fa-paint-brush"></i> </button>
                      &nbsp;

                       <a href="fornecedor-delete.php?id=' . $item->id . '">
                       <button type="button" class="btn btn-danger"> <i class="fas fa-trash"></i></button>
                       </a>


                      </td>
                      </tr>

                      ';
}

$resultados = strlen($resultados) ? $resultados : '<tr>
                                                     <td colspan="7" class="text-center" > Nenhuma Fornecedor Encontrado !!!!! </td>
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
                        <td colspan="7"> 
                        <button type="submit" class="btn btn-success" data-toggle="modal" data-target="#modal-default"> <i class="fas fa-plus"></i> &nbsp; Nova</button>
                        </td>
                        </tr>
                        <tr>
                           <th style="text-align: left; width:80px">  FOTO </th>
                           <th style="text-align: left; width:80px">  CÓDIGO</th>
                           <th style="text-align: left; width:200px"> DATA</th>
                           <th style="text-align: left; width:80px">  TELEFONE </th>
                           <th style="text-align: left; width:80px">  EMAIL </th>
                           <th> NOME </th> 
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
         <form action="./fornecedor-insert.php" method="post" enctype="multipart/form-data">

            <div class="modal-header">
               <h4 class="modal-title">Nova Categoria
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
                        <input type="text" class="form-control" name="nome" required>
                     </div>
                     <div class="col-lg-12 col-12">
                        <label>Telefone</label>
                        <input type="text" class="form-control" name="telefone" required>
                     </div>
                     <div class="col-lg-12 col-12">
                        <label>Email</label>
                        <input type="text" class="form-control" name="email" required>
                     </div>
                  </div>
               </div>

            </div>
            <div class="modal-footer justify-content-between">
               <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
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
      <form action="./fornecedor-edit.php" method="POST" enctype="multipart/form-data">
         <div class="modal-content bg-gray">
            <div class="modal-header">
               <h4 class="modal-title">Editar Fornecedores
               </h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">

               <div class="modal-body">
                  <input type="hidden" name="id" id="id">
                  <div class="row">
                     <div class="col-lg-3 col-3">
                        <img src="../../imgs/sem.jpg" style="width: 70px;">
                     </div>
                     <div class="col-lg-8 col-12">
                        <input type="file" name="arquivo" class="form-control">
                        <br>
                     </div>

                     <div class="col-lg-12 col-12">
                        <label>Nome</label>
                        <input type="text" class="form-control" name="nome" id="nome" required>
                     </div>
                     <div class="col-lg-12 col-12">
                        <label>Telefone</label>
                        <input type="text" class="form-control" name="telefone" id="telefone" required>
                     </div>
                     <div class="col-lg-12 col-12">
                        <label>Emmail</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                     </div>
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