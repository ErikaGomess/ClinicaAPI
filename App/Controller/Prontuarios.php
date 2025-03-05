<?php

namespace App\Controller;

use App\Model\Entity\Prontuario as EntityProntuario;
use \WilliamCosta\DatabaseManager\Pagination;

class Prontuarios extends Api {

    private static function getProntuariosItems($request, &$obPagination) {
        $itens = [];

        //QUANTIDADE TOTAL DE REGISTRO
        $quantidadetotal = EntityProntuario::getProntuarios(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        //PAGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        //INSTANCIA DE PAGINAÇÃO
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 5);

        //RESULTADOS DA PÁGINA
        $results = EntityProntuario::getProntuarios(null, 'id DESC', $obPagination->getLimit());

        //RENDERIZA O ITEM
        while ($obProntuario = $results->fetchObject(EntityProntuario::class)) {
            $itens[] = [
                'id' => (int) $obProntuario->id,
                'id_paciente' => (int) $obProntuario->id_paciente,
                'id_consulta' => (int) $obProntuario->id_consulta,
                'diagnostico' => $obProntuario->diagnostico,
                'prescricao' => $obProntuario->prescricao,
                'data_registro' => $obProntuario->data_registro,
            ];
        }

        return $itens;
    }

    public static function getProntuarios($request) {
        return[
            'prontuarios' => self::getProntuariosItems($request, $obPagination),
            'paginacao' => parent::getPagination($request, $obPagination)
        ];
    }

    public static function getProntuario($request, $id) {
        if (!is_numeric($id)) {
            throw new \Exception("O id'" . $id . "' não é válido.", 400);
        }
        $obProntuario = EntityProntuario::getProntuarioById($id);

        if (!$obProntuario instanceof EntityProntuario) {
            throw new \Exception("O prontuário " . $id . " não foi encontrado", 404);
        }

        return[
            'id' => (int) $obProntuario->id,
            'id_paciente' => (int) $obProntuario->id_paciente,
            'id_consulta' => (int) $obProntuario->id_consulta,
            'diagnostico' => $obProntuario->diagnostico,
            'prescricao' => $obProntuario->prescricao,
            'data_registro' => $obProntuario->data_registro,
        ];
    }

    public static function setNewPronturio($request) {
        //POST VARS
        $postVars = $request->getPostVars();

        //VALIDA OS CAMPOS OBRIGÁTORIOS
        if (!isset($postVars['id_paciente']) or!isset($postVars['id_consulta'])) {
            throw new \Exception("Os campos 'paciente' e 'consulta' são obrigátorios", 400);
        }

        $obProntuario = new EntityProntuario;
        $obProntuario->idPaciente = $postVars['idPaciente'];
        $obProntuario->idConsulta = $postVars['idConsulta'];
        $obProntuario->diagnostico = $postVars['diagnostico'];
        $obProntuario->prescricao = $postVars['prescricao'];
        $obProntuario->dataRegistro = $postVars['dataRegistro'];
        $obProntuario->cadastrar();

        return[
            'id' => (int) $obProntuario->id,
            'id_paciente' => (int) $obProntuario->id_paciente,
            'id_consulta' => (int) $obProntuario->id_consulta,
            'diagnostico' => $obProntuario->diagnostico,
            'prescricao' => $obProntuario->prescricao,
            'data_registro' => $obProntuario->data_registro,
        ];
    }

    public static function setEditProntuario($request, $id) {
        //POST VARS
        $postVars = $request->getPostVars();

        //VALIDA OS CAMPOS OBRIGÁTORIOS
        if (!isset($postVars['nome']) or!isset($postVars['data_nascimento'])) {
            throw new \Exception("Os campos 'nome' e 'data de nascimento' são obrigátorios", 400);
        }

        $obProntuario = EntityProntuario::getProntuarioById($id);

        //VALIDA A INSTANCIA 
        if (!$obProntuario instanceof EntityProntuario) {
            throw new Exception("O Prontuario " . $id . " não foi encontrada", 404);
        }
        $obProntuario->idPaciente = $postVars['idPaciente'];
        $obProntuario->idConsulta = $postVars['idConsulta'];
        $obProntuario->diagnostico = $postVars['diagnostico'];
        $obProntuario->prescricao = $postVars['prescricao'];
        $obProntuario->dataRegistro = $postVars['dataRegistro'];
        $obProntuario->atualizar();

        return[
            'id' => (int) $obProntuario->id,
            'id_paciente' => (int) $obProntuario->id_paciente,
            'id_consulta' => (int) $obProntuario->id_consulta,
            'diagnostico' => $obProntuario->diagnostico,
            'prescricao' => $obProntuario->prescricao,
            'data_registro' => $obProntuario->data_registro,
        ];
    }

    public static function setDeleteProntuario($request, $id) {

        $obProntuario = EntityProntuario::getProntuarioById($id);

        //VALIDA A INSTANCIA 
        if (!$obProntuario instanceof EntityProntuario) {
            throw new \Exception("O Prontuário " . $id . " não foi encontrado", 404);
        }
        $obProntuario->excluir();

        //RETORNA OS SUCESSO DA EXCLUSÃO
        return[
            'sucesso' => true
        ];
    }

}
