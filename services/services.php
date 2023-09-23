<?php
require("../dbconnect.php");
session_start();

if (isset($_GET["id_category"])) {
  $id_category = $_GET["id_category"];
} else {
  header("location: ../category/categories.php");
  exit;
}



try {

  $st = $connection->prepare("SELECT e.* FROM etablissement as e JOIN service as s ON e.id_service=s.id_service JOIN category as c on s.id_category=c.id_category  WHERE s.id_category =? AND e.status = 'accepte' ORDER BY e.rate desc");
  $st->execute([$id_category]);
  $res = $st->fetchAll();





  $st1 = $connection->prepare("SELECT * FROM category WHERE id_category=?");
  $st1->execute([$id_category]);
  $category = $st1->fetch();
} catch (PDOException $e) {
  die("ERROR :" . $e->getMessage());
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
  extract($_POST);
  if (isset($filter) && !empty($filter)) {
    try {
      $sql = "SELECT e.* FROM etablissement as e JOIN service as s ON e.id_service=s.id_service JOIN category as c on s.id_category=c.id_category  WHERE c.id_category =:id_category AND e.status = 'accepte' AND (s.name_service LIKE :searchTerm OR e.description_etab LIKE :searchTerm) ORDER BY e.rate desc ";
      $stmt = $connection->prepare($sql);
      // $id_catgory = 37;   // Just For Test !!!!!!!!!!!!!!!
      $stmt->bindParam(":id_category", $id_category);
      $stmt->bindValue(':searchTerm', "%$filter%", PDO::PARAM_STR);
      $stmt->execute();

      $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if (count($res) == 0) {
        $msg = "Nothing Found, try again or reset !";
      }
    } catch (PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
  }
}

// Close the database connection
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Services</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>

<body>
  <?php require("../header_footer/header.php") ?>
  <main>
    <div class="head">
      <div class="title"><span><?= $category["name_category"] ?></span></div>
      <div class="intro">
        <div class="shape-outer heptagon">
          <div class="shape-inner heptagon">
            <img src="<?= $category["img_category"] ?>" alt="cate-pic">
          </div>
        </div>
        <div class="description">
          <?= $category["description_category"] ?>
        </div>
      </div>
    </div>
    <div class="search">
      <h2>Trouvez votre meilleur service :</h2>
      <form action="" method="post">
        <div class="group">
          <svg class="icon" aria-hidden="true" viewBox="0 0 24 24">
            <g>
              <path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path>
            </g>
          </svg>
          <input placeholder="Search" type="search" class="input" name="filter" required />
          <button class="button" type="submit">Search</button>
          <a href="reset.php?id_category=<?php echo $_GET['id_category']; ?>&reset=true" class="button">Reset</a>
        </div>
      </form>
    </div>
    <div class="msg">
      <?php if (isset($msg)) echo $msg   ?>
    </div>
    <div class="cards">
      <?php
      foreach ($res as $row) {
        echo "<div class=\"card-con\">";
        echo "<div class=\"rating\">";
        $establishmentRate = $row['rate'];

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
        echo "<img src=" . $row['etab_pic'] . " alt='etab pic' />";
        echo "<div class=\"card\">";
        echo "<div class=\"content\">";
        echo "<p class='heading'>" . $row["name_etab"] . "</p>";
        echo "<p class='para'>" . $row["description_etab"] . "</p>";
        echo "<a href='../etablissement/etab.php?id_etab=" . $row["id_etab"] . "' class='btn'>Read more</a>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
      }
      ?>
    </div>
  </main>
  <?php require("../header_footer/footer.php") ?>


</body>

</html>