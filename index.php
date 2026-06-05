<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BMI / Fitness Progress Checker</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>BMI / Fitness Progress Checker</h1>
    <p>Enter your daily metrics below.</p>

    <nav>
        <a href="index.php">Calculate</a> | 
        <a href="history.php">View History</a> |
        <a href="members.php">Team Introductions</a>
    </nav>
    <br>

    <form method="post">
        <label for="weight">Weight (kg):</label>
        <input type="number" id="weight" name="weight" step="0.1" required>
        <br><br>

        <label for="height">Height (cm):</label>
        <input type="number" id="height" name="height" step="0.1" required>
        <br><br>

        <label for="protein">Daily Protein Intake (g):</label>
        <input type="number" id="protein" name="protein" step="1" required>
        <br><br>

        <button type="submit">Save Daily Log</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require_once 'db.php';

        $weight = (float) $_POST["weight"];
        $heightCm = (float) $_POST["height"];
        $protein = (int) $_POST["protein"];
        $userId = 1; // Default user from schema

        if ($weight > 0 && $heightCm > 0) {
            $heightM = $heightCm / 100;
            $bmi = $weight / ($heightM * $heightM);

            if ($bmi < 18.5) {
                $category = "Underweight";
            } elseif ($bmi < 25) {
                $category = "Normal weight";
            } elseif ($bmi < 30) {
                $category = "Overweight";
            } else {
                $category = "Obese";
            }

            echo "<h2>Result</h2>";
            echo "<p>Your BMI is: " . number_format($bmi, 2) . "</p>";
            echo "<p>Category: " . $category . "</p>";

            if ($protein >= 150 && $protein <= 160) {
                echo "<p style='color: green;'>Optimal daily protein target (150g - 160g) achieved.</p>";
            } elseif ($protein < 150) {
                echo "<p style='color: orange;'>Protein intake is below the 150g - 160g target range.</p>";
            }

            try {
                $pdo->beginTransaction();

                // Save to fitness_logs
                $stmt = $pdo->prepare("INSERT INTO fitness_logs (user_id, weight, height, bmi, bmi_category, log_date) VALUES (?, ?, ?, ?, ?, CURDATE())");
                $stmt->execute([$userId, $weight, $heightCm, number_format($bmi, 2), $category]);

                // Save to daily_macros
                $stmtMacro = $pdo->prepare("INSERT INTO daily_macros (user_id, protein_g, log_date) VALUES (?, ?, CURDATE())");
                $stmtMacro->execute([$userId, $protein]);

                $pdo->commit();
                echo "<p style='color: green;'>Record saved successfully.</p>";
            } catch (Exception $e) {
                $pdo->rollBack();
                echo "<p style='color: red;'>Error saving record: " . $e->getMessage() . "</p>";
            }

        } else {
            echo "<p>Please enter valid numbers.</p>";
        }
    }
    ?>

</body>
</html>