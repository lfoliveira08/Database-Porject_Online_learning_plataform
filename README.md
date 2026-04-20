# TechLearn — Online Learning Platform

TechLearn is a comprehensive online learning platform focused exclusively on tech and programming courses. Students can enroll in courses, complete assignments, and receive grades from instructors. This repository serves as a fully functional web-application connecting a responsive UI frontend (HTML/CSS/PHP) to a robust relational database backend (MySQL).

---

## 🔗 Quick Links
- **Manage Tasks:** [Project Workspace Board](https://github.com/users/lfoliveira08/projects/11)
- **Official Documentation:** [Project Wiki Page](https://github.com/lfoliveira08/Database-Porject_Online_learning_plataform/wiki)

---
## 📈 Project Status

The project is currently under active development.

| Milestone | Status | Description |
| :--- | :--- | :--- |
| **Milestone 1: Database Setup** | **In Progress** | MySQL Setup, Schema Definition, Table relationships, and Views. |
| **Milestone 2: UI Page creation** | **In Progress** | Frontend interfaces connecting to the PDO backend using PHP and CSS styling. |
| **Milestone 3: Report/Dashboard validation** | **Pending** | Validating that complex MySQL views render successfully on the frontend. |

---

## 🛡️ Key Features

1.  **Relational Integrity:** Implements robust Primary and Foreign keys across 7 unique tables (Students, Courses, Grades, Payments, etc.) to ensure database consistency.
2.  **Prepared Statements (PDO):** Security-first design using PHP Data Objects to safeguard all database inputs against SQL Injection attacks.
3.  **Data Aggregation (Views):** Custom MySQL views that instantly calculate logic like `Average Grade per Course` to minimize frontend computation overhead.
4.  **Responsive UI:** A mobile-friendly layout built with custom CSS, ensuring ease of access for both instructors and students.

 ---

## 🛠️ Tech Stack

* **Language:** PHP 8.x
* **Database:** MySQL / MariaDB
* **Frontend:** HTML5 / CSS3
* **Server Compatibility:** XAMPP, WAMP, or built-in PHP server.

---

## 📡 Application Flow & Pages

1.  **Student Registration** (`register_student.php`)
    * Captures and securely inserts new student details into the database.
2.  **Course Enrollment** (`enroll_student.php`)
    * Allows students to register for active courses, generating enrollment records.
3.  **Grade Submission** (`enter_grade.php`)
    * Instructor interface to grade student performance which updates the ledger.
4.  **Reports Dashboard** (`reports.php`)
    * Visualizes MySQL aggregated views for management (e.g. Student Count per Course).
5.  **Instructor Overview** (`instructor_dashboard.php`)
    * Displays instructor specific metrics and active classes.

---

## 🧩 Database Structure Summary

Instead of block structures, this project centers around a core relational schema.

```sql
-- Conceptual Schema Overview
STUDENT (StudentID [PK], Name, Email)
INSTRUCTOR (InstructorID [PK], Name, Department)
COURSE (CourseID [PK], Title, InstructorID [FK])
ENROLLMENT (EnrollmentID [PK], CourseID [FK], StudentID [FK])
GRADE (GradeID [PK], EnrollmentID [FK], Score)
```
*(The complete schema contains 7 tables and 5 views, located in `database/online_learning_platform.sql`)*

---

## 👥 User Stories (Completed)

The following stories direct our development lifecycle.

### User Story 1: Student Persona Journey
**As a Student**, I want an interface to register and browse courses, **so that** I can enroll directly into the learning platform.
* *Status: Closed*

### User Story 2: Instructor Persona Journey
**As an Instructor**, I want a simplified portal to enter grades, **so that** I can efficiently track my class performance metrics.
* *Status: Closed*

### User Story 3: Administrator Journey
**As an Admin**, I want dashboard screens utilizing database Views, **so that** I can view enrollment aggregates and financials at a glance.
* *Status: Closed*

---
## 📸 Project Final Report Evidence

This section will map the user interface visualization to the underlying database queries. 

> *(Screenshots to be injected after the UI testing is completed)*

### 1. Student Registration (UI vs Database)
**Objective:** Add a new user record.
| **Frontend Result** | **Backend Response (Database)** |
| :--- | :--- |
| *(Pending Registration UI Image)* | *(Pending DB Table Verification Image)* |

### 2. Enter Grades & Aggregation
**Objective:** Instructor modifies a grade and the Views auto-update.
| **Frontend Result** | **Backend Response (Database)** |
| :--- | :--- |
| *(Pending Grade Entry Form)* | *(Pending Computed Average View)* |

---

## 🔮 Possible Future Improvements

Subsequent versions of this project are planned to include:
* **Authentication & Authorization:** Secure Login mechanisms protecting instructor and student routes via session variables.
* **REST API Endpoints:** Expanding the backend from direct PHP rendering to a decoupled JSON API structure using Frameworks like Laravel.
* **Payment Gateway Integration:** E-commerce capabilities to handle course transactions seamlessly using Stripe.

## 👥 Contributors

| Role | Name |
| :--- | :--- |
| **Project Planning & Management** | @lfoliveira08 |
| **PHP Development** | @SeaDog410 |
| **Database Modeling** | @jonhalb |

## 📖 Contributions

| Team contributor | Responsibilities | Contribution % |
| :--- | :--- |  :--- |
| **@lfoliveira08** | Setup, Management, Documentation | *TBD* |
| **@SeaDog410** | Backend/Frontend Integrations | *TBD* |
| **@jonhalb** | SQL Schema, Queries, and Views | *TBD* |
