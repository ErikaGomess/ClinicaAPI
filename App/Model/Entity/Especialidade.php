<?php


namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;


class Especialidade {
    public int $id;
    public string $nome;

    public function cadastrar() {
        $this->id = (new Database('especialidades'))->insert([
            'nome' => $this->nome
        ]);
        return true;
    }

    public function atualizar() {
        return (new Database('especialidades'))->update('id = ' . $this->id, [
            'nome' => $this->nome
        ]);
    }

    public function excluir() {
        return (new Database('especialidades'))->delete('id = ' . $this->id);
    }

    public static function getEspecialidadeById($id) {
        return self::getEspecialidades('id = ' . $id)->fetchObject(self::class);
    }

    public static function getEspecialidades($where = null, $order = null, $limit = null, $fields = '*') {
        return (new Database('especialidades'))->select($where, $order, $limit, $fields);
    }
}
