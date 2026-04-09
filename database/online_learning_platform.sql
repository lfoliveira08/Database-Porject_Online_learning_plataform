-- TechLearn Online Learning Platform Database Script

DROP DATABASE IF EXISTS OnlineLearningPlatform;
CREATE DATABASE OnlineLearningPlatform;
USE OnlineLearningPlatform;

CREATE TABLE Categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(100) NOT NULL,
    description TEXT
);
CREATE TABLE Instructors (
    instructor_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    specialty VARCHAR(100),
    hire_date DATE
);
CREATE TABLE Courses (
    course_id INT AUTO_INCREMENT PRIMARY KEY,
    course_name VARCHAR(150) NOT NULL,
    description TEXT,
    instructor_id INT,
    category_id INT,
    price DECIMAL(8,2),
    duration_hours INT,
    start_date DATE,
    FOREIGN KEY (instructor_id) REFERENCES Instructors(instructor_id),
    FOREIGN KEY (category_id) REFERENCES Categories(category_id)
);
CREATE TABLE Students (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20),
    enrollment_date DATE,
    date_of_birth DATE
);
CREATE TABLE Enrollments (
    enrollment_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    course_id INT,
    enrollment_date DATE,
    status VARCHAR(30) DEFAULT 'Active',
    FOREIGN KEY (student_id) REFERENCES Students(student_id),
    FOREIGN KEY (course_id) REFERENCES Courses(course_id)
);
CREATE TABLE Assignments (
    assignment_id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT,
    title VARCHAR(150) NOT NULL,
    description TEXT,
    due_date DATE,
    max_score INT DEFAULT 100,
    FOREIGN KEY (course_id) REFERENCES Courses(course_id)
);
CREATE TABLE Grades (
    grade_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    assignment_id INT,
    score DECIMAL(5,2),
    submission_date DATE,
    feedback TEXT,
    FOREIGN KEY (student_id) REFERENCES Students(student_id),
    FOREIGN KEY (assignment_id) REFERENCES Assignments(assignment_id)
);


-- ================= DATA INSERTION =================

INSERT INTO Categories (category_name, description) VALUES
('Programming', 'Courses relating to Programming'),
('Data Science', 'Courses relating to Data Science'),
('Web Development', 'Courses relating to Web Development'),
('Cybersecurity', 'Courses relating to Cybersecurity'),
('Cloud Computing', 'Courses relating to Cloud Computing'),
('Database', 'Courses relating to Database'),
('Mobile Development', 'Courses relating to Mobile Development'),
('Design', 'Courses relating to Design');

INSERT INTO Instructors (first_name, last_name, email, specialty, hire_date) VALUES
('James', 'Jackson', 'james.jackson0@techlearn.edu', 'Data Science', '2023-01-15'),
('Karen', 'Davis', 'karen.davis1@techlearn.edu', 'Data Science', '2023-01-15'),
('Linda', 'Martinez', 'linda.martinez2@techlearn.edu', 'Cybersecurity', '2023-01-15'),
('William', 'Jones', 'william.jones3@techlearn.edu', 'Cloud Computing', '2023-01-15'),
('Jessica', 'Davis', 'jessica.davis4@techlearn.edu', 'Mobile Development', '2023-01-15'),
('Maria', 'Wilson', 'maria.wilson5@techlearn.edu', 'Design', '2023-01-15'),
('David', 'Davis', 'david.davis6@techlearn.edu', 'Programming', '2023-01-15'),
('William', 'Thomas', 'william.thomas7@techlearn.edu', 'Mobile Development', '2023-01-15'),
('David', 'Lopez', 'david.lopez8@techlearn.edu', 'Cloud Computing', '2023-01-15'),
('Karen', 'Martin', 'karen.martin9@techlearn.edu', 'Programming', '2023-01-15');

INSERT INTO Courses (course_name, description, instructor_id, category_id, price, duration_hours, start_date) VALUES
('Python for Beginners', 'Learn Python for Beginners thoroughly.', 1, 1, 99.99, 27, '2025-01-01'),
('Advanced SQL', 'Learn Advanced SQL thoroughly.', 2, 2, 120.0, 26, '2025-01-01'),
('React Native Basics', 'Learn React Native Basics thoroughly.', 3, 3, 49.99, 13, '2025-01-01'),
('AWS Cloud Concepts', 'Learn AWS Cloud Concepts thoroughly.', 4, 4, 49.99, 29, '2025-01-01'),
('UI/UX Foundations', 'Learn UI/UX Foundations thoroughly.', 5, 5, 99.99, 6, '2025-01-01'),
('Machine Learning 101', 'Learn Machine Learning 101 thoroughly.', 6, 6, 120.0, 16, '2025-01-01'),
('Fullstack Web', 'Learn Fullstack Web thoroughly.', 7, 7, 99.99, 8, '2025-01-01'),
('Cyber Defense', 'Learn Cyber Defense thoroughly.', 8, 8, 79.99, 19, '2025-01-01'),
('C++ System Design', 'Learn C++ System Design thoroughly.', 9, 1, 120.0, 19, '2025-01-01'),
('Docker Mastery', 'Learn Docker Mastery thoroughly.', 10, 2, 79.99, 33, '2025-01-01'),
('Graphic Design Intro', 'Learn Graphic Design Intro thoroughly.', 1, 3, 49.99, 10, '2025-01-01'),
('Data Analytics With Pandas', 'Learn Data Analytics With Pandas thoroughly.', 2, 4, 99.99, 13, '2025-01-01'),
('Java OOP', 'Learn Java OOP thoroughly.', 3, 5, 120.0, 23, '2025-01-01'),
('Ethical Hacking', 'Learn Ethical Hacking thoroughly.', 4, 6, 79.99, 8, '2025-01-01'),
('DevOps Pipeline', 'Learn DevOps Pipeline thoroughly.', 5, 7, 49.99, 16, '2025-01-01');

INSERT INTO Assignments (course_id, title, description, due_date, max_score) VALUES
(1, 'Final Project for Course 1', 'Complete the required milestone', '2025-06-01', 100),
(2, 'Final Project for Course 2', 'Complete the required milestone', '2025-06-01', 100),
(3, 'Final Project for Course 3', 'Complete the required milestone', '2025-06-01', 100),
(4, 'Final Project for Course 4', 'Complete the required milestone', '2025-06-01', 100),
(5, 'Final Project for Course 5', 'Complete the required milestone', '2025-06-01', 100),
(6, 'Final Project for Course 6', 'Complete the required milestone', '2025-06-01', 100),
(7, 'Final Project for Course 7', 'Complete the required milestone', '2025-06-01', 100),
(8, 'Final Project for Course 8', 'Complete the required milestone', '2025-06-01', 100),
(9, 'Final Project for Course 9', 'Complete the required milestone', '2025-06-01', 100),
(10, 'Final Project for Course 10', 'Complete the required milestone', '2025-06-01', 100),
(11, 'Final Project for Course 11', 'Complete the required milestone', '2025-06-01', 100),
(12, 'Final Project for Course 12', 'Complete the required milestone', '2025-06-01', 100),
(13, 'Final Project for Course 13', 'Complete the required milestone', '2025-06-01', 100),
(14, 'Final Project for Course 14', 'Complete the required milestone', '2025-06-01', 100),
(15, 'Final Project for Course 15', 'Complete the required milestone', '2025-06-01', 100);

INSERT INTO Students (first_name, last_name, email, phone, enrollment_date, date_of_birth) VALUES
('James', 'Thomas', 'student0_james@gmail.com', '555-652-1809', '2024-05-12', '2000-01-01'),
('Richard', 'Johnson', 'student1_richard@gmail.com', '555-816-4224', '2024-05-12', '2000-01-01'),
('Thomas', 'Moore', 'student2_thomas@gmail.com', '555-120-3474', '2024-05-12', '2000-01-01'),
('Susan', 'Brown', 'student3_susan@gmail.com', '555-907-8751', '2024-05-12', '2000-01-01'),
('Robert', 'Thomas', 'student4_robert@gmail.com', '555-565-1907', '2024-05-12', '2000-01-01'),
('William', 'Johnson', 'student5_william@gmail.com', '555-106-7434', '2024-05-12', '2000-01-01'),
('Jennifer', 'Lopez', 'student6_jennifer@gmail.com', '555-656-5223', '2024-05-12', '2000-01-01'),
('Barbara', 'Jackson', 'student7_barbara@gmail.com', '555-910-5984', '2024-05-12', '2000-01-01'),
('Michael', 'Gonzalez', 'student8_michael@gmail.com', '555-661-6297', '2024-05-12', '2000-01-01'),
('Charles', 'Jones', 'student9_charles@gmail.com', '555-482-6139', '2024-05-12', '2000-01-01'),
('Sarah', 'Miller', 'student10_sarah@gmail.com', '555-853-5957', '2024-05-12', '2000-01-01'),
('William', 'Williams', 'student11_william@gmail.com', '555-847-9148', '2024-05-12', '2000-01-01'),
('Charles', 'Garcia', 'student12_charles@gmail.com', '555-255-8243', '2024-05-12', '2000-01-01'),
('William', 'Martin', 'student13_william@gmail.com', '555-950-1663', '2024-05-12', '2000-01-01'),
('Jennifer', 'Gonzalez', 'student14_jennifer@gmail.com', '555-350-8363', '2024-05-12', '2000-01-01'),
('David', 'Lopez', 'student15_david@gmail.com', '555-147-8548', '2024-05-12', '2000-01-01'),
('Joseph', 'Lopez', 'student16_joseph@gmail.com', '555-607-2367', '2024-05-12', '2000-01-01'),
('James', 'Martin', 'student17_james@gmail.com', '555-890-9939', '2024-05-12', '2000-01-01'),
('Thomas', 'Miller', 'student18_thomas@gmail.com', '555-695-9292', '2024-05-12', '2000-01-01'),
('James', 'Martinez', 'student19_james@gmail.com', '555-531-2420', '2024-05-12', '2000-01-01'),
('Patricia', 'Taylor', 'student20_patricia@gmail.com', '555-111-8830', '2024-05-12', '2000-01-01'),
('William', 'Jones', 'student21_william@gmail.com', '555-355-7290', '2024-05-12', '2000-01-01'),
('Linda', 'Thomas', 'student22_linda@gmail.com', '555-900-9609', '2024-05-12', '2000-01-01'),
('Karen', 'Wilson', 'student23_karen@gmail.com', '555-755-9832', '2024-05-12', '2000-01-01'),
('Elizabeth', 'Wilson', 'student24_elizabeth@gmail.com', '555-651-2593', '2024-05-12', '2000-01-01'),
('Elizabeth', 'Miller', 'student25_elizabeth@gmail.com', '555-659-7521', '2024-05-12', '2000-01-01'),
('Linda', 'Thomas', 'student26_linda@gmail.com', '555-629-2214', '2024-05-12', '2000-01-01'),
('Sarah', 'Lopez', 'student27_sarah@gmail.com', '555-421-7927', '2024-05-12', '2000-01-01'),
('Michael', 'Anderson', 'student28_michael@gmail.com', '555-416-9437', '2024-05-12', '2000-01-01'),
('Sarah', 'Brown', 'student29_sarah@gmail.com', '555-312-2854', '2024-05-12', '2000-01-01'),
('Barbara', 'Wilson', 'student30_barbara@gmail.com', '555-544-3312', '2024-05-12', '2000-01-01'),
('Elizabeth', 'Martin', 'student31_elizabeth@gmail.com', '555-432-7550', '2024-05-12', '2000-01-01'),
('Barbara', 'Martin', 'student32_barbara@gmail.com', '555-672-5937', '2024-05-12', '2000-01-01'),
('Patricia', 'Miller', 'student33_patricia@gmail.com', '555-977-1763', '2024-05-12', '2000-01-01'),
('John', 'Garcia', 'student34_john@gmail.com', '555-597-3971', '2024-05-12', '2000-01-01'),
('Karen', 'Miller', 'student35_karen@gmail.com', '555-927-1630', '2024-05-12', '2000-01-01'),
('Michael', 'Perez', 'student36_michael@gmail.com', '555-507-1074', '2024-05-12', '2000-01-01'),
('Charles', 'Williams', 'student37_charles@gmail.com', '555-955-3041', '2024-05-12', '2000-01-01'),
('David', 'Jones', 'student38_david@gmail.com', '555-402-7524', '2024-05-12', '2000-01-01'),
('Barbara', 'Perez', 'student39_barbara@gmail.com', '555-307-3648', '2024-05-12', '2000-01-01'),
('William', 'Smith', 'student40_william@gmail.com', '555-492-8101', '2024-05-12', '2000-01-01'),
('Richard', 'Gonzalez', 'student41_richard@gmail.com', '555-495-4806', '2024-05-12', '2000-01-01'),
('Linda', 'Jackson', 'student42_linda@gmail.com', '555-921-7828', '2024-05-12', '2000-01-01'),
('Karen', 'Jackson', 'student43_karen@gmail.com', '555-714-9435', '2024-05-12', '2000-01-01'),
('Barbara', 'Brown', 'student44_barbara@gmail.com', '555-245-3456', '2024-05-12', '2000-01-01'),
('Joseph', 'Brown', 'student45_joseph@gmail.com', '555-419-3033', '2024-05-12', '2000-01-01'),
('Barbara', 'Moore', 'student46_barbara@gmail.com', '555-658-5863', '2024-05-12', '2000-01-01'),
('Patricia', 'Brown', 'student47_patricia@gmail.com', '555-157-5344', '2024-05-12', '2000-01-01'),
('Susan', 'Martinez', 'student48_susan@gmail.com', '555-308-1827', '2024-05-12', '2000-01-01'),
('Jennifer', 'Taylor', 'student49_jennifer@gmail.com', '555-933-1816', '2024-05-12', '2000-01-01'),
('James', 'Williams', 'student50_james@gmail.com', '555-408-8135', '2024-05-12', '2000-01-01'),
('Robert', 'Johnson', 'student51_robert@gmail.com', '555-495-1981', '2024-05-12', '2000-01-01'),
('Barbara', 'Johnson', 'student52_barbara@gmail.com', '555-140-5213', '2024-05-12', '2000-01-01'),
('David', 'Miller', 'student53_david@gmail.com', '555-613-8245', '2024-05-12', '2000-01-01'),
('Jennifer', 'Martinez', 'student54_jennifer@gmail.com', '555-161-7357', '2024-05-12', '2000-01-01'),
('John', 'Smith', 'student55_john@gmail.com', '555-452-6108', '2024-05-12', '2000-01-01'),
('James', 'Taylor', 'student56_james@gmail.com', '555-805-6036', '2024-05-12', '2000-01-01'),
('William', 'Gonzalez', 'student57_william@gmail.com', '555-457-5641', '2024-05-12', '2000-01-01'),
('Robert', 'Moore', 'student58_robert@gmail.com', '555-618-4923', '2024-05-12', '2000-01-01'),
('Charles', 'Johnson', 'student59_charles@gmail.com', '555-882-4070', '2024-05-12', '2000-01-01'),
('William', 'Davis', 'student60_william@gmail.com', '555-301-8061', '2024-05-12', '2000-01-01'),
('Barbara', 'Thomas', 'student61_barbara@gmail.com', '555-605-6853', '2024-05-12', '2000-01-01'),
('Maria', 'Davis', 'student62_maria@gmail.com', '555-674-4167', '2024-05-12', '2000-01-01'),
('John', 'Lopez', 'student63_john@gmail.com', '555-706-8596', '2024-05-12', '2000-01-01'),
('William', 'Miller', 'student64_william@gmail.com', '555-439-2497', '2024-05-12', '2000-01-01'),
('Barbara', 'Brown', 'student65_barbara@gmail.com', '555-254-5095', '2024-05-12', '2000-01-01'),
('William', 'Lee', 'student66_william@gmail.com', '555-430-4977', '2024-05-12', '2000-01-01'),
('Jennifer', 'Martin', 'student67_jennifer@gmail.com', '555-928-2874', '2024-05-12', '2000-01-01'),
('Michael', 'Wilson', 'student68_michael@gmail.com', '555-792-8083', '2024-05-12', '2000-01-01'),
('Jessica', 'Jones', 'student69_jessica@gmail.com', '555-526-9367', '2024-05-12', '2000-01-01'),
('Richard', 'Davis', 'student70_richard@gmail.com', '555-923-1432', '2024-05-12', '2000-01-01'),
('William', 'Moore', 'student71_william@gmail.com', '555-829-9277', '2024-05-12', '2000-01-01'),
('Jessica', 'Perez', 'student72_jessica@gmail.com', '555-118-6449', '2024-05-12', '2000-01-01'),
('Michael', 'Brown', 'student73_michael@gmail.com', '555-648-9222', '2024-05-12', '2000-01-01'),
('Jennifer', 'Lee', 'student74_jennifer@gmail.com', '555-743-7221', '2024-05-12', '2000-01-01'),
('David', 'Gonzalez', 'student75_david@gmail.com', '555-594-5850', '2024-05-12', '2000-01-01'),
('Linda', 'Anderson', 'student76_linda@gmail.com', '555-683-8282', '2024-05-12', '2000-01-01'),
('Patricia', 'Davis', 'student77_patricia@gmail.com', '555-551-6679', '2024-05-12', '2000-01-01'),
('James', 'Williams', 'student78_james@gmail.com', '555-593-1437', '2024-05-12', '2000-01-01'),
('Thomas', 'Jones', 'student79_thomas@gmail.com', '555-164-7955', '2024-05-12', '2000-01-01');

INSERT INTO Enrollments (student_id, course_id, enrollment_date, status) VALUES
(1, 5, '2025-02-01', 'Dropped'),
(2, 15, '2025-02-01', 'Dropped'),
(3, 12, '2025-02-01', 'Dropped'),
(4, 13, '2025-02-01', 'Active'),
(5, 2, '2025-02-01', 'Active'),
(6, 14, '2025-02-01', 'Active'),
(7, 9, '2025-02-01', 'Active'),
(8, 12, '2025-02-01', 'Dropped'),
(9, 11, '2025-02-01', 'Dropped'),
(10, 4, '2025-02-01', 'Completed'),
(11, 9, '2025-02-01', 'Dropped'),
(12, 8, '2025-02-01', 'Active'),
(13, 13, '2025-02-01', 'Active'),
(14, 5, '2025-02-01', 'Active'),
(15, 7, '2025-02-01', 'Completed'),
(16, 7, '2025-02-01', 'Completed'),
(17, 4, '2025-02-01', 'Completed'),
(18, 1, '2025-02-01', 'Dropped'),
(19, 9, '2025-02-01', 'Active'),
(20, 4, '2025-02-01', 'Completed'),
(21, 11, '2025-02-01', 'Active'),
(22, 1, '2025-02-01', 'Dropped'),
(23, 15, '2025-02-01', 'Completed'),
(24, 8, '2025-02-01', 'Dropped'),
(25, 14, '2025-02-01', 'Completed'),
(26, 3, '2025-02-01', 'Completed'),
(27, 7, '2025-02-01', 'Completed'),
(28, 1, '2025-02-01', 'Active'),
(29, 10, '2025-02-01', 'Active'),
(30, 8, '2025-02-01', 'Dropped'),
(31, 8, '2025-02-01', 'Completed'),
(32, 13, '2025-02-01', 'Active'),
(33, 14, '2025-02-01', 'Active'),
(34, 10, '2025-02-01', 'Completed'),
(35, 4, '2025-02-01', 'Active'),
(36, 10, '2025-02-01', 'Dropped'),
(37, 11, '2025-02-01', 'Dropped'),
(38, 14, '2025-02-01', 'Dropped'),
(39, 10, '2025-02-01', 'Dropped'),
(40, 14, '2025-02-01', 'Completed'),
(41, 5, '2025-02-01', 'Active'),
(42, 10, '2025-02-01', 'Dropped'),
(43, 13, '2025-02-01', 'Dropped'),
(44, 12, '2025-02-01', 'Active'),
(45, 3, '2025-02-01', 'Dropped'),
(46, 12, '2025-02-01', 'Completed'),
(47, 7, '2025-02-01', 'Completed'),
(48, 11, '2025-02-01', 'Active'),
(49, 15, '2025-02-01', 'Active'),
(50, 4, '2025-02-01', 'Completed'),
(51, 4, '2025-02-01', 'Active'),
(52, 15, '2025-02-01', 'Active'),
(53, 3, '2025-02-01', 'Completed'),
(54, 14, '2025-02-01', 'Dropped'),
(55, 15, '2025-02-01', 'Dropped'),
(56, 5, '2025-02-01', 'Completed'),
(57, 5, '2025-02-01', 'Completed'),
(58, 3, '2025-02-01', 'Dropped'),
(59, 4, '2025-02-01', 'Completed'),
(60, 9, '2025-02-01', 'Completed'),
(61, 8, '2025-02-01', 'Active'),
(62, 13, '2025-02-01', 'Dropped'),
(63, 4, '2025-02-01', 'Dropped'),
(64, 12, '2025-02-01', 'Dropped'),
(65, 7, '2025-02-01', 'Active'),
(66, 4, '2025-02-01', 'Completed'),
(67, 2, '2025-02-01', 'Dropped'),
(68, 8, '2025-02-01', 'Completed'),
(69, 4, '2025-02-01', 'Completed'),
(70, 6, '2025-02-01', 'Active'),
(71, 4, '2025-02-01', 'Active'),
(72, 2, '2025-02-01', 'Active'),
(73, 10, '2025-02-01', 'Dropped'),
(74, 3, '2025-02-01', 'Completed'),
(75, 12, '2025-02-01', 'Active'),
(76, 5, '2025-02-01', 'Active'),
(77, 8, '2025-02-01', 'Dropped'),
(78, 8, '2025-02-01', 'Dropped'),
(79, 9, '2025-02-01', 'Active'),
(80, 8, '2025-02-01', 'Completed');

INSERT INTO Grades (student_id, assignment_id, score, submission_date, feedback) VALUES
(1, 14, 68.88, '2025-05-01', 'Good work'),
(2, 2, 77.74, '2025-05-01', 'Good work'),
(3, 15, 60.74, '2025-05-01', 'Good work'),
(4, 10, 78.4, '2025-05-01', 'Good work'),
(5, 3, 63.48, '2025-05-01', 'Good work'),
(6, 6, 86.35, '2025-05-01', 'Good work'),
(7, 7, 60.69, '2025-05-01', 'Good work'),
(8, 15, 87.74, '2025-05-01', 'Good work'),
(9, 10, 94.33, '2025-05-01', 'Good work'),
(10, 9, 84.31, '2025-05-01', 'Good work'),
(11, 10, 81.97, '2025-05-01', 'Good work'),
(12, 8, 63.73, '2025-05-01', 'Good work'),
(13, 8, 60.02, '2025-05-01', 'Good work'),
(14, 15, 94.35, '2025-05-01', 'Good work'),
(15, 6, 80.41, '2025-05-01', 'Good work'),
(16, 7, 67.76, '2025-05-01', 'Good work'),
(17, 10, 91.0, '2025-05-01', 'Good work'),
(18, 10, 71.51, '2025-05-01', 'Good work'),
(19, 9, 60.78, '2025-05-01', 'Good work'),
(20, 8, 66.1, '2025-05-01', 'Good work'),
(21, 8, 62.23, '2025-05-01', 'Good work'),
(22, 6, 73.48, '2025-05-01', 'Good work'),
(23, 10, 68.71, '2025-05-01', 'Good work'),
(24, 5, 62.39, '2025-05-01', 'Good work'),
(25, 13, 97.99, '2025-05-01', 'Good work'),
(26, 8, 89.34, '2025-05-01', 'Good work'),
(27, 4, 93.02, '2025-05-01', 'Good work'),
(28, 6, 81.57, '2025-05-01', 'Good work'),
(29, 1, 97.58, '2025-05-01', 'Good work'),
(30, 4, 91.1, '2025-05-01', 'Good work'),
(31, 10, 72.09, '2025-05-01', 'Good work'),
(32, 1, 69.02, '2025-05-01', 'Good work'),
(33, 11, 81.18, '2025-05-01', 'Good work'),
(34, 3, 82.3, '2025-05-01', 'Good work'),
(35, 1, 77.38, '2025-05-01', 'Good work'),
(36, 10, 99.82, '2025-05-01', 'Good work'),
(37, 7, 66.2, '2025-05-01', 'Good work'),
(38, 12, 98.05, '2025-05-01', 'Good work'),
(39, 2, 60.79, '2025-05-01', 'Good work'),
(40, 7, 97.26, '2025-05-01', 'Good work'),
(41, 12, 63.44, '2025-05-01', 'Good work'),
(42, 8, 84.16, '2025-05-01', 'Good work'),
(43, 14, 61.8, '2025-05-01', 'Good work'),
(44, 9, 60.56, '2025-05-01', 'Good work'),
(45, 14, 81.61, '2025-05-01', 'Good work'),
(46, 5, 82.57, '2025-05-01', 'Good work'),
(47, 2, 90.87, '2025-05-01', 'Good work'),
(48, 12, 89.95, '2025-05-01', 'Good work'),
(49, 1, 74.62, '2025-05-01', 'Good work'),
(50, 12, 95.73, '2025-05-01', 'Good work'),
(51, 2, 75.18, '2025-05-01', 'Good work'),
(52, 13, 75.53, '2025-05-01', 'Good work'),
(53, 2, 75.14, '2025-05-01', 'Good work'),
(54, 10, 79.4, '2025-05-01', 'Good work'),
(55, 3, 76.53, '2025-05-01', 'Good work'),
(56, 8, 65.33, '2025-05-01', 'Good work'),
(57, 10, 91.0, '2025-05-01', 'Good work'),
(58, 7, 94.93, '2025-05-01', 'Good work'),
(59, 15, 84.41, '2025-05-01', 'Good work'),
(60, 4, 95.79, '2025-05-01', 'Good work'),
(61, 5, 69.05, '2025-05-01', 'Good work'),
(62, 3, 88.8, '2025-05-01', 'Good work'),
(63, 11, 81.8, '2025-05-01', 'Good work'),
(64, 3, 85.18, '2025-05-01', 'Good work'),
(65, 14, 64.31, '2025-05-01', 'Good work'),
(66, 9, 86.05, '2025-05-01', 'Good work'),
(67, 12, 92.86, '2025-05-01', 'Good work'),
(68, 6, 64.57, '2025-05-01', 'Good work'),
(69, 2, 81.9, '2025-05-01', 'Good work'),
(70, 12, 80.77, '2025-05-01', 'Good work'),
(71, 7, 90.88, '2025-05-01', 'Good work'),
(72, 2, 86.9, '2025-05-01', 'Good work'),
(73, 6, 80.0, '2025-05-01', 'Good work'),
(74, 11, 91.35, '2025-05-01', 'Good work'),
(75, 2, 98.61, '2025-05-01', 'Good work'),
(76, 8, 93.96, '2025-05-01', 'Good work'),
(77, 10, 97.8, '2025-05-01', 'Good work'),
(78, 13, 81.6, '2025-05-01', 'Good work'),
(79, 14, 65.9, '2025-05-01', 'Good work'),
(80, 10, 64.82, '2025-05-01', 'Good work');


-- ==============================================================================
-- SECTION 4: ASSIGNMENT QUERIES AND VIEWS
-- ==============================================================================

-- SELECT Queries (10)

-- Q1 - List all students with full name and email
-- SELECT CONCAT(first_name, ' ', last_name) AS full_name, email FROM Students;

-- Q2 - List all courses with instructor name and category
-- SELECT c.course_name, CONCAT(i.first_name, ' ', i.last_name) AS instructor, cat.category_name
-- FROM Courses c JOIN Instructors i ON c.instructor_id = i.instructor_id JOIN Categories cat ON c.category_id = cat.category_id;

-- Q3 - List all enrollments with student name and course name
-- SELECT CONCAT(s.first_name, ' ', s.last_name) AS student, c.course_name, e.status
-- FROM Enrollments e JOIN Students s ON e.student_id = s.student_id JOIN Courses c ON e.course_id = c.course_id;

-- Q4 - Show all grades with student name, assignment title, and score
-- SELECT CONCAT(s.first_name, ' ', s.last_name) AS student, a.title, g.score
-- FROM Grades g JOIN Students s ON g.student_id = s.student_id JOIN Assignments a ON g.assignment_id = a.assignment_id;

-- Q5 - Find all active enrollments
-- SELECT * FROM Enrollments WHERE status = 'Active';

-- Q6 - Find students enrolled in more than one course
-- SELECT student_id, COUNT(*) as active_courses FROM Enrollments GROUP BY student_id HAVING COUNT(*) > 1;

-- Q7 - Count total students per course
-- SELECT course_id, COUNT(student_id) AS student_count FROM Enrollments GROUP BY course_id;

-- Q8 - Find the top 10 highest-scoring students
-- SELECT student_id, MAX(score) as top_score FROM Grades GROUP BY student_id ORDER BY top_score DESC LIMIT 10;

-- Q9 - Find courses with price above $80
-- SELECT course_name, price FROM Courses WHERE price > 80.00;

-- Q10 - Find all dropped or completed enrollments
-- SELECT * FROM Enrollments WHERE status IN ('Dropped', 'Completed');


-- UPDATE Statements (5)

-- U1 - Update a student's phone number
-- UPDATE Students SET phone = '555-123-4567' WHERE student_id = 1;

-- U2 - Change enrollment status to Completed
-- UPDATE Enrollments SET status = 'Completed' WHERE enrollment_id = 1;

-- U3 - Give Python for Beginners students a 5-point grade bonus
-- UPDATE Grades g JOIN Assignments a ON g.assignment_id = a.assignment_id JOIN Courses c ON a.course_id = c.course_id SET g.score = g.score + 5 WHERE c.course_name = 'Python for Beginners' AND g.score <= 95;

-- U4 - Update a course price
-- UPDATE Courses SET price = 89.99 WHERE course_id = 1;

-- U5 - Update instructor specialty
-- UPDATE Instructors SET specialty = 'Full Stack Development' WHERE instructor_id = 1;


-- DELETE Statements (2)

-- D1 - Remove a dropped enrollment
-- DELETE FROM Enrollments WHERE status = 'Dropped' LIMIT 1;

-- D2 - Delete a cancelled assignment (safe delete with subquery check)
-- DELETE FROM Assignments WHERE assignment_id NOT IN (SELECT assignment_id FROM Grades);

-- VIEWS / REPORTS (5)

-- V1 - vw_student_enrollment_summary
CREATE OR REPLACE VIEW vw_student_enrollment_summary AS
SELECT 
    s.student_id, 
    CONCAT(s.first_name, ' ', s.last_name) AS student_name,
    COUNT(e.course_id) AS total_courses,
    SUM(CASE WHEN e.status = 'Completed' THEN 1 ELSE 0 END) AS completed_courses,
    SUM(CASE WHEN e.status = 'Active' THEN 1 ELSE 0 END) AS active_courses,
    SUM(CASE WHEN e.status = 'Dropped' THEN 1 ELSE 0 END) AS dropped_courses
FROM Students s
LEFT JOIN Enrollments e ON s.student_id = e.student_id
GROUP BY s.student_id;

-- V2 - vw_course_revenue
CREATE OR REPLACE VIEW vw_course_revenue AS
SELECT 
    c.course_id, 
    c.course_name, 
    COUNT(e.student_id) AS total_students,
    (COUNT(e.student_id) * c.price) AS total_revenue
FROM Courses c
LEFT JOIN Enrollments e ON c.course_id = e.course_id AND e.status != 'Dropped'
GROUP BY c.course_id;

-- V3 - vw_instructor_performance
CREATE OR REPLACE VIEW vw_instructor_performance AS
SELECT 
    i.instructor_id, 
    CONCAT(i.first_name, ' ', i.last_name) AS instructor_name,
    COUNT(DISTINCT c.course_id) AS courses_taught,
    AVG(g.score) AS average_student_score
FROM Instructors i
JOIN Courses c ON i.instructor_id = c.instructor_id
JOIN Assignments a ON c.course_id = a.course_id
JOIN Grades g ON a.assignment_id = g.assignment_id
GROUP BY i.instructor_id;

-- V4 - vw_top_students_per_course
CREATE OR REPLACE VIEW vw_top_students_per_course AS
SELECT 
    c.course_name, 
    CONCAT(s.first_name, ' ', s.last_name) AS student_name,
    g.score
FROM Grades g
JOIN Assignments a ON g.assignment_id = a.assignment_id
JOIN Courses c ON a.course_id = c.course_id
JOIN Students s ON g.student_id = s.student_id
WHERE g.score >= 90;

-- V5 - vw_revenue_by_category
CREATE OR REPLACE VIEW vw_revenue_by_category AS
SELECT 
    cat.category_name, 
    COUNT(e.enrollment_id) AS total_enrollments,
    SUM(c.price) AS total_revenue
FROM Categories cat
JOIN Courses c ON cat.category_id = c.category_id
JOIN Enrollments e ON c.course_id = e.course_id AND e.status != 'Dropped'
GROUP BY cat.category_id;
