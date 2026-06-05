# Installation Guide

### Prerequisites
* Raspberry Pi Zero 2W running a headless Linux distribution (e.g., DietPi or Raspberry Pi OS Lite).
* Temporary internet connection for initial package installation.

### 1. Install Server Components
Run the following commands in the terminal to install the HTTP server, PHP scripting engine, and MariaDB database:
`sudo apt update`
`sudo apt install nginx php-fpm php-mysql mariadb-server git -y`

### 2. Configure the Database
Secure the database installation and create the necessary application database and user:
`sudo mysql_secure_installation`
`sudo mysql -u root -p`
`CREATE DATABASE fitness_tracker;`
`CREATE USER 'fitness_user'@'localhost' IDENTIFIED BY 'secure_password';`
`GRANT ALL PRIVILEGES ON fitness_tracker.* TO 'fitness_user'@'localhost';`
`FLUSH PRIVILEGES;`
`EXIT;`

### 3. Deploy the Source Code
Navigate to the web root directory and clone the repository:
`cd /var/www/html`
`sudo git clone https://github.com/mrwaybe/fitness-progress-checker.git .`

### 4. Import the Database Schema
Load the table structures from the repository into MariaDB:
`sudo mysql -u fitness_user -p fitness_tracker < schema.sql`

### 5. Finalize Configuration
Edit the `db.php` file to ensure the connection string utilizes the `fitness_tracker` database and the credentials created in Step 2.