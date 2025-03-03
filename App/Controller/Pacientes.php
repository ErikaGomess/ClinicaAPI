<?php

namespace App\Controller;

use App\Model\Entity\Paciente as EntityPaciente;
use \WilliamCosta\DatabaseManager\Pagination;
use App\Http\Request;

class Pacientes extends Api {

    private static function getPacientesItems($request, &$obPagination) {
        $itens = [];

        //QUANTIDADE TOTAL DE REGISTRO
        $quantidadetotal = EntityPaciente::getPacientes(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        //PAGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        //INSTANCIA DE PAGINAÇÃO
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 5);

        //RESULTADOS DA PÁGINA
        $results = EntityPaciente::getPacientes(null, 'id DESC', $obPagination->getLimit());

        //RENDERIZA O ITEM
        while ($obPaciente = $results->fetchObject(EntityPaciente::class)) {
            $itens[] = [
                'id' => (int) $obPaciente->id,
                'nome' => $obPaciente->nome,
                'data_nascimento' => $obPaciente->data_nascimento,
                'sexo' => $obPaciente->sexo,
                'teleone' => $obPaciente->telefone,
                'email' => $obPaciente->email,
                'endereco' => $obPaciente->endereco,
                'data_cadastro' => $obPaciente->data_cadastro,
            ];
        }

        return $itens;
    }

    public static function getPacientes($request) {
        return[
            'pacientes' => self::getPacientesItems($request, $obPagination),
            'paginacao' => parent::getPagination($request, $obPagination)
        ];
    }

    public static function getPaciente($request, $id) {
        if (!is_numeric($id)) {
            throw new \Exception("O id'" . $id . "' não é válido.", 400);
        }
        $obPaciente = EntityPaciente::getPacienteById($id);

        if (!$obPaciente instanceof EntityPaciente) {
            throw new \Exception("O paciente " . $id . " não foi encontrado", 404);
        }

        return[
            'id' => (int) $obPaciente->id,
            'nome' => $obPaciente->nome,
            'data_nascimento' => $obPaciente->data_nascimento,
            'sexo' => $obPaciente->sexo,
            'teleone' => $obPaciente->telefone,
            'email' => $obPaciente->email,
            'endereco' => $obPaciente->endereco,
            'data_cadastro' => $obPaciente->data_cadastro,
        ];
    }

    public static function setNewPaciente($request) {
        //POST VARS
        $postVars = $request->getPostVars();

        //VALIDA OS CAMPOS OBRIGÁTORIOS
        if (!isset($postVars['nome']) or!isset($postVars['data_nascimento'])) {
            throw new \Exception("Os campos 'nome' e 'data de nascimento' são obrigátorios", 400);
        }

        $obPaciente = new EntityPaciente();
        $obPaciente->nome = $postVars['nome'];
        $obPaciente->dataNascimento = $postVars['data_nascimento'];
        $obPaciente->sexo = $postVars['sexo'];
        $obPaciente->telefone = $postVars['telefone'];
        $obPaciente->email = $postVars['email'];
        $obPaciente->endereco = $postVars['endereco'];
        $obPaciente->dataCadastro = $postVars['data_cadastro'];
        $obPaciente->cadastrar();

        return[
            'id' => (int) $obPaciente->id,
            'nome' => $obPaciente->nome,
            'data_nascimento' => $obPaciente->dataNascimento,
            'sexo' => $obPaciente->sexo,
            'telefone' => $obPaciente->telefone,
            'email' => $obPaciente->email,
            'endereco' => $obPaciente->endereco,
            'data_cadastro' => $obPaciente->dataCadastro,
        ];
    }

    public static function setEditPaciente($request, $id) {
        //POST VARS
        $postVars = $request->getPostVars();

        //VALIDA OS CAMPOS OBRIGÁTORIOS
        if (!isset($postVars['nome']) or!isset($postVars['data_nascimento'])) {
            throw new \Exception("Os campos 'nome' e 'data de nascimento' são obrigátorios", 400);
        }

        $obPaciente = EntityPaciente::getPacienteById($id);

        //VALIDA A INSTANCIA 
        if (!$obPaciente instanceof EntityPaciente) {
            throw new Exception("O Paciente " . $id . " não foi encontrado", 404);
        }
        $obPaciente->nome = $postVars['nome'];
        $obPaciente->dataNascimento = $postVars['data_nascimento'];
        $obPaciente->sexo = $postVars['sexo'];
        $obPaciente->telefone = $postVars['telefone'];
        $obPaciente->email = $postVars['email'];
        $obPaciente->endereco = $postVars['endereco'];
        $obPaciente->dataCadastro = $postVars['data_cadastro'];
        $obPaciente->atualizar();

        return[
            'id' => (int) $obPaciente->id,
            'nome' => $obPaciente->nome,
            'data_nascimento' => $obPaciente->dataNascimento,
            'sexo' => $obPaciente->sexo,
            'telefone' => $obPaciente->telefone,
            'email' => $obPaciente->email,
            'endereco' => $obPaciente->endereco,
            'data_cadastro' => $obPaciente->dataCadastro,
        ];
    }

    
    public static function setDeletePaciente($request, $id) {
        
        $obPaciente = EntityPaciente::getPacienteById($id);

        //VALIDA A INSTANCIA 
        if (!$obPaciente instanceof EntityPaciente) {
            throw new \Exception("O paciente " . $id . " não foi encontrado", 404);
        }
        //EXCLUI O DEPOIMENTO
        $obPaciente->excluir();

        //RETORNA OS SUCESSO DA EXCLUSÃO
        return[
            'sucesso' => true
        ];
    }

}
