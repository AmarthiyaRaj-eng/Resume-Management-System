<?php
session_start();
include "config/db.php";

if (!isset($_SESSION["user_id"])) {
    die("User not found.");
}

$user_id = $_SESSION["user_id"];


$stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM users WHERE id=?"
);

mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);

$user = mysqli_fetch_assoc(
    mysqli_stmt_get_result($stmt)
);

$stmt = mysqli_prepare(
    $conn,
    "SELECT *
     FROM skills
     WHERE user_id=?"
);

mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);

$skills = mysqli_stmt_get_result($stmt);

$stmt = mysqli_prepare(
    $conn,
    "SELECT *
     FROM education
     WHERE user_id=?
     ORDER BY end_year DESC"
);

mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);

$education = mysqli_stmt_get_result($stmt);


$stmt = mysqli_prepare(
    $conn,
    "SELECT *
     FROM achievements
     WHERE user_id=?
     ORDER BY achievement_year DESC"
);

mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);

$achievements = mysqli_stmt_get_result($stmt);


$stmt = mysqli_prepare(
    $conn,
    "SELECT *
     FROM projects
     WHERE user_id=?"
);

mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);

$projects = mysqli_stmt_get_result($stmt);

$stmt = mysqli_prepare(
    $conn,
    "SELECT *
     FROM experience
     WHERE user_id=?
     ORDER BY start_date DESC"
);

mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);

$experience = mysqli_stmt_get_result($stmt);

?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Resume Preview</title>

<link
rel="stylesheet"
href="asset/resume.css">

</head>

<body>

<div class="resume">

<div class="header">

<h1>

<?php echo htmlspecialchars($user["fullname"]); ?>

</h1>

<div class="contact">

<p>

<?php echo htmlspecialchars($user["email"]); ?>

</p>

<p>

<?php echo htmlspecialchars($user["phone"]); ?>

</p>

<p>

<?php echo htmlspecialchars($user["linkedin"]); ?>

</p>

<p>

<?php echo htmlspecialchars($user["github"]); ?>

</p>

</div>

</div>

<section>

<h2>

Skills

</h2>

<ul>

<?php

while($row=mysqli_fetch_assoc($skills)){

?>

<li>

<strong>

<?php echo htmlspecialchars($row["skill_name"]); ?>

</strong>

-

<?php echo htmlspecialchars($row["skill_level"]); ?>

</li>

<?php

}

?>

</ul>

</section>


<section>

<h2>

Education

</h2>

<?php

while($row=mysqli_fetch_assoc($education)){

?>

<div class="card">

<h3>

<?php echo htmlspecialchars($row["degree"]); ?>

</h3>

<p>

<strong>

Institution:

</strong>

<?php echo htmlspecialchars($row["institution"]); ?>

</p>

<p>

<strong>

Specialization:

</strong>

<?php echo htmlspecialchars($row["specialization"]); ?>

</p>

<p>

<strong>

Percentage / CGPA:

</strong>

<?php echo htmlspecialchars($row["percentage"]); ?>

</p>

<p>

<?php
echo htmlspecialchars($row["start_year"]);
?>

-

<?php
echo htmlspecialchars($row["end_year"]);
?>

</p>

</div>

<?php

}

?>

</section>
<section>

<h2>

Achievements

</h2>

<?php

while($row = mysqli_fetch_assoc($achievements)){

?>

<div class="card">

<h3>

<?php echo htmlspecialchars($row["achievement_title"]); ?>

</h3>

<p>

<?php echo htmlspecialchars($row["description"]); ?>

</p>

<p>

<strong>Year:</strong>

<?php echo htmlspecialchars($row["achievement_year"]); ?>

</p>

</div>

<?php

}

?>

</section>

<section>

<h2>

Projects

</h2>

<?php

while($row = mysqli_fetch_assoc($projects)){

?>

<div class="card">

<h3>

<?php echo htmlspecialchars($row["project_title"]); ?>

</h3>

<p>

<strong>Technologies:</strong>

<?php echo htmlspecialchars($row["technologies"]); ?>

</p>

<p>

<?php echo nl2br(htmlspecialchars($row["description"])); ?>

</p>

<?php if(!empty($row["github_link"])) { ?>

<p>

<strong>GitHub:</strong>

<a
href="<?php echo htmlspecialchars($row["github_link"]); ?>"
target="_blank">

<?php echo htmlspecialchars($row["github_link"]); ?>

</a>

</p>

<?php } ?>

<?php if(!empty($row["demo_link"])) { ?>

<p>

<strong>Live Demo:</strong>

<a
href="<?php echo htmlspecialchars($row["demo_link"]); ?>"
target="_blank">

<?php echo htmlspecialchars($row["demo_link"]); ?>

</a>

</p>

<?php } ?>

</div>

<?php

}

?>

</section>


<section>

<h2>

Experience

</h2>

<?php

while($row = mysqli_fetch_assoc($experience)){

?>

<div class="card">

<h3>

<?php echo htmlspecialchars($row["job_title"]); ?>

</h3>

<p>

<strong>Company:</strong>

<?php echo htmlspecialchars($row["company_name"]); ?>

</p>

<p>

<strong>Employment Type:</strong>

<?php echo htmlspecialchars($row["employment_type"]); ?>

</p>

<p>

<strong>Duration:</strong>

<?php

echo htmlspecialchars($row["start_date"]);

echo " - ";

if($row["currently_working"]){

    echo "Present";

}else{

    echo htmlspecialchars($row["end_date"]);

}

?>

</p>

<p>

<?php echo nl2br(htmlspecialchars($row["description"])); ?>

</p>

</div>

<?php

}

?>

</section>


<div class="buttons">


<button onclick="window.location.href='index.php'">

⬅ Back

</button>

</div>

</div>

</body>

</html>