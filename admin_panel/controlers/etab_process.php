<?php
include("../dbconnect.php");

session_start();
$role = $_SESSION["role"];
if (!isset($_SESSION) || $role !== "admin") {
    header("location: ../../login.php");
} else {


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_etab = $_POST["id_etab"];
        if (isset($_POST["accept"])) {
            $stmt = $pdo->prepare("UPDATE etablissement SET status ='accepte' WHERE id_etab =:id");
            $stmt->bindParam(':id', $id_etab);
            $stmt->execute();

            $stmt1 = $pdo->prepare("SELECT user FROM etablissement WHERE id_etab=?");
            $stmt1->execute([$id_etab]);
            $pro = $stmt1->fetch();
            $id_pro = $pro["user"];

            $stmt2 = $pdo->prepare("UPDATE user SET role ='pro' WHERE id_user=?");
            $stmt2->execute([$id_pro]);


            $_SESSION["msg"] = "Request Accepeted succesfully";

            header("Location: ../etabs.php");
            exit;
        }
        if (isset($_POST["reject"])) {
            $stmt = $pdo->prepare("UPDATE etablissement SET status='refuse' WHERE id_etab=:id");
            $stmt->bindParam(':id', $id_etab);
            $stmt->execute();


            $_SESSION["msg"] = "Request Rejected succesfully";

            header("Location: ../etabs.php");
            exit;
        }
    }
}
