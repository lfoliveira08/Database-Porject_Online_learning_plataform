<?php
require_once 'db_connect.php';

$message = '';
$message_type = '';
$editing = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id = (int)$_POST['enrollment_id'];

    if ($action === 'delete') {
        try {
            $stmt = $conn->prepare("DELETE FROM Enrollments WHERE enrollment_id = :id");
            $stmt->execute(['id' => $id]);
            $message = "Enrollment deleted successfully.";
            $message_type = "success";
        } catch (PDOException $e) {
            $message = "Database error: " . $e->getMessage();
            $message_type = "error";
        }
    } elseif ($action === 'update') {
        $status      = $_POST['status'];
        $enroll_dt   = trim($_POST['enrollment_date']);

        if (empty($status)) {
            $message = "Status is required.";
            $message_type = "error";
        } else {
            try {
                $sql = "UPDATE Enrollments SET status=:status, enrollment_date=:dt WHERE enrollment_id=:id";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    'status' => $status,
                    'dt'     => empty($enroll_dt) ? null : $enroll_dt,
                    'id'     => $id
                ]);
                $message = "Enrollment updated successfully!";
                $message_type = "success";
            } catch (PDOException $e) {
                $message = "Database error: " . $e->getMessage();
                $message_type = "error";
            }
        }
    }
}

if (isset($_GET['id'])) {
    $stmt = $conn->prepare("SELECT e.*, CONCAT(s.first_name,' ',s.last_name) AS student_name, c.course_name
                            FROM Enrollments e
                            JOIN Students s ON e.student_id = s.student_id
                            JOIN Courses c ON e.course_id = c.course_id
                            WHERE e.enrollment_id = :id");
    $stmt->execute(['id' => (int)$_GET['id']]);
    $editing = $stmt->fetch(PDO::FETCH_ASSOC);
}

$enrollments = $conn->query("SELECT e.enrollment_id, e.enrollment_date, e.status,
                             CONCAT(s.first_name,' ',s.last_name) AS student_name, c.course_name
                             FROM Enrollments e
                             JOIN Students s ON e.student_id = s.student_id
                             JOIN Courses c ON e.course_id = c.course_id
                             ORDER BY e.enrollment_id")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Enrollments | TechLearn</title>
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
            <h2>Edit Enrollment</h2>
            <p style="color:var(--text-muted);margin-bottom:1.5rem;">
                <?= htmlspecialchars($editing['student_name']) ?> &rarr; <?= htmlspecialchars($editing['course_name']) ?>
            </p>
            <form action="edit_enrollment.php" method="POST">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="enrollment_id" value="<?= $editing['enrollment_id'] ?>">
                <div class="form-group">
                    <label>Enrollment Date</label>
                    <input type="date" name="enrollment_date" value="<?= htmlspecialchars($editing['enrollment_date'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Status *</label>
                    <select name="status" required>
                        <?php foreach (['Active', 'Completed', 'Dropped'] as $opt): ?>
                            <option value="<?= $opt ?>" <?= $editing['status'] === $opt ? 'selected' : '' ?>>
                                <?= $opt ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit">Save Changes</button>
            </form>
            <div style="text-align:center;margin-top:1rem;">
                <a href="edit_enrollment.php" style="color:var(--text-muted);font-size:0.9rem;">Cancel</a>
            </div>
        </div>
        <?php endif; ?>

        <div class="table-container" style="max-width:900px;margin:0 auto;">
            <h2>All Enrollments</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($enrollments as $e): ?>
                    <tr>
                        <td><?= $e['enrollment_id'] ?></td>
                        <td><?= htmlspecialchars($e['student_name']) ?></td>
                        <td><?= htmlspecialchars($e['course_name']) ?></td>
                        <td><?= htmlspecialchars($e['enrollment_date'] ?? '—') ?></td>
                        <td><?= htmlspecialchars($e['status']) ?></td>
                        <td style="white-space:nowrap;">
                            <a href="edit_enrollment.php?id=<?= $e['enrollment_id'] ?>" class="btn-sm btn-edit">Edit</a>
                            <form method="POST" style="display:inline;"
                                  onsubmit="return confirm('Delete this enrollment? This cannot be undone.');">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="enrollment_id" value="<?= $e['enrollment_id'] ?>">
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
