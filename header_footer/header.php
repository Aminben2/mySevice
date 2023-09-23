<head>
    <style>
        header {

            height: 10vh;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 60px 30px 60px 30px;
        }

        header img {
            height: 60px;
            width: 200px;
        }

        header ul {
            list-style: none;
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        header li {
            padding: 0px 30px 0px 30px;
        }

        header #pro,
        header #logout {
            background-color: #4b2b79;
            padding: 10px 15px 10px 15px;
            border-radius: 18px;
        }

        header #pro a,
        header #logout {
            color: #ffffff;
        }

        header #pro:hover,
        header #logout {
            background-color: #fa8c5e;
            padding: 10px 15px 10px 15px;
            border-radius: 18px;
        }

        header li a {
            text-decoration: none;
            color: #4b2b79;
            font-size: 21px;
            letter-spacing: 4px;
            font-weight: bolder;
        }

        #profile {
            padding: 0;
            margin-left: 10px;
        }

        #profile a img {
            width: 50px;
            height: 50px;
        }
    </style>
    <script src="profile.js" defer></script>

</head>


<header>
    <img src="../imgs/logo.png" />

    <ul>
        <?php
        if (isset($_SESSION) && !empty($_SESSION)) {
            if ($_SESSION["role"] == "user") {
        ?>
                <li><a href="../home/home.php">Home</a></li>
                <li><a href="../category/categories.php">Categories</a></li>
                <li id="pro"><a href="../pro_register.php">Join as a Pro</a></li>
                <li id="logout"><a onclick="return confirm('Are you sure you want to Log Out')" href=" ../logout.php">Log out</a></li>
            <?php
            } else {
            ?>
                <li><a href="../home/home.php">Home</a></li>
                <li><a href="../category/categories.php">Categories</a></li>
                <li id="logout"><a onclick="return confirm('Are you sure you want to Log Out')" href="../logout.php">Log out</a></li>
                <li id="profile"><a id="prof" href="../etab_pro/pro_etab.php"><img src="../imgs/account.png" alt="profile"></a></li>
            <?php
            }
        } else {
            ?>
            <li><a href="../home/home.php">Home</a></li>
            <li><a href="../category/categories.php">Categories</a></li>
            <li id="signup"><a href="../register.php">Sing Up</a></li>
            <li id="login"><a href=" ../login.php">Log In</a></li>
            <li id="pro"><a href=" ../pro_register.php">Join as a Pro</a></li>
        <?php
        }
        ?>
    </ul>
</header>