<?php
require_once 'db_connect.php';

$table = $_GET['table'] ?? 'students';

$tables_map = [
    'students' => [
        'title' => 'Students',
        'query' => "SELECT student_id AS 'ID',
                           CONCAT(first_name, ' ', last_name) AS 'Full Name',
                           email AS 'Email',
                           phone AS 'Phone',
                           date_of_birth AS 'Date of Birth',
                           enrollment_date AS 'Enrollment Date'
                    FROM Students
                    ORDER BY last_name, first_name"
    ],
    'instructors' => [
        'title' => 'Instructors',
        'query' => "SELECT instructor_id AS 'ID',
                           CONCAT(first_name, ' ', last_name) AS 'Full Name',
                           email AS 'Email',
                           specialty AS 'Specialty',
                           hire_date AS 'Hire Date'
                    FROM Instructors
                    ORDER BY last_name, first_name"
    ],
    'courses' => [
        'title' => 'Courses',
        'query' => "SELECT c.course_id AS 'ID',
                           c.course_name AS 'Course Name',
                           CONCAT(i.first_name, ' ', i.last_name) AS 'Instructor',
                           cat.category_name AS 'Category',
                           c.price AS 'Price ($)',
                           c.duration_hours AS 'Duration (hrs)',
                           c.start_date AS 'Start Date'
                    FROM Courses c
                    JOIN Instructors i ON c.instructor_id = i.instructor_id
                    JOIN Categories cat ON c.category_id = cat.category_id
                    ORDER BY c.course_name"
    ],
    'categories' => [
        'title' => 'Categories',
        'query' => "SELECT category_id AS 'ID',
                           category_name AS 'Category Name',
                           description AS 'Description'
                    FROM Categories
                    ORDER BY category_name"
    ],
    'enrollments' => [
        'title' => 'Enrollments',
        'query' => "SELECT e.enrollment_id AS 'ID',
                           CONCAT(s.first_name, ' ', s.last_name) AS 'Student',
                           c.course_name AS 'Course',
                           e.enrollment_date AS 'Enrollment Date',
                           e.status AS 'Status'
                    FROM Enrollments e
                    JOIN Students s ON e.student_id = s.student_id
                    JOIN Courses c ON e.course_id = c.course_id
                    ORDER BY e.enrollment_id"
    ],
    'assignments' => [
        'title' => 'Assignments',
        'query' => "SELECT a.assignment_id AS 'ID',
                           c.course_name AS 'Course',
                           a.title AS 'Title',
                           a.due_date AS 'Due Date',
                           a.max_score AS 'Max Score'
                    FROM Assignments a
                    JOIN Courses c ON a.course_id = c.course_id
                    ORDER BY c.course_name, a.title"
    ],
    'grades' => [
        'title' => 'Grades',
        'query' => "SELECT g.grade_id AS 'ID',
                           CONCAT(s.first_name, ' ', s.last_name) AS 'Student',
                           c.course_name AS 'Course',
                           g.score AS 'Score',
                           g.submission_date AS 'Submission Date',
                           g.feedback AS 'Feedback'
                    FROM Grades g
                    JOIN Students s ON g.student_id = s.student_id
                    JOIN Assignments a ON g.assignment_id = a.assignment_id
                    JOIN Courses c ON a.course_id = c.course_id
                    ORDER BY g.grade_id"
    ]
];

if (!array_key_exists($table, $tables_map)) {
    $table = 'students';
}

$current = $tables_map[$table];
$data = [];
$columns = [];
$row_count = 0;

try {
    $stmt = $conn->query($current['query']);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $row_count = count($data);
    if ($row_count > 0) {
        $columns = array_keys($data[0]);
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Browse Tables | TechLearn</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'nav.php'; ?>
    <main>
        <h2>Browse Tables</h2>

        <div style="margin-bottom:1.5rem;">
            <form action="browse_tables.php" method="GET" style="display:flex;gap:10px;max-width:420px;">
                <select name="table" onchange="this.form.submit()" style="flex:1;">
                    <?php foreach ($tables_map as $key => $details): ?>
                        <option value="<?= $key ?>" <?= ($table === $key) ? 'selected' : '' ?>>
                            <?= $details['title'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <noscript><button type="submit" class="btn">View</button></noscript>
            </form>
        </div>

        <div class="table-container">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
                <h3><?= htmlspecialchars($current['title']) ?></h3>
                <span style="color:var(--text-muted);font-size:0.9rem;"><?= $row_count ?> record<?= $row_count !== 1 ? 's' : '' ?></span>
            </div>

            <?php if ($row_count > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <?php foreach ($columns as $col): ?>
                                <th><?= htmlspecialchars($col) ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $row): ?>
                            <tr>
                                <?php foreach ($row as $cell): ?>
                                    <td><?= htmlspecialchars((string)($cell ?? '—')) ?></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p style="color:var(--text-muted);text-align:center;padding:2rem 0;">No records found in this table.</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
