
# :fire: Transaction Challenge


Esse é um mini projeto que simula a transação entre dois usuários.

* **[Sobre](#sobre)**
* **[Instalação](#instalação)**
* **[Tests](#tests)**
* **[Documentação](#documentação)**

## Sobre

#### Requisitos

Para o projeto funcionar na sua maquina é necessário que o:

- **[Docker](https://www.docker.com/)** esteja instalado.
- **[docker-compose](https://docs.docker.com/compose/)** esteja instalado.

#### Containers

| Containers             | Sobre                | Port |
|-----------------------|----------------------|------|
| **nginx** | `nginx:1.15.0-alpine` | 8000 |
| **app** | `php:8.0.3-fpm-alpine3.13` | - |
| **db** | `mysql:5.7` | - |
| **phpmyadmin** | `phpmyadmin/phpmyadmin:5.0.2` | 8080 |

## Instalação

#### setup:

```bash
# Clonar
$ git clone https://github.com/lucasmatsui/transaction-challenge.git

# Renomear .env.example para .env
$ cp src/.env.example src/.env

# Buildar os containers
$ docker-compose up -d --build
```

## Tests

```bash
# Acessar o container do app
$ docker exec -it app bash

# Acessar a pasta do framework
$ cd src/

# Rodar o phpunit
$ ./vendor/bin/phpunit
```

## Documentação

3 usuários são criados por padrão no banco de dados.

```bash
Roberto
- id : 49585f0b-ffdf-4cdc-aebe-a1bb2eed771b
- id_type: 1 (Customer)

Fernando
- id : ad2b411f-685e-4676-82bf-d0003cc43d19
- id_type: 1 (Customer)

Lucas
- id : 93c1bc56-b6ac-489a-aa7f-97c014ae8e3b
- id_type: 2 (Shopkeepper)
```
Rotas disponíveis:

```bash
GET /users/id

200 OK: 
{
  "id": "49585f0b-ffdf-4cdc-aebe-a1bb2eed771b",
  "name": "Roberto",
  "cpf": "230.302.92-09",
  "cnpj": "670.222.45-23",
  "email": "XThhvHu35D@gmail.com",
  "balance": "3200.00",
  "type": 1
}
```

```bash
POST /transaction
{
  "payer":"49585f0b-ffdf-4cdc-aebe-a1bb2eed771b",
  "payee": "ad2b411f-685e-4676-82bf-d0003cc43d19",
  "amount": 200.00
}

200 OK:
{
  "message": "Transferencia feita com sucesso",
  "code": 200
}
```

### Envio de email

Quando é feita uma transferência com sucesso é adicionado a uma fila de disparo de email.

### supervisor

Roda no container do **app** atualmente com 5 workers para processar as filas.

### Modelagem
![Screenshot](https://user-images.githubusercontent.com/31348487/119587783-c35f7a80-bda5-11eb-8e54-57215d313b8f.png)

