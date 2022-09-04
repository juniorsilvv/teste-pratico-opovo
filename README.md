# Configuração Teste Prático Desenvolvedor Back-end iV Grupo O Povo

## Configurações iniciais

Execute o comando `composer install` para o composer instalar as dependências necessárias

Renomei o arquivo `env_exemples` para `.env` .

Crie o banco de dados e adicione as crendenciais no arquivo .env na sessão marcada como DATABASE.

Realize as migrações.
    Abra a pasta do projeto no terminal e execute o seguinte comando:
        `php spark migrate`


Para iniciar a aplicação execute `php spark serve`

# Dados a serem enviado.

### Cadastro:
* first_name  `Obrigátorio`
* last_name   `Obrigátorio`
* email       `Obrigátorio`
* password    `Obrigátorio`

### Login
* email  `Obrigátorio`
* passord  `Obrigátorio`

### Cadastro Tipo de Notícia
* type_name   `Obrigátorio`

### Cadastro Notícias
* news_type_id  `Obrigátorio`
* title  `Obrigátorio`
* description  `Obrigátorio`
* news_body  `Obrigátorio`
* featured_image  `Opcional`


# Controllers

## WebController
* Responsável pelas rotas que não necessitam de autenticação para serem acessadas  Login & Registro  

## JournalistController
* Responsável por retornar os dados do jornalista

## NewsTypeController
* Responsável pelo `crud` do tipo de notícia 

## NewsController
* Responsável pelo `crud` das notícia 

# Models And Tables
*  Journalist `journalist`  
*  NewsType `news_type`  
*  News `news`

# Middleware
* Auth.php responsável pela validação das requisições `App/Filter/Auth`

# Rotas
* POST /api/register  `Rota de cadastro de jornalista`
* POST /api/login  `Rota de login de jornalista`
* GET /api/me  `Retorna os dados do jornalista`
* GET /api/type/me  `Retorna os tipos de noticias`
* POST /api/type/create  `Rota de cadastro dos tipos de notícias`
* PUT /api/type/update/  `Rota de alteração dos tipos de notícias. OBS: necessário informar o id`
* DELETE /api/type/delete/  `Rota de delete dos tipos de notícias. OBS: necessário informar o id`
* GET /api/news/me  `Retornas todas as notícias do jornalista`
* GET /api/news/me/  `Retorna todas as noticias por tipo de noticia do jornalista. OBS: necessário informar o id`
* POST /api/news/create  `Rota de cadastro das noticias`
* PUT /api/news/update/  `Rota de alteração das notícias. OBS: necessário informar o id`
* DELETE /news/type/delete/  `Rota de delete das notícias. OBS: necessário informar o id`








