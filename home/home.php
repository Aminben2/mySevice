<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>home</title>

  <link rel="stylesheet" href="home.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;400&display=swap" rel="stylesheet">

</head>

<body>
  <?php
  session_start();
  require("../header_footer/header.php");
  ?>
  <section>
    <div class="wordCarousel">
      <span>Trouvez ce<br>dont vous avez besoin</span><br>
      <p id="para">réservation</p>
      <div>
        <!-- Use classes 2,3,4, or 5 to match the number of words -->
        <ul class="flip5">
          <li>Marché</li>
          <li>Beauté</li>
          <li>Cabinets</li>
          <li>Services a domicil</li>
          <li>Boutiques</li>
        </ul>
      </div>
      <button id="btn-get"><a id="get" href="../category/categories.php">Get Start</a></button>
    </div>
  </section>
  <?php require("../header_footer/footer.php") ?>
</body>

</html>