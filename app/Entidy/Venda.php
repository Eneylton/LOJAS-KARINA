<?php 

namespace App\Entidy;

use \App\Db\Database;

use \PDO;


class Venda{
    
    
    public $id;
    
    public $codigo;

    public $barra;

    public $nome;

    public $qtd;

    public $valor_venda;

    public $forma_pagamento;

    public $subtotal;

    public $produtos_id;

    public $usuarios_id;
    
    public $clientes_id;

    public $mecanicos_id;

    
    public function cadastar(){

        $this-> data = date('Y-m-d H:i:s');

        $obdataBase = new Database('vendas');  
        
        $this->id = $obdataBase->insert([
          
            'codigo'           => $this->codigo, 
            'barra'            => $this->barra, 
            'nome'             => $this->nome, 
            'qtd'              => $this->qtd, 
            'valor_venda'      => $this->valor_venda, 
            'forma_pagamento'  => $this->forma_pagamento, 
            'subtotal'         => $this->subtotal,
            'produtos_id'      => $this->produtos_id, 
            'usuarios_id'      => $this->usuarios_id, 
            'clientes_id'      => $this->clientes_id, 
            'mecanicos_id'     => $this->mecanicos_id 

        ]);

        return true;

    }

    public function atualizar(){
        return (new Database ('vendas'))->update('id = ' .$this-> id, [
    
                                                   
                                                'status'         => $this->status 
    
        ]);
      
    }

public static function getList($where = null, $order = null, $limit = null){

    return (new Database ('vendas'))->select($where,$order,$limit)
                                   ->fetchAll(PDO::FETCH_CLASS, self::class);

}


public static function getVendasDiaria($where = null, $order = null, $limit = null){

    return (new Database ('vendas'))->vendaDiaria($where,$order,$limit)
                                   ->fetchAll(PDO::FETCH_CLASS, self::class);

}


public static function getReceber($where = null, $order = null, $limit = null){

    return (new Database ('vendas'))->receber($where,$order,$limit)
                                   ->fetchAll(PDO::FETCH_CLASS, self::class);

}

public static function getUsuarios($where = null, $order = null, $limit = null){

    return (new Database ('usuarios'))->select($where,$order,$limit)
                                   ->fetchAll(PDO::FETCH_CLASS, self::class);

}

public static function getQtd($where = null){

    return (new Database ('vendas'))->select($where,null,null,'COUNT(*) as qtd')
                                   ->fetchObject()
                                   ->qtd;

}


public static function getID($id){
    return (new Database ('vendas'))->select('id = ' .$id)
                                   ->fetchObject(self::class);
 
}

public static function getITem($id){
    return (new Database ('vendas'))->select('produtos_id = ' .$id)
                                   ->fetchObject(self::class);
 
}


public function excluir(){
    return (new Database ('vendas'))->delete('id = ' .$this->id);
  
}




}