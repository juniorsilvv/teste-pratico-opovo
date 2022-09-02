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
            return $this->respondDeleted([
                "status" => 422,
                "message" => "Primeiro nome não informado"
            ]);
        }
        // validando se o last_name foi preenchido
        if(empty($data['last_name'])){
            return $this->respondDeleted([
                "status" => 422,
                "message" => "Sobrenome não informado"
            ]);
        }
        // validando se o email foi preenchido
        if(empty($data['email'])){
            return $this->respondDeleted([
                "status" => 422,
                "message" => "Email não informado"
            ]);
        }
        // validando se o email foi preenchido
        if(empty($data['password'])){
            return $this->respondDeleted([
                "status" => 422,
                "message" => "Senha não informado"
            ]);
        }
       
        // Verificando se o email informado já está cadastrado
        $exist_email = $this->journalist->where('email', $data['email'])->first();
        if($exist_email){
            return $this->respondDeleted([
                "status" => 422,
                "message" => "Email já cadastrado"
            ]);
        }

        if(!$this->journalist->save($data)){
            return $this->respondDeleted([
                "status" => 502,
                "message" => "tudo ok"
            ]);
        }
        return $this->respondDeleted([
                "status" => 201,
                "message" => "Jornalista cadastrado com sucesso"
        ]);
    }
    public function login()
    {
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        if(empty($email)){
            return $this->respondDeleted([
                "status" => 422,
                "message" => "Email não informado"
            ]);
        }
        if(empty($password)){
            return $this->respondDeleted([
                "status" => 422,
                "message" => "Senha não informada"
            ]);
        }
        $exist_journalist = $this->journalist->where('email', $email)->first();
        if(!$exist_journalist || !password_verify($password, $exist_journalist['password'])){
            return $this->respondDeleted([
                "status" => 422,
                "message" => "Email ou senha inválidos"
            ]);
        }

        $payload = [
            'iss' => 'localhost',
            'aud' => 'localhost',
            'exp' => getenv('TOKEN_EXPIRE'),
            //dados do meu usuário
            'data' => [
                'user_id' => $exist_journalist['id'],
                'first_name' =>  $exist_journalist['first_name'],
                'last_name' =>  $exist_journalist['last_name']
            ]
        ];
        $token = JWT::encode($payload, getenv('TOKEN_SECRET_KEY'), 'HS256');
        return $this->respondDeleted([
            "status" => 200,
            "token" => $token,
            "message" => "Usuário logado com sucesso"
        ]);


    }
}
