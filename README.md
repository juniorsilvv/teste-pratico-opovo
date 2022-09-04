# Configuração Teste Prático Desenvolvedor Back-end iV Grupo O Povo

## Configurações iniciais

Execute o comando `composer install` para o composer instalar as dependências necessárias

Renomei o arquivo `env_exemples` para `.env` .

Crie o banco de dados e adicione as crendenciais no arquivo .env na sessão marcada como DATABASE.

Realize as migrações.
    Abra a pasta do projeto no terminal e execute o seguinte comando:
        `php spark migrate`


Para iniciar a aplicação execute `php spark serve`

# Dados a ser enviado.

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





