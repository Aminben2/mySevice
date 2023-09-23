<?php
require("dbconnect.php");


session_start();
if (isset($_SESSION["msg"])  && !empty($_SESSION["msg"])) {
    $msg = $_SESSION["msg"];
    echo "<script>window.onload=function () {alert('$msg')}</script>";
    unset($_SESSION["msg"]);
    session_unset();
    session_destroy();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        if (empty($_POST['username'])) {
            $username_error = "Entrez votre nom d'utilisateur";
        } elseif (empty($_POST['password'])) {
            $password_error = "Entrez votre mot de passe";
        } else {
            try {
                $username = $_POST['username'];
                $passwordd = $_POST['password'];

                $adminQuery = "SELECT * FROM user WHERE user_username = :username ";
                $st = $connection->prepare($adminQuery);
                $st->bindParam(':username', $username);
                $st->execute();
                $user = $st->fetch();

                $check_exist = false;
                if ($st->rowCount() == 1) {
                    if (password_verify($passwordd, $user['password_user'])) {
                        if ($user["role"] == "admin") {
                            $check_exist = true;
                            session_start();
                            $_SESSION["role"] = "admin";
                            $_SESSION["username"] = $username;
                            $_SESSION["id"] = $user["id_user"];
                            header("Location: admin_panel/index.php");
                            exit;
                        } elseif ($user["role"] == "pro") {
                            $check_exist = true;
                            session_start();
                            $_SESSION["role"] = "pro";
                            $_SESSION["username"] = $username;
                            $_SESSION["id"] = $user["id_user"];
                            header("Location: home/home.php");
                            exit;
                        } else {
                            $check_exist = true;
                            session_start();
                            $_SESSION["role"] = "user";
                            $_SESSION["username"] = $username;
                            $_SESSION["id"] = $user["id_user"];
                            header("Location: category/categories.php");
                            exit;
                        }
                    }
                }


                if ($check_exist == false) {
                    $login_error = "Veuillez vérifier votre nom ou mot de passe.";
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
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
    <title>Log in</title>
    <link rel="stylesheet" href="css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet" />
</head>

<body>
    <div class="big">
        <div class="form-container">
            <p class="title">Connexion à MyService</p>
            <p class="signup">Vous n'avez pas de compte ?
                <a rel="noopener noreferrer" href="register.php" class="">Inscrivez-vous</a>
            </p>
            <form class="form" method="post" action="">
                <div class="input-group">
                    <label for="username">Nom d'utilisateur</label>
                    <input type="text" name="username" id="username" placeholder="" class="input">
                    <div class="error">
                        <span><?php if (isset($username_error)) echo $username_error ?></span>
                    </div>
                </div>
                <div class="input-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" name="password" id="password" placeholder="" class="input">
                    <div class="error">
                        <span><?php if (isset($password_error)) echo $password_error ?></span>
                    </div>
                </div>
                <div class="error">
                    <span><?php if (isset($login_error)) echo $login_error ?></span>
                </div>
                <button type="submit" class="sign">Se connecter</button>

            </form>
        </div>

        <div id="logo">
            <img src="imgs/logo.png" id="logo-img">
        </div>

    </div>
</body>

</html>