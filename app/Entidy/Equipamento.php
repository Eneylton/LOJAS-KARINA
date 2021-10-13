<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;


class Equipamento
{
    public $id;
    public $nome;
    public $data;
    public $foto;
    public $barra;
    public $valor_custo;
    public $valor;
    public $fornecedores_id;
    public $usuarios_id;

    public function cadastar()
    {


        $obdataBase = new Database('equipamentos');

        $this->id = $obdataBase->insert([

            'data'                   => $this->data,
            'nome'                   => $this->nome,
            'foto'                   => $this->foto,
            'barra'                  => $this->barra,
            'valor_custo'            => $this->valor_custo,
            'valor'                  => $this->valor,
            'fornecedores_id'        => $this->fornecedores_id,
            'usuarios_id'            => $this->usuarios_id
            
            ]);

        return true;
    }

    public static function getList($where = null, $order = null, $limit = null)
    {

        return (new Database('equipamentos'))->select($where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getListEquipamentos($where = null, $order = null, $limit = null)
    {

        return (new Database('equipamentos'))->innerjoinForn($where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getListEqipID($where = null)
    {

        return (new Database('equipamentos'))->qtdforn($where, null, null, 'COUNT(*) as qtd')
            ->fetchObject()
            ->qtd;
    }


    public static function getQtd($where = null)
    {

        return (new Database('equipamentos'))->select($where, null, null, 'COUNT(*) as qtd')
            ->fetchObject()
            ->qtd;
    }


    public static function getID($id)
    {
        return (new Database('equipamentos'))->select('id = ' . $id)
            ->fetchObject(self::class);
    }

    public function atualizar()
    {
        return (new Database('equipamentos'))->update('id = ' . $this->id, [

            'data'                   => $this->data,
            'nome'                   => $this->nome,
            'foto'                   => $this->foto,
            'barra'                  => $this->barra,
            'valor_custo'            => $this->valor_custo,
            'valor'                  => $this->valor,
            'fornecedores_id'        => $this->fornecedores_id,
            'usuarios_id'            => $this->usuarios_id
        ]);
    }

    public function atualizarstatus()
    {
        return (new Database('equipamentos'))->update('id = ' . $this->id, [

            'status'                => $this->status,
            'data'                  => $this->data
        ]);
    }


    public function excluir()
    {
        return (new Database('equipamentos'))->delete('id = ' . $this->id);
    }


    public static function getEmail($form_pagamento)
    {

        return (new Database('equipamentos'))->select('form_pagamento = "' . $form_pagamento . '"')->fetchObject(self::class);
    }

    public static function getPdf()
    {

        return (new Database('equipamentos'))->pdf($where = null)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }
}
