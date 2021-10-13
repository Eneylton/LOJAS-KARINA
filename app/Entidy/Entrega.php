<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;


class Entrega
{

    public $id;
    public $cod_id;
    public $status;


    public function cadastar()
    {


        $obdataBase = new Database('entregas');

        $this->id = $obdataBase->insert([

            'cod_id'        => $this->cod_id,
            'status'        => $this->status

        ]);

        return true;
    }

    public static function getList($where = null, $order = null, $limit = null)
    {

        return (new Database('entregas'))->select($where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getListTotal($where = null, $order = null, $limit = null)
    {

        return (new Database('entregas'))->selectTotal($where, $order, $limit)
               ->fetchObject(self::class);
    }

    public static function getListPedidos($where = null, $order = null, $limit = null)
    {

        return (new Database('entregas'))->selectPedidos($where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getQtdPedidos($where = null)
    {

        return (new Database('entregas'))->qtdPedidos($where, null, null, 'COUNT(*) as qtd')
            ->fetchObject()
            ->qtd;
    }

    
    public static function getQtd($where = null)
    {

        return (new Database('entregas'))->select($where, null, null, 'COUNT(*) as qtd')
            ->fetchObject()
            ->qtd;
    }

    



    public static function getID($id)
    {
        return (new Database('entregas'))->select('id = ' . $id)
            ->fetchObject(self::class);
    }

 
    public function atualizar()
    {
        return (new Database('entregas'))->update('id = ' . $this->id, [


            'cod_id'        => $this->cod_id,
            'status'        => $this->status
        ]);
    }

    public function excluir()
    {
        return (new Database('entregas'))->delete('id = ' . $this->id);
    }


    public static function getEmail($foto)
    {

        return (new Database('entregas'))->select('foto = "' . $foto . '"')->fetchObject(self::class);
    }

    public static function getPdf()
    {

        return (new Database('entregas'))->pdf($where = null)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }
}
