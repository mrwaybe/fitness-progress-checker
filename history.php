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

    $sql = "SELECT f.log_date, f.weight, f.height, f.bmi, f.bmi_category, 
                   (SELECT m.protein_g FROM daily_macros m WHERE m.user_id = f.user_id AND m.log_date = f.log_date ORDER BY m.id DESC LIMIT 1) as protein_g 
            FROM fitness_logs f 
            WHERE f.user_id = 1 
            ORDER BY f.id DESC";
            
    $stmt = $pdo->query($sql);
    $logs = $stmt->fetchAll();

    if ($logs) {
        echo "<table>";
        echo "<tr><th>Date</th><th>Weight (kg)</th><th>Height (cm)</th><th>BMI</th><th>Category</th><th>Protein (g)</th></tr>";
        foreach ($logs as $log) {
            $protein = isset($log['protein_g']) ? $log['protein_g'] : '0';
            echo "<tr>";
            echo "<td>" . htmlspecialchars($log['log_date']) . "</td>";
            echo "<td>" . htmlspecialchars($log['weight']) . "</td>";
            echo "<td>" . htmlspecialchars($log['height']) . "</td>";
            echo "<td>" . htmlspecialchars($log['bmi']) . "</td>";
            echo "<td>" . htmlspecialchars($log['bmi_category']) . "</td>";
            echo "<td>" . htmlspecialchars($protein) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No fitness logs found.</p>";
    }
    ?>

</body>
</html>
