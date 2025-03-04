# Todo App

This is a simple Todo application built with PHP and MySQL.

## Features

- Add new tasks
- Delete existing tasks
- List all tasks

## Requirements

- PHP 7.4 or higher
- MySQL
- Composer (for dependency management)

## Installation

1. Clone the repository:

    ```sh
    git clone https://github.com/dansarpong/todo-php.git todo-app
    cd todo-app
    ```

2. Install dependencies:

    ```sh
    composer install
    ```

3. Create a `.env` file in the root directory and add your database configuration:

    ```env
    DATABASE_HOST=localhost
    DATABASE_PORT=3306
    DATABASE_NAME=todo
    DATABASE_USER=user
    DATABASE_PASSWORD=password
    ```

4. Run the application:

    ```sh
    php -S localhost:8000
    ```

5. Open your browser and navigate to `http://localhost:8000`.

## Usage

- To add a new task, enter the task in the input field and click "Add".
- To delete a task, click the "Delete" button next to the task.
