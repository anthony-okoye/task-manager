# Laravel Task Manager

A simple Laravel-based task management app with drag-and-drop reordering and project-based task filtering.

## Features
- Create, edit, and delete tasks.
- Reorder tasks with drag-and-drop.
- Assign tasks to projects.
- Filter tasks by project.
- Styled with Tailwind CSS.
- Unit tested with PHPUnit.

## Installation

### 1. Clone the repository
```sh
git clone https://github.com/anthony-okoye/task-manager.git
cd task-manager

### 2. Install dependencies

composer install
npm install && npm run dev

### 3. Configure the environment

change the .env.example to .env and change the details below in the .env to suit your database connection 

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_manager
DB_USERNAME=root
DB_PASSWORD=

### 4. Run database migrations
php artisan migrate

### 5. Start the development server
php artisan serve

Navigate to the link shown on the console
