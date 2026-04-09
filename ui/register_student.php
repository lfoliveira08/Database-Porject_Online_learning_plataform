<?php
require_once 'db_connect.php';

$message = '';
$message_type = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = trim($_POST['first_name']);
    $lastName  = trim($_POST['last_name']);
    $email     = trim($_POST['email']);
    $phone     = trim($_POST['phone']);
    $dob       = trim($_POST['date_of_birth']);
    $enroll_dt = trim($_POST['enrollment_date']);

    // Validation
    if (empty($firstName) || empty($lastName) || empty($email)) {
        $message = "Please fill in all required fields.";
        $message_type = "error";
    } else {
        try {
            // Check for duplicate email
            $stmt = $conn->prepare("SELECT * FROM Students WHERE email = :email");
            $stmt->execute(['email' => $email]);
            if ($stmt->rowCount() > 0) {
                $message = "Email address is already in use.";
                $message_type = "error";
            } else {
                // Insert new student
                $sql = "INSERT INTO Students (first_name, last_name, email, phone, date_of_birth, enrollment_date) 
                        VALUES (:fname, :lname, :email, :phone, :dob, :edt)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    'fname' => $firstName,
                    'lname' => $lastName,
                    'email' => $email,
                    'phone' => empty($phone) ? null : $phone,
                    'dob'   => empty($dob) ? null : $dob,
                    'edt'   => empty($enroll_dt) ? null : $enroll_dt
                ]);
                $message = "Student registered successfully!";
                $message_type = "success";
            }
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
    <title>Student Registration | TechLearn</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'nav.php'; ?>

    <main>
        <div class="form-container">
            <h2>Add New Student</h2>

            <?php if (!empty($message)): ?>
                <div class="alert alert-<?= $message_type ?>">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>

            <form action="register_student.php" method="POST">
                <div class="form-group">
                    <label>First Name *</label>
                    <input type="text" name="first_name" required>
                </div>
                <div class="form-group">
                    <label>Last Name *</label>
                    <input type="text" name="last_name" required>
                </div>
                <div class="form-group">
                    <label>Email Address *</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone">
                </div>
                <div class="form-group">
                    <label>Date of Birth</label>
                    <input type="date" name="date_of_birth">
                </div>
                <div class="form-group">
                    <label>Enrollment Date</label>
                    <input type="date" name="enrollment_date" value="<?= date('Y-m-d') ?>">
                </div>
                <button type="submit">Register Student</button>
            </form>
        </div>
    </main>
</body>
</html>
