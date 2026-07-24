<?php

session_start();

include "config/db.php";


if (!isset($_SESSION["user_id"])) {

    die("User not found");

}


$user_id = $_SESSION["user_id"];


if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $titles = $_POST["achievement_title"];
    $descriptions = $_POST["description"];
    $years = $_POST["achievement_year"];


    for($i = 0; $i < count($titles); $i++){


        $title = trim($titles[$i]);
        $description = trim($descriptions[$i]);
        $year = $years[$i];


        if($title == "")
            continue;


        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO achievements
            (user_id, achievement_title, description, achievement_year)
            VALUES(?,?,?,?)"
        );


        mysqli_stmt_bind_param(
            $stmt,
            "isss",
            $user_id,
            $title,
            $description,
            $year
        );


        mysqli_stmt_execute($stmt);

    }


    header("Location: project_details.php");
    exit();

}

?>


<!DOCTYPE html>
<html>

<head>

<title>Achievement Details</title>

<link rel="stylesheet" href="asset/achievements.css">

</head>

<body>

<div class="container">
    <h2>Achievements</h2>
    <form method="POST">


        <div id="achievement-container">
            <div class="achievement-box">
                <input
                type="text"
                name="achievement_title[]"
                placeholder="Achievement Title"
                required>

                <textarea
                name="description[]"
                placeholder="Describe your achievement">
                </textarea>

                <input
                type="number"
                name="achievement_year[]"
                placeholder="Achievement Year">

                <button
                type="button"
                class="remove"
                onclick="removeAchievement(this)">
                    Remove
                </button>
            </div>
        </div>

        <div class="buttons">


        <button
        type="button"
        class="add"
        onclick="addAchievement()">

        + Add Achievement

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
    function addAchievement(){
            
        let container = document.getElementById(
        "achievement-container"
        );


        let div = document.createElement("div");


        div.className = "achievement-box";


        div.innerHTML = `

        <input
        type="text"
        name="achievement_title[]"
        placeholder="Achievement Title"
        required>


        <textarea
        name="description[]"
        placeholder="Describe your achievement">
        </textarea>


        <input
        type="number"
        name="achievement_year[]"
        placeholder="Achievement Year">


        <button
        type="button"
        class="remove"
        onclick="removeAchievement(this)">
        Remove
        </button>

        `;
        container.appendChild(div);

    }



    function removeAchievement(button){
        let boxes = document.querySelectorAll(".achievement-box");

        if(boxes.length > 1){
            button.parentElement.remove();
        }
    }


</script>



</body>

</html>