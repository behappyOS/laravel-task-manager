# Laravel Task Manager

Um gerenciador de tarefas simples feito com Laravel 12, Docker e MySQL.

## Tecnologias

- Laravel 12
- PHP 8.2
- Docker
- MySQL
- Bootstrap

## Como rodar

```bash
git clone https://github.com/behappyOS/task-manager.git
cd task-manager
docker-compose up -d --build

# Instale as dependências
docker exec -it laravel_app bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
