<?php

namespace App\Controller;

use App\Model\Entity\Consulta as EntityPagamento;
use \WilliamCosta\DatabaseManager\Pagination;

class Pagamento extends Api {

    private static function getPagamentoItems($request, &$obPagination) {
        $itens = [];

        //QUANTIDADE TOTAL DE REGISTRO
        $quantidadetotal = EntityPagamento::getPagamentos(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        //PAGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        //INSTANCIA DE PAGINAÇÃO
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 5);

        //RESULTADOS DA PÁGINA
        $results = EntityPagamento::getPagamentos(null, 'id DESC', $obPagination->getLimit());

        //RENDERIZA O ITEM
        while ($obPagamento = $results->fetchObject(EntityPagamento::class)) {
            $itens[] = [
                'id' => (int) $obPagamento->id,
                'id_consulta' => (int) $obPagamento->id_consulta,
                'valor' => $obPagamento->valor,
                'metodo_pagamento' => $obPagamento->metodo_pagamento,
                'status' => $obPagamento->status,
                'data_pagamento' => $obPagamento->data_pagamento,
            ];
        }

        return $itens;
    }

    public static function getPagamentos($request) {
        return[
            'pagamento' => self::getPagamentoItems($request, $obPagination),
            'paginacao' => parent::getPagination($request, $obPagination)
        ];
    }

    public static function getPagamento($request, $id) {
        if (!is_numeric($id)) {
            throw new \Exception("O id'" . $id . "' não é válido.", 400);
        }
        $obPagamento = EntityPagamento::getPagamentoById($id);

        if (!$obPagamento instanceof EntityPagamento) {
            throw new \Exception("O Pagamento " . $id . " não foi encontrado", 404);
        }

        return[
            'id' => (int) $obPagamento->id,
            'id_consulta' => (int) $obPagamento->id_consulta,
            'valor' => $obPagamento->valor,
            'metodo_pagamento' => $obPagamento->metodo_pagamento,
            'status' => $obPagamento->status,
            'data_pagamento' => $obPagamento->data_pagamento,
        ];
    }

    public static function setNewPagamento($request) {
        //POST VARS
        $postVars = $request->getPostVars();

        //VALIDA OS CAMPOS OBRIGÁTORIOS
        if (!isset($postVars['id_consulta']) or!isset($postVars['valor'])) {
            throw new \Exception("Os campos 'consulta' e 'valor' são obrigátorios", 400);
        }

        $obPagamento = new EntityPagamento;
        $obPagamento->idConsulta = $postVars['id_consulta'];
        $obPagamento->valor = $postVars['valor'];
        $obPagamento->metodoPagamento = $postVars['metodo_pagamento'];
        $obPagamento->status = $postVars['status'];
        $obPagamento->dataPagamento = $postVars['data_pagamento'];
        $obPagamento->cadastrar();

        return[
            'id' => (int) $obPagamento->id,
            'id_consulta' => (int) $obPagamento->id_consulta,
            'valor' => $obPagamento->valor,
            'metodo_pagamento' => $obPagamento->metodo_pagamento,
            'status' => $obPagamento->status,
            'data_pagamento' => $obPagamento->data_pagamento,
        ];
    }

    public static function setEditPagamento($request, $id) {
        //POST VARS
        $postVars = $request->getPostVars();

        //VALIDA OS CAMPOS OBRIGÁTORIOS
        if (!isset($postVars['id_consulta']) or!isset($postVars['valor'])) {
            throw new \Exception("Os campos 'consulta' e 'valor' são obrigátorios", 400);
        }

        $obPagamento = EntityPagamento::getPagamentoById($id);

        //VALIDA A INSTANCIA 
        if (!$obPagamento instanceof EntityPagamento) {
            throw new Exception("O Pagamento " . $id . " não foi encontrado", 404);
        }
        $obPagamento->idConsulta = $postVars['id_consulta'];
        $obPagamento->valor = $postVars['valor'];
        $obPagamento->metodoPagamento = $postVars['metodo_pagamento'];
        $obPagamento->status = $postVars['status'];
        $obPagamento->dataPagamento = $postVars['data_pagamento'];
        $obPagamento->atualizar();

        return[
            'id' => (int) $obPagamento->id,
            'id_consulta' => (int) $obPagamento->id_consulta,
            'valor' => $obPagamento->valor,
            'metodo_pagamento' => $obPagamento->metodo_pagamento,
            'status' => $obPagamento->status,
            'data_pagamento' => $obPagamento->data_pagamento,
        ];
    }

    public static function setDeletePagamento($request, $id) {

        $obPagamento = EntityPagamento::getConsultaById($id);

        //VALIDA A INSTANCIA 
        if (!$obPagamento instanceof EntityPagamento) {
            throw new \Exception("O Pagamento " . $id . " não foi encontrado", 404);
        }
        $obPagamento->excluir();

        //RETORNA OS SUCESSO DA EXCLUSÃO
        return[
            'sucesso' => true
        ];
    }

}
