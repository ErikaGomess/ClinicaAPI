<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class Medico {
    public int $id;
    public string $nome;
    public string $crm;
    public string $telefone;
    public string $email;
    public int $idEspecialidade;

    public function cadastrar() {
        $this->id = (new Database('medicos'))->insert([
            'nome' => $this->nome,
            'crm' => $this->crm,
            'telefone' => $this->telefone,
            'email' => $this->email,
            'id_especialidade' => $this->idEspecialidade
        ]);
        return true;
    }

    public function atualizar() {
        return (new Database('medicos'))->update('id = ' . $this->id, [
            'nome' => $this->nome,
            'crm' => $this->crm,
            'telefone' => $this->telefone,
            'email' => $this->email,
            'id_especialidade' => $this->idEspecialidade
        ]);
    }

    public function excluir() {
        return (new Database('medicos'))->delete('id = ' . $this->id);
    }

    public static function getMedicoById($id) {
        return self::getMedicos('id = ' . $id)->fetchObject(self::class);
    }

    public static function getMedicos($where = null, $order = null, $limit = null, $fields = '*') {
        return (new Database('medicos'))->select($where, $order, $limit, $fields);
    }
}