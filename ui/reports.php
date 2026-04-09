<?php
require_once 'db_connect.php';

$report_type = $_GET['report'] ?? 'student_enrollment';

$reports_map = [
    'student_enrollment' => [
        'view' => 'vw_student_enrollment_summary',
        'title' => 'Student Enrollment Summary'
    ],
    'course_revenue' => [
        'view' => 'vw_course_revenue',
        'title' => 'Course Revenue Report'
    ],
    'instructor_performance' => [
        'view' => 'vw_instructor_performance',
        'title' => 'Instructor Performance'
    ],
    'top_students' => [
        'view' => 'vw_top_students_per_course',
        'title' => 'Top Students Per Course'
    ],
    'revenue_category' => [
        'view' => 'vw_revenue_by_category',
        'title' => 'Revenue by Category'
    ]
];

if (!array_key_exists($report_type, $reports_map)) {
    $report_type = 'student_enrollment';
}

$current_report = $reports_map[$report_type];
$data = [];
$columns = [];

try {
    $stmt = $conn->query("SELECT * FROM " . $current_report['view']);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($data) > 0) {
        $columns = array_keys($data[0]);
    }
} catch(PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reports Dashboard | TechLearn</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'nav.php'; ?>
    <main>
        <h2>Reports Dashboard</h2>
        
        <div style="margin-bottom: 20px;">
            <form action="reports.php" method="GET" style="display: flex; gap: 10px; max-width: 400px;">
                <select name="report" onchange="this.form.submit()" style="flex: 1;">
                    <?php foreach($reports_map as $key => $details): ?>
                        <option value="<?= $key ?>" <?= ($report_type == $key) ? 'selected' : '' ?>>
                            <?= $details['title'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <noscript><button type="submit" class="btn">View</button></noscript>
            </form>
        </div>

        <div class="table-container">
            <h3><?= $current_report['title'] ?></h3>
            <?php if (count($data) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <?php foreach($columns as $col): ?>
                                <th><?= ucwords(str_replace('_', ' ', $col)) ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data as $row): ?>
                            <tr>
                                <?php foreach($row as $cell): ?>
                                    <td><?= htmlspecialchars((string)$cell) ?></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No data available for this report.</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
