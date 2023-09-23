<?php
require("../dbconnect.php");
session_start();


if (isset($_SESSION) && !empty($_SESSION) && $_SESSION["role"] == "pro") {
  $id_pro = $_SESSION["id"];
} else {
  header("location: ../login.php");
  exit;
}


try {
  $st = $connection->prepare("SELECT * FROM etablissement as e JOIN service as s ON e.id_service=s.id_service JOIN user  ON e.user=user.id_user WHERE user = ?");
  $st->execute([$id_pro]);
  $etab = $st->fetch();

  $id_etab = $etab["id_etab"];
} catch (PDOException $e) {
  die("ERROR :" . $e->getMessage());
}




if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_FILES) && $_FILES["pic"]["error"] == 0) {

    $name = $_FILES["pic"]["name"];
    $path = "../imgs/" . $name;
    $size = $_FILES["pic"]["size"];
    $tmp_name = $_FILES["pic"]["tmp_name"];

    $type = exif_imagetype($tmp_name);
    $types = [
      "image/png" => 3,
      "image/svg+xml" => 18,
      "image/jpeg" => 2,
      "image/tiff" => 6
    ];


    if (in_array($type, $types)) {
      if ($size < 4000000) {
        move_uploaded_file($tmp_name, $path);


        try {
          $stt = $connection->prepare("UPDATE etablissement SET etab_pic=? WHERE id_etab=?");
          $res = $stt->execute([$path, $id_etab]);

          if ($res) {
            $msg = "Image is updated";
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
      } else {
        $msg = "Please choose a small Image";
        $_SESSION["msg"] = $msg;
        header("location: pro_etab.php");
        exit;
      }
    } else {
      $msg = "File is not an image";
      $_SESSION["msg"] = $msg;
      header("location: pro_etab.php");
      exit;
    }
  } else {
    $msg = "File not uploaded";
    $_SESSION["msg"] = $msg;
    header("location: pro_etab.php");
    exit;
  }
}


try {
  $st1 = $connection->prepare("SELECT * FROM rendez_vous as r JOIN user as u ON r.id_user=u.id_user WHERE r.id_etab=?");
  $st1->execute([$id_etab]);
  $rende = $st1->fetchAll();
} catch (PDOException $e) {
  die("ERROR :" . $e->getMessage());
}



if (isset($_SESSION["msg"])  && !empty($_SESSION["msg"])) {
  $msg = $_SESSION["msg"];
  echo "<script>window.onload=()=>alert('$msg')</script>";
  unset($_SESSION["msg"]);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pro ETab</title>
  <link rel="stylesheet" href="pro_etab.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>

<body>
  <div class="image-update">
    <img id="span" src="../imgs/close.png" alt="X">
    <form action="" method="post" enctype="multipart/form-data">
      <label for="">Choose new Image :</label>
      <input type="file" name="pic" id="">
      <input type="submit" value="Update" class="button">
    </form>
  </div>
  <div class="container">
    <?php
    require("../header_footer/header.php");



    ?>

    <div class="intro">
      <div class="pic">
        <img src="<?= $etab["etab_pic"] ?>" alt="profile-pic" /><a id="edit" href="#"><img src="../imgs/image-editing.png" alt="edit" /></a>
      </div>
      <div class="title"><?= $etab["name_etab"] ?></div>
    </div>
    <div class="informations">
      <div class="info">
        <h2>The informations About Your Etablisement :</h2>
        <a href="edit_etab.php?id_etab=<?= $id_etab ?>" class="button">Info Update</a>
      </div>
      <div class="cards">
        <div class="card">
          <h3>Le Type de service :</h3>
          <p>
            <?= $etab["name_service"] ?>
          </p>
        </div>
        <div class="card">
          <h3>Street Address :</h3>
          <p>
            <?= $etab["adress"] ?>
          </p>
        </div>
        <div class="card">
          <h3>Etablisement Description :</h3>
          <p>
            <?= $etab["description_etab"] ?>
          </p>
        </div>
        <div class="card">
          <h3>Contact Number :</h3>
          <p>
            <?= $etab["contact_num"] ?>
          </p>
        </div>
        <div class="card">
          <h3>Opening Time :</h3>
          <p>
            <?= $etab["heure_overture"] ?>
          </p>
        </div>
        <div class="card">
          <h3>Closing Time :</h3>
          <p>
            <?= $etab["heure_fermeture"] ?>
          </p>
        </div>
        <div class="card">
          <h3>License Number :</h3>
          <p>
            <?= $etab["num_pattente"] ?>
          </p>
        </div>
        <div class="card">
          <h3>Etablisement Rate :</h3>
          <p>
            <?php


            $etab["rate"];
            echo "<div class=\"rating\">";
            $establishmentRate = $etab['rate'];

            // Convert the rate into a number of stars
            $numberOfStars = round($establishmentRate);

            // Generate the HTML code for the star rating dynamically
            $starsHtml = '';
            for ($i = 1; $i <= 5; $i++) {
              if ($i <= $numberOfStars) {
                $starsHtml .= '<span class="fa fa-star checked"></span>';
              } else {
                $starsHtml .= '<span class="fa fa-star"></span>';
              }
            }
            echo $starsHtml;
            echo "</div>";
            ?>
          </p>
        </div>
        <div class="card">
          <h3>Professioneel Full Name :</h3>
          <p>
            <?= $etab["prenom_user"] . " " . $etab["nom_user"] ?>
          </p>
        </div>
      </div>
    </div>
    <div class="table-wrapper">
      <h2>Les rendez-vous :</h2>
      <table class="fl-table">
        <thead>
          <th>Nom Complet</th>
          <th>User Email</th>
          <th>Date Rendez-vous</th>
          <th>Heuere Rendez-vous</th>
          <th>État Rendez-vous</th>
          <th>Raison</th>
        </thead>
        <tbody>
          <?php
          foreach ($rende as $row) {
            echo "<tr>";
            echo "<td>" . $row["prenom_user"] . " " . $row["prenom_user"] . "</td>";
            echo "<td>" . $row["nom_user"] . "</td>";
            echo "<td>" . $row["rv_date"] . "</td>";
            echo "<td>" . $row["rv_time"] . "</td>";
            echo "<td>" . $row["rv_etat"] . "</td>";
            echo "<td>" . $row["reason"] . "</td>";
            echo "</tr>";
          }
          ?>
        </tbody>
      </table>
    </div>

  </div>
  <?php //require("../header_footer/footer.php")  
  ?>
  <script>
    let editBTn = document.querySelector("#edit");
    let formDiv = document.querySelector(".image-update");
    let con = document.querySelector(".container");
    let closeBTn = document.querySelector("#span");

    editBTn.addEventListener("click", function() {
      // formDiv.style.display = "block";
      formDiv.classList.add("show");
      con.classList.add("blur");
    })
    closeBTn.addEventListener("click", function() {
      // formDiv.style.display = "none";
      formDiv.classList.remove("show");
      con.classList.remove("blur");
    })
  </script>
</body>

</html>