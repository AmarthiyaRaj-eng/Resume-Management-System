<?php
session_start();
include "config/db.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);

    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {

        $error = "Please fill all the fields.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Invalid email address.";

    } elseif ($password != $confirm_password) {

        $error = "Passwords do not match.";

    } else {

        $check = mysqli_prepare(
            $conn,
            "SELECT id FROM user_login WHERE email=?"
        );

        mysqli_stmt_bind_param($check, "s", $email);

        mysqli_stmt_execute($check);

        $result = mysqli_stmt_get_result($check);

        if (mysqli_num_rows($result) > 0) {

            $error = "Email already exists.";

        } else {

            $hashedPassword = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $role = "user";

            $stmt = mysqli_prepare(
                $conn,
                "INSERT INTO user_login(name,email,password,role)
                 VALUES(?,?,?,?)"
            );

            mysqli_stmt_bind_param(
                $stmt,
                "ssss",
                $name,
                $email,
                $hashedPassword,
                $role
            );

            if (mysqli_stmt_execute($stmt)) {

                $success = "Registration Successful! Redirecting to Login...";

                header("refresh:2;url=login.php");

            } else {

                $error = "Registration Failed.";

            }

        }

    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Register</title>

<link rel="stylesheet" href="asset/register.css">

<link rel="preconnect"
href="https://fonts.googleapis.com">

<link rel="preconnect"
href="https://fonts.gstatic.com"
crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

</head>

<body>

<div class="container">

    <div class="left">

        <h1>Resume Management System</h1>

        <p>

            Build professional resumes,
            manage candidate profiles,
            search applicants,
            and organize everything
            from one place.

        </p>

        <ul>

            <li>✔ Resume Builder</li>

            <li>✔ Candidate Search</li>

            <li>✔ Projects & Experience</li>

            <li>✔ Resume Preview</li>

        </ul>

    </div>

    <div class="right">

        <form method="POST">

            <h2>Create Account</h2>

            <?php
            if($error!=""){
                echo "<div class='error'>$error</div>";
            }

            if($success!=""){
                echo "<div class='success'>$success</div>";
            }
            ?>

            <input
            type="text"
            name="name"
            placeholder="Full Name"
            required>

            <input
            type="email"
            name="email"
            placeholder="Email Address"
            required>

            <input
            type="password"
            id="password"
            name="password"
            placeholder="Password"
            required>

            <input
            type="password"
            id="confirm_password"
            name="confirm_password"
            placeholder="Confirm Password"
            required>

            <button type="submit">

                Create Account

            </button>

            <p class="bottom">

                Already have an account?

                <a href="login.php">

                    Login

                </a>

            </p>

        </form>

    </div>

</div>

</body>

</html>