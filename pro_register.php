<?php
require("dbconnect.php");
require("validation_functions.php");

session_start();



if (isset($_SESSION) && !empty($_SESSION)) {
  $id = $_SESSION["id"];
} else {
  $_SESSION["msg"] = "You need to be registerd/loged in";
  header("location: login.php");
  exit;
}



//   this is just for testing because we need the user id
//   And the user have to be loged in to fetch the id from the SESSION.


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (
    isset($_POST["etab_name"]) && isset($_POST["etab_desc"]) &&
    isset($_POST["etab_address"]) && isset($_POST["contact"]) &&
    isset($_POST["o_time"]) && isset($_POST["c_time"]) &&
    isset($_POST["license"])
  ) {
    $service;
    if (empty($_POST['subService'])) {
      $service = $_POST['service'];
    } else {
      $service = $_POST['subService'];
    }


    $etab_name = checkInput($_POST['etab_name']);
    $etab_desc = checkInput($_POST['etab_desc']);
    $etab_address = checkInput($_POST['etab_address']);
    $contact = checkInput($_POST['contact']);
    $license = checkInput($_POST['license']);
    $o_time = $_POST['o_time'];
    $c_time = $_POST['c_time'];

    try {

      if (isset($_FILES) && $_FILES["pic"]["error"] == 0) {
        $name = $_FILES["pic"]["name"];
        $path = "imgs/" . $name;
        $size = $_FILES["pic"]["size"];
        $tmp_name = $_FILES["pic"]["tmp_name"];
        $type = $_FILES["pic"]["type"];

        $types = ["image/png", "image/svg", "image/jpg", "image/jpeg", "image/tiff"];
        if (in_array($type, $types)) {
          if ($size < 4000000) {
            move_uploaded_file($tmp_name, $path);

            $query1 = "INSERT INTO etablissement (name_etab, id_service, adress, description_etab, contact_num, heure_overture, heure_fermeture, num_pattente, user,etab_pic) VALUES (:namee, :servicee, :addresss, :descc, :contact, :o_time, :c_time, :license, :id,:pic)";
            $stmt1 = $connection->prepare($query1);
            $stmt1->bindParam(':namee', $etab_name);
            $stmt1->bindParam(':servicee', $service);
            $stmt1->bindParam(':addresss', $etab_address);
            $stmt1->bindParam(':descc', $etab_desc);
            $stmt1->bindParam(':contact', $contact);
            $stmt1->bindParam(':o_time', $o_time);
            $stmt1->bindParam(':c_time', $c_time);
            $stmt1->bindParam(':license', $license);
            $stmt1->bindParam(':id', $id);
            $stmt1->bindParam(':pic', $path);

            $result = $stmt1->execute();
            if ($result) {
              $_SESSION["msg"] = "Request is submited wait for trearing your request";
              // echo "<scripts>alert('Request is submited')</scripts>";
              header("location: category/categories.php");
              exit;
            }
          } else {
            $img_err = "Please Enter a small picture";
          }
        } else {
          $img_err = "Please Enter a Picture";
        }
      } else {
        $img_err = "File not uploaded";
      }
    } catch (PDOException $e) {
      // Handle any database errors
      if ($e->getCode() === '23000') {
        // Handle duplicate entry error
        if (strpos($e->getMessage(), 'num_pattente') !== false) {
          $license_error = "The lincense is already taken.";
        } elseif (strpos($e->getMessage(), 'user') !== false) {
          $user_error = "You are already a Pro";
        } else {
          echo "Error: Duplicate entry error.";
        }
      } else {
        // Handle other database errors
        echo "Error: " . $e->getMessage();
      }
    }
  }
}



try {
  $stmt = $connection->prepare("SELECT id_category, name_category  FROM category");
  $stmt->execute();
  $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $pdo = null;
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pro Register</title>
  <link rel="stylesheet" href="css/reg1.css">


</head>

<body>
  <div class="form-container">
    <p class="title">S'inscrire en tant que professionnel</p>
    <form class="form" method="post" action="" enctype="multipart/form-data">
      <div class="form1">
        <div class="group1">
          <div class="input-group">
            <label for="etab_name">Nom de l'établissement</label>
            <input type="text" name="etab_name" id="etab_name" required placeholder="">
            <div class="error">
              <span id="etab_nameErr"></span>
            </div>
          </div>

          <div class="input-group">
            <label for="etab_desc">Description</label>
            <textarea name="etab_desc" id="etab_desc" cols="30" rows="10" required></textarea>
          </div>

          <div class="input-group">
            <label for="etab_address">Etablissement adresse</label>
            <input type="text" name="etab_address" id="etab_address" required placeholder="">
            <div class="error">
              <span id="etab_addressErr"></span>
            </div>
          </div>

          <div class="input-group">
            <label for="category">Type d'établissement</label>
            <select id="categorySelect" onchange="getServices()" required>
              <?php
              foreach ($categories as $category) {
                echo '<option value="' . $category['id_category'] . '">' . $category['name_category'] . '</option>';
              }
              ?>
            </select>
          </div>
          <!-- Second Select Dropdown - Services -->
          <div class="input-group">
            <label for="category">Type de service</label>
            <select id="serviceSelect" name="service" onchange="getSubServices()" required>
              <!-- Services will be populated dynamically -->
            </select>
          </div>
        </div>
        <div class="group2">
          <!-- Third Select Dropdown - Sub-Services -->
          <div class="input-group div" id="serviceSelect1">
            <label for="category">Type de sous service</label>
            <select id="subServiceSelect" name="subService">
              <!-- Sub-Services will be populated dynamically -->
            </select>
          </div>
          <div class="input-group">
            <label for="contact">Numéro de contact</label>
            <input type="tel" name="contact" id="contact" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" placeholder="123-456-7890" required>
          </div>
          <div class="full-name">
            <div class="input-group">
              <label for="o_time">heure d'ouverture</label>
              <input type="time" name="o_time" id="o_time" required placeholder="">
            </div>
            <div class="input-group">
              <label for="c_time">heure de fermeture</label>
              <input type="time" name="c_time" id="c_time" required placeholder="">
            </div>
          </div>
          <div class="input-group">
            <label for="license">Numero de patent</label>
            <input type="text" name="license" id="license" required placeholder="">
          </div>
          <div class="input-group">
            <label for="pic">Choisissez une image</label>
            <input type="file" name="pic" required>
            <div class="error">
              <span id="licenseErr">
                <?php if (isset($user_error)) echo $user_error ?>
                <?php if (isset($license_error)) echo $license_error ?>
                <?php if (isset($img_err)) echo $img_err ?>
              </span>
            </div>
          </div>
        </div>
      </div>



      <div class="form2">

        <button class="sign" type="submit">Soumettre</button>
      </div>
    </form>
  </div>



  <p class="signup">déjà un professionnel?
    <a rel="noopener noreferrer" href="login.php" class="">Se connecter</a>
  </p>
  </div>
  <script src="scripts/ajax.js"></script>

</body>

</html>