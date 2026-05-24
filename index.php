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

    <form method="post">
        <label for="weight">Weight in kilograms:</label>
        <input type="number" id="weight" name="weight" step="0.1" required>
        <br><br>

        <label for="height">Height in centimeters:</label>
        <input type="number" id="height" name="height" step="0.1" required>
        <br><br>

        <button type="submit">Calculate BMI</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
        } else {
            echo "<p>Please enter valid numbers.</p>";
        }
    }
    ?>

</body>
</html>
