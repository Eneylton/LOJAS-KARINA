<?php

namespace App\Entidy;

use \App\Db\Database;
use \PDO;

class Mecanico
{

    public $id;
    public $nome;
    public $telefone;

    public function cadastar()
    {

        $obdataBase = new Database('mecanicos');

        $this->id = $obdataBase->insert([

            'nome' => $this->nome,
            'telefone' => $this->telefone

        ]);

        return true;

    }

    public static function getList($where = null, $order = null, $limit = null)
    {

        return (new Database('mecanicos'))->select($where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);

    }

    public static function getInnerJoin($where = null, $order = null, $limit = null)
    {

        return (new Database('mecanicos'))->innerjoin($where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);

    }

    public static function getQtd($where = null)
    {

        return (new Database('mecanicos'))->select($where, null, null, 'COUNT(*) as qtd')
            ->fetchObject()
            ->qtd;

    }

    public static function getCli($where = null)
    {

        return (new Database('mecanicos'))->qtdCli($where, null, null, 'COUNT(*) as qtd')
            ->fetchObject()
            ->qtd;

    }

    public static function getID($id)
    {
        return (new Database('mecanicos'))->select('id = ' . $id)
            ->fetchObject(self::class);

    }

    public function atualizar()
    {
        return (new Database('mecanicos'))->update('id = ' . $this->id, [
            
            'nome' => $this->nome,
            'telefone' => $this->telefone

        ]);

    }

    public function excluir()
    {
        return (new Database('mecanicos'))->delete('id = ' . $this->id);

    }

    public static function getPdf()
    {

        return (new Database('mecanicos'))->pdf($where = null)
            ->fetchAll(PDO::FETCH_CLASS, self::class);

    }

}
