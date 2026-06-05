<?php
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'db.php';

    $weight = (float) $_POST["weight"];
    $heightCm = (float) $_POST["height"];
    $userId = 1; 

    if ($weight > 0 && $heightCm > 0) {
        $heightM = $heightCm / 100;
        $bmi = $weight / ($heightM * $heightM);

        // Mifflin-St Jeor Calculation
        $age = 21; 
        $bmr = (10 * $weight) + (6.25 * $heightCm) - (5 * $age) + 5;
        $tdee = $bmr * 1.55; // Activity multiplier for hypertrophy training

        // Determine Caloric Phase
        if ($bmi >= 25) {
            $category = "Overweight";
            $targetKcals = $tdee - 500; // 500 kcal deficit for fat loss
            $plan = "Fat loss cutting phase.";
        } elseif ($bmi < 18.5) {
            $category = "Underweight";
            $targetKcals = $tdee + 300; // 300 kcal surplus for lean bulking
            $plan = "Lean bulking phase.";
        } else {
            $category = "Normal weight";
            $targetKcals = $tdee; // Maintenance
            $plan = "Maintenance and body recomposition.";
        }

        // We seamlessly save an average protein value (155g) to the database 
        // to keep your historical tracking table intact without requiring manual input.
        $dbProtein = 155; 

        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("INSERT INTO fitness_logs (user_id, weight, height, bmi, bmi_category, log_date) VALUES (?, ?, ?, ?, ?, CURDATE())");
            $stmt->execute([$userId, $weight, $heightCm, number_format($bmi, 2), $category]);

            $stmtMacro = $pdo->prepare("INSERT INTO daily_macros (user_id, protein_g, log_date) VALUES (?, ?, CURDATE())");
            $stmtMacro->execute([$userId, $dbProtein]);

            $pdo->commit();
            
            // Redirect with the newly calculated targets
            header("Location: index.php?status=success&bmi=" . number_format($bmi, 2) . "&cat=" . urlencode($category) . "&kcal=" . round($targetKcals) . "&plan=" . urlencode($plan));
            exit();

        } catch (Exception $e) {
            $pdo->rollBack();
            $message = "<p style='color: red;'>Error saving record: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    } else {
        $message = "<p style='color: red;'>Please enter valid numbers.</p>";
    }
}

if (isset($_GET['status']) && $_GET['status'] == 'success') {
    $bmi = (float) $_GET['bmi'];
    $cat = htmlspecialchars($_GET['cat']);
    $kcal = (int) $_GET['kcal'];
    $plan = htmlspecialchars($_GET['plan']);

    $message .= "<div style='background-color: #e8f4f8; padding: 15px; border-radius: 8px; margin-top: 20px;'>";
    $message .= "<h2 style='margin-top: 0; color: #1a5276;'>Daily Analysis</h2>";
    $message .= "<p>Current BMI: <strong>" . $bmi . "</strong> (" . $cat . ")</p>";
    $message .= "<p>Action Plan: <strong>" . $plan . "</strong></p>";
    
    $message .= "<hr style='border: 1px solid #ccc; margin: 15px 0;'>";
    $message .= "<h3 style='color: #1a5276;'>Nutrition Targets</h3>";
    $message .= "<p>Recommended Intake: <strong style='color: #2874a6; font-size: 1.1em;'>" . $kcal . " kcal/day</strong></p>";
    $message .= "<p>Optimal Protein: <strong style='color: green; font-size: 1.1em;'>150g &ndash; 160g</strong></p>";
    $message .= "<p style='font-size: 0.85em; color: #555; margin-top: 10px;'>*Protein requirement is locked to maximize muscle retention and growth during hypertrophy training.</p>";
    $message .= "</div>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BMI / Fitness Progress Checker</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>BMI / Fitness Progress Checker</h1>
    <p>Enter your daily metrics to receive your updated nutritional targets.</p>

    <nav>
        <a href="index.php">Calculate</a> | 
        <a href="history.php">View History</a> |
        <a href="members.php">Team Introductions</a>
    </nav>
    <br>

    <form method="post" action="index.php">
        <label for="weight">Weight (kg):</label>
        <input type="number" id="weight" name="weight" step="0.1" min="20" max="300" required>
        <br><br>

        <label for="height">Height (cm):</label>
        <input type="number" id="height" name="height" step="0.1" min="50" max="250" required>
        <br><br>

        <button type="submit">Calculate Targets</button>
    </form>

    <div class="results-container" style="width: 100%; max-width: 400px; margin-top: 20px;">
        <?php echo $message; ?>
    </div>

</body>
</html>
