<?php
session_start();
include "config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $linkedin = mysqli_real_escape_string($conn, $_POST['linkedin']);
    $github = mysqli_real_escape_string($conn, $_POST['github']);

    $sql = "INSERT INTO users
            (fullname, email, phone, linkedin, github)
            VALUES
            ('$fullname', '$email', '$phone', '$linkedin', '$github')";

    if (mysqli_query($conn, $sql)) {

        $_SESSION["user_id"] = mysqli_insert_id($conn);

        header("Location: skill_details.php");
        exit();

    } else {

        echo "Error: " . mysqli_error($conn);

    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Resume Management System</title>

    <link rel="stylesheet" href="asset/styles.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&display=swap" rel="stylesheet">
</head>

<body>

<div class="profile-container">

    <div class="profile-header">
        <div>

            <h1>Personal Details</h1>

            <p>

                Start building your professional resume by filling in your basic information.

            </p>

        </div>

    </div>

    <section>

        <form method="POST">

            <div class="form-grid">

                <div class="form-group">

                    <label>Full Name</label>

                    <input
                    type="text"
                    name="fullname"
                    placeholder="Enter your full name"
                    required>

                </div>

                <div class="form-group">

                    <label>Email Address</label>

                    <input
                    type="email"
                    name="email"
                    placeholder="Enter your email"
                    required>

                </div>

                <div class="form-group">

                    <label>Phone Number</label>

                    <input
                    type="text"
                    name="phone"
                    placeholder="Enter your phone number"
                    required>

                </div>

                <div class="form-group">

                    <label>LinkedIn Profile</label>

                    <input
                    type="url"
                    name="linkedin"
                    placeholder="https://linkedin.com/in/username">

                </div>

                <div class="form-group full">

                    <label>GitHub Profile</label>

                    <input
                    type="url"
                    name="github"
                    placeholder="https://github.com/username">

                </div>

            </div>

            <button
            type="submit"
            class="save-btn">

                Save & Continue →

            </button>

        </form>

    </section>

</div>

</body>
</html>