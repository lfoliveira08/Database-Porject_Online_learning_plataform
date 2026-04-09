<?php
require_once 'db_connect.php';

$message = '';
$message_type = '';

// Fetch all students and courses for dropdowns
try {
    $students = $conn->query("SELECT student_id, CONCAT(first_name, ' ', last_name) AS full_name FROM Students ORDER BY first_name")->fetchAll(PDO::FETCH_ASSOC);
    $courses = $conn->query("SELECT course_id, course_name FROM Courses ORDER BY course_name")->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentId = $_POST['student_id'];
    $courseId  = $_POST['course_id'];
    $enroll_dt = $_POST['enrollment_date'];
    $status    = $_POST['status'];

    if (empty($studentId) || empty($courseId) || empty($status)) {
        $message = "Please select a student, course, and status.";
        $message_type = "error";
    } else {
        try {
            // Insert enrollment
            $sql = "INSERT INTO Enrollments (student_id, course_id, enrollment_date, status) 
                    VALUES (:sid, :cid, :dt, :status)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                'sid'    => $studentId,
                'cid'    => $courseId,
                'dt'     => empty($enroll_dt) ? date('Y-m-d') : $enroll_dt,
                'status' => $status
            ]);
            $message = "Student enrolled successfully!";
            $message_type = "success";
        } catch(PDOException $e) {
            $message = "Database error: " . $e->getMessage();
            $message_type = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Course Enrollment | TechLearn</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'nav.php'; ?>
    <main>
        <div class="form-container">
            <h2>Enroll Student</h2>

            <?php if (!empty($message)): ?>
                <div class="alert alert-<?= $message_type ?>">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>

            <form action="enroll_student.php" method="POST">
                <div class="form-group">
                    <label>Select Student *</label>
                    <select name="student_id" required>
                        <option value="">-- Choose a Student --</option>
                        <?php foreach($students as $s): ?>
                            <option value="<?= $s['student_id'] ?>"><?= htmlspecialchars($s['full_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Select Course *</label>
                    <select name="course_id" required>
                        <option value="">-- Choose a Course --</option>
                        <?php foreach($courses as $c): ?>
                            <option value="<?= $c['course_id'] ?>"><?= htmlspecialchars($c['course_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Enrollment Date</label>
                    <input type="date" name="enrollment_date" value="<?= date('Y-m-d') ?>">
                </div>
                <div class="form-group">
                    <label>Status *</label>
                    <select name="status" required>
                        <option value="Active">Active</option>
                        <option value="Completed">Completed</option>
                        <option value="Dropped">Dropped</option>
                    </select>
                </div>
                <button type="submit">Enroll Student</button>
            </form>
        </div>
    </main>
</body>
</html>
