# Oblivia  
**Gamify Your Life**  
Oblivia is a to-do list web application that transforms task management into a gamified experience.  

## Description  
Oblivia is a PHP-based web application that allows users to manage their tasks efficiently. The platform supports user authentication, task management, and data import/export functionalities.  

## Features  
- **User Authentication**: Register, log in, and log out functionality.  
- **Task Management**: Add, update, delete, and view tasks.  
- **Data Import/Export**: Export tasks to a file and import tasks from external sources.  
- **Gamified Experience**: Enhance productivity by making task management engaging.  

## Project Structure  
/Oblivia
│── /Assets # CSS, JS, images, and external libraries
│── /controllers # PHP controllers handling user and task logic
│── /models # Data models for users and tasks
│── /Views # HTML views for different pages
│── index.php # Main entry point
│── config.php # Configuration settings
│── README.md # Project documentation

## Requirements  
To run this project, you need:  
- PHP 7.4 or later  
- MySQL or MariaDB  
- Web server (Apache, Nginx, or built-in PHP server)  

## Installation  
1. Clone the repository:  
   ```sh
   git clone https://github.com/your-repo/Oblivia.git
   cd Oblivia
2. Configure the database:
  Create a database.
  Import the provided SQL file (if available).
3. Start a local server:
  `php -S localhost:8000`
4. Open http://localhost:8000 in a web browser.

## How It Works

Users can register and log in.

Once logged in, they can add, update, delete, and view tasks.

Users can import and export tasks for better data management.

The UI dynamically updates based on the login state.


## Screenshots
- List
  ![ToDoList](assets/images/5.png)  

## Technologies Used

- Frontend: HTML, CSS (Bootstrap), JavaScript

- Backend: PHP, MySQL

- Libraries: FontAwesome, Swiper, jQuery

## Author

Jan Kowalski (KoowalDev)