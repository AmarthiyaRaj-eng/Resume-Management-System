<?php

include "config/db.php";

if(!isset($_GET["id"])){

    die("Invalid Candidate");

}

$user_id = $_GET["id"];

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

$user_result = mysqli_stmt_get_result($stmt);

$user = mysqli_fetch_assoc($user_result);



if(!$user){

    die("Candidate not found");

}


$education = mysqli_query(
    $conn,
    "SELECT *
     FROM education
     WHERE user_id=$user_id"
);

$skills = mysqli_query(
    $conn,
    "SELECT *
     FROM skills
     WHERE user_id=$user_id"
);


$experience = mysqli_query(
    $conn,
    "SELECT *
     FROM experience
     WHERE user_id=$user_id"
);


$projects = mysqli_query(
    $conn,
    "SELECT *
     FROM projects
     WHERE user_id=$user_id"
);


$achievements = mysqli_query(
    $conn,
    "SELECT *
     FROM achievements
     WHERE user_id=$user_id"
);



?>


<!DOCTYPE html>
<html>

<head>

<title>
Candidate Profile
</title>


<link rel="stylesheet" href="asset/candidate_profile.css">


</head>


<body>


<div class="profile-container">


<div class="profile-header">


<div class="avatar">

<?php echo strtoupper(substr($user["fullname"],0,1)); ?>

</div>


<div>

<h1>

<?php echo $user["fullname"]; ?>

</h1>


<p>

<?php echo $user["email"]; ?>

</p>


<p>

<?php echo $user["phone"]; ?>

</p>


<div class="links">

<?php if($user["linkedin"]!=""){ ?>

<a href="<?php echo $user["linkedin"]; ?>">
LinkedIn
</a>

<?php } ?>


<?php if($user["github"]!=""){ ?>

<a href="<?php echo $user["github"]; ?>">
GitHub
</a>

<?php } ?>

</div>


</div>


</div>

<section>

<h2>
Education
</h2>


<?php while($row=mysqli_fetch_assoc($education)){ ?>


<div class="card">

<h3>

<?php echo $row["degree"]; ?>

</h3>


<p>
<?php echo $row["institution"]; ?>
</p>


<p>
<?php echo $row["specialization"]; ?>
</p>


<p>

<?php echo $row["percentage"]; ?>%

|

<?php echo $row["start_year"]; ?>

-

<?php echo $row["end_year"]; ?>

</p>


</div>


<?php } ?>


</section>

<section>

<h2>
Skills
</h2>


<div class="skill-container">


<?php while($row=mysqli_fetch_assoc($skills)){ ?>


<div class="skill">

<span>

<?php echo $row["skill_name"]; ?>

</span>


<small>

<?php echo $row["skill_level"]; ?>

</small>


</div>


<?php } ?>


</div>


</section>

<section>

<h2>
Experience
</h2>


<?php while($row=mysqli_fetch_assoc($experience)){ ?>


<div class="card">


<h3>

<?php echo $row["job_title"]; ?>

</h3>


<h4>

<?php echo $row["company_name"]; ?>

</h4>


<p>

<?php echo $row["employment_type"]; ?>

</p>


<p>

<?php echo $row["start_date"]; ?>

-

<?php

if($row["currently_working"]=="Yes"){

echo "Present";

}

else{

echo $row["end_date"];

}

?>

</p>


<p>

<?php echo $row["description"]; ?>

</p>


</div>


<?php } ?>


</section>
<section>

<h2>
Projects
</h2>


<?php while($row=mysqli_fetch_assoc($projects)){ ?>


<div class="card">


<h3>

<?php echo $row["project_title"]; ?>

</h3>


<p>

<b>Technologies:</b>

<?php echo $row["technologies"]; ?>

</p>


<p>

<?php echo $row["description"]; ?>

</p>


<?php if($row["github_link"]!=""){ ?>

<a href="<?php echo $row["github_link"]; ?>">
GitHub
</a>

<?php } ?>


<?php if($row["demo_link"]!=""){ ?>

<a href="<?php echo $row["demo_link"]; ?>">
Live Demo
</a>

<?php } ?>


</div>


<?php } ?>


</section>

<section>

<h2>
Achievements
</h2>


<?php while($row=mysqli_fetch_assoc($achievements)){ ?>


<div class="card">


<h3>

<?php echo $row["achievement_title"]; ?>

</h3>


<p>

<?php echo $row["description"]; ?>

</p>


<p>

<?php echo $row["achievement_year"]; ?>

</p>


</div>


<?php } ?>


</section>



</div>
</body>
</html>