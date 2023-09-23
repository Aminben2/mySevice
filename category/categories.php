<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MyService</title>
  <link rel="stylesheet" href="categ.css" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet" />
</head>

<body>
  <!--header-->

  <?php
  require("dbconnect.php");
  session_start();
  require("../header_footer/header.php");


  if (isset($_SESSION["msg"])  && !empty($_SESSION["msg"])) {
    $msg = $_SESSION["msg"];
    echo "<script>window.onload=function () {alert('$msg')}</script>";
    unset($_SESSION["msg"]);
    session_unset();
    session_destroy();
  }

  try {
    $query = "SELECT * FROM category";
    $stmt = $connection->query($query);
    $categoryCards = '';
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $id_category = $row['id_category'];
      $name_category = $row['name_category'];
      $description_category = $row['description_category'];
      $img_category = $row['img_category'];
      $categoryCards .= '<div class="card">';
      $categoryCards .= '<img src="' . $img_category . '" alt="" />';
      $categoryCards .= '<p>' . $description_category . '</p>';
      $categoryCards .= '<button><a href="../services/services.php?id_category=' . $id_category . '">' . $name_category . '</a></button>';
      $categoryCards .= '</div>';
    }
    echo '<div class="container">' . $categoryCards . '</div>';
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  ?>


  <!--MyService Pro-->

  <div id="mspro">
    <div id="proimg">
      <img id="imgp" src="../imgs/PNG/mspro.png" alt="" />
    </div>
    <div id="protxt">
      <h2>PRÊT À SERVIRE LES CLIENTS.</h2>
      <h3>NOUS TROUVERONS VOTRE EMPLOI IDÉAL,QUEL QUE SOIT...</h3>
    </div>
    <div id="probtn">
      <button>
        <a href="../pro_register.php"> MYSERVICE PRO</a>
        <div class="arrow-wrapper">
          <div class="arrow"></div>
        </div>
      </button>
    </div>
  </div>

  <!--GET STARTED-->
  <div id="starting">
    <div id="shape"><img src="../imgs/PNG/orange.png" alt="" /></div>

    <h1>Travail flexible, à portée de main</h1>
    <p>
      Trouvez des emplois locaux qui correspondent à vos compétences et à
      votre emploi du temps. Avec MYSERVICE, vous avez la liberté pour être
      votre propre patron.
    </p>
  </div>
  <!--process-->
  <div class="process">
    <div id="proc-row1">
      <div class="step">
        <img id="proc" src="../imgs/PNG/sign.png" alt="" />
        <div class="discpro">
          <h3>1. Inscrivez-vous</h3>
          <p>Créez votre compte, puis continuez l'inscription..</p>
        </div>
      </div>

      <div class="step">
        <img id="proc" src="../imgs/PNG/verify.png" alt="" />
        <div class="discpro">
          <h3>3. Vérifiez votre éligibilité pour les tâches</h3>
          <p>
            Confirmez votre identité et soumettez les vérifications
            nécessaires.
          </p>
        </div>
      </div>

      <div class="step">
        <img id="proc" src="../imgs/PNG/pro.png" alt="" />
        <div class="discpro">
          <h3>5. Devenez un professionnel MyService</h3>
          <p>
            MYSERVICE vous connecte avec des clients locaux et vous aide à
            vous promouvoir professionnellement.
          </p>
        </div>
      </div>
    </div>

    <div id="proc-row2">
      <div class="step">
        <img id="proc" src="../imgs/PNG/profile.png" alt="" />
        <div class="discpro">
          <h3>2. Construisez votre profil</h3>
          <p>Sélectionnez les services que vous souhaitez offrir et quand.</p>
        </div>
      </div>
      <div class="step">
        <img id="proc" src="../imgs/PNG/schedule.png" alt="" />
        <div class="discpro">
          <h3>4.Définissez votre emploi du temps et votre zone de travail</h3>
          <p>
            Fixez votre disponibilité pour recevoir des emplois le jour même.
          </p>
        </div>
      </div>
      <div class="step">
        <img id="proc" src="../imgs/PNG/job.png" alt="" />
        <div class="discpro">
          <h3>6. Commencez à obtenir des emplois</h3>
          <p>Développez votre entreprise selon vos propres conditions.</p>
        </div>
      </div>
    </div>
  </div>

  <!--FOOTER-->


  <?php require("../header_footer/footer.php") ?>


</body>

</html>