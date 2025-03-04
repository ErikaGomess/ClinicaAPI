<?php

namespace App\Controller;

use App\Model\Entity\Consulta as EntityConsulta;
use \WilliamCosta\DatabaseManager\Pagination;

class Consultas extends Api {

    private static function getConsultasItems($request, &$obPagination) {
        $itens = [];

        //QUANTIDADE TOTAL DE REGISTRO
        $quantidadetotal = EntityConsulta::getConsultas(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        //PAGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        //INSTANCIA DE PAGINAÇÃO
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 5);

        //RESULTADOS DA PÁGINA
        $results = EntityConsulta::getConsultas(null, 'id DESC', $obPagination->getLimit());

        //RENDERIZA O ITEM
        while ($obConsulta = $results->fetchObject(EntityConsulta::class)) {
            $itens[] = [
                'id' => (int) $obConsulta->id,
                'id_paciente' => (int) $obConsulta->id_paciente,
                'id_medico' => (int) $obConsulta->id_medico,
                'data_hora' => $obConsulta->data_hora,
                'status' => $obConsulta->status,
                'observacoes' => $obConsulta->observacoes,
            ];
        }

        return $itens;
    }

    public static function getConsultas($request) {
        return[
            'consultas' => self::getConsultasItems($request, $obPagination),
            'paginacao' => parent::getPagination($request, $obPagination)
        ];
    }

    public static function getConsulta($request, $id) {
        if (!is_numeric($id)) {
            throw new \Exception("O id'" . $id . "' não é válido.", 400);
        }
        $obConsulta = EntityConsulta::getConsultaById($id);

        if (!$obConsulta instanceof EntityConsulta) {
            throw new \Exception("A consulta " . $id . " não foi encontrada", 404);
        }

        return[
            'id' => (int) $obConsulta->id,
            'id_paciente' => (int) $obConsulta->id_paciente,
            'id_medico' => (int) $obConsulta->id_medico,
            'data_hora' => $obConsulta->data_hora,
            'status' => $obConsulta->status,
            'observacoes' => $obConsulta->observacoes,
        ];
    }

    public static function setNewConsulta($request) {
        //POST VARS
        $postVars = $request->getPostVars();

        //VALIDA OS CAMPOS OBRIGÁTORIOS
        if (!isset($postVars['nome']) or!isset($postVars['data_nascimento'])) {
            throw new \Exception("Os campos 'nome' e 'data de nascimento' são obrigátorios", 400);
        }

        $obConsulta = new EntityConsulta;
        $obConsulta->idPaciente = $postVars['idPaciente'];
        $obConsulta->idMedico = $postVars['idMedico'];
        $obConsulta->dataHora = $postVars['data_hora'];
        $obConsulta->status = $postVars['status'];
        $obConsulta->observacoes = $postVars['observacoes'];
        $obConsulta->cadastrar();

        return[
            'id' => (int) $obConsulta->id,
            'id_paciente' => (int) $obConsulta->id_paciente,
            'id_medico' => (int) $obConsulta->id_medico,
            'data_hora' => $obConsulta->data_hora,
            'status' => $obConsulta->status,
            'observacoes' => $obConsulta->observacoes,
        ];
    }

    public static function setEditConsulta($request, $id) {
        //POST VARS
        $postVars = $request->getPostVars();

        //VALIDA OS CAMPOS OBRIGÁTORIOS
        if (!isset($postVars['nome']) or!isset($postVars['data_nascimento'])) {
            throw new \Exception("Os campos 'nome' e 'data de nascimento' são obrigátorios", 400);
        }

        $obConsulta = EntityConsulta::getPacienteById($id);

        //VALIDA A INSTANCIA 
        if (!$obConsulta instanceof EntityConsulta) {
            throw new Exception("A Consulta " . $id . " não foi encontrada", 404);
        }
        $obConsulta->idPaciente = $postVars['idPaciente'];
        $obConsulta->idMedico = $postVars['idMedico'];
        $obConsulta->dataHora = $postVars['data_hora'];
        $obConsulta->status = $postVars['status'];
        $obConsulta->observacoes = $postVars['observacoes'];
        $obConsulta->atualizar();

        return[
            'id' => (int) $obConsulta->id,
            'id_paciente' => (int) $obConsulta->id_paciente,
            'id_medico' => (int) $obConsulta->id_medico,
            'data_hora' => $obConsulta->data_hora,
            'status' => $obConsulta->status,
            'observacoes' => $obConsulta->observacoes,
        ];
    }

    public static function setDeleteConsulta($request, $id) {

        $obConsulta = EntityConsulta::getConsultaById($id);

        //VALIDA A INSTANCIA 
        if (!$obConsulta instanceof EntityConsulta) {
            throw new \Exception("A consulta " . $id . " não foi encontrada", 404);
        }
        $obConsulta->excluir();

        //RETORNA OS SUCESSO DA EXCLUSÃO
        return[
            'sucesso' => true
        ];
    }

}
