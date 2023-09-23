<?php
include("../dbconnect.php");

session_start();

$role = $_SESSION["role"];
if (!isset($_SESSION) || $role !== "admin") {
    header("location: ../../login.php");
}


//------------------find the wanted service by id ---------------------
$service_id = $_GET["id_service"];

$stmtt = $pdo->prepare("SELECT * FROM service WHERE id_service= :id");
$stmtt->bindParam(':id', $service_id);
$stmtt->execute();
$service = $stmtt->fetch(PDO::FETCH_ASSOC);

$parentServiceId = $service["parent_service"];
$category_id = $service["id_category"];



//---------------------------update by form-----------------------------------
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST['id_service']) && !empty($_POST['id_service']) &&
        isset($_POST['name_service']) && !empty($_POST['name_service'] &&
            isset($_POST['parent_service']) && !empty($_POST['parent_service']) &&
            isset($_POST['category']) && !empty($_POST['category']))
    ) {

        $id = checkInput($_POST['id_service']);
        $nom = checkInput($_POST['name_service']);
        $parent_service = checkInput($_POST['parent_service']);
        $categoey = checkInput($_POST['category']);


        $stmt1 = $pdo->prepare("UPDATE service SET name_service = :nom, parent_service = :parent, id_category=:category WHERE id_service = :id");
        $stmt1->bindParam(':parent', $parent_service);
        $stmt1->bindParam(':nom', $nom);
        $stmt1->bindParam(':id', $id);
        $stmt1->bindParam(':category', $categoey);
        $stmt1->execute();


        $_SESSION["msg"] = "Service has been updated succesfully";

        header("Location: ../services.php");
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
    <title>Edit_Service</title>
    <link rel="stylesheet" href="controler_css/form.css">
    <script src="scripts/service_validation.js" defer></script>
</head>

<body>
    <?php
    $sql = "SELECT * FROM service";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql1 = "SELECT * FROM category";
    $stmt1 = $pdo->prepare($sql1);
    $stmt1->execute();
    $result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="wrraper">
        <h1>Service Update</h1>
        <form action="" method="post" class="my-form">
            <input type="hidden" name="id_service" value="<?php echo $service['id_service']; ?>">
            <label for="name_service">Service Name:</label>
            <input type="text" id="nom" required name="name_service" value="<?php echo $service['name_service']; ?>">
            <div class="errors name"></div>
            <label for="category">Category:</label><br>
            <select name="category">
                <?php foreach ($result1 as $row1) { ?>
                    <option value="<?php echo $row1['id_category']; ?>" <?php if ($row1['id_category'] == $category_id) echo "selected"; ?>><?php echo $row1['name_category']; ?></option>
                <?php } ?>
            </select><br>
            <label for="parent_service">Parent Service:</label><br>
            <select name="parent_service">
                <option value="">None</option>
                <?php foreach ($result as $row) { ?>
                    <option value="<?php echo $row['id_service']; ?>" <?php if ($row['id_service'] == $parentServiceId) echo "selected"; ?>><?php echo $row['name_service']; ?></option>
                <?php } ?>
            </select>
            <input type="submit" value="Update">
        </form>
    </div>

</body>

</html>