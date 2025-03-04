<?php

namespace App\Controller;

use App\Model\Entity\Especialidade as EntityEspecialidade;
use \WilliamCosta\DatabaseManager\Pagination;

class Especialidades extends Api {

    private static function getEspecialidadesItems($request, &$obPagination) {
        $itens = [];

        //QUANTIDADE TOTAL DE REGISTRO
        $quantidadetotal = EntityEspecialidade::getEspecialidades(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        //PAGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        //INSTANCIA DE PAGINAÇÃO
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 5);

        //RESULTADOS DA PÁGINA
        $results = EntityEspecialidade::getEspecialidades(null, 'id DESC', $obPagination->getLimit());

        //RENDERIZA O ITEM
        while ($obEspecialidade = $results->fetchObject(EntityEspecialidade::class)) {
            $itens[] = [
                'id' => (int) $obEspecialidade->id,
                'nome' => $obEspecialidade->nome,
            ];
        }

        return $itens;
    }

    public static function getEspecialidades($request) {
        return[
            'especialidades' => self::getEspecialidadesItems($request, $obPagination),
            'paginacao' => parent::getPagination($request, $obPagination)
        ];
    }

    public static function getEspecialidade($request, $id) {
        if (!is_numeric($id)) {
            throw new \Exception("O id'" . $id . "' não é válido.", 400);
        }
        $obEspecialidade = EntityEspecialidade::getEspecialidadeById($id);

        if (!$obEspecialidade instanceof EntityEspecialidade) {
            throw new \Exception("A especialidade " . $id . " não foi encontrada", 404);
        }

        return[
            'id' => (int) $obEspecialidade->id,
            'nome' => $obEspecialidade->nome,
            
        ];
    }

    public static function setNewEspecialidade($request) {
        //POST VARS
        $postVars = $request->getPostVars();

        //VALIDA OS CAMPOS OBRIGÁTORIOS
        if (!isset($postVars['nome'])) {
            throw new \Exception("Os campos 'nome' é obrigátorios", 400);
        }

        $obEspecialidade = new EntityEspecialidade;
        $obEspecialidade->id = $postVars['id'];
        $obEspecialidade->nome = $postVars['nome'];
        $obEspecialidade->cadastrar();

        return[
            'id' => (int) $obEspecialidade->id,
            'nome' => $obEspecialidade->nome,
        ];
    }

    public static function setEditEspecialidade($request, $id) {
        //POST VARS
        $postVars = $request->getPostVars();

        //VALIDA OS CAMPOS OBRIGÁTORIOS
        if (!isset($postVars['nome'])) {
            throw new \Exception("Os campos 'nome' é obrigátorios", 400);
        }

        $obEspecialidade = EntityEspecialidade::getEspecialidadeById($id);

        //VALIDA A INSTANCIA 
        if (!$obEspecialidade instanceof EntityEspecialidade) {
            throw new Exception("A Especialidade " . $id . " não foi encontrada", 404);
        }
        $obEspecialidade->idPaciente = $postVars['id'];
        $obEspecialidade->nome = $postVars['nome'];
        $obEspecialidade->atualizar();

        return[
            'id' => (int) $obEspecialidade->id,
            'nome' => $obEspecialidade->nome,
           
        ];
    }

    public static function setDeleteEspecialidade($request, $id) {

        $obEspecialidade = EntityEspecialidade::getConsultaById($id);

        //VALIDA A INSTANCIA 
        if (!$obEspecialidade instanceof EntityEspecialidade) {
            throw new \Exception("A consulta " . $id . " não foi encontrada", 404);
        }
        $obEspecialidade->excluir();

        //RETORNA OS SUCESSO DA EXCLUSÃO
        return[
            'sucesso' => true
        ];
    }

}
