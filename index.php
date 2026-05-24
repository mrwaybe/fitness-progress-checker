<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BMI / Fitness Progress Checker</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>BMI / Fitness Progress Checker</h1>
    <p>Enter your information below to calculate your BMI.</p>

    <nav>
        <a href="index.php">Calculate</a> | 
        <a href="history.php">View History</a>
    </nav>
    <br>

    <form method="post">
        <label for="weight">Weight in kilograms:</label>
        <input type="number" id="weight" name="weight" step="0.1" required>
        <br><br>

        <label for="height">Height in centimeters:</label>
        <input type="number" id="height" name="height" step="0.1" required>
        <br><br>

        <button type="submit">Calculate and Save BMI</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require_once 'db.php';

        $weight = (float) $_POST["weight"];
        $heightCm = (float) $_POST["height"];

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

            // Save to database
            $stmt = $pdo->prepare("INSERT INTO fitness_logs (weight, height, bmi, category, log_date) VALUES (?, ?, ?, ?, NOW())");
            if ($stmt->execute([$weight, $heightCm, number_format($bmi, 2), $category])) {
                echo "<p style='color: green;'>Record saved successfully.</p>";
            } else {
                echo "<p style='color: red;'>Error saving record.</p>";
            }

        } else {
            echo "<p>Please enter valid numbers.</p>";
        }
    }
    ?>

</body>
</html>