<?php
require_once 'db_connect.php';

$message = '';
$message_type = '';
$editing = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id = (int)$_POST['student_id'];

    if ($action === 'delete') {
        try {
            $stmt = $conn->prepare("DELETE FROM Students WHERE student_id = :id");
            $stmt->execute(['id' => $id]);
            $message = "Student deleted successfully.";
            $message_type = "success";
        } catch (PDOException $e) {
            $message = "Cannot delete: student has linked enrollments or grades. Remove those first.";
            $message_type = "error";
        }
    } elseif ($action === 'update') {
        $firstName = trim($_POST['first_name']);
        $lastName  = trim($_POST['last_name']);
        $email     = trim($_POST['email']);
        $phone     = trim($_POST['phone']);
        $dob       = trim($_POST['date_of_birth']);
        $enroll_dt = trim($_POST['enrollment_date']);

        if (empty($firstName) || empty($lastName) || empty($email)) {
            $message = "First name, last name, and email are required.";
            $message_type = "error";
        } else {
            try {
                $sql = "UPDATE Students SET first_name=:fname, last_name=:lname, email=:email,
                        phone=:phone, date_of_birth=:dob, enrollment_date=:edt
                        WHERE student_id=:id";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    'fname' => $firstName,
                    'lname' => $lastName,
                    'email' => $email,
                    'phone' => empty($phone) ? null : $phone,
                    'dob'   => empty($dob) ? null : $dob,
                    'edt'   => empty($enroll_dt) ? null : $enroll_dt,
                    'id'    => $id
                ]);
                $message = "Student updated successfully!";
                $message_type = "success";
            } catch (PDOException $e) {
                $message = "Database error: " . $e->getMessage();
                $message_type = "error";
            }
        }
    }
}

if (isset($_GET['id'])) {
    $stmt = $conn->prepare("SELECT * FROM Students WHERE student_id = :id");
    $stmt->execute(['id' => (int)$_GET['id']]);
    $editing = $stmt->fetch(PDO::FETCH_ASSOC);
}

$students = $conn->query("SELECT * FROM Students ORDER BY last_name, first_name")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Students | TechLearn</title>
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
            <h2>Edit Student</h2>
            <form action="edit_student.php" method="POST">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="student_id" value="<?= $editing['student_id'] ?>">
                <div class="form-group">
                    <label>First Name *</label>
                    <input type="text" name="first_name" value="<?= htmlspecialchars($editing['first_name']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Last Name *</label>
                    <input type="text" name="last_name" value="<?= htmlspecialchars($editing['last_name']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Email Address *</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($editing['email']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone" value="<?= htmlspecialchars($editing['phone'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Date of Birth</label>
                    <input type="date" name="date_of_birth" value="<?= htmlspecialchars($editing['date_of_birth'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Enrollment Date</label>
                    <input type="date" name="enrollment_date" value="<?= htmlspecialchars($editing['enrollment_date'] ?? '') ?>">
                </div>
                <button type="submit">Save Changes</button>
            </form>
            <div style="text-align:center;margin-top:1rem;">
                <a href="edit_student.php" style="color:var(--text-muted);font-size:0.9rem;">Cancel</a>
            </div>
        </div>
        <?php endif; ?>

        <div class="table-container" style="max-width:900px;margin:0 auto;">
            <h2>All Students</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $s): ?>
                    <tr>
                        <td><?= $s['student_id'] ?></td>
                        <td><?= htmlspecialchars($s['first_name'] . ' ' . $s['last_name']) ?></td>
                        <td><?= htmlspecialchars($s['email']) ?></td>
                        <td><?= htmlspecialchars($s['phone'] ?? '—') ?></td>
                        <td style="white-space:nowrap;">
                            <a href="edit_student.php?id=<?= $s['student_id'] ?>" class="btn-sm btn-edit">Edit</a>
                            <form method="POST" style="display:inline;"
                                  onsubmit="return confirm('Delete this student? This cannot be undone.');">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="student_id" value="<?= $s['student_id'] ?>">
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
