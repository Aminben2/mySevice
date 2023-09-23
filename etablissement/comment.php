<?php
require("../dbconnect.php");
require("../header_footer/header.php");
session_start();
if (isset($_SESSION["id"]) && !empty($_SESSION["id"])) {
    $id_user = $_SESSION["id"];
} else {
    $_SESSION["msg"] = "You have to be Loged in to add a comment";
    header("location: ../login.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    extract($_POST);
    if (isset($comment) && !empty($comment) && isset($rate) && isset($id_etab)) {
        if (empty($rate)) {
            $rate = 0;
        }
        $comment = checkInput($comment);
        try {
            $currentDate = date("Y-m-d");
            $insertQuery = "INSERT INTO avis (id_etab,id_user,avis_text, date_avis, rate) VALUES (?, ?, ?,?,?)";

            $st3 = $connection->prepare($insertQuery);
            $st3->execute([$id_etab, $id_user, $comment, $currentDate, $rate]);

            // Calculate the new average rating for the establishment
            $ratingQuery = "SELECT AVG(rate) AS avgRating FROM avis WHERE id_etab = ?";
            $st4 = $connection->prepare($ratingQuery);
            $st4->execute([$id_etab]);


            $newAverageRating = $st4->fetch();

            // Update the rate column in the etablissement table with the new average rating
            $updateQuery = "UPDATE etablissement SET rate = ? WHERE id_etab = ?";
            $st5 = $connection->prepare($updateQuery);
            $st5->execute([$newAverageRating["avgRating"], $id_etab]);


            header("location: etab.php?id_etab=$id_etab");
            exit;
        } catch (PDOException $e) {
            die("ERROR :" . $e->getMessage());
        }
    }
}

function checkInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
