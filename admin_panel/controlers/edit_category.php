<?php
include("../dbconnect.php");

session_start();

$role = $_SESSION["role"];
if (!isset($_SESSION) || $role !== "admin") {
    header("location: ../../login.php");
}

$id_category = $_GET["id_category"];

$stmt = $pdo->prepare("SELECT * FROM category WHERE id_category= :id");
$stmt->bindParam(':id', $id_category);
$stmt->execute();
$category = $stmt->fetch(PDO::FETCH_ASSOC);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST['id_category']) && !empty($_POST['id_category']) &&
        isset($_POST['nom']) && !empty($_POST['nom'] &&
            isset($_POST['description']) && !empty($_POST['description']))
    ) {

        $id = checkInput($_POST['id_category']);
        $nom = checkInput($_POST['nom']);
        $description = checkInput($_POST['description']);

        if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {

            $picture_name = CheckInput($_FILES['picture']['name']);
            $picture_tmp = $_FILES['picture']['tmp_name'];
            $picture_path = "../imgs/" . $picture_name;
            move_uploaded_file($picture_tmp, $picture_path);

            $imageExtension  = pathinfo($picture_path, PATHINFO_EXTENSION);
            if ($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg") {
                $imageError = "Les fichiers autorises sont: .jpg, .jpeg, .png";
            }
            if ($_FILES["picture"]["size"] > 500000) {
                $imageError = "Le fichier ne doit pas depasser les 500KB";
            }
        } else {
            $imageError = "Il y a eu une erreur lors de l'upload";
        }

        $stmt1 = $pdo->prepare("UPDATE category SET name_category = :nom, description_category = :desc ,img_category=:img WHERE id_category = :id");
        $stmt1->bindParam(':desc', $description);
        $stmt1->bindParam(':nom', $nom);
        $stmt1->bindParam(':id', $id);
        $stmt1->bindParam(':img', $picture_path);
        $stmt1->execute();


        $_SESSION["msg"] = "The category informations have been updated succesfully";

        header("Location: ../categories.php");
        exit;
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
    <script src="scripts/category_validation.js" defer></script>
</head>

<body>
    <div class="wrraper">
        <h1>Category Upadate</h1>
        <form action="" method="post" class="my-form">
            <input type="hidden" name="id_category" value='<?php if (isset($category["id_category"])) echo $category["id_category"] ?>'>
            <label for="prenom">Category name</label><br>
            <input type="text" id="nom" name="nom" required value='<?php if (isset($category["name_category"])) echo $category["name_category"]  ?>'><br>
            <div class="errors name"></div>
            <label for="nom">Category Description</label><br>
            <input type="text" name="description" required id="description" value='<?php if (isset($category["description_category"])) echo $category["description_category"]  ?>'><br>
            <div class="errors desc"></div>
            <input type="file" name="picture" value="<?php if (isset($category["img_category"])) echo $category["img_category"]  ?>" required>
            <div class="errors">
                <?php if (isset($imageError)) echo $imageError ?>
            </div>
            <div class="errors">
                <?php if (isset($erroMsg)) echo $erroMsg ?>
            </div>
            <input type='submit' value='Update'>
        </form>
    </div>
</body>

</html>