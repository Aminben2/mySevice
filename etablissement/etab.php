<?php
require("../dbconnect.php");
session_start();


if (isset($_SESSION["id"]) && !empty($_SESSION["id"])) {
  $id_user = $_SESSION["id"];
}


if (isset($_GET["id_etab"])) {
  $id_etab = $_GET["id_etab"];

  try {
    $st = $connection->prepare("SELECT * FROM etablissement WHERE id_etab=?");
    $st->execute([$id_etab]);
    $etab = $st->fetch();



    $st1 = $connection->prepare("SELECT * FROM offer WHERE id_etab=?");
    $st1->execute([$id_etab]);
    $offers = $st1->fetchAll();



    $st2 = $connection->prepare("SELECT * FROM avis as a JOIN user ON a.id_user=user.id_user WHERE id_etab=?");
    $st2->execute([$id_etab]);
    $avis = $st2->fetchAll();
  } catch (PDOException $e) {
    die("ERROR :" . $e->getMessage());
  }
} else {
  header("location: ../category/categories.php");
  exit;
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="etab.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;400&display=swap" rel="stylesheet">

</head>

<body>
  <?php require("../header_footer/header.php"); ?>
  <main>
    <div class="head">
      <div class="title">
        <span><?= $etab["name_etab"] ?></span>
        <a class="button" href="../rendez-vous/rendez_vous.php?id_etab=<?= $id_etab ?>">Book now</a>
      </div>
      <div class="intro">
        <div class="shape-outer heptagon">
          <div class="shape-inner heptagon">
            <img src="<?= $etab["etab_pic"] ?>" alt="etab-pic">
          </div>
        </div>
        <div class="description">
          <h3 style="text-align: start;">Les horaires :</h3>
          <table>
            <thead>
              <th>Heure Overture</th>
              <th>Heure Fermeture</th>
            </thead>
            <tbody>
              <td><?= $etab["heure_overture"] ?></td>
              <td><?= $etab["heure_fermeture"] ?></td>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="offers-title">
      Les offres de Etablisement :
    </div>
    <div class="offers">
      <?php
      if (count($offers) > 0) {
        foreach ($offers as $offer) {
          echo "<div class='card'>";
          echo "<p class='card-title'>" . $offer["name_offer"] . "</p>";
          echo "<p class='small-desc'>" . $offer["descr_offer"] . "</p>";
          echo "<div class='go-corner'>";
          echo "<div class='go-arrow'>→</div>";
          echo "</div>";
          echo "</div>";
        }
      } else {
        echo "<div class='not-found'>Les offres seront bientôt disponibles</div>";
      }
      ?>
    </div>
    <div class="offers-title">
      Les avis sur l'établissement :
    </div>
    <div class="comments">
      <div class="comment-card">
        <span id="title">Laissez votre commentaire</span>
        <form class="form" action="comment.php" method="post">
          <input type="hidden" name="id_etab" value="<?= $id_etab ?>">
          <div class="group">
            <textarea placeholder="‎" id="comment" name="comment" rows="5" required=""></textarea>
            <label for="comment">Commenter</label>
          </div>
          <span id="title">Evaluer</span>
          <div class="rate">
            <input value="1" name="rate" id="star-1" type="radio">
            <label for="star-1">
              <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z" pathLength="360"></path>
              </svg>
            </label>
            <input value="2" name="rate" id="star-2" type="radio">
            <label for="star-2">
              <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z" pathLength="360"></path>
              </svg>
            </label>
            <input value="3" name="rate" id="star-3" type="radio">
            <label for="star-3">
              <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z" pathLength="360"></path>
              </svg>
            </label>
            <input value="4" name="rate" id="star-4" type="radio">
            <label for="star-4">
              <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z" pathLength="360"></path>
              </svg>
            </label>
            <input value="5" name="rate" id="star-5" type="radio">
            <label for="star-5">
              <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z" pathLength="360"></path>
              </svg>
            </label>
          </div>
          <button type="submit">Submit</button>
        </form>
      </div>

      <div class="cmnt">
        <span id="cmnt-title">Commentaires</span>
        <div class="con">
          <?php
          if (count($avis) > 0) {
            foreach ($avis as $avi) {
              $dbDatetime = $avi["date_avis"];

              // Create a DateTime object from the database datetime
              $datetime = new DateTime($dbDatetime);

              // Format the datetime in the desired format
              $formattedDatetime = $datetime->format('l, F jS \a\t g:ia');
              echo "<div class='cmnts'>";
              echo "<div class='comment-container'>";
              echo "<div class='user'>";
              echo "<div class='user-pic'>";
              echo "<svg fill='none' viewBox='0 0 24 24' height='20' width='20' xmlns='http://www.w3.org/2000/svg'>
                    <path stroke-linejoin='round' fill='#707277' stroke-linecap='round' stroke-width='2' stroke='#707277' d='M6.57757 15.4816C5.1628 16.324 1.45336 18.0441 3.71266 20.1966C4.81631 21.248 6.04549 22 7.59087 22H16.4091C17.9545 22 19.1837 21.248 20.2873 20.1966C22.5466 18.0441 18.8372 16.324 17.4224 15.4816C14.1048 13.5061 9.89519 13.5061 6.57757 15.4816Z'></path>
                    <path stroke-width='2' fill='#707277' stroke='#707277' d='M16.5 6.5C16.5 8.98528 14.4853 11 12 11C9.51472 11 7.5 8.98528 7.5 6.5C7.5 4.01472 9.51472 2 12 2C14.4853 2 16.5 4.01472 16.5 6.5Z'></path>
                  </svg>";
              echo "</div>";
              echo "<div class='user-info'>
                  <span>" . $avi["prenom_user"] . " " . $avi["nom_user"] . "</span>
                  <p>$formattedDatetime</p>
                </div>";
              echo "</div>";
              echo "<p class='comment-content'>" . $avi["avis_text"] . "</p>";
              echo "</div>";
              echo "</div>";
            }
          } else {
            echo "<div class='not-found'>No Commentaires</div>";
          }
          ?>
        </div>
      </div>
    </div>
  </main>

  <?php require("../header_footer/footer.php") ?>

</body>

</html>