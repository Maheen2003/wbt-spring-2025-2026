<?php
// Initialize variables (empty strings to avoid undefined variable warnings)
$fnameErr = $lnameErr = $genderErr = $emailErr = $companyErr = $ROCErr = $topicErr = "";
$fname = $lname = $gender = $email = $company = $ROC = $topic = "";

// Sanitization function: trim → strip slashes → escape HTML
function cleanInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Process form only on POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // First Name
    if (empty($_POST["first_name"])) {
        $fnameErr = "First name is required";
    } else {
        $fname = cleanInput($_POST["first_name"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $fname)) {
            $fnameErr = "Only letters, hyphens, apostrophes, and spaces allowed";
        }
    }

    // Last Name
    if (empty($_POST["last_name"])) {
        $lnameErr = "Last name is required";
    } else {
        $lname = cleanInput($_POST["last_name"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $lname)) {
            $lnameErr = "Only letters, hyphens, apostrophes, and spaces allowed";
        }
    }

    // Gender (radio)
    if (empty($_POST["gender"])) {
        $genderErr = "Gender is required";
    } else {
        $gender = cleanInput($_POST["gender"]);
    }

    // Email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = cleanInput($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    // Company
    if (empty($_POST["company"])) {
        $companyErr = "Company name is required";
    } else {
        $company = cleanInput($_POST["company"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $company)) {
            $companyErr = "Only letters, hyphens, apostrophes, and spaces allowed";
        }
    }

    // Reason of Contact (ROC) — assuming "roc" field
    if (empty($_POST["roc"])) {
        $ROCErr = "Reason of contact is required";
    } else {
        $ROC = cleanInput($_POST["roc"]);
    }

    // Topic (dropdown)
    if (empty($_POST["topic"])) {
        $topicErr = "Please select a topic";
    } else {
        $topic = cleanInput($_POST["topic"]);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Me</title>
    <link rel="stylesheet" href="../css/contact.css">
</head>
<body>
    <nav>
        <a href="../index.html">Home</a>
        <a href="educations.html">Education</a>
        <a href="experience.html">Experience</a>
        <a href="projects.html">Projects</a>
        <a href="contact.html">Contact</a>
    </nav>

    <h1>Contact Me</h1>

    <form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <fieldset>
            <legend>Contact Information</legend>

            <table>
                <tr>
                    <td><label for="first_name">First name:</label></td>
                    <td>
                        <input type="text" id="first_name" name="first_name" value="<?= $fname ?>">
                        <span class="error"><?= $fnameErr ?></span>
                    </td>
                </tr>

                <tr>
                    <td><label for="last_name">Last name:</label></td>
                    <td>
                        <input type="text" id="last_name" name="last_name" value="<?= $lname ?>">
                        <span class="error"><?= $lnameErr ?></span>
                    </td>
                </tr>

                <tr>
                    <td><label>Gender:</label></td>
                    <td>
                        <input type="radio" name="gender" value="male" <?= ($gender === "male") ? "checked" : "" ?>> Male &nbsp;
                        <input type="radio" name="gender" value="female" <?= ($gender === "female") ? "checked" : "" ?>> Female
                        <span class="error"><?= $genderErr ?></span>
                    </td>
                </tr>

                <tr>
                    <td><label for="email">Email:</label></td>
                    <td>
                        <input type="email" id="email" name="email" value="<?= $email ?>">
                        <span class="error"><?= $emailErr ?></span>
                    </td>
                </tr>

                <tr>
                    <td><label for="company">Company:</label></td>
                    <td>
                        <input type="text" id="company" name="company" value="<?= $company ?>">
                        <span class="error"><?= $companyErr ?></span>
                    </td>
                </tr>

                <tr>
                    <td><label>Reason of Contact:</label></td>
                    <td>
                        <input type="checkbox" name="roc[]" value="project"> Project &nbsp;
                        <input type="checkbox" name="roc[]" value="thesis"> Thesis &nbsp;
                        <input type="checkbox" name="roc[]" value="job"> Job
                        <span class="error"><?= $ROCErr ?></span>
                    </td>
                </tr>

                <tr>
                    <td><label for="topic">Topic:</label></td>
                    <td>
                        <select id="topic" name="topic">
                            <option value="">-- Select --</option>
                            <option value="web" <?= ($topic === "web") ? "selected" : "" ?>>Web Development</option>
                            <option value="mobile" <?= ($topic === "mobile") ? "selected" : "" ?>>Mobile Development</option>
                            <option value="ai" <?= ($topic === "ai") ? "selected" : "" ?>>AI/ML Development</option>
                        </select>
                        <span class="error"><?= $topicErr ?></span>
                    </td>
                </tr>

                <tr>
                    <td><label for="date">Consultation Date:</label></td>
                    <td>
                        <input type="date" id="date" name="date">
                    </td>
                </tr>

                <tr>
                    <td></td>
                    <td>
                        <input type="submit" value="Submit">
                        <input type="reset" value="Clear">
                    </td>
                </tr>
            </table>
        </fieldset>
    </form>
</body>
</html>