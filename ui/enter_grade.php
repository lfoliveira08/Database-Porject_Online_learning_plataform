<?php
require_once 'db_connect.php';

$message = '';
$message_type = '';

try {
    $students = $conn->query("SELECT student_id, CONCAT(first_name, ' ', last_name) AS full_name FROM Students ORDER BY first_name")->fetchAll(PDO::FETCH_ASSOC);
    $assignments = $conn->query("SELECT a.assignment_id, c.course_name AS title FROM Assignments a JOIN Courses c ON a.course_id = c.course_id ORDER BY c.course_name")->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentId     = $_POST['student_id'];
    $assignmentId  = $_POST['assignment_id'];
    $score         = $_POST['score'];
    $submit_dt     = $_POST['submission_date'];
    $feedback      = trim($_POST['feedback']);

    if (empty($studentId) || empty($assignmentId) || $score === '') {
        $message = "Please fill in all required fields.";
        $message_type = "error";
    } elseif ($score < 0 || $score > 100) {
        $message = "Score must be between 0 and 100.";
        $message_type = "error";
    } else {
        try {
            $sql = "INSERT INTO Grades (student_id, assignment_id, score, submission_date, feedback) 
                    VALUES (:sid, :aid, :score, :sdt, :feedback)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                'sid'      => $studentId,
                'aid'      => $assignmentId,
                'score'    => $score,
                'sdt'      => empty($submit_dt) ? date('Y-m-d') : $submit_dt,
                'feedback' => empty($feedback) ? null : $feedback
            ]);
            $message = "Grade submitted successfully!";
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
    <title>Enter Grade | TechLearn</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'nav.php'; ?>
    <main>
        <div class="form-container">
            <h2>Enter Student Grade</h2>

            <?php if (!empty($message)): ?>
                <div class="alert alert-<?= $message_type ?>">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>

            <form action="enter_grade.php" method="POST">
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
                    <label>Select Assignment *</label>
                    <select name="assignment_id" required>
                        <option value="">-- Choose an Assignment --</option>
                        <?php foreach($assignments as $a): ?>
                            <option value="<?= $a['assignment_id'] ?>"><?= htmlspecialchars($a['title']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Score (0-100) *</label>
                    <input type="number" name="score" min="0" max="100" step="0.01" required>
                </div>
                <div class="form-group">
                    <label>Submission Date</label>
                    <input type="date" name="submission_date" value="<?= date('Y-m-d') ?>">
                </div>
                <div class="form-group">
                    <label>Feedback</label>
                    <textarea name="feedback" placeholder="Optional comments on the assignment"></textarea>
                </div>
                <button type="submit">Submit Grade</button>
            </form>
        </div>
    </main>
</body>
</html>
