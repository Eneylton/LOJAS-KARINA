<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;


class Ordem
{

    public $id;
    public $clientes_id;
    public $mecanicos_id;
    public $servicos_id;
    public $mao_obra;
    public $obs;
    public $status;

    public function cadastar()
    {

        $obdataBase = new Database('ordem_servicos');

        $this->id = $obdataBase->insert([

            'clientes_id'               => $this->clientes_id,
            'mecanicos_id'              => $this->mecanicos_id,
            'servicos_id'               => $this->servicos_id,
            'mao_obra'                  => $this->mao_obra,
            'status'                    => $this->status,
            'obs'                       => $this->obs

        ]);

        return true;
    }

    public static function getList($where = null, $order = null, $limit = null)
    {

        return (new Database('ordem_servicos'))->select($where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getQtd($where = null)
    {

        return (new Database('ordem_servicos'))->select($where, null, null, 'COUNT(*) as qtd')
            ->fetchObject()
            ->qtd;
    }

    public static function getID($id)
    {
        return (new Database('ordem_servicos'))->select('id = ' . $id)
            ->fetchObject(self::class);
    }

    public static function getIDServico($id)
    {
        return (new Database('ordem_servicos'))->select('id = ' . $id)
            ->fetchObject(self::class);
    }

    public static function getClientID($id)
    {
        return (new Database('ordem_servicos'))->selectService('os.clientes_id = ' . $id)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getOcamentoID($id)
    {
        return (new Database('ordem_servicos'))->selectService2('os.clientes_id = ' . $id . ' AND os.status = 0') 
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getMarcID($id)
    {
        return (new Database('ordem_servicos'))->select('id = ' . $id)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public function atualizar()
    {
        return (new Database('ordem_servicos'))->update('id = ' . $this->id, [

            'clientes_id'               => $this->clientes_id,
            'mecanicos_id'              => $this->mecanicos_id,
            'servicos_id'               => $this->servicos_id,
            'mao_obra'                  => $this->mao_obra,
            'status'                    => $this->status,
            'obs'                       => $this->obs
        ]);
    }

    public function excluir()
    {
        return (new Database('ordem_servicos'))->delete('id = ' . $this->id);
    }


    public static function getPdf()
    {

        return (new Database('ordem_servicos'))->pdf($where = null)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }
}
