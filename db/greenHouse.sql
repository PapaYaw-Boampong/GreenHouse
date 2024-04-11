-- Check if the database exists, create if not exists
CREATE DATABASE IF NOT EXISTS greenHouse;
USE greenHouse;

-- Create Users table
CREATE TABLE IF NOT EXISTS Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE,
    email VARCHAR(100) UNIQUE,
    password_hash VARCHAR(255),
    fname VARCHAR(50),
    lname VARCHAR(50),
    dob DATE,
    gender INT NOT NULL,
    bio TEXT,
    phone VARCHAR(20) NOT NULL,
    account_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login_at TIMESTAMP
);

-- Create Plants table
CREATE TABLE IF NOT EXISTS Plants (
    plant_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(100),
    species VARCHAR(100),
    description TEXT,
    personal_notes TEXT,
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE
);

-- Create Care_activities table
CREATE TABLE IF NOT EXISTS Care_activities (
    activity_id INT AUTO_INCREMENT PRIMARY KEY,
    activity_name VARCHAR(100) NOT NULL,
    custom INT,
    description TEXT,
    FOREIGN KEY (custom) REFERENCES Plants(plant_id) 
);

-- Create Plant_Care table
CREATE TABLE IF NOT EXISTS Plant_Care (
    activity_id INT NOT NULL,
    plant_id INT NOT NULL,
    FOREIGN KEY (activity_id) REFERENCES Care_activities(activity_id) ON DELETE CASCADE,
    FOREIGN KEY (plant_id) REFERENCES Plants(plant_id) ON DELETE CASCADE
);

-- Populate Care_activities table with basic types of plant care if not already populated
INSERT INTO Care_activities (activity_name, description, custom) VALUES 
    ('Watering', 'Provide water to the plant based on its needs.', NULL),
    ('Fertilizing', 'Supply essential nutrients to the plant to support growth.', NULL),
    ('Pruning', 'Remove dead or overgrown parts of the plant to promote healthy growth.', NULL),
    ('Repotting', 'Transfer the plant to a larger container to allow for continued growth.', NULL),
    ('Sunlight Exposure', 'Ensure the plant receives adequate sunlight for photosynthesis.', NULL),
    ('Pest Control', 'Monitor and manage pests to prevent damage to the plant.', NULL),
    ('Humidity Control', 'Maintain appropriate humidity levels to support plant health.', NULL);

-- Create Schedules table
CREATE TABLE IF NOT EXISTS Schedule (
    schedule_id INT AUTO_INCREMENT PRIMARY KEY,
    schedule_name VARCHAR(50)
);

-- Insert predefined schedules into the Schedules table
INSERT INTO Schedule (schedule_name) VALUES 
    ('Daily'),
    ('Weekly'),
    ('Monthly'),
    ('Yearly');

-- Create Task_Statuses table
CREATE TABLE IF NOT EXISTS Task_Statuses (
    status_id INT AUTO_INCREMENT PRIMARY KEY,
    status_name VARCHAR(20)
);

-- Insert predefined statuses into the Task_Statuses table
INSERT INTO Task_Statuses (status_name) VALUES 
    ('Complete'),
    ('Incomplete');

-- Create Tasks table
CREATE TABLE IF NOT EXISTS Tasks (
    task_id INT AUTO_INCREMENT PRIMARY KEY,
    plant_id INT,
    activity_id INT,
    schedule_id INT,
    status_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (plant_id) REFERENCES Plants(plant_id) ON DELETE CASCADE,
    FOREIGN KEY (activity_id) REFERENCES Care_activities(activity_id) ON DELETE CASCADE,
    FOREIGN KEY (schedule_id) REFERENCES Schedule(schedule_id),
    FOREIGN KEY (status_id) REFERENCES Task_Statuses(status_id)
);

-- Create Care_Stats table
CREATE TABLE IF NOT EXISTS Care_Stats (
    care_stat_id INT AUTO_INCREMENT PRIMARY KEY,
    task_id INT NOT NULL,
    activity_count INT NOT NULL DEFAULT 0,
    last_update_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (task_id) REFERENCES Tasks(task_id) ON DELETE CASCADE
);
