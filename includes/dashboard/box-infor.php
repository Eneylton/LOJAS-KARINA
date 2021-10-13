<?php
$resultados = '';

$data = "";
$total = "";

foreach ($vendas as $item) {
  
  $data  = $item->data;
  $total = $item->total;

}

$resultados = strlen($resultados) ? 'bg-danger' : 'bg-primary';

// ESTOQUE BAIXO
$qtd = 0;
$sub = 0;
$subtotal1 = 0;
$total_uni = 0;

foreach ($estoqueBaixo as $item) {
  $qtd += $item->estoque;
  $total_uni += $item->valor_compra;
  $sub = ($item->estoque * $item->valor_compra);
  $subtotal1 += $sub;
 
}

?>

<div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box <?= $resultados ?>">
              <div class="inner">
                <h3><?= $total ?></h3>

                <p>Faturamento do Dia: &nbsp;</p><span> <?= date('d/m/Y à\s H:i:s', strtotime($data))  ?></span>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">Mais Informações <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>53<sup style="font-size: 20px">%</sup></h3>

                <p>Bounce Rate</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-gray">
              <div class="inner">
                <h3>44</h3>

                <p>User Registrations</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-dark">
              <div class="inner">
                <h3>Lista de Compras: <?= $qtd ?> </h3>
                <p>Unitário: <span style="color:#ee7272">R$  <?= number_format($total_uni,"2",",",".") ?></span> / Total:<span style="color:#ff0000"> R$ <?= number_format($subtotal1,"2",",",".") ?></span></p>
                <p></p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="pages/compras/gerarCompra-pdf.php" class="small-box-footer">Emitir Relatório <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

        </div>
      </div>