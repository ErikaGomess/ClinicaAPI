<?php

namespace App\Controller;

use App\Model\Entity\Medico as EntityMedico;
use \WilliamCosta\DatabaseManager\Pagination;

class Medicos extends Api {

    private static function getMedicosItems($request, &$obPagination) {
        $itens = [];

        //QUANTIDADE TOTAL DE REGISTRO
        $quantidadetotal = EntityMedico::getMedicos(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        //PAGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        //INSTANCIA DE PAGINAÇÃO
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 5);

        //RESULTADOS DA PÁGINA
        $results = EntityMedico::getMedicos(null, 'id DESC', $obPagination->getLimit());

        //RENDERIZA O ITEM
        while ($obMedico = $results->fetchObject(EntityMedico::class)) {
            $itens[] = [
                'id' => (int) $obMedico->id,
                'nome' => $obMedico->nome,
                'crm' => $obMedico->crm,
                'telefone' => $obMedico->telefone,
                'email' => $obMedico->email,
                'id_especialidade' => (int) $obMedico->id_especialidade,
            ];
        }

        return $itens;
    }

    public static function getMedicos($request) {
        return[
            'medicos' => self::getMedicosItems($request, $obPagination),
            'paginacao' => parent::getPagination($request, $obPagination)
        ];
    }

    public static function getMedico($request, $id) {
        if (!is_numeric($id)) {
            throw new \Exception("O id'" . $id . "' não é válido.", 400);
        }
        $obMedico = EntityMedico::getMedicoById($id);

        if (!$obMedico instanceof EntityMedico) {
            throw new \Exception("O médico " . $id . " não foi encontrado", 404);
        }

        return[
            'id' => (int) $obMedico->id,
            'nome' => $obMedico->nome,
            'crm' => $obMedico->crm,
            'telefone' => $obMedico->telefone,
            'email' => $obMedico->email,
            'id_especialidade' => (int) $obMedico->id_especialidade,
        ];
    }

    public static function setNewMedico($request) {
        //POST VARS
        $postVars = $request->getPostVars();

        //VALIDA OS CAMPOS OBRIGÁTORIOS
        if (!isset($postVars['nome']) or!isset($postVars['crm'])) {
            throw new \Exception("Os campos 'nome' e 'crm' são obrigátorios", 400);
        }

        $obMedico = new EntityMedico;
        $obMedico->nome = $postVars['nome']; 
        $obMedico->crm = $postVars['crm'];
        $obMedico->telefone = $postVars['telefone'];
        $obMedico->email = $postVars['email'];
        $obMedico->id_especialidade = $postVars['id_especialidade'];
        $obMedico->cadastrar();

        return[
            'id' => (int)$obMedico->id,
            'nome' => $obMedico->nome,
            'crm' => $obMedico->crm,
            'telefone' => $obMedico->telefone,
            'email' => $obMedico->email,
            'id_especialidade' => $obMedico->id_especialidade,
        ];
    }

    public static function setEditMedico($request, $id) {
        //POST VARS
        $postVars = $request->getPostVars();

        //VALIDA OS CAMPOS OBRIGÁTORIOS
        if (!isset($postVars['nome']) or!isset($postVars['crm'])) {
            throw new \Exception("Os campos 'Nome' e 'CRM' são obrigátorios", 400);
        }

        $obMedico = EntityMedico::getPacienteById($id);

        //VALIDA A INSTANCIA 
        if (!$obMedico instanceof EntityMedico) {
            throw new Exception("O Médico " . $id . " não foi encontrada", 404);
        }
        
        $obMedico->nome = $postVars['nome']; 
        $obMedico->crm = $postVars['crm'];
        $obMedico->telefone = $postVars['telefone'];
        $obMedico->email = $postVars['email'];
        $obMedico->id_especialidade = $postVars['id_especialidade'];
        $obMedico->atualizar();

        return[
            'id' => (int)$obMedico->id,
            'nome' => $obMedico->nome,
            'crm' => $obMedico->crm,
            'telefone' => $obMedico->telefone,
            'email' => $obMedico->email,
            'id_especialidade' => $obMedico->id_especialidade,
        ];
    }

    public static function setDeleteMedico($request, $id) {

        $obMedico = EntityMedico::getMedicoById($id);

        //VALIDA A INSTANCIA 
        if (!$obMedico instanceof EntityMedico) {
            throw new \Exception("O médico " . $id . " não foi encontrado", 404);
        }
        $obMedico->excluir();

        //RETORNA OS SUCESSO DA EXCLUSÃO
        return[
            'sucesso' => true
        ];
    }

}
