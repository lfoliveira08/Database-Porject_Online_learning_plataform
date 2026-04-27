<?php
require_once 'db_connect.php';

$message = '';
$message_type = '';
$editing = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id = (int)$_POST['grade_id'];

    if ($action === 'delete') {
        try {
            $stmt = $conn->prepare("DELETE FROM Grades WHERE grade_id = :id");
            $stmt->execute(['id' => $id]);
            $message = "Grade deleted successfully.";
            $message_type = "success";
        } catch (PDOException $e) {
            $message = "Database error: " . $e->getMessage();
            $message_type = "error";
        }
    } elseif ($action === 'update') {
        $score       = $_POST['score'];
        $submit_dt   = trim($_POST['submission_date']);
        $feedback    = trim($_POST['feedback']);

        if ($score === '' || $score < 0 || $score > 100) {
            $message = "Score must be between 0 and 100.";
            $message_type = "error";
        } else {
            try {
                $sql = "UPDATE Grades SET score=:score, submission_date=:sdt, feedback=:feedback WHERE grade_id=:id";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    'score'    => $score,
                    'sdt'      => empty($submit_dt) ? null : $submit_dt,
                    'feedback' => empty($feedback) ? null : $feedback,
                    'id'       => $id
                ]);
                $message = "Grade updated successfully!";
                $message_type = "success";
            } catch (PDOException $e) {
                $message = "Database error: " . $e->getMessage();
                $message_type = "error";
            }
        }
    }
}

if (isset($_GET['id'])) {
    $stmt = $conn->prepare("SELECT g.*, CONCAT(s.first_name,' ',s.last_name) AS student_name, c.course_name
                            FROM Grades g
                            JOIN Students s ON g.student_id = s.student_id
                            JOIN Assignments a ON g.assignment_id = a.assignment_id
                            JOIN Courses c ON a.course_id = c.course_id
                            WHERE g.grade_id = :id");
    $stmt->execute(['id' => (int)$_GET['id']]);
    $editing = $stmt->fetch(PDO::FETCH_ASSOC);
}

$grades = $conn->query("SELECT g.grade_id, g.score, g.submission_date, g.feedback,
                        CONCAT(s.first_name,' ',s.last_name) AS student_name, c.course_name
                        FROM Grades g
                        JOIN Students s ON g.student_id = s.student_id
                        JOIN Assignments a ON g.assignment_id = a.assignment_id
                        JOIN Courses c ON a.course_id = c.course_id
                        ORDER BY g.grade_id")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Grades | TechLearn</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'nav.php'; ?>
    <main>
        <?php if (!empty($message)): ?>
            <div class="alert alert-<?= $message_type ?>" style="max-width:900px;margin:0 auto 1.5rem;">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <?php if ($editing): ?>
        <div class="form-container">
            <h2>Edit Grade</h2>
            <p style="color:var(--text-muted);margin-bottom:1.5rem;">
                <?= htmlspecialchars($editing['student_name']) ?> &rarr; <?= htmlspecialchars($editing['course_name']) ?>
            </p>
            <form action="edit_grade.php" method="POST">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="grade_id" value="<?= $editing['grade_id'] ?>">
                <div class="form-group">
                    <label>Score (0–100) *</label>
                    <input type="number" name="score" min="0" max="100" step="0.01"
                           value="<?= htmlspecialchars($editing['score']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Submission Date</label>
                    <input type="date" name="submission_date" value="<?= htmlspecialchars($editing['submission_date'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Feedback</label>
                    <textarea name="feedback"><?= htmlspecialchars($editing['feedback'] ?? '') ?></textarea>
                </div>
                <button type="submit">Save Changes</button>
            </form>
            <div style="text-align:center;margin-top:1rem;">
                <a href="edit_grade.php" style="color:var(--text-muted);font-size:0.9rem;">Cancel</a>
            </div>
        </div>
        <?php endif; ?>

        <div class="table-container" style="max-width:900px;margin:0 auto;">
            <h2>All Grades</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Score</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($grades as $g): ?>
                    <tr>
                        <td><?= $g['grade_id'] ?></td>
                        <td><?= htmlspecialchars($g['student_name']) ?></td>
                        <td><?= htmlspecialchars($g['course_name']) ?></td>
                        <td><?= htmlspecialchars($g['score']) ?></td>
                        <td><?= htmlspecialchars($g['submission_date'] ?? '—') ?></td>
                        <td style="white-space:nowrap;">
                            <a href="edit_grade.php?id=<?= $g['grade_id'] ?>" class="btn-sm btn-edit">Edit</a>
                            <form method="POST" style="display:inline;"
                                  onsubmit="return confirm('Delete this grade? This cannot be undone.');">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="grade_id" value="<?= $g['grade_id'] ?>">
                                <button type="submit" class="btn-sm btn-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
