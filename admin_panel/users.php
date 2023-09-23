<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>users</title>
    <link rel="stylesheet" href="css/table.css">
</head>

<body>
    <?php
    require("admin_navbar.php");

    $sql = "SELECT * FROM user";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $pdo = null;

    if (isset($_SESSION["msg"])) {
        $msg = $_SESSION["msg"];
        echo '<script>window.onload = function() {alert(" ' . $msg . ' ")};</script>';
        unset($_SESSION["msg"]);
    }
    ?>
    <h2>Users Table</h2>
    <div class="table-wrapper">
        <table class="fl-table">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Full name</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($result)) {
                    foreach ($result as $row) {
                        echo "<tr>";
                        echo "<td>" . $row["id_user"] . "</td>";
                        echo "<td>" . $row["prenom_user"] . " " . $row["nom_user"] . "</td>";
                        echo "<td>" . $row["user_username"] . "</td>";
                        echo "<td>" . $row["role"] . "</td>";
                        echo "<td><a id='edit' href='controlers/edit_user.php?id_user=" . $row['id_user'] . "'><img src='imgs/pen.png'><</a></td>";
                ?>
                        <td>
                            <form action='controlers/delete_user.php' method='post' onsubmit='return confirmDelete()'>
                                <input type='hidden' name='id_user' value='<?php if (isset($row["id_user"])) echo $row["id_user"] ?>'>
                                <button id="delete" type="submit"><img src="imgs/delete.png" alt=""></button>
                            </form>
                        </td>
                <?php
                        echo "<tr>";
                    }
                }

                ?>
                <script>
                    function confirmDelete() {
                        return confirm("Are you sure you want de delete this user ?")
                    }
                </script>

            <tbody>
        </table>
    </div>
</body>

</html>
<?php

// $password = bin2hex(random_bytes(8)); // Generate an 8-character random password
// $hashedPassword = password_hash("password_test", PASSWORD_BCRYPT);
// echo $hashedPassword;

?>