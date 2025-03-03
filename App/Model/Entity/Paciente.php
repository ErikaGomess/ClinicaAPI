<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class Paciente {

    public int $id;
    public string $nome;
    public string $dataNascimento;
    public string $sexo;
    public string $telefone;
    public string $email;
    public string $endereco;
    public string $dataCadastro;

    public function cadastrar() {
        //INSERE A INSTANCIA NO BANCO
        $this->id = (new Database('pacientes'))->insert([
            'nome' => $this->nome,
            'data_nascimento' => $this->dataNascimento,
            'sexo' => $this->sexo,
            'telefone' => $this->telefone,
            'email' => $this->email,
            'endereco' => $this->endereco,
            'data_cadastro' => $this->dataCadastro
        ]);

        //SUCESSO
        return true;
    }

    public function atualizar() {
        return (new Database('pacientes'))->update('id = ' . $this->id, [
                    'nome' => $this->nome,
                    'data_nascimento' => $this->dataNascimento,
                    'sexo' => $this->sexo,
                    'telefone' => $this->telefone,
                    'email' => $this->email,
                    'endereco' => $this->endereco,
        ]);
    }

    public function excluir() {
        return (new Database('pacientes'))->delete('id = ' . $this->id);
    }

    public static function getPacienteById($id) {
        return self::getPacientes('id = ' . $id)->fetchObject(self::class);
    }

    public static function getPacientes($where = null, $order = null, $limit = null, $fields = '*') {
        return (new Database('pacientes'))->select($where, $order, $limit, $fields);
    }

}
