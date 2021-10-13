<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;


class Servico
{

    public $id;
    public $nome;
    public $valor;

    public function cadastar()
    {

        $obdataBase = new Database('servicos');

        $this->id = $obdataBase->insert([

            'nome'             => $this->nome,
            'valor'            => $this->valor
        ]);

        return true;
    }

    public static function getList($where = null, $order = null, $limit = null)
    {

        return (new Database('servicos'))->select($where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getQtd($where = null)
    {

        return (new Database('servicos'))->select($where, null, null, 'COUNT(*) as qtd')
            ->fetchObject()
            ->qtd;
    }

    public static function getID($id)
    {
        return (new Database('servicos'))->select('id = ' . $id)
            ->fetchObject(self::class);
    }

    public static function getMarcID($id)
    {
        return (new Database('servicos'))->select('id = ' . $id)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public function atualizar()
    {
        return (new Database('servicos'))->update('id = ' . $this->id, [

            'nome'            => $this->nome,
            'valor'           => $this->valor
        ]);
    }

    public function excluir()
    {
        return (new Database('servicos'))->delete('id = ' . $this->id);
    }


    public static function getPdf()
    {

        return (new Database('servicos'))->pdf($where = null)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }
}
