<?php
$nameErr = $emailErr = $genderErr = $ageErr = $countryErr = "";
$name = $email = $gender = $age = $country = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty($_POST["name"])) {
        $nameErr = "{'error': You must provide a valid Name !}";
    } else {
        $name = test_input($_POST["name"]);
    }

    // Validate email
    if (empty($_POST["email"])) {
        $emailErr = "{'error': You must provide a valid Email !}";
    } else {
        $email = test_input($_POST["email"]);
    }

    // Validate age
    if (empty($_POST["age"])) {
        $ageErr = "{'error': You must provide a Age !}";
    } else {
        $age = test_input($_POST["age"]);
    }

    // Validate gender
    if (empty($_POST["gender"])) {
        $genderErr = "{'error': You must provide a Gender !}";
    } else {
        $gender = test_input($_POST["gender"]);
    }

    // Validate country
    if (empty($_POST["country"])) {
        $countryErr = "{'error': You must provide a Country !}";
    } else {
        $country = test_input($_POST["country"]);
    }
}

// Helper function to sanitize inputs
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<script>
    function showCountryHint(str) {
        if (str.length == 0) {
            document.getElementById("countryHint").innerHTML = "";
            return;
        } else {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("countryHint").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "getcountries.php?q=" + str, true);
            xmlhttp.send();
        }
    }

    function selectCountry(country) {
        document.getElementById("country").value = country;
        document.getElementById("countryHint").innerHTML = "";
    }
</script>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="index2.css">
    <title>PHP Form Validation Example</title>
</head>

<body>
    <?php include ('../view/header.php'); ?>
    <div class="container">
        

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            Name: <input type="text" name="name" value="<?php echo $name; ?>">
            <span class="error"> <?php echo $nameErr; ?></span>
            <br><br>

            E-mail: <input type="text" name="email" value="<?php echo $email; ?>">
            <span class="error"> <?php echo $emailErr; ?></span>
            <br><br>

            Age: <input type="text" name="age" value="<?php echo $age; ?>">
            <span class="error"> <?php echo $ageErr; ?></span>
            <br><br>

            <div class="gender">
                Gender:
                <input type="radio" name="gender" value="Female" <?php if (isset($gender) && $gender == "Female")
                    echo "checked"; ?>>Female
                <input type="radio" name="gender" value="Male" <?php if (isset($gender) && $gender == "Male")
                    echo "checked"; ?>>Male
                <input type="radio" name="gender" value="Other" <?php if (isset($gender) && $gender == "Other")
                    echo "checked"; ?>>Other
                <span class="error"> <?php echo $genderErr; ?></span>
                <br><br>
            </div>

            <label for="country">Country:</label>
            <input type="text" id="country" name="country" placeholder="South East Asian Country"
                onkeyup="showCountryHint(this.value)">
            <span class="error"> <?php echo $countryErr; ?></span>
            <p class="suggest">Suggestions: <span id="countryHint"></span></p>

            <input type="submit" name="submit" value="Submit">
        </form>
    </div>

    <?php
    // Display the input values if the form is submitted and validated
    if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($nameErr) && empty($emailErr) && empty($ageErr) && empty($genderErr) && empty($countryErr)) {
        $successClass = "success";
        echo "<h2 class='$successClass'>Your Input</h2>";
        echo "<p class='input-text'>Name: " . $name . "</p>";
        echo "<p class='input-text'>Email: " . $email . "</p>";
        echo "<p class='input-text'>Age: " . $age . "</p>";
        echo "<p class='input-text'>Gender: " . $gender . "</p>";
        echo "<p class='input-text'>Country: " . $country . "</p>";
    }
    ?>

<?php include ('../view/footer.php'); ?>
</body>

</html>