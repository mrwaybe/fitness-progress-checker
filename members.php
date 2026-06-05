<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Team Introductions</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .member-card { border: 1px solid #ccc; padding: 15px; margin: 15px auto; width: 60%; border-radius: 5px; background: #f9f9f9; }
        .member-card h2 { margin-top: 0; color: #2874a6; }
        .role { font-weight: bold; color: #555; }
    </style>
</head>
<body>

    <h1>Project Team</h1>
    <nav>
        <a href="index.php">Calculate</a> | 
        <a href="history.php">View History</a> |
        <a href="members.php">Team Introductions</a>
    </nav>
    <br>

    <?php
    require_once 'db.php';

    $stmt = $pdo->query("SELECT name, role, bio FROM team_members ORDER BY id ASC");
    $members = $stmt->fetchAll();

    if ($members) {
        foreach ($members as $member) {
            echo "<div class='member-card'>";
            echo "<h2>" . htmlspecialchars($member['name']) . "</h2>";
            echo "<p class='role'>Role: " . htmlspecialchars($member['role']) . "</p>";
            echo "<p>" . htmlspecialchars($member['bio']) . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No team members found in the database.</p>";
    }
    ?>

</body>
</html>