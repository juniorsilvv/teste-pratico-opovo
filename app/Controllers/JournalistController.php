<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Journalist;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JournalistController extends BaseController
{
    use ResponseTrait;
    protected $journalist;

    public function __construct()
    {
        $this->journalist = new Journalist();
    }

    public function journalistMe()
    {
        $key = getenv('TOKEN_SECRET_KEY');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        $token = null;
  
        // explode para ter acesso ao token
        if(!empty($header)) {
            if (preg_match('/Bearer\s(\S+)/', $header, $matches)) {
                $token = $matches[1];
            }
        }
        $jwt = JWT::decode($token, new Key($key, 'HS256'));
        $journalist = $this->journalist->find($jwt->data->user_id);

        return $this->respond([
            "email" => $journalist['email'],
            "first_name" => $journalist['first_name'],
            "last_name" => $journalist['last_name'],
        ], 200);
    }
}
