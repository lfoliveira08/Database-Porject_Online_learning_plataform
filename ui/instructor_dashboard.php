<?php
require_once 'db_connect.php';

try {
    // Main query to get all instructors and aggregate data
    $sql = "SELECT 
                i.instructor_id,
                i.first_name, 
                i.last_name, 
                i.specialty, 
                i.hire_date,
                COUNT(DISTINCT c.course_id) AS total_courses,
                COUNT(DISTINCT e.student_id) AS total_students
            FROM Instructors i
            LEFT JOIN Courses c ON i.instructor_id = c.instructor_id
            LEFT JOIN Enrollments e ON c.course_id = e.course_id AND e.status != 'Dropped'
            GROUP BY i.instructor_id
            ORDER BY i.first_name, i.last_name";
    
    $instructors = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    // Fetch detail data for courses to be shown on click
    $detail_sql = "SELECT i.instructor_id, c.course_name, COUNT(e.student_id) AS enrollees
                   FROM Instructors i
                   JOIN Courses c ON i.instructor_id = c.instructor_id
                   LEFT JOIN Enrollments e ON c.course_id = e.course_id AND e.status != 'Dropped'
                   GROUP BY i.instructor_id, c.course_id";
    $course_details_raw = $conn->query($detail_sql)->fetchAll(PDO::FETCH_ASSOC);
    
    $course_details = [];
    foreach($course_details_raw as $row) {
        $course_details[$row['instructor_id']][] = $row;
    }

} catch(PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Instructor Dashboard | TechLearn</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function toggleDetails(id) {
            var el = document.getElementById("details-" + id);
            if (el.style.display === "none") {
                el.style.display = "block";
            } else {
                el.style.display = "none";
            }
        }
    </script>
</head>
<body>
    <?php include 'nav.php'; ?>
    <main>
        <h2>Instructor Dashboard</h2>

        <div class="table-container" style="background: transparent; box-shadow: none; padding: 0;">
            <?php foreach($instructors as $inst): ?>
                <div class="instructor-card">
                    <h3 style="cursor: pointer; color: #1f4e79;" onclick="toggleDetails(<?= $inst['instructor_id'] ?>)">
                        <?= htmlspecialchars($inst['first_name'] . ' ' . $inst['last_name']) ?> <small style="font-size: 0.8rem; color: #555;">(Click to view courses)</small>
                    </h3>
                    <p><strong>Specialty:</strong> <?= htmlspecialchars($inst['specialty']) ?> | <strong>Hire Date:</strong> <?= htmlspecialchars($inst['hire_date']) ?></p>
                    <p><strong>Total Courses Taught:</strong> <?= $inst['total_courses'] ?> | <strong>Total Students:</strong> <?= $inst['total_students'] ?></p>

                    <div id="details-<?= $inst['instructor_id'] ?>" style="display: none; margin-top: 15px; border-top: 1px solid #ccc; padding-top: 10px;">
                        <h4>Courses:</h4>
                        <?php if (isset($course_details[$inst['instructor_id']])): ?>
                            <ul>
                            <?php foreach($course_details[$inst['instructor_id']] as $c): ?>
                                <li><?= htmlspecialchars($c['course_name']) ?> (<?= $c['enrollees'] ?> active/completed students)</li>
                            <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p>No courses currently assigned.</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>
