<?php
session_start();
include "config/db.php";

if (!isset($_SESSION["user_id"])) {
    die("User not found");
}

$user_id = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $titles = $_POST["project_title"];
    $techs = $_POST["technologies"];
    $descs = $_POST["description"];
    $githubs = $_POST["github_link"];
    $demos = $_POST["demo_link"];

    for ($i = 0; $i < count($titles); $i++) {

        $title = trim($titles[$i]);

        if ($title == "")
            continue;

        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO projects
            (user_id, project_title, technologies, description, github_link, demo_link)
            VALUES (?, ?, ?, ?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "isssss",
            $user_id,
            $title,
            $techs[$i],
            $descs[$i],
            $githubs[$i],
            $demos[$i]
        );

        mysqli_stmt_execute($stmt);
    }

    header("Location: experience_details.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Projects</title>

<style>

@import url('https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Alien+Block&family=Archivo+Black&family=BBH+Hegarty&family=BioRhyme+Expanded:wght@200;300;400;700;800&family=Bitcount+Grid+Double:wght@100..900&family=Bitcount+Prop+Single:wght@100..900&family=Changa+One:ital@0;1&family=Exo+2:ital,wght@0,100..900;1,100..900&family=Inconsolata:wght@200..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&family=Science+Gothic:wght@100..900&family=Stack+Sans+Notch:wght@200..700&display=swap');

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:"Roboto mono" , monospace;
}

body{
background:#f4f4f4;
display:flex;
justify-content:center;
align-items:center;
min-height:100vh;
}

.container{
width:800px;
background:white;
padding:30px;
border-radius:12px;
box-shadow:0 0 20px #ccc;
}

h2{
text-align:center;
margin-bottom:25px;
}

.project-box{
border:1px solid #ddd;
padding:20px;
margin-bottom:20px;
border-radius:10px;
}

input,textarea{
width:100%;
padding:12px;
margin-bottom:12px;
border:1px solid #ccc;
border-radius:8px;
}

textarea{
height:120px;
resize:vertical;
}

.buttons{
display:flex;
gap:10px;
}

button{
padding:12px;
border:none;
border-radius:8px;
cursor:pointer;
color:white;
font-size:16px;
}

.add{
background:#2563eb;
flex:1;
}

.save{
background:#16a34a;
flex:1;
}

.remove{
background:#dc2626;
width:100%;
}

</style>

</head>

<body>

<div class="container">

<h2>Projects</h2>

<form method="POST">

<div id="project-container">

<div class="project-box">

<input
type="text"
name="project_title[]"
placeholder="Project Title"
required>

<input
type="text"
name="technologies[]"
placeholder="Technologies Used">

<textarea
name="description[]"
placeholder="Project Description"></textarea>

<input
type="url"
name="github_link[]"
placeholder="GitHub Repository Link">

<input
type="url"
name="demo_link[]"
placeholder="Live Demo Link">

<button
type="button"
class="remove"
onclick="removeProject(this)">
Remove
</button>

</div>

</div>

<div class="buttons">

<button
type="button"
class="add"
onclick="addProject()">
+ Add Project
</button>

<button
type="submit"
class="save">
Save & Continue
</button>

</div>

</form>

</div>

<script>

function addProject(){

let container=document.getElementById("project-container");

let div=document.createElement("div");

div.className="project-box";

div.innerHTML=`

<input
type="text"
name="project_title[]"
placeholder="Project Title"
required>

<input
type="text"
name="technologies[]"
placeholder="Technologies Used">

<textarea
name="description[]"
placeholder="Project Description"></textarea>

<input
type="url"
name="github_link[]"
placeholder="GitHub Repository Link">

<input
type="url"
name="demo_link[]"
placeholder="Live Demo Link">

<button
type="button"
class="remove"
onclick="removeProject(this)">
Remove
</button>

`;

container.appendChild(div);

}

function removeProject(button){

let boxes=document.querySelectorAll(".project-box");

if(boxes.length>1){
button.parentElement.remove();
}

}

</script>

</body>
</html>