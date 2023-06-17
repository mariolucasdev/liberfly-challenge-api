# Libertfly Challenge API

## 💻 Sobre o projeto

O projecto contém uma Api RESTFul desenvolvida em PHP com o framework Laravel,

## ⚠️ Requisitos do Projeto

-   Laravel 10
-   PHP ^8.1
-   MySQL ^5.6
-   Composer ^2.5

## 🧰 Ferramenta para Teste de Requisições HTTP

-   Swagger com a biblioteca L5 Swagger

## 🏗️ Instalação

### Clone o repositório para o seu computador e acesse a pasta do projeto:

```
//clone
git clone https://github.com/mariolucasdev/gpm-challenge-backend.git

//acesso a pasta
cd gpm-challenge-backend
```

### Renomeie o arquivo .env.example para .env na raiz do projeto e configure seu banco de dados:

Crie um bando de dados, para menos configurações nomeie seu banco de dados como _gpm_challenge_backend_ e conclua as configurações do seu .env.

```php
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gpm_challenge_backend //nome do seu banco de dados
DB_USERNAME=root
DB_PASSWORD=
```

### Instale as dependências do composer:

```
composer install
ou
composer install -q --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist
```

### Gere sua chave da aplicação:

```php
php artisan key:generate
```

### Instale as dependências package.json

```
npm install
```

### Execute as migrações do banco de dados e os seeders:

```
php artisan migrate --seed
```

### Execute o servidor:

```
php artisan serve
```

Seguido todo os passos agora você conseguirá acessar os recursos da api, através dos enpoints abaixo.

## Api Endoints

## **Marcas**

| Método | Endpoint   | Parâmetros | Descrição              | Retorno |
| ------ | ---------- | ---------- | ---------------------- | ------- |
| `GET`  | api/brands | ---        | Busca lista de marcas. | 200     |

## _GET - api/brands_

```javascript
// Headers
// Content-Type: application/json
// Accept: application/json

// Retorno
{
    "data": [
        {
            "id": 1,
            "name": "Electrolux"
        },
        {...},
        {...}
    ]
}
```

## **Eletrodomésticos**

| Método   | Endpoint          | Parâmetros                                   | Descrição                         | Status          |
| -------- | ----------------- | -------------------------------------------- | --------------------------------- | --------------- |
| `POST`   | api/appliance     | name, description, eletric_tension, brand_id | Busca lista de marcas.            | 201 or 422      |
| `GET`    | api/appliance     | ------                                       | Listagem de Eletrodomésticos.     | 200             |
| `GET`    | api/appliance/:id | ------                                       | Exibir 1 eletrodoméstico pelo id. | 200 ou 404      |
| `PUT`    | api/appliance/:id | name, description, eletric_tension, brand_id | Editar eletrodoméstico.           | 200, 404 or 422 |
| `DELETE` | api/appliance/:id | ------                                       | Excluir um Eletrodomésticos.      | 200 ou 404      |

## _POST - api/appliance_

```javascript
// Headers
// Content-Type: application/json
// Accept: application/json

// Envio
{
	"name" : "Geladeira Frost Free",
	"description": "Produto versátil.",
	"eletric_tension" : "220v",
	"brand_id" : 2
}

// Retorno
{
	"id": 72,
	"name": "Geladeira Frost Free",
	"description": "Produto versátil.",
	"eletric_tension": "220v",
	"brand_id": 2,
	"created_at": "2023-06-14 17:33:11",
	"updated_at": "2023-06-14 17:33:11",
	"brand": "Brastemp"
}
```

## _GET - api/appliance_

```javascript
// Headers
// Accept: application/json

// Retorno
[
    {
		"id": 42,
		"name": "Geladeira Frost Free",
		"description": "Produto versátil.",
		"eletric_tension": "220v",
		"brand_id": 1,
		"created_at": "2023-06-14 10:43:50",
		"updated_at": "2023-06-14 10:43:50",
		"brand": "Electrolux"
	},
    {...},
    {...}
]
```

## _GET - api/appliance/:id_

```javascript
// Headers
// Accept: application/json

// Retorno
{
	"id": 68,
	"name": "Geladeira Frost Free",
	"description": "Produto versátil.",
	"eletric_tension": "220v",
	"brand_id": 2,
	"created_at": "2023-06-14 14:15:44",
	"updated_at": "2023-06-14 14:15:44",
	"brand": "Brastemp"
}
```

## _PUT - api/appliance/:id_

```javascript
// Headers
// Content-Type: application/json
// Accept: application/json

// Envio
{
	"name" : "Cooktop",
	"description": "05 bocas.",
	"eletric_tension" : "110v",
	"brand_id" : 5
}

// Retorno
{
	"id": 67,
	"name": "Cooktop",
	"description": "05 bocas.",
	"eletric_tension": "110v",
	"brand_id": 5,
	"created_at": "2023-06-14 14:14:32",
	"updated_at": "2023-06-14 14:14:50",
	"brand": "LG"
}
```

## _DELETE - api/appliance/:id_

receberá um status 200 caso tenha corrido tudo bem ou 404 caso não exista o id no banco de dados.

## 🧪 Execução de Testes

### Teste de unidade:

```
php artisan test --parallel
```

### Teste de análise estática

```
vendor/bin/phpstan analyse
```

### Teste de estilo de código

```
vendor/bin/pint --test
```
