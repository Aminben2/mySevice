<?php
session_start();

$role = $_SESSION["role"];
if (!isset($_SESSION) || $role !== "admin") {
    header("location: ../../login.php");
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST['name_service']) && !empty($_POST['name_service']) &&
        isset($_POST['category']) && !empty($_POST['category']) && isset($_POST['parent_service'])
    ) {
        try {
            include("../dbconnect.php");
            $name_ersvice = checkInput($_POST['name_service']);
            $id_parent_service =  checkInput($_POST['parent_service']);
            $id_category = checkInput($_POST['category']);

            if ($id_parent_service === "") {
                $id_parent_service = null; // Set $id_parent_service as null if the option is empty
            }

            $stmt1 = $pdo->prepare("INSERT INTO service(name_service,id_category,parent_service) VALUES (:name_ser,:id_cate,:parent);");
            $stmt1->bindParam(':name_ser', $name_ersvice);
            $stmt1->bindParam(':id_cate', $id_category);
            $stmt1->bindParam(':parent', $id_parent_service);
            $stmt1->execute();

            $_SESSION["msg"] = "The Service has been added";

            header("Location: ../services.php");
            exit;
        } catch (PDOException $e) {
            // Handle any database errors
            if ($e->getCode() === '23000') {
                // Handle duplicate entry error
                if (strpos($e->getMessage(), 'name_service') !== false) {
                    $name_error = "The Service is already exists.";
                } elseif (strpos($e->getMessage(), 'parent_service') !== false) {
                    $name_error = "The parent is already exists.";
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
    <title>Add_Service</title>
    <link rel="stylesheet" href="controler_css/form.css">
    <script src="scripts/service_validation.js" defer></script>
</head>

<body>
    <?php
    include("../dbconnect.php");
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
        <h1>Service Adding</h1>
        <form action="" method="post" class="my-form">
            <label for="name_service">Service Name:</label>
            <input type="text" id="nom" required name="name_service">
            <div class="errors name">
                <?php if (isset($name_error)) echo $name_error ?>
            </div>
            <label for="category">Category:</label><br>
            <select name="category">
                <?php foreach ($result1 as $row1) { ?>
                    <option value="<?php echo $row1['id_category']; ?>"><?php echo $row1['name_category']; ?></option>
                <?php } ?>
            </select><br>
            <label for="parent_service">Parent Service:</label><br>
            <select name="parent_service">
                <option value="">None</option>
                <?php foreach ($result as $row) { ?>
                    <option value="<?php echo $row['id_service']; ?>"><?php echo $row['name_service']; ?></option>
                <?php } ?>
            </select>
            <div class="errors">
                <?php if (isset($erroMsg)) echo $erroMsg ?>
            </div>
            <input type="submit" value="Update">
        </form>

    </div>
</body>

</html>