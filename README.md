# 📋 Laravel Task Manager

Um gerenciador de tarefas completo feito com **Laravel 12**, **Docker**, **MySQL**, **Tailwind CSS**, **Alpine.js** e exportação de relatórios em PDF/CSV.

## ✨ Principais funcionalidades

- ✍️ Autenticação com Laravel Breeze (registro, login, logout, reset de senha e verificação de e-mail)
- 🧑‍💼 Gestão de perfil do usuário (editar perfil, trocar senha, excluir conta)
- ✅ CRUD de tarefas com marcação de conclusão via dropdown
- 🗂️ Filtros por status e intervalo de datas
- 🧹 Limpeza com botão “Limpar Pesquisa”
- 🧾 Exportação de tarefas para CSV e PDF
- 🗳️ Paginação com preservação dos filtros
- ✅ Modal de confirmação para exclusão de tarefas (Alpine.js)

---

## 🚀 Pré-requisitos

- Docker & Docker Compose instalado
- Git
- (Opcional) Node.js + npm (para builds locais com Vite)

---

## 🧱 Executando o projeto localmente (modo Docker)

Clone e prepare o ambiente:

```bash
git clone https://github.com/behappyOS/laravel-task-manager.git
cd laravel-task-manager
docker-compose up -d --build
````

Dentro do container laravel_app, execute:

```bash
docker exec -it laravel_app bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
````

Se precisar compilar assets:

```bash
# Se tiver node instalado na máquina host:
npm install
npm run dev

# ou, dentro do container node (se configurado):
docker exec -it laravel_node bash
npm install
npm run dev
````
---

## 🌐 Acessando a aplicação
Frontend: http://localhost:8000

API Vite (desenvolvimento): http://localhost:5173

---

## 🧪 Testes
O projeto já inclui testes com PHPUnit para:

- Autenticação (registro, login, reset, e-verificação)

- Atualização de perfil

Execute os testes:

```bash
docker exec -it laravel_app bash
php artisan test
````

---

## 🛠️ Fluxo de uso

1.Registre-se ou faça login

2.Crie, edite ou exclua tarefas

3.Use os filtros no topo da lista:

- Status: Todos / Concluída / Pendente

- Intervalo de data

- Botão Limpar Pesquisa

4.Exporte sua lista com PDF ou CSV

5.Paginação automática, mantendo os filtros ativos

6.Modal confirma antes de excluir a tarefa

---

## 📃 Licença
MIT License – veja o arquivo LICENSE para detalhes.
