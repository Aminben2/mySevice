<?php
require("dbconnect.php");
require("validation_functions.php");



session_start();
if (isset($_SESSION["msg"])  && !empty($_SESSION["msg"])) {
    $msg = $_SESSION["msg"];
    echo "<script>window.onload=function () {alert('$msg')}</script>";
    unset($_SESSION["msg"]);
    session_unset();
    session_destroy();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST["username"]) && isset($_POST["password"]) &&
        isset($_POST["f_name"]) && isset($_POST["l_name"]) &&
        isset($_POST["adress"]) && isset($_POST["email"]) &&
        isset($_POST["confirm"]) && isset($_POST["gender"]) &&
        isset($_POST["phone"])
    ) {
        $first_name = checkInput($_POST['f_name']);
        $last_name = checkInput($_POST['l_name']);
        $gender = $_POST['gender'];
        $username = checkInput($_POST['username']);
        $email = checkInput($_POST['email']);
        $passwordd = checkInput($_POST['password']);
        $confirm = checkInput($_POST["confirm"]);
        $address = checkInput($_POST['adress']);
        $phone = checkInput($_POST['phone']);


        $check = 0;


        if (!validateUsername($username)) {
            $check++;
            $username_error = "nom d'utilisateur non valide";
        }

        if (!validateAddress($address)) {
            $check++;
            $address_error = "Adresse non valide";
        }

        if (!validatePassword($passwordd, $confirm)) {
            $check++;
            $confirm_error = "Les mots de passe ne correspondent pas";
        }

        if (!validatePassword1($passwordd)) {
            $check++;
            $password_error = "Le mot de passe est faible";
        }


        if ($check == 0) {
            try {
                $hashedPassword = password_hash($passwordd, PASSWORD_BCRYPT);

                $query = "INSERT INTO user (user_username, email_user, password_user,nom_user,prenom_user,adress_user,gender,tel_user) VALUES (:username, :email, :passwordd,:f_name,:l_name,:adress,:gender,:phone)";
                $stmt = $connection->prepare($query);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':passwordd', $hashedPassword);
                $stmt->bindParam(':f_name', $first_name);
                $stmt->bindParam(':l_name', $last_name);
                $stmt->bindParam(':adress', $address);
                $stmt->bindParam(':gender', $gender);
                $stmt->bindParam(':phone', $phone);
                $result = $stmt->execute();


                if ($result) {
                    header("location: login.php");
                    exit;
                }
            } catch (PDOException $e) {

                if ($e->getCode() === '23000') {

                    if (strpos($e->getMessage(), 'user_username') !== false) {
                        $username_error = "Le nom d'utilisateur est déjà utilisé.";
                    } elseif (strpos($e->getMessage(), 'email_user') !== false) {
                        $email_error = "L'adresse e-mail est déjà enregistrée.";
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
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Se connecter</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet" />
    <script src="scripts/register.js" defer></script>
    <link rel="stylesheet" href="css/register.css">
</head>

<body>

    <div class="form-container">
        <h1>Rejoindre nous</h1>
        <p class="signup">Vous avez déjà un compte?
            <a rel="noopener noreferrer" href="login.php" id="cnx">Connexion</a>
        </p>
        <!---->
        <form class="form" method="post" action="">

            <div id="full-name">
                <div class="gh">
                    <i><img src="imgs/f-icons/user.png"></i>
                    <div class="input-group">
                        <input type="text" name="f_name" id="f_name" required placeholder="Prénom">
                        <div class="error">
                            <span id="fNameErr"></span>
                        </div>
                    </div>
                    <div class="input-group">
                        <input type="text" name="l_name" id="l_name" required placeholder="Nom de famille">
                        <div class="error">
                            <span id="lNameErr"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div id="gender" class="input-group">
                <label for="gender">Sexe:</label>
                <div class="l-radio">
                    <label for="ff-option">
                        <input type="radio" id="ff-option" value="female" tanindex="1" required name="gender">
                        <span>Féminin</span>
                    </label>
                    <label for="ss-option">
                        <input type="radio" value="male" id="ss-option" tabindex="1" required name="gender">
                        <span>Masculin</span>
                    </label>
                </div>
            </div>

            <div class="input-group">
                <div class="gh">
                    <i><img src="imgs/f-icons/id.png"></i>
                    <input type="text" name="username" id="username" required placeholder="Nom d'utilisateur">
                </div>

                <div class="error">
                    <span id="usernameErr"><?php if (isset($username_error)) echo $username_error ?></span>
                </div>
            </div>
            <div class="input-group">
                <div class="gh">
                    <i><img src="imgs/f-icons/mail.png"></i>
                    <input type="email" name="email" id="email" required placeholder="E-mail">
                </div>

                <div class="error">
                    <span id="emailErr"><?php if (isset($email_error)) echo $email_error  ?></span>
                </div>
            </div>
            <div class="input-group">
                <div class="gh">
                    <i><img src="imgs/f-icons/phone.png"></i>
                    <input type="tel" name="phone" id="phone" required pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" placeholder="Télephone">
                </div>
                <div class="error">
                    <span id="phoneErr"><?php if (isset($email_error)) echo $email_error  ?></span>
                </div>
            </div>

            <div class="input-group">
                <div class="gh">
                    <i><img src="imgs/f-icons/adress.png"></i>
                    <input type="text" name="adress" id="adress" required placeholder="Adresse">
                </div>
                <div class="error">
                    <span id="addressErr"><?php if (isset($address_error)) echo $address_error ?></span>
                </div>
            </div>
            <div class="input-group">
                <div class="gh">
                    <i><img src="imgs/f-icons/password.png"></i>
                    <input type="password" name="password" id="password" required placeholder="Mot de passe">
                </div>
                <div class="error">
                    <span id="passwordErr"><?php if (isset($password_error)) echo $password_error ?></span>
                </div>
            </div>
            <div class="input-group">
                <div class="gh">
                    <i><img src="imgs/f-icons/password.png"></i>
                    <input type="password" name="confirm" id="confirm" required placeholder="Confirmer le mot de passe">
                </div>
                <div class="error">
                    <span id="confirmErr"><?php if (isset($confirm_error)) echo $confirm_error ?></span>
                </div>
            </div>
            <div id="spn">
                <button class="sign" type="submit">S'inscrire</button>
                <span><img id="logo_img" src="imgs/logo.png" /></span>
            </div>

        </form>

    </div>
</body>

</html>