<?php
include("../dbconnect.php");

session_start();

$role = $_SESSION["role"];
if (!isset($_SESSION) || $role !== "admin") {
    header("location: ../../login.php");
}

$id_user = $_GET["id_user"];

$stmt = $pdo->prepare("SELECT * FROM user WHERE id_user = :id");
$stmt->bindParam(':id', $id_user);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST['id_user']) && !empty($_POST['id_user']) &&
        isset($_POST['prenom']) && !empty($_POST['prenom']) &&
        isset($_POST['nom']) && !empty($_POST['nom']) &&
        isset($_POST['email']) && !empty($_POST['email']) &&
        isset($_POST['role']) && !empty($_POST['role'])
    ) {
        $id = checkInput($_POST['id_user']);
        $prenom = checkInput($_POST['prenom']);
        $nom = checkInput($_POST['nom']);
        $email = checkInput($_POST['email']);
        $role = checkInput($_POST['role']);

        try {
            $stmt1 = $pdo->prepare("UPDATE user SET prenom_user = :prenom, nom_user = :nom, email_user = :email,role =:role WHERE id_user = :id");
            $stmt1->bindParam(':prenom', $prenom);
            $stmt1->bindParam(':nom', $nom);
            $stmt1->bindParam(':email', $email);
            $stmt1->bindParam(':id', $id);
            $stmt1->bindParam(':role', $role);
            $stmt1->execute();

            $_SESSION["msg"] = "The User informations have been updated succesfully";

            header("Location: ../users.php");
            exit;
        } catch (PDOException $e) {
            die("Error :" . $e->getMessage());
        }
    } else {
        $erroMsg = "You have to fill all the fields";
    }
}
function checkInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit_user</title>
    <link rel="stylesheet" href="controler_css/form.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&family=Roboto+Mono:ital@1&display=swap" rel="stylesheet">

</head>

<body>
    <div class="wrraper">
        <h1>User informations Upadate</h1>
        <form action="" method="post" class="my-form">
            <input type="hidden" name="id_user" value='<?php if (isset($user["id_user"])) echo $user["id_user"] ?>' required>
            <label for="prenom">First name</label><br>
            <input type="text" id="prenom" name="prenom" value='<?php if (isset($user["prenom_user"])) echo $user["prenom_user"];  ?>' required><br>
            <div class="errors" id="prenomErr"></div>
            <label for="nom">Last name</label><br>
            <input type="text" id="nom" name="nom" value='<?php if (isset($user["nom_user"])) echo $user["nom_user"];  ?>' required><br>
            <div class="errors" id="nomErr"></div>
            <label for="role">Role</label><br>
            <input type="text" id="role" name="role" value='<?php if (isset($user["role"])) echo $user["role"];  ?>' required><br>
            <div class="errors" id="roleErr"></div> 
            <label for="prenom">Email</label><br>
            <input type="text" id="email" name="email" value='<?php if (isset($user["email_user"])) echo $user["email_user"];  ?>' required><br>
            <div class="errors" id="emailErr">
                <?php if (isset($erroMsg)) echo $erroMsg ?>
            </div>
            <input type='submit' value='Update'>
        </form>
        <script src="scripts/user_validation.js"></script>
    </div>
</body>

</html>