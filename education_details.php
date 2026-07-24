<?php

session_start();

include "config/db.php";


if (!isset($_SESSION["user_id"])) {

    die("User not found");

}


$user_id = $_SESSION["user_id"];



if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $degrees = $_POST["degree"];
    $institutions = $_POST["institution"];
    $start_years = $_POST["start_year"];
    $end_years = $_POST["end_year"];
    $percentages = $_POST["percentage"];



    for($i=0; $i<count($degrees); $i++){


        $degree = trim($degrees[$i]);

        $institution = trim($institutions[$i]);

        $start = $start_years[$i];

        $end = $end_years[$i];

        $percentage = trim($percentages[$i]);



        if($degree=="")
            continue;



        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO education
            (user_id,degree,institution,start_year,end_year,percentage)
            VALUES(?,?,?,?,?,?)"
        );


        mysqli_stmt_bind_param(
            $stmt,
            "isssss",
            $user_id,
            $degree,
            $institution,
            $start,
            $end,
            $percentage
        );


        mysqli_stmt_execute($stmt);


    }



    header("Location: achievement_details.php");

    exit();

}


?>


<!DOCTYPE html>
<html>

<head>

<title>Education Details</title>


<style>

    @import url('https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Alien+Block&family=Archivo+Black&family=BBH+Hegarty&family=BioRhyme+Expanded:wght@200;300;400;700;800&family=Bitcount+Grid+Double:wght@100..900&family=Bitcount+Prop+Single:wght@100..900&family=Changa+One:ital@0;1&family=Exo+2:ital,wght@0,100..900;1,100..900&family=Inconsolata:wght@200..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&family=Science+Gothic:wght@100..900&family=Stack+Sans+Notch:wght@200..700&display=swap');

*{

margin:0;
padding:0;
box-sizing:border-box;
font-family:"roboto mono" , monospace;

}


body{

background:#f4f4f4;

display:flex;

justify-content:center;

align-items:center;

min-height:100vh;

}


.container{

width:750px;

background:white;

padding:30px;

border-radius:12px;

box-shadow:0 0 20px #ccc;

}


h2{

text-align:center;

margin-bottom:25px;

}



.education-box{

border:1px solid #ddd;

padding:20px;

margin-bottom:20px;

border-radius:10px;

}



input{

width:100%;

padding:12px;

margin-bottom:12px;

border:1px solid #ccc;

border-radius:8px;

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


<h2>Education Details</h2>


<form method="POST">


<div id="education-container">


<div class="education-box">


<input 
type="text"
name="degree[]"
placeholder="Degree (B.Tech, B.Sc...)"
required>


<input 
type="text"
name="institution[]"
placeholder="Institution Name"
required>


<input 
type="number"
name="start_year[]"
placeholder="Start Year"
required>


<input 
type="number"
name="end_year[]"
placeholder="End Year"
required>


<input 
type="text"
name="percentage[]"
placeholder="Percentage / CGPA">


<button 
type="button"
class="remove"
onclick="removeEducation(this)">
Remove
</button>


</div>


</div>



<div class="buttons">


<button 
type="button"
class="add"
onclick="addEducation()">

+ Add Education

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


function addEducation(){


let container=document.getElementById(
"education-container"
);



let div=document.createElement("div");


div.className="education-box";



div.innerHTML=`

<input 
type="text"
name="degree[]"
placeholder="Degree"
required>


<input 
type="text"
name="institution[]"
placeholder="Institution Name"
required>


<input 
type="number"
name="start_year[]"
placeholder="Start Year"
required>


<input 
type="number"
name="end_year[]"
placeholder="End Year"
required>


<input 
type="text"
name="percentage[]"
placeholder="Percentage / CGPA">


<button 
type="button"
class="remove"
onclick="removeEducation(this)">
Remove
</button>

`;



container.appendChild(div);


}



function removeEducation(button){


let boxes=document.querySelectorAll(".education-box");


if(boxes.length>1){

button.parentElement.remove();

}


}


</script>


</body>

</html>