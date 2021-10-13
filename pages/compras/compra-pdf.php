<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Produto;
use \App\Session\Login;

$usuariologado = Login::getUsuarioLogado();

$usuarios_nome = $usuariologado['nome'];
$usuarios_email = $usuariologado['email'];

Login::requireLogin();

$res = "";

$listar = Produto::getBaixoEstoque(null, 'c.nome ASC', null);
$subtotal = 0;
$totalQtd = 0;
$total1 = 0;
$total2 = 0;
foreach ($listar as $item) {
    
    $total1 += $item->valor_compra;
    $totalQtd  += $item->estoque;
    $subtotal = ($item->estoque * $item->valor_compra);
    $total2  += $subtotal;

    if (empty($item->foto)) {

        $foto = 'imgs/sem.jpg';
    } else {

        $foto = $item->foto;
    }

    $res .= '
                <tr>
                
                <td style="width:40px; text-align:center">
              
                <img style="width:30px; heigth:40px;object-fit: contain;" src="../.' . $foto . '" class="img-thumbnail">

                <td style="width:30px">' . $item->barra . '</td>
                <td style="text-transform: uppercase; text-align:left; width:115px">' . date('d/m/Y à\s H:i:s', strtotime($item->data)) . '</td>
                <td style="text-transform: uppercase; text-align:left ; width:115px">' . $item->categoria . '</td>
                <td style="text-transform: uppercase; text-align:left; width:170px">' . $item->nome . '</td>
                <td style="text-transform: uppercase; text-align:center; width:35px">' . $item->estoque . '</td>
                <td style="text-transform: uppercase; text-align:left; width:80px"> R$ ' . number_format($item->valor_compra, "2", ",", ".") . '</td>
                <td style="text-transform: uppercase; text-align:left; width:80px"> R$ ' . number_format($subtotal, "2", ",", ".") . '</td>
                
                </td>
                   
                </tr>
                ';
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        @page {
            margin: 70px 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: "Open Sans", sans-serif;
        }

        .header {
            position: fixed;
            top: -70px;
            left: 0;
            right: 0;
            width: 100%;
            text-align: center;
            background-color: #555555;
            padding: 10px;
        }

        .header img {
            width: 160px;
        }

        .footer {
            bottom: -27px;
            left: 0;
            width: 100%;
            padding: 5px 10px 10px 10px;
            text-align: center;
            background: #555555;
            color: #fff;
        }

        .footer .page:after {
            content: counter(page);

        }

        table {
            width: 100%;
            border: 1px solid #555555;
            margin: 0;
            padding: 0;
        }

        th {
            text-transform: uppercase;
        }

        table,
        th,
        td {
            font-size: xx-small;
            border: 1px solid #555555;
            border-collapse: collapse;
            text-align: center;
            padding: 5px;

        }

        tr:nth-child(2n+0) {
            background: #eeeeee;
        }

        p {
            color: #888888;
            margin: 0;
            text-align: center;
        }

        h2 {
            text-align: center;

        }
    </style>

    <title>Estoque Baixo</title>
</head>

<body>

    <table style="margin-top: -40px;">
        <tbody>
            <tr style="background-color: #fff; color:#000">

                <td style="text-align: left; width:260px; border:1px solid #fff; ">
                    <span style="margin-left:126px; margin-top: -50px; font-size:small">Lojao do carro</span><br>
                    <span style="margin-left:126px; margin-top: -30px; font-size:xx-small ">Email:&nbsp; <?= $usuarios_email  ?> </span><br>
                    <span style="margin-left:126px; margin-top: -30px; font-size:xx-small">Atendente:&nbsp; <?= $usuarios_nome  ?> </span><br>
                    <img style="width:120px; height:50px; float:left;margin-top:-50px; padding:10px; margin-left:-12px;" src="../../01.png">
                    <br />
                    <br />

                </td>
                <td style="text-align:center; font-weight:600; font-size:16px; border:1px solid #fff;">• ESTOQUE BAIXO •</td>
                <td style="text-align:right; border:1px solid #fff;">Data de Emissão: <?php echo date("d/m/Y") ?><br></td>

            </tr>
        </tbody>
    </table>


    <table>
        <tbody>
            <tr style="background-color:#ff0000; color:#fff">
                <td style="text-align: center; text-transform:uppercase" colspan="9">PRODUTOS</td>
            </tr>

            <tr style="background-color: #000; color:#fff">

                <td style="text-align:center;text-transform:uppercase">Img</td>
                <td style="text-align: center;text-transform:uppercase">Barra</td>
                <td style="text-align: center;text-transform:uppercase">Data Pedido</td>
                <td style="text-align: center;text-transform:uppercase">Categorias</td>
                <td style="text-align: center;text-transform:uppercase">Descrição</td>
                <td style="text-align: center;text-transform:uppercase">Qtd</td>
                <td style="text-align: center;text-transform:uppercase">V.Compra</td>
                <td style="text-align: center;text-transform:uppercase">Subtotal</td>


            </tr>

            <?= $res ?>

            <tr style="background-color: #039803; color:#fff; text-transform: uppercase;" >
                     <td colspan="5" style="font-size:12px;text-align:right">
                      total
                     </td>
                     <td  style="font-size:12px;">
                      <?= $totalQtd ?>
                     </td>
                     <td  style="font-size:12px; text-align:left">
                     R$ <?=  number_format($total1 , "2",",",".") ?>
                     </td>
                     <td  style="font-size:12px; text-align:left">
                     R$ <?=  number_format($total2 , "2",",",".") ?>
                     </td>
                     </tr>
        </tbody>
    </table>

</body>

</html>