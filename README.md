# 📌 Projeto de Livraria com Laravel

## 📖 Sobre o Projeto

Este projeto é um sistema de catálogo e avaliação de livros utilizando Laravel. Ele permite que os leitores avaliem os livros com suas opiniões e pontuação. O sistema também permite a visualização de livros para não usuários mas exige criação de conta para outras funcionalidades.

Usuários administradores podem cadastrar novos livros, categorias e autores e esconder comentários.

## 🛠️ Tecnologias Utilizadas

- **PHP 7.4**
- **Laravel 7**
- **PostgreSQL**
- **Blade Templates** (Frontend integrado ao Laravel)
- **Bootstrap** (para estilização básica)

## 🚀 Como Configurar e Executar o Projeto

### 1️⃣ Clonar o Repositório

```bash
git clone https://github.com/andressa-mb/Prova--Cadastro-de-Livros.git
cd prova
```

### 2️⃣ Instalar Dependências

```bash
composer install
```

### 3️⃣ Configurar a Base de Dados

Renomeie o arquivo **.env.example** para **.env** e configure suas credenciais do banco de dados:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=seu_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

### 4️⃣ Gerar Chave da Aplicação

```bash
php artisan key:generate
```

### 5️⃣ Executar as Migrações do Banco de Dados

```bash
php artisan migrate
```

### 6️⃣ Rodar o Servidor

```bash
php artisan serve
```

Acesse [**http://127.0.0.1:8000**](http://127.0.0.1:8000) no navegador.

---

## ✨ Como Inserir Dados na Base

Copie o conteúdo do arquivo livraria.sql para a query tool do PGAdmin e execute.&#x20;

Pode também ser restaurado usando psql.

