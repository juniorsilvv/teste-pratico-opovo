# Configuração Teste Prático Desenvolvedor Back-end iV Grupo O Povo

## Configurações iniciais

Execute o comando `composer install` para o composer instalar as dependências necessárias

Renomei o arquivo `env_exemples` para `.env` .

Crie o banco de dados e adicione as crendenciais no arquivo .env na sessão marcada como DATABASE.

Realize as migrações.
    Abra a pasta do projeto no terminal e execute o seguinte comando:
        `php spark migrate`


Para iniciar a aplicação execute `php spark serve`