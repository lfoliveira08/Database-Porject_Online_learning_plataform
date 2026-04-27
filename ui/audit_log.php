<?php
require_once 'db_connect.php';

$filter_table  = $_GET['table']  ?? 'all';
$filter_action = $_GET['action'] ?? 'all';

$allowed_tables  = ['all', 'Students', 'Instructors', 'Courses', 'Categories', 'Enrollments', 'Assignments', 'Grades'];
$allowed_actions = ['all', 'INSERT', 'UPDATE', 'DELETE'];

if (!in_array($filter_table, $allowed_tables))  $filter_table  = 'all';
if (!in_array($filter_action, $allowed_actions)) $filter_action = 'all';

$where = [];
$params = [];

if ($filter_table !== 'all') {
    $where[] = 'table_name = :tbl';
    $params['tbl'] = $filter_table;
}
if ($filter_action !== 'all') {
    $where[] = 'action = :act';
    $params['act'] = $filter_action;
}

$sql = "SELECT * FROM audit_log";
if ($where) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " ORDER BY changed_at DESC";

$data = [];
try {
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

$action_colors = [
    'INSERT' => '#34d399',
    'UPDATE' => '#60a5fa',
    'DELETE' => '#f87171',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Audit Log | TechLearn</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'nav.php'; ?>
    <main>
        <h2>Audit Log</h2>
        <p style="color:var(--text-muted);margin-top:-1rem;margin-bottom:1.5rem;">
            Every create, edit, and delete is recorded here automatically.
        </p>

        <form action="audit_log.php" method="GET"
              style="display:flex;gap:10px;max-width:560px;margin-bottom:1.5rem;">
            <select name="table" onchange="this.form.submit()" style="flex:1;">
                <option value="all" <?= $filter_table === 'all' ? 'selected' : '' ?>>All Tables</option>
                <?php foreach (['Students','Instructors','Courses','Categories','Enrollments','Assignments','Grades'] as $t): ?>
                    <option value="<?= $t ?>" <?= $filter_table === $t ? 'selected' : '' ?>><?= $t ?></option>
                <?php endforeach; ?>
            </select>
            <select name="action" onchange="this.form.submit()" style="flex:1;">
                <option value="all"   <?= $filter_action === 'all'    ? 'selected' : '' ?>>All Actions</option>
                <option value="INSERT" <?= $filter_action === 'INSERT' ? 'selected' : '' ?>>INSERT (Create)</option>
                <option value="UPDATE" <?= $filter_action === 'UPDATE' ? 'selected' : '' ?>>UPDATE (Edit)</option>
                <option value="DELETE" <?= $filter_action === 'DELETE' ? 'selected' : '' ?>>DELETE</option>
            </select>
            <noscript><button type="submit" class="btn">Filter</button></noscript>
        </form>

        <div class="table-container">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
                <h3>Activity History</h3>
                <span style="color:var(--text-muted);font-size:0.9rem;"><?= count($data) ?> record<?= count($data) !== 1 ? 's' : '' ?></span>
            </div>

            <?php if (count($data) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Action</th>
                            <th>Table</th>
                            <th>Record ID</th>
                            <th>Summary</th>
                            <th>Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $row): ?>
                        <tr>
                            <td><?= $row['log_id'] ?></td>
                            <td>
                                <span style="
                                    color: <?= $action_colors[$row['action']] ?? 'white' ?>;
                                    font-weight: 600;
                                    font-size: 0.8rem;
                                    letter-spacing: 0.5px;">
                                    <?= htmlspecialchars($row['action']) ?>
                                </span>
                            </td>
                            <td style="color:var(--text-muted);"><?= htmlspecialchars($row['table_name']) ?></td>
                            <td><?= htmlspecialchars($row['record_id'] ?? '—') ?></td>
                            <td><?= htmlspecialchars($row['summary'] ?? '—') ?></td>
                            <td style="color:var(--text-muted);font-size:0.88rem;white-space:nowrap;">
                                <?= htmlspecialchars($row['changed_at']) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p style="color:var(--text-muted);text-align:center;padding:2rem 0;">No activity recorded yet.</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
