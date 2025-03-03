<?php


namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;


class Consulta {
    public int $id;
    public int $idPaciente;
    public int $idMedico;
    public string $dataHora;
    public string $status;
    public string $observacoes;

    public function cadastrar() {
        $this->id = (new Database('consultas'))->insert([
            'id_paciente' => $this->idPaciente,
            'id_medico' => $this->idMedico,
            'data_hora' => $this->dataHora,
            'status' => $this->status,
            'observacoes' => $this->observacoes
        ]);
        return true;
    }

    public function atualizar() {
        return (new Database('consultas'))->update('id = ' . $this->id, [
            'id_paciente' => $this->idPaciente,
            'id_medico' => $this->idMedico,
            'data_hora' => $this->dataHora,
            'status' => $this->status,
            'observacoes' => $this->observacoes
        ]);
    }

    public function excluir() {
        return (new Database('consultas'))->delete('id = ' . $this->id);
    }

    public static function getConsultaById($id) {
        return self::getConsultas('id = ' . $id)->fetchObject(self::class);
    }

    public static function getConsultas($where = null, $order = null, $limit = null, $fields = '*') {
        return (new Database('consultas'))->select($where, $order, $limit, $fields);
    }
}
