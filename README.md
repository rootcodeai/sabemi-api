# Boilerplate Laravel 12 (Docker Custom Setup)

Este é um boilerplate Laravel 12 configurado com um ambiente Docker personalizado (substituindo o Laravel Sail) para desenvolvimento robusto e escalável.

## 🚀 Tecnologias e Serviços

O ambiente Docker é composto pelos seguintes serviços:

- **App**: PHP 8.4 (FPM)
- **Web Server**: Nginx
- **Database**: MySQL 8.0
- **Cache/Queue/Session**: Redis
- **Mail**: Mailpit (SMTP Testing)

## 🛠 Ferramentas Instaladas

- **Laravel Horizon**: Monitoramento de filas (Redis).
- **Laravel Telescope**: Debug e monitoramento da aplicação.
- **Laravel Pulse**: Monitoramento de performance e saúde do servidor.
- **Laravel Pint**: Padronização de código (PHP CS Fixer).

---

## 🔗 Endereços de Acesso

| Serviço | URL | Descrição |
|---------|-----|-----------|
| **Aplicação** | [http://localhost](http://localhost) | Home do projeto |
| **Telescope** | [http://localhost/telescope](http://localhost/telescope) | Dashboard de Debug |
| **Pulse** | [http://localhost/pulse](http://localhost/pulse) | Monitoramento de Performance |
| **Horizon** | [http://localhost/horizon](http://localhost/horizon) | Monitoramento de Filas |
| **Mailpit** | [http://localhost:8025](http://localhost:8025) | Caixa de entrada de emails (fake) |
| **API Docs** | [http://localhost/docs](http://localhost/docs) | Documentação da API (Scribe) |

---

## ⚙️ Comandos Principais

Todos os comandos devem ser executados através do `docker-compose` para garantir que rodem dentro do container.

### Gerenciamento do Ambiente

```bash
# Iniciar os containers (em background)
docker-compose up -d

# Parar os containers
docker-compose down

# Rebuildar os containers (caso altere Dockerfile)
docker-compose up -d --build
```

### Comandos Laravel (Artisan)

```bash
# Rodar migrações
docker-compose exec app php artisan migrate

# Limpar cache de configuração
docker-compose exec app php artisan config:clear

# Acessar o Tinker
docker-compose exec app php artisan tinker
```

### Ferramentas de Desenvolvimento

```bash
# Rodar o Pint (Formatar código)
docker-compose exec app ./vendor/bin/pint

# Rodar testes
docker-compose exec app php artisan test

# Instalar dependências (Composer)
docker-compose exec app composer install
```

### Filas e Monitoramento

O **Horizon** (filas) e o **Pulse** (monitoramento) são iniciados automaticamente junto com o container através do Supervisor.

Para verificar os processos em execução:

```bash
docker-compose exec app ps aux
```

---

## 📂 Estrutura Docker

- **.docker/php/Dockerfile**: Configuração da imagem PHP-FPM 8.4 (com extensões Redis, MySQL, etc).
- **.docker/nginx/nginx.conf**: Configuração do servidor Nginx.
- **docker-compose.yml**: Orquestração dos serviços.

## 📝 Instalação Inicial

1. Clone o repositório.
2. Copie o arquivo `.env.example` para `.env`:
   ```bash
   cp .env.example .env
   ```
3. Suba os containers:
   ```bash
   docker-compose up -d
   ```
4. Instale as dependências:
   ```bash
   docker-compose exec app composer install
   ```
5. Gere a chave da aplicação:
   ```bash
   docker-compose exec app php artisan key:generate
   ```
6. Rode as migrações:
   ```bash
   docker-compose exec app php artisan migrate
   ```
