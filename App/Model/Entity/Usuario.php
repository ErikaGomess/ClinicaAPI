<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class Usuario {
    public int $id;
    public string $nome;
    public string $email;
    public string $senha;
    public string $tipo;
    
    public function cadastrar() {
        $this->id = (new Database('usuarios'))->insert([
            'nome' => $this->nome,
            'email' => $this->email,
            'senha_hash' => $this->senha,
            'tipo' => $this->tipo
        ]);
        return true;
    }

    public function atualizar() {
        return (new Database('usuarios'))->update('id = ' . $this->id, [
            'nome' => $this->nome,
            'email' => $this->email,
            'senha_hash' => $this->senha,
            'tipo' => $this->tipo
        ]);
    }

    public function excluir() {
        return (new Database('usuarios'))->delete('id = ' . $this->id);
    }

    public static function getUsuarioById($id) {
        return self::getUsuarios('id = ' . $id)->fetchObject(self::class);
    }

    public static function getUsuarios($where = null, $order = null, $limit = null, $fields = '*') {
        return (new Database('usuarios'))->select($where, $order, $limit, $fields);
    }
    
}
