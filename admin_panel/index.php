<?php
include("dbconnect.php");

//---------------users---------------------------
$sql = "SELECT COUNT(*) AS total_users FROM user";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$total_users = $result["total_users"];


//---------------Categories---------------------------

$sql1 = "SELECT COUNT(*) AS total_cate FROM category";
$stmt1 = $pdo->prepare($sql1);
$stmt1->execute();
$result1 = $stmt1->fetch(PDO::FETCH_ASSOC);

$total_category = $result1["total_cate"];


//---------------Services---------------------------

$sql2 = "SELECT COUNT(*) AS total_service FROM service";
$stmt2 = $pdo->prepare($sql2);
$stmt2->execute();
$result2 = $stmt2->fetch(PDO::FETCH_ASSOC);

$total_service = $result2["total_service"];


//---------------Professionnels---------------------------

$sql3 = "SELECT COUNT(*) AS total_etab FROM etablissement";
$stmt3 = $pdo->prepare($sql3);
$stmt3->execute();
$result3 = $stmt3->fetch(PDO::FETCH_ASSOC);

$total_pros = $result3["total_etab"];

//closing the connection
$pdo = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <?php
    require("admin_navbar.php")
    ?>
    <main>
        <div class="row1-container">
            <div class="box box-down cyan">
                <h2>Users</h2>
                <p>There are <span style="color: black;font-weight:bold"><?php if (isset($total_users)) echo $total_users ?></span> users on the app</p>
                <img src="https://assets.codepen.io/2301174/icon-supervisor.svg" alt="">
            </div>

            <div class="box red">
                <h2>Categories</h2>
                <p>There are <span style="color: black;font-weight:bold"><?php if (isset($total_category)) echo $total_category ?></span> Categories on the app</p>
                <img src="https://assets.codepen.io/2301174/icon-team-builder.svg" alt="">
            </div>

            <div class="box box-down blue">
                <h2>Services</h2>
                <p>Our App offer <span style="color: black;font-weight:bold"><?php if (isset($total_service)) echo $total_service ?></span> different types of services</p>
                <img src="https://assets.codepen.io/2301174/icon-calculator.svg" alt="">
            </div>
        </div>
        <div class="row2-container">
            <div class="box orange">
                <h2>Professionnels</h2>
                <p>There are <span style="color: black;font-weight:bold"><?php if (isset($total_pros)) echo $total_pros ?></span> professionnels work on this App</p>
                <img src="https://assets.codepen.io/2301174/icon-karma.svg" alt="">
            </div>
        </div>
    </main>

</body>

</html>