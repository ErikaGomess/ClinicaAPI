<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class Prontuario {

    public int $id;
    public int $idPaciente;
    public int $idConsulta;
    public string $diagnostico;
    public string $prescricao;
    public string $dataRegistro;

    public function cadastrar() {
        $this->id = (new Database('prontuarios'))->insert([
            'id_paciente' => $this->idPaciente,
            'id_consulta' => $this->idConsulta,
            'diagnostico' => $this->diagnostico,
            'prescricao' => $this->prescricao,
            'data_registro' => $this->registro
        ]);
        return true;
    }

    public function atualizar() {
        return (new Database('prontuarios'))->update('id = ' . $this->id, [
                    'id_paciente' => $this->idPaciente,
                    'id_consulta' => $this->idConsulta,
                    'diagnostico' => $this->diagnostico,
                    'prescricao' => $this->prescricao,
                    'data_registro' => $this->registro
        ]);
    }

    public function excluir() {
        return (new Database('prontuarios'))->delete('id = ' . $this->id);
    }

    public static function getProntuarioById($id) {
        return self::getProntuarios('id = ' . $id)->fetchObject(self::class);
    }

    public static function getProntuarios($where = null, $order = null, $limit = null, $fields = '*') {
        return (new Database('prontuarios'))->select($where, $order, $limit, $fields);
    }

}
