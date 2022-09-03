<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Journalist;
use CodeIgniter\API\ResponseTrait;
use \Firebase\JWT\JWT;

class WebController extends BaseController
{
    use ResponseTrait;
    protected $journalist;
    public function __construct()
    {
        $this->journalist = new Journalist();
    }

    public function register()
    {
        $data = [
            "first_name" => $this->request->getVar('first_name'),
            "last_name"  => $this->request->getVar('last_name'),
            "email"      => $this->request->getVar('email'),
            "password"   => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
        ];
        
        // validando se o first_name foi preenchido
        if(empty($data['first_name'])){
            return $this->respond([
                "message" => "Primeiro nome não informado"
            ], 422);
        }
        // validando se o last_name foi preenchido
        if(empty($data['last_name'])){
            return $this->respond([
                "message" => "Sobrenome não informado"
            ], 422);
        }
        // validando se o email foi preenchido
        if(empty($data['email'])){
            return $this->respond([
                "message" => "Email não informado"
            ], 422);
        }
        // validando se o email foi preenchido
        if(empty($data['password'])){
            return $this->respond([
                "message" => "Senha não informado"
            ], 422);
        }
       
        // Verificando se o email informado já está cadastrado
        $exist_email = $this->journalist->where('email', $data['email'])->first();
        if($exist_email){
            return $this->respond([
                "message" => "Email já cadastrado"
            ], 422);
        }

        if(!$this->journalist->save($data)){
            return $this->respond([
                "message" => "Erro ao cadastrar jornalista"
            ], 502);
        }
        return $this->respondCreated([
                "message" => "Jornalista cadastrado com sucesso"
        ]);
    }
    public function login()
    {
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        //Verificando se email foi preenchido
        if(empty($email)){
            return $this->respond([
                "message" => "Email não informado"
            ], 422);
        }

        //Verificando se senha foi preenchido
        if(empty($password)){
            return $this->respond([
                "message" => "Senha não informada"
            ], 422);
        }

        //Verificando se existe algum usuário com o email informado e se a senha
        // é igual a informada
        $exist_journalist = $this->journalist->where('email', $email)->first();
        if(!$exist_journalist || !password_verify($password, $exist_journalist['password'])){
            return $this->respond([
                "status" => 422,
                "message" => "Email ou senha inválidos"
            ]);
        }

        $payload = [
            'iss' => 'localhost',
            'aud' => 'localhost',
            'iat' => time(),
            'nbf' => time(),
            'exp' => time() + getenv('TOKEN_EXPIRE'),
            //dados do usuário
            'data' => [
                'user_id' => $exist_journalist['id']
            ]
        ];
        $token = JWT::encode($payload, getenv('TOKEN_SECRET_KEY'), 'HS256');
        return $this->respond([
            "token" => $token,
            "message" => "Usuário logado com sucesso"
        ], 200);
    }
}
