<?php

namespace App\Http\Middleware;
use \App\Model\Entity\User;
\Firebase\JWT\JWT;

class JWTAuth {

    /**
     * Método responsável por retornar uma instancia de usuários auntenticado
     * @param Request $request
     * @return User
     */
    private function getJWTAuthUser($request){
        //HEADERS
        $headers = $request->getHeaders($request);
        
       
     
        //TOKEN PURO EM JWT
        $jwt = isset($headers['Authorization']) ? str_replace('Bearer','',$headers['Authorization']) : '';
        
        try {
             //DECODE
             $decode = (array)JWT::decode($jwt,getenv('JWT_KEY'),['HS256']);
        } catch (\Exception $e) {
            throw new $e("Token inválido",403);
        }
        
        //EMAIL
        $email = $decode['email'] ?? '';
        
        
        //BUSCA O USUÁRIO PELO E-MAIL
        $obUser = User::getUsersByEmail($_SERVER['PHP_AUTH_USER']);
        
        //RETORNA O USUÁRIO
        return $obUser instanceof User ? $obUser : false;
    }
    /**
     * Método responsável por validar o acesso via JWT
     * @param Request $request
     * @return boolean
     * @throws \Exception
     */
    private function auth($request){
        //VERIFICAR O USUÁRIO RECEBIDO
        if($obUser = $this->getJWTAuthUser($request)){
            $request->user = $obUser;
            return true;
        }
        throw new \Exception("Acesso negado",403);
    }
    /**
     * Método responsável por executar o middleware
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle($request, $next) {
        //REALIZA A VALIDAÇÃO DO ACESSO JWT
        $this->auth($request);
        
        //EXECUTA O PRÓXIMO NÍVEL DO MIDDLEWARE
        return $next($request);
    }

}
