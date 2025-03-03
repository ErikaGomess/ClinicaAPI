<?php

namespace App\Http\Middleware;
use \App\Model\Entity\User;

class UserBasicAuth {

    /**
     * Método responsável por retornar uma instancia de usuários auntenticado
     * @return User
     */
    private function getBasicAuthUser(){
        //VERIFICAR A EXISTÊNCIA DOS DADOS DE ACESSO
        if(!isset($_SERVER['PHP_AUTH_USER']) or !isset($_SERVER['PHP_AUTH_PW'])){
            return false;
        }
        //BUSCA O USUÁRIO PELO E-MAIL
        $obUser = User::getUserByEmail($_SERVER['PHP_AUTH_USER']);
        
        //VERIFICA A INSTÂNCIA
        if(!$obUser instanceof User){
            return false;
        }
        //SUCESSO
        return password_verify($_SERVER['PHP_AUTH_PW'],$obUser->senha) ? $obUser : false;
    }
    /**
     * Método responsável por validar o acesso via HTTP BASIC AUTH
     * @param Request $request
     * @return boolean
     * @throws \Exception
     */
    private function basicAuth($request){
        //VERIFICAR O USUÁRIO RECEBIDO
        if($obUser = $this->getBasicAuthUser()){
            $request->user = $obUser;
            return true;
        }
        throw new \Exception("Usuário ou senha inválidos",403);
    }
    /**
     * Método responsável por executar o middleware
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle($request, $next) {
        //REALIZA A VALIDAÇÃO DO ACESSO VIA BASIC AUTH
        $this->basicAuth($request);
        
        //EXECUTA O PRÓXIMO NÍVEL DO MIDDLEWARE
        return $next($request);
    }

}
