<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\News;
use App\Models\NewsType;
use CodeIgniter\API\ResponseTrait;

class NewsTypeController extends BaseController
{
    use ResponseTrait;
    protected $type_news;
    public function __construct()
    {
        $this->type_news = new NewsType();
    }

    public function newsTypeMe()
    {
       $types = $this->type_news->where('journalist_id', $_SESSION['token_jwt']->data->user_id)->findAll();
       return $this->respond($types, 200);
    }
    
    public function create()
    {
        $data = [
            "journalist_id" => $_SESSION['token_jwt']->data->user_id,
            "type_name" => $this->request->getVar('type_name')
        ];

        //Verificando se o tipo de notícia foi informado
        if(empty($data['type_name'])){
            return $this->respond([
                "message" => "Tipo de notícia não informado"
            ], 422);
        }
        //Verificando se o tipo de notícia já esta cadastrado para o jornalista informado
        if($this->type_news->where('type_name', $data['type_name'])->where('journalist_id', $data['journalist_id'])->first()){
            return $this->respond([
                "message" => "Tipo de notícia já cadastrado"
            ], 422);
        }

        //Verificando se houve algum erro na inserção do registro
        if(!$this->type_news->save($data)){
            return $this->respond([
                "message" => "Erro ao cadastrar registro"
            ], 502);
        }
        return $this->respondCreated([
                "message" => "Registro cadastrado com sucesso"
        ]);
        
    }

    public function update(int $id)
    {
        $data = [
            "journalist_id" => $_SESSION['token_jwt']->data->user_id,
            "type_name" => $this->request->getVar('type_name')
        ];
        // verifica se tipo de noticia foi informado
        if(empty($data['type_name'])){
            return $this->respond([
                "message" => "Tipo de notícia não informado"
            ], 422);
        }

        // Verificando se o usuário não irá alterar o tipo da noticia para uma já existente
        if($this->type_news->where('type_name', $data['type_name'])->where('journalist_id', $data['journalist_id'])->first()){
            return $this->respond([
                "message" => "Tipo de notícia já cadastrado"
            ], 422);
        }

        //Verificando se houve algum erro na alteração do registro
        if(!$this->type_news->update($id, $data)){
            return $this->respond([
                "message" => "Erro ao alterar registro"
            ], 502);
        }
        return $this->respondUpdated([
                "message" => "Registro alterado com sucesso"
        ]);
    }

    public function delete(int $id)
    {
        //Verificando se o tipo de noticia pertence ao usuário logado
        if(!$this->type_news->where('journalist_id', $_SESSION['token_jwt']->data->user_id)->where('id', $id)->first()){
            return $this->respond([
                "message" => "Não é possível excluír esse tipo de notícia"
            ], 422);
        }

        //Verificando se não tem nenhuma notícia associada a esse tipo de notícia
        if((new News)->where('news_type_id', $id)->find()){
            return $this->respond([
                "message" => "Não é possível excluír esse tipo de notícia pois ela possuí notíciais associada"
            ], 422);
        }

        //Verificando se houve algum erro na deletar o registro
        if(!$this->type_news->delete($id)){
            return $this->respond([
                "message" => "Erro ao deletar registro"
            ], 502);
        }
        return $this->respondDeleted([
            "message" => "Registro deletado com sucesso"
        ], 502);
    }
}