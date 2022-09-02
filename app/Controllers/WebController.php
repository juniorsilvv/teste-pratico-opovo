<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Journalist;
use CodeIgniter\API\ResponseTrait;

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
                "status" => 502,
                "message" => "Primeiro nome não informado"
            ]);
        }
        // validando se o last_name foi preenchido
        if(empty($data['last_name'])){
            return $this->respondDeleted([
                "status" => 502,
                "message" => "Sobrenome não informado"
            ]);
        }
        // validando se o email foi preenchido
        if(empty($data['email'])){
            return $this->respondDeleted([
                "status" => 502,
                "message" => "Email não informado"
            ]);
        }
        // validando se o email foi preenchido
        if(empty($data['password'])){
            return $this->respondDeleted([
                "status" => 502,
                "message" => "Senha não informado"
            ]);
        }
       
        // Verificando se o email informado já está cadastrado
        $exist_email = $this->journalist->where('email', $data['email'])->first();
        if($exist_email){
            return $this->respond([
                "message" => "Email já cadastrado"
            ], 422);
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
        //
    }
}
