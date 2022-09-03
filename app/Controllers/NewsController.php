<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\News;
use CodeIgniter\API\ResponseTrait;

class NewsController extends BaseController
{
    use ResponseTrait;
    protected $news;
    public function __construct()
    {
        $this->news = new News();
    }
    public function newsMe()
    {
        //Retorna todas as notícias do jornalista
        $news = $this->news->where('journalist_id', $_SESSION['token_jwt']->data->user_id)->findAll();
        return $this->respond($news, 200);
    }
    public function newsTypeMe(int $id)
    {
        $news = $this->news->where('journalist_id', 
        $_SESSION['token_jwt']->data->user_id)->where('news_type_id', $id)->findAll();
        return $this->respond($news, 200);
    }
    public function create()
    {
        $data = [
            "journalist_id" => $_SESSION['token_jwt']->data->user_id,
            "news_type_id" => $this->request->getVar('news_type_id'),
            "title" => $this->request->getVar('title'),
            "description" => $this->request->getVar('description'),
            "news_body" => $this->request->getVar('news_body'), 
            "featured_image" => $this->request->getVar('featured_image')
        ];

        //Verificando se o tipo de notícia foi informado
        if(empty($data['news_type_id'])){
            return $this->respond([
                "message" => 'Tipo de notícia não informado'
            ],422);
        }
        //Verificando se o título foi informado
        if(empty($data['title'])){
            return $this->respond([
                "message" => 'Título da notícia não informado'
            ],422);
        }
        //Verificando se o descrição foi informado
        if(empty($data['description'])){
            return $this->respond([
                "message" => 'Descrição da notícia não informado'
            ],422);
        }
        //Verificando se o notícia foi informado
        if(empty($data['description'])){
            return $this->respond([
                "message" => 'Notícia não informado'
            ],422);
        }

        //Verificando se houve algum erro ao cadastrar a notícia
        if(!$this->news->save($data)){
            return $this->respond([
                "message" => 'Erro ao cadastrar notícia'
            ],502);
        }
        return $this->respondCreated([
            "message" => 'Notícia cadastrada com sucesso'
        ]);
    }
    public function update(int $id)
    {
        $data = [
            "news_type_id" => $this->request->getVar('news_type_id'),
            "title" => $this->request->getVar('title'),
            "description" => $this->request->getVar('description'),
            "news_body" => $this->request->getVar('news_body'), 
            "featured_image" => $this->request->getVar('featured_image')
        ];

        //Verificando se o tipo de notícia foi informado
        if(empty($data['news_type_id'])){
            return $this->respond([
                "message" => 'Tipo de notícia não informado'
            ],422);
        }
        //Verificando se o título foi informado
        if(empty($data['title'])){
            return $this->respond([
                "message" => 'Título da notícia não informado'
            ],422);
        }
        //Verificando se o descrição foi informado
        if(empty($data['description'])){
            return $this->respond([
                "message" => 'Descrição da notícia não informado'
            ],422);
        }
        //Verificando se o notícia foi informado
        if(empty($data['description'])){
            return $this->respond([
                "message" => 'Notícia não informado'
            ],422);
        }
        //Verificando se houve algum erro ao alterar a notícia
        if(!$this->news->update($id, $data)){
            return $this->respond([
                "message" => 'Erro ao aletrar notícia'
            ],502);
        }
        return $this->respondUpdated([
            "message" => 'Notícia alterada com sucesso'
        ]);
    }

    public function delete(int $id)
    {
         //Verificando se houve algum erro na deletar o registro
         if(!$this->news->delete($id)){
            return $this->respond([
                "message" => "Erro ao deletar registro"
            ], 502);
        }
        return $this->respondDeleted([
            "message" => "Registro deletado com sucesso"
        ]);
    }

}
