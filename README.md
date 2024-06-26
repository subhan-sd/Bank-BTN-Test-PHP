# Task Manager

This is a simple task manager application built with PHP and MySQL.

## Screenshot

![Screenshot](Screenshot.jpeg)

## Requirements

- PHP (version 7 or above) recomended PHP version 8.2.4
- MySQL (version 5.6 or above) recomended version 10.4.28
- Any web server software (e.g., Apache, Nginx)

## Setup Instructions

1. Clone the repository or download the source code.

2. Create a MySQL database named "task_manager".

3. Import the SQL file to create the tasks table:

   ```sql
   CREATE DATABASE task_manager;

   USE task_manager;

   CREATE TABLE tasks (
       id INT AUTO_INCREMENT PRIMARY KEY,
       title VARCHAR(255) NOT NULL,
       description TEXT NOT NULL,
       status ENUM('Pending', 'In Progress', 'Completed') DEFAULT 'Pending',
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
       updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
   );
   ```

4. Or u can import database in directory Database

5. Update `config.php` with your database connection details.

6. Place the files in your web server's root directory.

7. Open your web browser and navigate to the location where you placed the files (e.g., `http://localhost/[your directory]/index.php`).

## App Description

The Task Manager app allows you to manage tasks with the following features:

- Add a new task with a title and description.
- Display a list of existing tasks with their title and status.
- Update the status of each task.
- Search tasks by title and filter by status.

## Testing the App

- Add a new task by filling out the form and clicking "Add Task".
- Update a task's status by clicking the corresponding links.
- Search for tasks by entering a title and/or selecting a status from the dropdown and clicking "Search".
