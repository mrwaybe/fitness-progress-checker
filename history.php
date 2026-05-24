<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fitness History</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table { margin: 20px auto; border-collapse: collapse; width: 80%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #2874a6; color: white; }
    </style>
</head>
<body>

    <h1>Your Fitness Logs</h1>
    <nav>
        <a href="index.php">Calculate</a> | 
        <a href="history.php">View History</a>
    </nav>
    <br>

    <?php
    require_once 'db.php';

    $stmt = $pdo->query("SELECT * FROM fitness_logs ORDER BY log_date DESC");
    $logs = $stmt->fetchAll();

    if ($logs) {
        echo "<table>";
        echo "<tr><th>Date</th><th>Weight (kg)</th><th>Height (cm)</th><th>BMI</th><th>Category</th></tr>";
        foreach ($logs as $log) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($log['log_date']) . "</td>";
            echo "<td>" . htmlspecialchars($log['weight']) . "</td>";
            echo "<td>" . htmlspecialchars($log['height']) . "</td>";
            echo "<td>" . htmlspecialchars($log['bmi']) . "</td>";
            echo "<td>" . htmlspecialchars($log['category']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No fitness logs found.</p>";
    }
    ?>

</body>
</html>