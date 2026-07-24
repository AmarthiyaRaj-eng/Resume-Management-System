<?php
session_start();
include "config/db.php";

$search = "";

if (isset($_GET["search"])) {
    $search = trim($_GET["search"]);
}

/* ==========================
   SEARCH QUERY
========================== */

if ($search != "") {

    $keyword = "%" . $search . "%";

    $stmt = mysqli_prepare(
        $conn,
        "SELECT DISTINCT
            users.id,
            users.fullname,
            users.email,
            users.phone
         FROM users
         LEFT JOIN skills
         ON users.id = skills.user_id
         WHERE
            users.fullname LIKE ?
            OR users.email LIKE ?
            OR skills.skill_name LIKE ?
         ORDER BY users.fullname"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "sss",
        $keyword,
        $keyword,
        $keyword
    );

} else {

    $stmt = mysqli_prepare(
        $conn,
        "SELECT
            id,
            fullname,
            email,
            phone
         FROM users
         ORDER BY fullname"
    );

}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Search Resumes</title>

<link
rel="stylesheet"
href="asset/search.css">

</head>

<body>

<div class="container">

<h1>

Resume Management System

</h1>

<form method="GET">

<div class="search-box">

<input
type="text"
name="search"
placeholder="Search by Name, Email or Skill..."
value="<?php echo htmlspecialchars($search); ?>">

<button type="submit">

Search

</button>

</div>

</form>

<table>

<tr>

<th>Name</th>

<th>Email</th>

<th>Phone</th>

<th>Skills</th>

<th>Action</th>

</tr>

<?php

while($user = mysqli_fetch_assoc($result)){

$skillStmt = mysqli_prepare(
    $conn,
    "SELECT skill_name
     FROM skills
     WHERE user_id=?"
);

mysqli_stmt_bind_param(
    $skillStmt,
    "i",
    $user["id"]
);

mysqli_stmt_execute($skillStmt);

$skillResult = mysqli_stmt_get_result($skillStmt);

$skills = [];

while($skill = mysqli_fetch_assoc($skillResult)){

    $skills[] = $skill["skill_name"];

}

?>

<tr>

    <td>
        <a href="candidate_profile.php?id=<?php echo $user['id']; ?>" class="candidate-name">
            <?php echo htmlspecialchars($user['fullname']); ?>
        </a>
    </td>

    <td>

        <?php echo htmlspecialchars($user["email"]); ?>

    </td>

    <td>

        <?php echo htmlspecialchars($user["phone"]); ?>

    </td>

    <td>

        <?php echo htmlspecialchars(implode(", ", $skills)); ?>

    </td>

    <td class="actions">
        
        <a
            href="edit_resume.php?id=<?php echo $user["id"]; ?>"
            class="edit-btn">

            Edit

        </a>

        <a
            href="delete_resume.php?id=<?php echo $user["id"]; ?>"
            class="delete-btn"
            onclick="return confirm('Are you sure you want to delete this resume?');">

            Delete

        </a>

    </td>

</tr>

<?php

}

?>

</table>

<?php

if (mysqli_num_rows($result) == 0) {

?>

<p class="no-result">

    No resumes found.

</p>

<?php

}

?>

</div>

</body>

</html>