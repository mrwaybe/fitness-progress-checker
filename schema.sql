CREATE DATABASE IF NOT EXISTS fitness_tracker;
USE fitness_tracker;

-- Fulfills the "in-app page for showing the introductions" requirement
CREATE TABLE team_members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    role VARCHAR(100),
    bio TEXT
);

-- Core Application Entities
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    target_weight DECIMAL(5,2)
);

CREATE TABLE fitness_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    log_date DATE NOT NULL,
    weight DECIMAL(5,2) NOT NULL,
    height DECIMAL(5,2) NOT NULL,
    bmi DECIMAL(4,2),
    bmi_category VARCHAR(50),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE daily_macros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    log_date DATE NOT NULL,
    protein_g INT DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Insert the mandatory team member data
INSERT INTO team_members (name, role, bio) VALUES
('Miguel Angel Wells Viasus', 'Backend Developer', 'Responsible for PHP development, MariaDB schema, and RPi Zero 2W deployment.'),
('Wayne', 'Frontend Developer', 'Responsible for HTML/UI implementation and CSS styling.'),
('Ben', 'QA & Documentation', 'Responsible for testing, documentation, and presentation materials.');

-- Insert a default user to allow immediate logging without a separate registration system
INSERT INTO users (username, target_weight) VALUES ('DefaultUser', 70.00);