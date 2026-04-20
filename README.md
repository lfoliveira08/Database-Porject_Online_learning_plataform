# TechLearn — Online Learning Platform

TechLearn is a comprehensive online learning platform focused exclusively on tech and programming courses. Students can enroll in courses, complete assignments, and receive grades from instructors. 

This repository serves as a fully functional web-application connecting a responsive UI frontend (HTML/CSS/PHP) to a robust relational database backend (MySQL).

## Team Members & Roles
- **@lfoliveira08**: Project Planning & Management
- **@SeaDog410**: PHP Development
- **@jonhalb**: Database Modeling

## Folder Structure
```
online-learning-platform/
│
├── database/
│   └── online_learning_platform.sql     # Complete database schema, views, and data
│
├── ui/                                  # Frontend Application
│   ├── db_connect.php                   # PDO Database string config
│   ├── nav.php                          # Shared navigation component
│   ├── register_student.php             # Page 1: Add new student
│   ├── enroll_student.php               # Page 2: Add student to a course
│   ├── enter_grade.php                  # Page 3: Submit student grades
│   ├── reports.php                      # Page 4: MySQL Data views dashboard
│   ├── instructor_dashboard.php         # Page 5: Instructor metrics overview
│   └── style.css                        # UI styling rules
│
├── screenshots/                         # Final application UI screenshots
│
├── docs/                                # Project documentation templates
│   ├── group_task_document.md
│   ├── github_setup_guide.md
│   └── project_roadmap.md
│
└── README.md                            # You are here
```

## Local Environment Setup
### Prerequisites
- PHP 8.x
- MySQL / MariaDB Server (e.g. XAMPP, WAMP, or standalone)
- Web Browser

### 1. Database Initialization
1. Open your MySQL interface (e.g. phpMyAdmin, MySQL Workbench, or CLI).
2. Create or navigate to the required destination database.
3. Import or execute the `database/online_learning_platform.sql` script.
4. This script automatically generates the necessary 7 tables, inserts all required data rows, and constructs 5 query-aggregated views.

### 2. Frontend Connection
1. In the `ui/` folder, open `db_connect.php`.
2. Update the default database credentials if your local MySQL instance has a non-empty password for the `root` user.

### 3. Running the Server Locally
Using PHP's built-in rapid deployment server:
```bash
# Navigate to the ui repository
cd ui/

# Start the web server on port 8000
php -S localhost:8000
```
Open a browser and navigate to `http://localhost:8000/reports.php` to begin navigating the application.
