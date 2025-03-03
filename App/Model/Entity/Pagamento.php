<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class Pagamento {

    public int $id;
    public int $idConsulta;
    public float $valor;
    public string $metodoPagamento;
    public string $status;
    public string $dataPagamento;

    public function cadastrar() {
        //INSERE A INSTANCIA NO BANCO
        $this->id = (new Database('pagamentos'))->insert([
            'id_consulta' => $this->idConsulta,
            'valor' => $this->valor,
            'metodo_pagamento' => $this->metodoPagamento,
            'status' => $this->status,
            'data_pagamento' => $this->dataPagamento,
        ]);

        //SUCESSO
        return true;
    }

    public function atualizar() {
        return (new Database('pacientes'))->update('id = ' . $this->id, [
                    'id_consulta' => $this->idConsulta,
                    'valor' => $this->valor,
                    'metodo_pagamento' => $this->metodoPagamento,
                    'status' => $this->status,
                    'data_pagamento' => $this->dataPagamento,
        ]);
    }

    public function excluir() {
        return (new Database('pagamento'))->delete('id = ' . $this->id);
    }

    public static function getPagamentoById($id) {
        return self::getPagamentos('id = ' . $id)->fetchObject(self::class);
    }

    public static function getPagamentos($where = null, $order = null, $limit = null, $fields = '*') {
        return (new Database('pagamentos'))->select($where, $order, $limit, $fields);
    }

}