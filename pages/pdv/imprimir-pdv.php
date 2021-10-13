<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Cliente;
use App\Entidy\Entrega;
use App\Entidy\Mecanico;
use App\Entidy\Orcamento;
use App\Entidy\Ordem;
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
    $telefone_cliente   = $cliente->telefone;

    $placa_cliente      = $cliente->placa;

    $mecanico = Mecanico::getID($mecanico_id);
    $nome_mecanico = $mecanico->nome;
}

$ordem_servicos = Ordem::getOcamentoID($cliente_id);

$result = '';
$total_serv = 0;
foreach ($ordem_servicos as $value) {
    $id_serv = $value->id;
    
    $result .= '
        <tr>
        <td style="text-align: left;">' . $value->nome . '</td>
        <td style="text-align: left;"> R$ ' . number_format($value->valor, "2", ",", ".") . '</td>
        </tr>

        ';

        $total_serv += $value->valor;

        $ordem = Ordem::getIDServico($id_serv);
        $ordem->status = 1;
        $ordem->atualizar();
}

$result_prod = '';
$total_prod = 0;
 // GERAR CODIGO
$codigo = substr(uniqid(rand()), 0, 6);

$item = new Entrega;
$item->cod_id = $codigo;
$item->status = 1;
$item->cadastar();

foreach ($_SESSION['dados-venda'] as $item) {
    
    $produto         = $item['nome'];
    $codigo_prod     = $item['codigo'];
    $barra           = $item['barra'];
    $produtos_id     = $item['produtos_id'];
    $qtd             = $item['qtd'];
    $uni             = $item['valor_venda'];
    $sub             = $item['subtotal'];
    

    $result_prod .= '
        <tr>
        <td>' . $produto . '</td>
        <td>' . $qtd . '</td>
        <td> R$ ' . number_format($uni, "2", ",", ".") . '</td>
        <td style="text-align: left;"> R$ ' . number_format($sub, "2", ",", ".") . '</td>
        </tr>

        ';

        $total_prod += $sub;

       
        $orcamento = New Orcamento;
        $orcamento->nome               =  $produto;
        $orcamento->cod_id             =  $codigo;
        $orcamento->codigo             =  $codigo_prod;
        $orcamento->barra              =  $barra;
        $orcamento->qtd                =  $qtd;
        $orcamento->valor_venda        =  $uni;
        $orcamento->subtotal           =  $sub;
        $orcamento->forma_pagamento    =  $forma_pagamento;
        $orcamento->usuarios_id        =  $usuario_id;
        $orcamento->clientes_id        =  $cliente_id;
        $orcamento->mecanicos_id       =  $mecanico_id;
        $orcamento->produtos_id        =  $produtos_id;
        $orcamento->cadastar();

       

        
}

$total_geral = $total_serv + $total_prod + $mao_obra ;

unset($_SESSION['compras']);
unset($_SESSION['carrinho']);
unset($_SESSION['dados-venda']);
unset($_SESSION['forma-pagamento']);
unset($_SESSION['dados-serv']);


header('location: pdv.php?status=success');
exit;


?>