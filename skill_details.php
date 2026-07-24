<?php
session_start();
include "config/db.php";

if (!isset($_SESSION["user_id"])) {
    die("User not found. Please complete your personal details first.");
}

$user_id = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["skill_name"])) {

        $skills = $_POST["skill_name"];
        $levels = $_POST["skill_level"];

        for ($i = 0; $i < count($skills); $i++) {

            $skill = trim($skills[$i]);
            $level = $levels[$i];

            if ($skill == "")
                continue;

            $stmt = mysqli_prepare(
                $conn,
                "INSERT INTO skills(user_id, skill_name, skill_level)
                 VALUES(?,?,?)"
            );

            mysqli_stmt_bind_param(
                $stmt,
                "iss",
                $user_id,
                $skill,
                $level
            );

            mysqli_stmt_execute($stmt);
        }
    }

    exit();
}
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Skill Details</title>

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

    width:700px;
    background:white;
    padding:30px;
    border-radius:12px;
    box-shadow:0 0 20px rgba(0,0,0,.15);

}

h2{

    text-align:center;
    margin-bottom:30px;

}

.skill-row{

    display:flex;
    gap:10px;
    margin-bottom:15px;

}

.skill-row input{

    flex:2;
    padding:12px;
    border:1px solid #ccc;
    border-radius:8px;

}

.skill-row select{

    flex:1;
    padding:12px;
    border:1px solid #ccc;
    border-radius:8px;

}

.remove-btn{

    width:45px;
    border:none;
    background:#dc3545;
    color:white;
    border-radius:8px;
    cursor:pointer;

}

.remove-btn:hover{

    background:#bb2d3b;

}

.buttons{

    display:flex;
    gap:10px;
    margin-top:20px;

}

.add-btn{

    flex:1;
    background:#0d6efd;
    color:white;
    border:none;
    padding:12px;
    border-radius:8px;
    cursor:pointer;

}

.save-btn{

    flex:1;
    background:#198754;
    color:white;
    border:none;
    padding:12px;
    border-radius:8px;
    cursor:pointer;

}

.add-btn:hover{

    background:#0b5ed7;

}

.save-btn:hover{

    background:#157347;

}

</style>

</head>

<body>

<div class="container">

<h2>Skill Details</h2>

<form method="POST">

<div id="skills">

<div class="skill-row">

<input
type="text"
name="skill_name[]"
placeholder="Skill Name"
required>

<select name="skill_level[]">

<option>Beginner</option>
<option>Intermediate</option>
<option>Advanced</option>
<option>Expert</option>

</select>

<button
type="button"
class="remove-btn"
onclick="removeSkill(this)">
×
</button>

</div>

</div>

<div class="buttons">

<button
type="button"
class="add-btn"
onclick="addSkill()">

+ Add Skill

</button>

<button
type="submit"
class="save-btn">

Save & Continue

</button>

</div>

</form>

</div>

<script>

function addSkill(){

    let container=document.getElementById("skills");

    let div=document.createElement("div");

    div.className="skill-row";

    div.innerHTML=`

        <input
        type="text"
        name="skill_name[]"
        placeholder="Skill Name"
        required>

        <select name="skill_level[]">

            <option>Beginner</option>
            <option selected>Intermediate</option>
            <option>Advanced</option>
            <option>Expert</option>

        </select>

        <button
        type="button"
        class="remove-btn"
        onclick="removeSkill(this)">
        ×
        </button>

    `;

    container.appendChild(div);

}

function removeSkill(button){

    let rows=document.querySelectorAll(".skill-row");

    if(rows.length>1){

        button.parentElement.remove();

    }

}

</script>

</body>

</html>