<?php

$fnameErr = $lnameErr = $contactErr = $passwordErr = $emailErr = "";
$fname = $lname = $contact = $email = $password = "";
$successMsg = "";  // For success message

// Database connection
$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASS = "";
$DB_NAME = "webtech";

$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

//removes unnecessary whitespace and special charecter
function cleanInput($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

//indentation after this if must be maintained otherwise form validation will not work properly
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (empty($_POST["first_name"]))
    {
        $fnameErr = "This name field must be filled up";
    }
    else
    {
        $fname = cleanInput($_POST["first_name"]);

        //checks for special charecter
        if (!preg_match("/^[a-zA-Z-' ]*$/", $fname))
        {
            $fnameErr = "Only letters and white space allowed";
        }
    }

    if (empty($_POST["last_name"]))
    {
        $lnameErr = "This name field must be filled up";
    }
    else
    {
        $lname = cleanInput($_POST["last_name"]);

        //checks for special charecter
        if (!preg_match("/^[a-zA-Z-' ]*$/", $lname))
        {
            $lnameErr = "Only letters and white space allowed";
        }
    }

    if (empty($_POST["contact"]))
    {
        $contactErr = "This contact field must be filled up";
    }
    else
    {
        $contact = cleanInput($_POST["contact"]);
        // Validate contact number (only digits, 10-15 characters)
        if (!preg_match("/^[0-9]{10,15}$/", $contact))
        {
            $contactErr = "Invalid contact number (10-15 digits only)";
        }
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = cleanInput($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    if (empty($_POST["password"]))
    {
        $passwordErr = "This password field must be filled up";
    }
    elseif(strlen($_POST["password"]) <= 8){
        $passwordErr = "The password must have atleast 8 charechters";
    }
    else
    {
        $password = $_POST["password"];  // Don't clean password before hashing
    }

    // If no errors, insert into database
    if ($fnameErr == "" && $lnameErr == "" && $contactErr == "" && $emailErr == "" && $passwordErr == "")
    {
        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL statement to prevent SQL injection
        $stmt = mysqli_prepare($conn, "INSERT INTO students (fname, lname, contact, email, password) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssiss", $fname, $lname, $contact, $email, $hashedPassword);

        if (mysqli_stmt_execute($stmt)) {
            $successMsg = "Registration successful!";
            // Clear form fields after successful registration
            $fname = $lname = $contact = $email = $password = "";
        } else {
            // Check for duplicate email
            if (mysqli_errno($conn) == 1062) {
                $emailErr = "This email is already registered";
            } else {
                $successMsg = "Error: " . mysqli_stmt_error($stmt);
            }
        }
        mysqli_stmt_close($stmt);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Signup</title>
</head>

<body>

    <h1>Signup as new user!</h1>

    <?php if ($successMsg != ""): ?>
        <p style="color: green; font-weight: bold;"><?= $successMsg ?></p>
    <?php endif; ?>

    <form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

        <fieldset>

            <legend>Personal information</legend>
            <!--Gives the field a title-->

            <table>

                <tr>
                    <td>
                        <label for="first_name">First name:</label>
                    </td>
                    <td>
                        <input type="text" id="first_name" name="first_name" value="<?= $fname ?>">
                    </td>
                    <td>
                        <span style="color:red;">
                            <?= $fnameErr ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="last_name">Last name:</label>
                    </td>
                    <td>
                        <input type="text" id="last_name" name="last_name" value="<?= $lname ?>">
                    </td>
                    <td>
                        <span style="color:red;">
                            <?= $lnameErr ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="contact">Contact:</label>
                    </td>
                    <td>
                        <input type="text" id="contact" name="contact" value="<?= $contact ?>">
                    </td>
                    <td>
                        <span style="color:red;">
                            <?= $contactErr ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>Email <span class="required">*</span></td>
                    <td>
                        <input type="text" name="email" value="<?= $email ?>">
                    </td>
                    <td>
                        <span style="color:red;">
                            <?= $emailErr ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="password">Password:</label>
                    </td>
                    <td>
                        <input type="password" id="password" name="password">
                    </td>
                    <td>
                        <span style="color:red;">
                            <?= $passwordErr ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td colspan="3">
                        <input type="submit" value="Register">
                    </td>
                </tr>

            </table>

        </fieldset>

    </form>

</body>

</html>