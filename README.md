# Fitness Progress Checker

## Project Description

Fitness Progress Checker is a simple web application that helps users calculate their Body Mass Index (BMI) and track their fitness progress over time.

Users can enter their height, weight, and basic information. The system calculates their BMI, shows their BMI category, and saves their fitness records in a database. Users can also view previous progress logs to see how their weight and BMI change over time.

This project is designed as a lightweight PHP and MariaDB web application that can run on a Raspberry Pi Zero 2W.

## Target Users

The target users are students or individuals who want a simple way to check their BMI and monitor fitness progress.

## Main Features

- Calculate BMI using height and weight
- Show BMI category
- Save fitness progress records
- View previous fitness logs
- Track weight changes over time
- Set a target weight goal
- Display contributor information

## Technologies Used

- PHP
- MariaDB
- HTML
- CSS
- Apache or Nginx web server
- Raspberry Pi Zero 2W

## System Architecture

This project follows a 3-tier architecture:

1. Presentation Layer  
   HTML and CSS pages that users interact with.

2. Application Layer  
   PHP files that handle BMI calculation, form submission, result display, and database communication.

3. Data Layer  
   MariaDB database that stores users, fitness logs, BMI records, and goals.

## Database Design

The database will include the following main tables:

### users
Stores user information.

### fitness_logs
Stores height, weight, BMI, BMI category, and log date.

### goals
Stores target weight goals and goal status.

## Contributors

Contributor information is listed in `Contributors.md`.

## Installation

Installation instructions are listed in `Installation.md`.

## User Guide

User instructions are listed in `UserGuide.md`.

## Admin Guide

Administrator instructions are listed in `AdminGuide.md`.
