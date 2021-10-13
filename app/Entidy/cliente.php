<?php 

namespace App\Entidy;

use \App\Db\Database;

use \PDO;


class Cliente{

    public $id;
    public $nome;
    public $telefone;
    public $email;
 

    public function cadastar(){


        $obdataBase = new Database('clientes');  
        
        $this->id = $obdataBase->insert([
           
                'nome'             => $this->nome, 
                'telefone'         => $this->telefone, 
                'email'            => $this->email, 
                'usuarios_id'      => $this->usuarios_id

        ]);

        return true;

    }

public static function getList($where = null, $order = null, $limit = null){

    return (new Database ('clientes'))->select($where,$order,$limit)
                                   ->fetchAll(PDO::FETCH_CLASS, self::class);

}

public static function getListCliMarca($where = null, $order = null, $limit = null){

    return (new Database ('clientes'))->CliMarca($where,$order,$limit)
                                   ->fetchAll(PDO::FETCH_CLASS, self::class);

}

public static function getQtdCliMarca($where = null){

    return (new Database ('clientes'))->qtdCli($where,null,null,'COUNT(*) as qtd')
                                   ->fetchObject()
                                   ->qtd;

}


public static function getQtd($where = null){

    return (new Database ('clientes'))->select($where,null,null,'COUNT(*) as qtd')
                                   ->fetchObject()
                                   ->qtd;

}


public static function getID($id){
    return (new Database ('clientes'))->select('id = ' .$id)
                                   ->fetchObject(self::class);
 
}

public static function getclientID($id){
    return (new Database ('clientes'))->clientemarcaid('c.id = ' .$id)
                                   ->fetchObject(self::class);
 
}


public function atualizar(){
    return (new Database ('clientes'))->update('id = ' .$this-> id, [

                                               
        'nome'             => $this->nome, 
        'telefone'         => $this->telefone, 
        'email'            => $this->email,
        'usuarios_id'      => $this->usuarios_id


    ]);
  
}

public function excluir(){
    return (new Database ('clientes'))->delete('id = ' .$this->id);
  
}


public static function getEmail($foto){

    return (new Database ('clientes'))->select('foto = "'.$foto.'"')-> fetchObject(self::class);

}

public static function getPdf(){

    return (new Database ('clientes'))->pdf($where = null)
                                   ->fetchAll(PDO::FETCH_CLASS, self::class);

}


}