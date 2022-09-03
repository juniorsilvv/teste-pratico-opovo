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
        $journalist = $this->journalist->find($_SESSION['token_jwt']->data->user_id);
        return $this->respond([
            "email" => $journalist['email'],
            "first_name" => $journalist['first_name'],
            "last_name" => $journalist['last_name'],
        ], 200);
    }
}
