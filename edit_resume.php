<?php

include "config/db.php";


if (!isset($_GET["id"])) {

    die("Invalid User ID.");

}


$user_id = (int)$_GET["id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if(isset($_POST["update_user"])) {


        $fullname = mysqli_real_escape_string(
            $conn,
            $_POST["fullname"]
        );


        $email = mysqli_real_escape_string(
            $conn,
            $_POST["email"]
        );


        $phone = mysqli_real_escape_string(
            $conn,
            $_POST["phone"]
        );


        $linkedin = mysqli_real_escape_string(
            $conn,
            $_POST["linkedin"]
        );


        $github = mysqli_real_escape_string(
            $conn,
            $_POST["github"]
        );


        $stmt = mysqli_prepare(
            $conn,
            "UPDATE users
             SET fullname=?,
                 email=?,
                 phone=?,
                 linkedin=?,
                 github=?
             WHERE id=?"
        );


        mysqli_stmt_bind_param(
            $stmt,
            "sssssi",
            $fullname,
            $email,
            $phone,
            $linkedin,
            $github,
            $user_id
        );


        mysqli_stmt_execute($stmt);


        echo "<script>alert('Personal details updated');</script>";

    }

}

$stmt = mysqli_prepare(
    $conn,
    "SELECT *
     FROM users
     WHERE id=?"
);


mysqli_stmt_bind_param(
    $stmt,
    "i",
    $user_id
);


mysqli_stmt_execute($stmt);


$user = mysqli_fetch_assoc(
    mysqli_stmt_get_result($stmt)
);



if(!$user){

    die("User not found.");

}

$stmt = mysqli_prepare(
    $conn,
    "SELECT *
     FROM skills
     WHERE user_id=?"
);


mysqli_stmt_bind_param(
    $stmt,
    "i",
    $user_id
);


mysqli_stmt_execute($stmt);


$skills = mysqli_stmt_get_result($stmt);


?>


<!DOCTYPE html>

<html>

<head>

<title>Edit Resume</title>

<link rel="stylesheet" href="asset/edit.css">

</head>

    <body>

    <div class="container">

    <h1>Edit Resume</h1>

    <h2>Personal Details</h2>

    <form method="POST">

    <input
    type="text"
    name="fullname"
    value="<?php echo htmlspecialchars($user['fullname']); ?>"
    placeholder="Full Name"
    required>

    <input
    type="email"
    name="email"
    value="<?php echo htmlspecialchars($user['email']); ?>"
    placeholder="Email"
    required>

    <input
    type="text"
    name="phone"
    value="<?php echo htmlspecialchars($user['phone']); ?>"
    placeholder="Phone">


    <input
    type="url"
    name="linkedin"
    value="<?php echo htmlspecialchars($user['linkedin']); ?>"
    placeholder="LinkedIn">


    <input
    type="url"
    name="github"
    value="<?php echo htmlspecialchars($user['github']); ?>"
    placeholder="Github">


    <button
    type="submit"
    name="update_user">

    Update Personal Details

    </button>


    </form>



    <h2>Skills</h2>


    <form method="POST">


    <?php

    while($skill = mysqli_fetch_assoc($skills)){

    ?>


    <input
    type="text"
    name="skill_name[]"
    value="<?php echo htmlspecialchars($skill['skill_name']); ?>">


    <select name="skill_level[]">

    <option
    <?php if($skill['skill_level']=="Beginner") echo "selected"; ?>>

    Beginner

    </option>


    <option
    <?php if($skill['skill_level']=="Intermediate") echo "selected"; ?>>

    Intermediate

    </option>


    <option
    <?php if($skill['skill_level']=="Advanced") echo "selected"; ?>>

    Advanced

    </option>


    <option
    <?php if($skill['skill_level']=="Expert") echo "selected"; ?>>

    Expert

    </option>


    </select>


    <?php

    }

    ?>