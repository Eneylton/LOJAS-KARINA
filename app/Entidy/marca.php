<?php 

namespace App\Entidy;

use \App\Db\Database;

use \PDO;


class Marca{
    

    public $id;

    public $nome;
    public $fabricante;
    
    public function cadastar(){


        $obdataBase = new Database('marcas');  
        
        $this->id = $obdataBase->insert([
          
            'nome'               => $this->nome, 
            'fabricante'         => $this->fabricante 

        ]);

        return true;

    }

public static function getList($where = null, $order = null, $limit = null){

    return (new Database ('marcas'))->select($where,$order,$limit)
                                   ->fetchAll(PDO::FETCH_CLASS, self::class);

}

public static function getQtd($where = null){

    return (new Database ('marcas'))->select($where,null,null,'COUNT(*) as qtd')
                                   ->fetchObject()
                                   ->qtd;

}


public static function getID($id){
    return (new Database ('marcas'))->select('id = ' .$id)
                                   ->fetchObject(self::class);
 
}

public function atualizar(){
    return (new Database ('marcas'))->update('id = ' .$this-> id, [

                                               
        'nome'               => $this->nome, 
        'fabricante'         => $this->fabricante 

    ]);
  
}

public function excluir(){
    return (new Database ('marcas'))->delete('id = ' .$this->id);
  
}


public static function getEmail($foto){

    return (new Database ('marcas'))->select('foto = "'.$foto.'"')-> fetchObject(self::class);

}

public static function getPdf(){

    return (new Database ('marcas'))->pdf($where = null)
                                   ->fetchAll(PDO::FETCH_CLASS, self::class);

}


}