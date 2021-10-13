<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Cliente;
use App\Entidy\Mecanico;
use App\Entidy\Ordem;
use App\Entidy\Produto;
use App\Entidy\Venda;
use \App\Session\Login;

Login::requireLogin();

if(isset($_SESSION['forma-pagamento'])){

    foreach ($_SESSION['forma-pagamento'] as $item) {

    $troco = $item['troco'];
    $recebido = $item['valor_recebido'];
    $forma_pagamento = $item['forma_pagamento'];
    }
}

$usuariologado = Login::getUsuarioLogado();

$usuario    = $usuariologado['nome'];
$usuario_id = $usuariologado['id'];

$total_geral = 0;

if (isset($_SESSION['dados-serv'])) {

    foreach ($_SESSION['dados-serv'] as $item) {

        $cliente_id      = $item['cliente'];
        $mecanico_id     = $item['mecanico'];
        $mao_obra        = $item['obra'];
        $servicos        = $item['servico'];
        $sub             = $item['total'];
    }

    $cliente = Cliente::getclientID($cliente_id);
    $nome_cliente       = $cliente->nome;
    $email_cliente      = $cliente->email;
    $telefone_cliente   = $cliente->telefone;
    $marca_cliente      = $cliente->marca;
    $fabricante_cliente = $cliente->fabricante;
    $placa_cliente      = $cliente->placa;

    $mecanico = Mecanico::getID($mecanico_id);
    $nome_mecanico = $mecanico->nome;
}


$ordem_servicos = Ordem::getClientID($cliente_id);

$result = '';
$total_serv = 0;
foreach ($ordem_servicos as $value) {
    $id_serv = $value->id;
    
    $result .= '
        <tr>
        <td style="text-align:left;">' . $value->nome . '</td>
        <td style="text-align:left;"> R$ ' . number_format($value->valor, "2", ",", ".") . '</td>
        </tr>

        ';

        $total_serv += $value->valor;

        $ordem = Ordem::getIDServico($id_serv);
        $ordem->status = 1;
        $ordem->atualizar();
}

$result_prod = '';
$total_prod = 0;
$total_qtd = 0;

foreach ($_SESSION['dados-venda'] as $item) {
    
    $nome            = $item['nome'];
    $codigo_prod     = $item['codigo'];
    $barra           = $item['barra'];
    $produtos_id     = $item['produtos_id'];
    $qtd             = $item['qtd'];
    $uni             = $item['valor_venda'];
    $sub             = $item['subtotal'];

    $produto  = Produto::getID($produtos_id);
    $total_qtd = $produto->estoque - $qtd;
    $produto->estoque = $total_qtd;
    $produto->atualizar();
    

    $result_prod .= '
        <tr>
        <td style="text-align:left;">' . $nome . '</td>
        <td>' . $qtd . '</td>
        <td> R$ ' . number_format($uni, "2", ",", ".") . '</td>
        <td style="text-align: left;"> R$ ' . number_format($sub, "2", ",", ".") . '</td>
        </tr>

        ';

        $total_prod += $sub;

       
        $venda = New Venda;
        $venda->nome               =  $nome;
        $venda->codigo             =  $codigo_prod;
        $venda->barra              =  $barra;
        $venda->qtd                =  $qtd;
        $venda->valor_venda        =  $uni;
        $venda->subtotal           =  $sub;
        $venda->forma_pagamento    =  $forma_pagamento;
        $venda->usuarios_id        =  $usuario_id;
        $venda->clientes_id        =  $cliente_id;
        $venda->mecanicos_id       =  $mecanico_id;
        $venda->produtos_id        =  $produtos_id;
        $venda->cadastar();
     
}

$total_geral = $total_serv + $total_prod + $mao_obra ;




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

    <title>Recibo</title>
</head>

<body>

    <table style="margin-top: -30px;">
        <tbody>
            <tr style="background-color: #fff; color:#000">
                <td style="border:1px solid #fff; text-align:left">
                    <span style="margin-left:126px; margin-top: -30px; font-size:large">LOJÃO DO CARRO </span><br>
                    <span>Orçamento de serviços</span>
                    <img style="width:120px; height:50px; float:left;margin-top:-40px; padding:10px; margin-left:-12px;" src="../../01.png">

                <td style="border:1px solid #fff; text-align:right; font-size:12px">
                    Data: de Emissão: <?php echo date("d/m/Y") ?>
                </td>
            </tr>
        </tbody>
    </table>

    <table style="margin-top: 0px;">
        <tbody>
            <tr style="background-color: #fff; color:#000">
                <td style="border:1px solid #fff; text-align:center;font-size:11px">
                    RECIBO
                </td>
            </tr>
        </tbody>
    </table>

    <table style="margin-top: 0px;">
        <tbody>
            <tr style="background-color: #fff; color:#000">
                <td style="border:1px solid #fff; text-align:left;font-size:13px">
                Atendente: <?= $usuario  ?>
                </td>
            </tr>
        </tbody>
    </table>

    <table style="margin-top: 0px;">
        <tbody>
            <tr style="background-color: #dddddd; color:#000">
                <td style="border:1px solid #eeeeee; text-align:left;font-size:11px">
                    DADOS DO CLIENTE
                </td>
            </tr>
        </tbody>
    </table>
   
    <table style="margin-top: 0px;">
        <tbody>
            <tr style="background-color: #fff; color:#000">
                <td style="width:25px; border:1px solid #fff; text-align:left;font-size:12px">
                    Cliente:
                </td>
                <td style="border:1px solid #fff; text-align:left;font-size:12px" >
                    <?= $nome_cliente ?>
                </td>
            </tr>
            <tr>
                <td style="width:25px; border:1px solid #fff; text-align:left;font-size:11px; background-color:#fff">
                    Email:
                </td>
                <td style="border:1px solid #fff; text-align:left;font-size:11px; background-color:#fff">
                <?= $email_cliente ?>
                </td>
                <td style="width:25px; border:1px solid #fff; text-align:left;font-size:11px; background-color:#fff">
                    Telefone:
                </td>
                <td style="border:1px solid #fff; text-align:left;font-size:11px; background-color:#fff">
                <?= $telefone_cliente ?>
                </td>

            </tr>
        </tbody>
    </table>

    <table style="margin-top: 0px;">
        <tbody>
            <tr style="background-color: #dddddd; color:#000">
                <td style="border:1px solid #eeeeee; text-align:left;font-size:11px">
                   DADOS DO VEÍCULO
                </td>
            </tr>
        </tbody>
    </table>

    <table style="margin-top: 0px;">
        <tbody>
       
            <tr>
                <td style="width:25px; border:1px solid #fff; text-align:left;font-size:11px">
                    Marca:
                </td>
                <td style="border:1px solid #fff; text-align:left;font-size:11px">
                <?= $marca_cliente; echo ' / '. $fabricante_cliente ?>
                </td>
                <td style="width:25px; border:1px solid #fff; text-align:left;font-size:11px">
                    Placa:
                </td>
                <td style="border:1px solid #fff; text-align:left;font-size:11px">
                   <?= $placa_cliente ?>
                </td>

            </tr>
        </tbody>
    </table>

    <table style="margin-top: 0px;">
        <tbody>
            <tr style="background-color: #dddddd; color:#000">
                <td style="border:1px solid #eeeeee; text-align:left;font-size:11px">
                   SERVIÇOS
                </td>
            </tr>
        </tbody>
    </table>


    <table style="margin-top: 0px;">
        <tbody>
       
            <tr>
                <td style="width:180px; border:1px solid #fff; text-align:left;font-size:11px">
                    Mecânico Responsavél:
                </td>
                <td style="border:1px solid #fff; text-align:left;font-size:11px">
                     <?= $nome_mecanico ?>
                </td>
                

            </tr>
        </tbody>
    </table>

    <table>
        <tbody>
            <tr style="background-color: #000; color:#fff">
                
                <td style="text-align: left; width:620px">SERVIÇOS</td>
                <td style="text-align: left; width:620px">VALOR</td>
               
            </tr>     
             <?= $result; ?> 

             <tr style="background-color: #444546; color:#fff">
             <td style="text-align: left;">
               TOTAL
             </td>
             <td style="text-align: left;">
              <span>R$ <?= number_format( $total_serv,"2",",",".") ?></span>
             </td>
             </tr>
        </tbody>
    </table>

    <table style="margin-top: 20px;">
        <tbody>
            <tr style="background-color: #dddddd; color:#000">
                <td style="border:1px solid #eeeeee; text-align:left;font-size:11px">
                   PRODUTOS
                </td>
            </tr>
        </tbody>
    </table>
    <table>
        <tbody>
            <tr style="background-color: #ff0000; color:#fff">
                
                <td style="text-align:left;">PRODUTO</td>
                <td>QTD</td>
                <td>UNI</td>
                <td style="text-align: left;">SUBTOTAL</td>
               
            </tr>     
             <?= $result_prod; ?>  

             <tr style="background-color: #444546; color:#fff">
             <td style="text-align: left;" colspan="3">
               TOTAL
             </td>
             <td style="text-align: left;" >
             <span>R$ <?= number_format( $total_prod,"2",",",".") ?></span>
             </td>
             </tr>
        </tbody>
    </table>

    <table style="margin-top: 10px;">
        <tbody>
            <tr style="background-color: #fff; color:#000; font-size:11px">
                <td style="border:1px solid #eeeeee; text-align:left;font-size:15px">
                <span>Forma de Pagamento: <?= $forma_pagamento ?></span>
                <br>
                ______________________________________
                <br>
                <span style="font-size: 10px;"> Total do(s) Serviço(s)  [+]...................................... R$ <?= number_format($total_serv,"2",",",".") ?></span> 
                <br>
                <span style="font-size: 10px;"> Total do(s) Produto(s)  [+]...................................... R$ <?= number_format($total_prod,"2",",",".") ?></span> 
                <br>
                <span style="font-size: 10px;"> Total da Mão de Obra    [+]...................................... R$ <?= number_format($mao_obra ,"2",",",".") ?> </span> 
                <br>
                ______________________________________
                <br>
                <br>
                <span style="font-size: 10px;"> Total [+]------------------------------------------------------ R$ <?= number_format($total_geral,"2",",",".") ?></span>
                <br> 
                <span style="font-size: 10px;">  Valor Recebido  [+]---------------------------------------- R$ <?= number_format($recebido,"2",",",".") ?> </span>
                <br> 
                <span style="font-size: 10px;"> Troco [-]------------------------------------------------------ R$ <?= number_format($troco,"2",",",".") ?> </span>

                </td>
            </tr>

        </tbody>
    </table>

</body>

</html>

<?php



unset($_SESSION['compras']);
unset($_SESSION['carrinho']);
unset($_SESSION['dados-venda']);
unset($_SESSION['forma-pagamento']);
unset($_SESSION['dados-serv']);

?>