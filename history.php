<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fitness History</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table { margin: 20px auto; border-collapse: collapse; width: 90%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #2874a6; color: white; }
    </style>
</head>
<body>

    <h1>Your Fitness Logs</h1>
    <nav>
        <a href="index.php">Calculate</a> | 
        <a href="history.php">View History</a> |
        <a href="members.php">Team Introductions</a>
    </nav>
    <br>

    <?php
    require_once 'db.php';

    $sql = "SELECT f.log_date, f.weight, f.height, f.bmi, f.bmi_category, m.protein_g 
            FROM fitness_logs f 
            LEFT JOIN daily_macros m ON f.user_id = m.user_id AND f.log_date = m.log_date 
            WHERE f.user_id = 1 
            ORDER BY f.log_date DESC";
            
    $stmt = $pdo->query($sql);
    $logs = $stmt->fetchAll();

    if ($logs) {
        echo "<table>";
        echo "<tr><th>Date</th><th>Weight (kg)</th><th>Height (cm)</th><th>BMI</th><th>Category</th><th>Protein (g)</th></tr>";
        foreach ($logs as $log) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($log['log_date']) . "</td>";
            echo "<td>" . htmlspecialchars($log['weight']) . "</td>";
            echo "<td>" . htmlspecialchars($log['height']) . "</td>";
            echo "<td>" . htmlspecialchars($log['bmi']) . "</td>";
            echo "<td>" . htmlspecialchars($log['bmi_category']) . "</td>";
            echo "<td>" . htmlspecialchars($log['protein_g'] ?? '0') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No fitness logs found.</p>";
    }
    ?>

</body>
</html>