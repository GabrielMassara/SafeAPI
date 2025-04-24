
# 📦 API REST em PHP com PostgreSQL + JWT

Este projeto é uma API REST completa desenvolvida em **PHP puro** com **PostgreSQL**, totalmente funcional **sem o uso do Composer**, com autenticação via **JWT (JSON Web Tokens)** e suporte para múltiplos usuários.

---

## 🚀 Tecnologias Utilizadas

- PHP 8.2 (modo embutido via `php -S`)
- PostgreSQL 15
- JWT (implementado manualmente, sem Composer)
- Docker e Docker Compose
- DBeaver (sugerido para visualização do banco de dados)
- PGAdmin (opcional via `phpmyadmin`/`pgadmin4` container)

---

## 📂 Estrutura do Projeto

```
rest-api-php/
├── config/              # Configuração da conexão com o banco de dados
├── controllers/         # Lógica dos endpoints (UserController, AuthController)
├── models/              # Modelo User (com persistência no PostgreSQL)
├── routes/              # Roteamento principal
├── middleware/          # Validação do token JWT
├── utils/               # Funções auxiliares (JWT manual)
├── sql/init.sql         # Script para criar e popular o banco
├── Dockerfile           # Build do container PHP
├── docker-compose.yml   # Orquestração dos containers
└── index.php            # Ponto de entrada principal
```

---

## 🔧 Como Executar

### 1. Requisitos

- Docker + Docker Compose

### 2. Clonar o projeto

```bash
git clone https://github.com/seuusuario/rest-api-php-postgres.git
cd rest-api-php-postgres
```

### 3. Subir os containers

```bash
docker-compose up --build
```

A API estará disponível em:  
📍 `http://localhost:8000`

---

## 📚 Endpoints da API

### 🔐 Autenticação

#### `POST /api/login`
Autentica o usuário e retorna um token JWT.

**Body JSON:**

```json
{
  "email": "admin@example.com",
  "password": "123456"
}
```

**Resposta:**
```json
{
  "token": "eyJhbGciOi..."
}
```

---

### 👤 Usuários

#### `POST /api/users`
📌 **Cadastro de novo usuário (sem autenticação)**

```json
{
  "name": "Maria",
  "email": "maria@example.com",
  "password": "senha123"
}
```

---

#### `GET /api/users`
🔐 **Listar todos os usuários (requer token)**

```http
Authorization: Bearer SEU_TOKEN
```

---

#### `GET /api/users/{id}`
🔐 **Obter usuário por ID**

---

#### `PUT /api/users/{id}`
🔐 **Atualizar usuário**

```json
{
  "name": "Novo Nome",
  "email": "novo@email.com"
}
```

---

#### `DELETE /api/users/{id}`
🔐 **Excluir usuário**

---

## 🔑 Segurança: JWT

- Os tokens JWT são gerados no login.
- Enviados no cabeçalho de cada requisição autenticada:

```http
Authorization: Bearer SEU_TOKEN_AQUI
```

- Tempo de expiração: 1 hora
- Validação feita manualmente via HMAC-SHA256

---

## 🧪 Testes com `curl`

#### Criar usuário:

```bash
curl -X POST http://localhost:8000/api/users   -H "Content-Type: application/json"   -d '{"name": "Gabriel", "email": "gabriel@exemplo.com", "password": "123456"}'
```

#### Login:

```bash
curl -X POST http://localhost:8000/api/login   -H "Content-Type: application/json"   -d '{"email": "gabriel@exemplo.com", "password": "123456"}'
```

#### Listar usuários com token:

```bash
curl http://localhost:8000/api/users   -H "Authorization: Bearer SEU_TOKEN_AQUI"
```

---

## 🧠 Acesso ao Banco (opcional)

Você pode acessar o banco via DBeaver ou PGAdmin:

| Campo     | Valor            |
|-----------|------------------|
| Host      | localhost         |
| Porta     | 5432             |
| Banco     | meubanco         |
| Usuário   | meuusuario       |
| Senha     | senhasegura      |

> Certifique-se de que a porta 5432 está mapeada no `docker-compose.yml`.

---

## 🛡️ Validação e Erros

- Campos obrigatórios são validados no backend
- Mensagens de erro são retornadas em JSON com os códigos HTTP corretos:
  - `400` Campos ausentes
  - `401` Não autenticado
  - `409` E-mail duplicado
  - `404` Usuário não encontrado

---

## 📌 Considerações

- Este projeto é ideal como base para APIs em PHP simples e seguras
- JWT é implementado manualmente, sem bibliotecas externas
- Pode ser facilmente estendido para incluir controle de permissões, logs, e-mail de recuperação, etc.

---

## 📥 Contribuições

Sinta-se à vontade para sugerir melhorias, abrir PRs e relatar issues.

---

## 🧑‍💻 Autor

Desenvolvido por [Seu Nome] – _open source with ❤️_
