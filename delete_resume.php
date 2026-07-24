<?php

include "config/db.php";


if (!isset($_GET["id"])) {

    die("Invalid Resume ID.");

}


$user_id = (int)$_GET["id"];

$stmt = mysqli_prepare(
    $conn,
    "DELETE FROM skills WHERE user_id=?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $user_id
);

mysqli_stmt_execute($stmt);

$stmt = mysqli_prepare(
    $conn,
    "DELETE FROM education WHERE user_id=?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $user_id
);

mysqli_stmt_execute($stmt);

$stmt = mysqli_prepare(
    $conn,
    "DELETE FROM achievements WHERE user_id=?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $user_id
);

mysqli_stmt_execute($stmt);

$stmt = mysqli_prepare(
    $conn,
    "DELETE FROM projects WHERE user_id=?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $user_id
);

mysqli_stmt_execute($stmt);

$stmt = mysqli_prepare(
    $conn,
    "DELETE FROM experience WHERE user_id=?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $user_id
);

mysqli_stmt_execute($stmt);

$stmt = mysqli_prepare(
    $conn,
    "DELETE FROM users WHERE id=?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $user_id
);

mysqli_stmt_execute($stmt);



header("Location: search_resume.php");

exit();

?>