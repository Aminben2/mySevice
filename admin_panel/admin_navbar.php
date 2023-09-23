<?php
require("dbconnect.php");
session_start();

$role = $_SESSION["role"];
if (!isset($_SESSION) || $role !== "admin") {
    header("location: ../login.php");
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["Logout"])) {
        if (session_destroy() || session_unset()) {
            header("location: ../login.php");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>navbar</title>
    <script src="scripts/nav_bar_active.js" defer></script>
    <link rel="stylesheet" href="css/admin_navbar.css">
</head>

<body>
    <header>
        <img src="imgs/settings.png" alt="logo">
        <div class="controls">
            <nav>
                <ul id="header-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="users.php">Users</a></li>
                    <li><a href="categories.php">Gategories</a></li>
                    <li><a href="services.php">Services</a></li>
                    <li><a href="etabs.php">Etablisement</a></li>
                </ul>
            </nav>
            <div class="logout">
                <?php
                if (isset($_SESSION) && !empty($_SESSION)) { ?>
                    <form action="" method="post" onsubmit=" return confirmLogout()">
                        <button class="Btn" type="submit" name="Logout">

                            <div class="sign"><svg viewBox="0 0 512 512">
                                    <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path>
                                </svg></div>

                            <div class="text">Logout</div>
                        </button>
                    </form>
                    <script>
                        function confirmLogout() {
                            return confirm("Are you sure you want to Log out ?")
                        }
                    </script>
                <?php
                } else {
                    header("loaction: login.php");
                }
                ?>
            </div>
        </div>
    </header>
</body>

</html>