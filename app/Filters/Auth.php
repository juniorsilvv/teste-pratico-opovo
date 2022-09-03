<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use CodeIgniter\API\ResponseTrait;

class Auth implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    use ResponseTrait;
    public function before(RequestInterface $request, $arguments = null)
    {
        $key = getenv('TOKEN_SECRET_KEY');
        $header = $request->getServer('HTTP_AUTHORIZATION');
        $token = null;
  
        // explode para ter acesso ao token
        if(!empty($header)) {
            if (preg_match('/Bearer\s(\S+)/', $header, $matches)) {
                $token = $matches[1];
            }
        }
        $response = service('response');


        //verificando se o token é nulo
        if(is_null($token) || empty($token)) {
            $response->setBody('Acesso Negado');
            $response->setStatusCode(401);
            return $response;
        }

  
        try {
            // Cria uma sessão com os dados do jwt para poder ter o user_id do jornalista
            $_SESSION['token_jwt'] = JWT::decode($token, new Key($key, 'HS256'));
        } catch (\Exception $ex) {
            $response->setBody('Acesso Negado');
            $response->setStatusCode(401);
            return $response;
        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //limpar sessão
        unset($_SESSION['token_jwt']);
    }
}
