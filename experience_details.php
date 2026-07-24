<?php
session_start();
include "config/db.php";

if (!isset($_SESSION["user_id"])) {
    die("User not found. Please complete the previous steps first.");
}

$user_id = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $companies = $_POST["company_name"];
    $jobs = $_POST["job_title"];
    $types = $_POST["employment_type"];
    $starts = $_POST["start_date"];
    $ends = $_POST["end_date"];
    $descriptions = $_POST["description"];

    $working = isset($_POST["currently_working"])
        ? $_POST["currently_working"]
        : [];

    for ($i = 0; $i < count($companies); $i++) {

        $company = trim($companies[$i]);
        $job = trim($jobs[$i]);
        $type = trim($types[$i]);
        $start = $starts[$i];
        $end = $ends[$i];
        $description = trim($descriptions[$i]);

        $currentlyWorking = isset($working[$i]) ? 1 : 0;

        if ($currentlyWorking) {
            $end = NULL;
        }

        if ($company == "" || $job == "") {
            continue;
        }

        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO experience
            (
                user_id,
                company_name,
                job_title,
                employment_type,
                start_date,
                end_date,
                currently_working,
                description
            )
            VALUES
            (
                ?,?,?,?,?,?,?,?
            )"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "isssssis",
            $user_id,
            $company,
            $job,
            $type,
            $start,
            $end,
            $currentlyWorking,
            $description
        );

        mysqli_stmt_execute($stmt);
    }

    header("Location: resume_preview.php");
    exit();
}
?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Experience Details</title>

<link
rel="stylesheet"
href="asset/experience.css">

</head>

<body>

<div class="container">

<h2>Experience Details</h2>

<form method="POST">

<div id="experience-container">

<div class="experience-box">

<input
type="text"
name="company_name[]"
placeholder="Company Name"
required>

<input
type="text"
name="job_title[]"
placeholder="Job Title"
required>

<select
name="employment_type[]">

<option value="Full-time">
Full-time
</option>

<option value="Part-time">
Part-time
</option>

<option value="Internship">
Internship
</option>

<option value="Freelance">
Freelance
</option>

<option value="Contract">
Contract
</option>

</select>

<label>

Start Date

</label>

<input
type="date"
name="start_date[]">

<label>
End Date
</label>

<input
type="date"
name="end_date[]"
class="end-date">

<label class="checkbox">

<input
type="checkbox"
name="currently_working[0]"
value="1"
onchange="toggleEndDate(this)">

Currently Working Here

</label>

<textarea
name="description[]"
placeholder="Describe your responsibilities, achievements, technologies used..."
rows="6"></textarea>

<button
type="button"
class="remove-btn"
onclick="removeExperience(this)">

Remove Experience

</button>

</div>

</div>

<div class="buttons">

<button
type="button"
class="add-btn"
onclick="addExperience()">

+ Add Experience

</button>

<button
type="submit"
class="save-btn">

Finish Resume

</button>

</div>

</form>

</div>

<script src="js/experience.js"></script>

</body>
</html>