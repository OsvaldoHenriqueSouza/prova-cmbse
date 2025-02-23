# Sistema de Gerenciamento de Produtos e Categorias

Este projeto é um sistema simples de gerenciamento de Produtos, onde cada produto pertence a uma Categoria. O objetivo é demonstrar a implementação de um CRUD completo e a correta utilização dos relacionamentos entre modelos.

## Funcionalidades

- **Categorias**:
    - Criar, visualizar, editar e excluir categorias.
    - Cada categoria possui um nome e uma descrição.

- **Produtos**:
    - Criar, visualizar, editar e excluir produtos.
    - Cada produto possui um nome, descrição, preço, quantidade e está associado a uma categoria.

- **Relacionamentos**:
    - Um produto pertence a uma categoria.
    - Uma categoria pode ter vários produtos.

## Tecnologias Utilizadas

- **Backend**:
    - Laravel (PHP).
    - Eloquent ORM.
    - Migrations.

- **Frontend**:
    - Blade Templates para a interface do usuário.
    - Bootstrap para estilização e layout responsivo.

- **Banco de Dados**:
    - PostgreSQL para armazenamento de dados.

- **Ferramentas**:
    - Docker para conteinerização e ambiente de desenvolvimento.

## Como Executar o Projeto

1. **Clone o repositório**:
   ```bash
   https://github.com/OsvaldoHenriqueSouza/prova-cmbse.git
   cd prova-cmbse
   ```
   
2. **Suba os contêineres**:
   ```bash
   docker-compose up -d --build
   ```
   
3. **Acesse o contêiner da aplicação**:
   ```bash
    docker exec -it laravel_app bash
    ```
   
4. **Execute as migrações**:
    ```bash
    php artisan migrate
    ```
   
5. **Popule o banco com os dados iniciais**:
    ```bash
    php artisan db:seed
    ```
   
6. **Acesse a aplicação**:
7. **Acesse a aplicação**:
   - Acesse a aplicação em [http://localhost:8099]

## Testes

Para executar os testes, acesse o contêiner da aplicação e execute o comando:
```bash
php artisan test
```


