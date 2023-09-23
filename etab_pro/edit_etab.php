<?php
require("../dbconnect.php");
session_start();
if (!isset($_SESSION) || empty($_SESSION)) {
    header("location: ../login.php");
    exit;
}


if (isset($_GET) && !empty($_GET)) {
    $id_etab = $_GET["id_etab"];
}

try {
    $stt = $connection->prepare("SELECT * FROM etablissement WHERE id_etab=?");
    $stt->execute([$id_etab]);
    $etab = $stt->fetch();
} catch (PDOException $e) {
    die("ERROR :" . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    extract($_POST);
    if (
        isset($nom) && !empty($nom) &&
        isset($address) && !empty($address) &&
        isset($desc) && !empty($desc) &&
        isset($num) && !empty($num)
        && isset($open) && !empty($open) &&
        isset($close) && !empty($close)
    ) {
        try {
            $st = $connection->prepare("UPDATE etablissement SET  name_etab=? ,adress=?,description_etab=?,contact_num=?,heure_overture=?,heure_fermeture=? WHERE id_etab = ?");
            $res = $st->execute([$nom, $address, $desc, $num, $open, $close, $id_etab]);
            if ($res) {
                $msg = "The informations are updated";
                $_SESSION["msg"] = $msg;
                header("location: pro_etab.php");
                exit;
            } else {
                $msg = "Something went Wrong";
                $_SESSION["msg"] = $msg;
                header("location: pro_etab.php");
                exit;
            }
        } catch (PDOException $e) {
            die("ERROR :" . $e->getMessage());
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Etab</title>
    <link rel="stylesheet" href="etab_form.css">
</head>

<body>
    <div class="form-container">
        <h1>Modifier vos Informations</h1>
        <form action="" method="post">
            <div class="input-group">
                <label for="">Nom etablissement</label>
                <input type="text" name="nom" id="" value="<?= $etab["name_etab"] ?>" required>
            </div>
            <div class="input-group">
                <label for="">Address</label>
                <input type="text" name="address" id="" value="<?= $etab["adress"] ?>" required>
            </div>
            <div class="input-group">
                <label for="">Description</label>
                <textarea name="desc" required><?= $etab["description_etab"] ?></textarea>
            </div>
            <div class="input-group">
                <label for="">Numero de Contact</label>
                <input type="text" name="num" id="" value="<?= $etab["contact_num"] ?>" required>
            </div>
            <div class="input-group">
                <label for="">Heure Overture</label>
                <input type="time" name="open" id="" value="<?= $etab["heure_overture"] ?>" required>
            </div>
            <div class="input-group">
                <label for="">Heure Fermeture</label>
                <input type="time" name="close" id="" value="<?= $etab["heure_fermeture"] ?>" required>
            </div>
            <input type="submit" value="Mise a jour" class="button">
        </form>
    </div>
</body>

</html>