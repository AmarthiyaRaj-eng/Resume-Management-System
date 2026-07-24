<?php
session_start();
include "config/db.php";

$form = $_GET['form'] ?? 'signin';


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {

    $name = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if (mysqli_num_rows($check) > 0) {

        echo "<script>alert('Email already exists');</script>";

    } else {

        $sql = "INSERT INTO users(fullname,email,password,role)
                VALUES('$name','$email','$password','user')";

        if (mysqli_query($conn, $sql)) {

            echo "<script>alert('Account created successfully');</script>";
            $form = "signin";
        } else if(isset($users["fullname"])) {
            echo "<script>alert('User already exists. Please use another username');</script>";
        } else if(isset($users["email"])) {
            echo "<script>alert('Email already exists. PLease use another email adress');</script>";    
        }else if(isset($users["password"])){
            echo "<script>alert('Password already exist. PLease use another password');</script>";
        } else {
            echo "<script>alert('Registration failed');</script>";
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM user_login WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["fullname"];

            header("Location: index.php");
            exit();
        } else {
            echo "<script>alert('Invalid password');</script>";
        }
            
        echo "<script>alert('User not found');</script>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Login</title>

<link rel="stylesheet" href="asset/login.css">

</head>

<body>

<div class="login-container">

    <form method="POST" class="login-box">

        <h2>Resume Management System</h2>

        <p>Sign in to continue</p>


        <input
        type="email"
        name="email"
        placeholder="Email"
        required>

        <input
        type="password"
        name="password"
        placeholder="Password"
        required>

        <button type="submit" name="login">

            Login

        </button>

        <p>

            Don't have an account?

            <a href="register.php">

                Register

            </a>

        </p>

    </form>

</div>

</body>

</html>