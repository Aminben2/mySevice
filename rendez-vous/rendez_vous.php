<?php
require("../dbconnect.php");
session_start();

if (!isset($_SESSION["id"])) {
  $register_error = "You have to be registerd to book an appointment";
  $_SESSION["msg"] = $register_error;
  header("location: ../login.php");
  exit;
} else {

  $id_user = $_SESSION["id"];
  if (isset($_GET) && !empty($_GET)) {
    $id_etab = $_GET["id_etab"];
  }

  try {
    $st1 = $connection->prepare("SELECT * FROM etablissement WHERE id_etab = ?");

    $st1->execute([$id_etab]);
    $res = $st1->fetch();


    $st2 = $connection->prepare("SELECT * FROM offer WHERE id_etab = ?");
    $st2->execute([$id_etab]);
    $offers = $st2->fetchAll();
  } catch (PDOException $e) {
    die("ERROR :" . $e->getMessage());
  }


  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    extract($_POST);
    if (
      isset($time) && !empty($time) &&
      isset($date) && !empty($date) &&
      isset($reason) && !empty($reason)
    ) {

      try {
        $st = $connection->prepare("INSERT INTO rendez_vous(id_etab,id_user,id_offer,rv_date,rv_time,reason) VALUES(?,?,?,?,?,?)");

        $ress = $st->execute([$id_etab, $id_user, $offer, $date, $time, $reason]);
        if ($ress) {
          $msg = "The appointment is booked";
        } else {
          $msg = "Something went wrong,Try Again";
        }
      } catch (PDOException $e) {
        die("ERROR :" . $e->getMessage());
      }
    }
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Rendez Vous</title>
  <link rel="stylesheet" href="rendez_vous.css" />
</head>

<body>
  <div class="sidebar"></div>
  <div class="main">
    <nav>
      <ul>
        <li><a href="../category/categories.php">Categories</a></li>
        <li><a href="../home/home.php">About Us</a></li>
        <li><a href="../etablissement/etab.php?id_etab=<?= $id_etab ?>">Appointment</a></li>
        <li><a href="../home/home.php#footer">Contact</a></li>
      </ul>
    </nav>
    <div class="container">
      <div class="left">
        <h1><?= $res["name_etab"] ?></h1>
        <h1>To Your</h1>
        <h1>Service</h1>
        <p>
          <?php echo $res["description_etab"]  ?>
        </p>
        <a href="../etablissement/etab.php?id_etab=<?= $id_etab ?>" class="button2">Read more</a>
      </div>
      <div class="right">
        <h2>Book an Appointment</h2>
        <form action="" method="post">
          <div class="input-group">
            <div class="input">
              <label for="prenom">First name</label>
              <input type="text" name="prenom" id="" placeholder="Enter your first name" required />
            </div>
            <div class="input">
              <label for="nom">Last name</label>
              <input type="text" name="nom" id="" placeholder="Enter your last name" required />
            </div>
          </div>
          <div class="input">
            <label for="email">Email Address</label>
            <input type="text" name="email" id="" required placeholder="Email Address" />
          </div>

          <div class="input">
            <label for="contact">Contact Number</label>
            <input type="tel" name="contact" pattern="^(06|05) \d{4} \d{4}$" id="" required placeholder="06|05 1234 1234" />
          </div>
          <div class="input">
            <label for="offer">Sélectionnez un offre</label>
            <select name="offer" id="offer">
              <option value="">None</option>
              <?php
              foreach ($offers as $offer) {
              ?>
                <option value="<?= $offer["id_offer"] ?>"><?= $offer["name_offer"] ?></option>
              <?php
              }
              ?>
            </select>
          </div>
          <div class="input-group">
            <div class="input">
              <label for="date">Date</label>
              <input type="date" name="date" id="" required />
            </div>
            <div class="input">
              <label for="time">Time</label>
              <input type="time" name="time" id="" required />
            </div>
          </div>
          <div class="input">
            <label for="duration">Duration(min)</label>
            <input type="number" name="duration" id="" required />
          </div>
          <div class="input">
            <label for="reason">Reason for appointment</label>
            <textarea id="reason" name="reason" required></textarea>
          </div>
          <input type="submit" value="Book now" />
          <div class="errors">
            <?php if (isset($msg)) echo $msg  ?>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>