<?php

namespace App\Controller;

use App\Model\Entity\Usuario as EntityUsuario;
use \WilliamCosta\DatabaseManager\Pagination;

class Usuarios extends Api {

    private static function getUsuariosItems($request, &$obPagination) {
        $itens = [];

        //QUANTIDADE TOTAL DE REGISTRO
        $quantidadetotal = EntityUsuario::getUsuarios(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        //PAGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        //INSTANCIA DE PAGINAÇÃO
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 5);

        //RESULTADOS DA PÁGINA
        $results = EntityUsuario::getUsuarios(null, 'id DESC', $obPagination->getLimit());

        //RENDERIZA O ITEM
        while ($obUsuario = $results->fetchObject(EntityUsuario::class)) {
            $itens[] = [
                'id' => (int) $obUsuario->id,
                'nome' => $obUsuario->nome,
                'email' => $obUsuario->email,
                'senha_hash' => $obUsuario->senha_hash,
                'tipo' => $obUsuario->status,
            ];
        }

        return $itens;
    }

    public static function getUsuarios($request) {
        return[
            'usuarios' => self::getUsuariosItems($request, $obPagination),
            'paginacao' => parent::getPagination($request, $obPagination)
        ];
    }

    public static function getConsulta($request, $id) {
        if (!is_numeric($id)) {
            throw new \Exception("O id'" . $id . "' não é válido.", 400);
        }
        $obUsuario = EntityUsuario::getUsuarioById($id);

        if (!$obUsuario instanceof EntityUsuario) {
            throw new \Exception("O usuario " . $id . " não foi encontrado", 404);
        }


        return[
            'id' => (int) $obUsuario->id,
            'nome' => $obUsuario->nome,
            'email' => $obUsuario->email,
            'senha_hash' => $obUsuario->senha_hash,
            'tipo' => $obUsuario->tipo,
        ];
    }

    public static function setNewUsuario($request) {
        //POST VARS
        $postVars = $request->getPostVars();

        //VALIDA OS CAMPOS OBRIGÁTORIOS
        if (!isset($postVars['nome']) or!isset($postVars['email'])) {
            throw new \Exception("Os campos 'nome' e 'email' são obrigátorios", 400);
        }

        $obUsuario = new EntityUsuario;
        $obUsuario->nome = $postVars['nome'];
        $obUsuario->email = $postVars['email'];
        $obUsuario->senha = $postVars['senha'];
        $obUsuario->tipo = $postVars['status'];
        $obUsuario->cadastrar();

        return[
            'id' => (int) $obUsuario->id,
            'nome' => $obUsuario->nome,
            'email' => $obUsuario->email,
            'senha_hash' => $obUsuario->senha_hash,
            'tipo' => $obUsuario->tipo,
        ];
    }

    public static function setEditUsuario($request, $id) {
        //POST VARS
        $postVars = $request->getPostVars();

        //VALIDA OS CAMPOS OBRIGÁTORIOS
        if (!isset($postVars['nome']) or!isset($postVars['email'])) {
            throw new \Exception("Os campos 'nome' e 'data de nascimento' são obrigátorios", 400);
        }

        $obUsuario = EntityUsuario::getUsuarioById($id);

        //VALIDA A INSTANCIA 
        if (!$obUsuario instanceof EntityUsuario) {
            throw new Exception("O Usuário " . $id . " não foi encontrado", 404);
        }
        $obUsuario->nome = $postVars['nome'];
        $obUsuario->email = $postVars['email'];
        $obUsuario->senha = $postVars['senha'];
        $obUsuario->tipo = $postVars['status'];
        $obUsuario->atualizar();

        return[
            'id' => (int) $obUsuario->id,
            'nome' => $obUsuario->nome,
            'email' => $obUsuario->email,
            'senha_hash' => $obUsuario->senha_hash,
            'tipo' => $obUsuario->tipo,
        ];
    }

    public static function setDeleteUsuario($request, $id) {

        $obUsuario = EntityUsuario::getUsuarioById($id);

        //VALIDA A INSTANCIA 
        if (!$obUsuario instanceof EntityUsuario) {
            throw new \Exception("O usuário " . $id . " não foi encontrado", 404);
        }
        $obUsuario->excluir();

        //RETORNA OS SUCESSO DA EXCLUSÃO
        return[
            'sucesso' => true
        ];
    }

}
