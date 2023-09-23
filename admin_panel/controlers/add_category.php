<?php
session_start();

$role = $_SESSION["role"];
if (!isset($_SESSION) || $role !== "admin") {
    header("location: ../../login.php");
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST['nom']) && !empty($_POST['nom']) &&
        isset($_POST['description']) && !empty($_POST['description'])
    ) {
        try {
            include("../dbconnect.php");
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



            $stmt1 = $pdo->prepare("INSERT INTO category(name_category, description_category, img_category) VALUES (:nom, :desc, :picture_path);");
            $stmt1->bindParam(':desc', $description);
            $stmt1->bindParam(':nom', $nom);
            $stmt1->bindParam(':picture_path', $picture_path);
            $stmt1->execute();



            $_SESSION["msg"] = "The category has been added";

            header("Location: ../categories.php");
            exit;
        } catch (PDOException $e) {
            // Handle any database errors
            if ($e->getCode() === '23000') {
                // Handle duplicate entry error
                if (strpos($e->getMessage(), 'name_category') !== false) {
                    $name_error = "The category is already exists.";
                } else {
                    echo "Error: Duplicate entry error.";
                }
            } else {
                // Handle other database errors
                echo "Error: " . $e->getMessage();
            }
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
    <title>Add_Category</title>
    <link rel="stylesheet" href="controler_css/form.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&family=Roboto+Mono:ital@1&display=swap" rel="stylesheet">
    <script defer src="scripts/category_validation.js"></script>
</head>

<body>
    <div class="wrraper">
        <h1>Category Adding</h1>
        <form action="" method="post" class="my-form" enctype="multipart/form-data">
            <label for="prenom">Category name</label><br>
            <input type="text" id="nom" name="nom" value='' required><br>
            <div class="errors name">
                <?php if (isset($name_error)) echo $name_error ?>
            </div>
            <label for="nom">Category Description</label><br>
            <input type="text" id="description" name="description" value='' required><br>
            <div class="errors desc"></div>
            <label for="picture">Category Picture</label><br>
            <input type="file" id="picture" name="picture" required><br>
            <div class="errors">
                <?php if (isset($imageError)) echo $imageError ?>
            </div>
            <div class="errors desc">
                <?php if (isset($erroMsg)) echo $erroMsg ?>
            </div>
            <input type='submit' value='Add'>
        </form>
    </div>
</body>

</html>