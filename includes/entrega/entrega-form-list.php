<?php

$resultados = '';
$status = '';
$disabled = 'disabled';

foreach ($listar as $item) {

   switch ($item->status) {

      case '1':
         $cor = "badge-warning";
         $disabled = "";
         $status = "Entregar Produtos...";
         break;
      

      default:
         $cor = "badge-success";
         $disabled = "disabled";
         $status = "Concluido...";
         break;
   }
   
   $resultados .= '<tr>
                      <td style="display:none">' . $item->id . '</td>
                      <td>
                      <h4>
                        <small class="badge badge-pill ' . $cor . '"><i class="far fa-clock"></i> &nbsp; &nbsp;' . $status . '</small>
                      </h4>
                      </td>
                      <td>' . $item->codigo . '</td>
                      <td>' . date('d/m/Y À\S H:i:s', strtotime($item->data)) . '</td>
                      <td style="text-transform:uppercase">' . $item->cliente . '</td>
                      <td style="text-transform:uppercase">' . $item->mecanico . '</td>
                      <td style="text-align: center;">
                        
                      
                      <button type="submit" class="btn btn-primary editbtn" '.$disabled.'> <i class="fa fa-th-list" aria-hidden="true"></i> &nbsp; Produtos </button>
                     


                      </td>
                      </tr>

                      ';
}

$resultados = strlen($resultados) ? $resultados : '<tr>
                                                     <td colspan="7" class="text-center" > Nenhum Pedido encontrado até o momento !!!!! </td>
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

                           <label>Buscar por Narca</label>
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
                           <th> STATUS </th>
                           <th> CÓDIGO </th>
                           <th> DATA </th>
                           <th> CLIENTE </th>
                           <th> MECÂNICO </th>
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
      <form action="./entrega-edit.php" method="get">
         <div class="modal-content bg-gray ">
            <div class="modal-header">
               <h4 class="modal-title">Lista de Produtos
               </h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <input type="hidden" name="id" id="id">    
               <input type="hidden" id="codigo" name="codigo" >
               <div class="form-group">

                  <select class="form-control form-control-lg" name="produtos" id="produtos" multiple  size="10">


                  </select>
               </div>
               
            </div>
            <div class="modal-footer justify-content-between">
               <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
               <button type="submit" class="btn btn-danger">Finalizar
               </button>
            </div>
         </div>
      </form>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>