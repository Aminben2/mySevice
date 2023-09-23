<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etabs</title>
    <link rel="stylesheet" href="css/table.css">
</head>

<body>
    <?php
    require("admin_navbar.php");

    $sql = "SELECT * FROM etablissement WHERE status = 'en attent'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_SESSION["msg"])) {
        $msg = $_SESSION["msg"];
        echo '<script>window.onload = function() {alert(" ' . $msg . ' ")};</script>';
        unset($_SESSION["msg"]);
    }
    ?>
    <h2>Prof_requests</h2>
    <div class="table-wrapper">
        <table class="fl-table">
            <thead>
                <tr>
                    <th>Etab ID</th>
                    <th>Etab Name</th>
                    <th>Etab description</th>
                    <th>Contact Number</th>
                    <th>Licence number</th>
                    <th>Pro ID</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($result)) {
                    foreach ($result as $row) {
                        echo "<tr>";
                        echo "<td>" . $row["id_etab"] . "</td>";
                        echo "<td>" . $row["name_etab"] . "</td>";
                        echo "<td>" . $row["description_etab"] . "</td>";
                        echo "<td>" . $row["contact_num"] . "</td>";
                        echo "<td>" . $row["num_pattente"] . "</td>";
                        echo "<td>" . $row["user"] . "</td>";
                ?>
                        <td>
                            <form action="controlers/etab_process.php" method="post">
                                <input type="hidden" name="id_etab" value="<?php echo $row["id_etab"] ?>">
                                <button title="Accept The Request" id="accept" type="submit" name="accept"><img src="imgs//check (1).png"></button>
                                <button title="Reject The Request" id="reject" type="submit" name="reject"><img src="imgs/cross.png"></button>
                            </form>
                        </td>
                <?php
                        echo "</tr>";
                    }
                }
                ?>
            <tbody>
        </table>
    </div>
</body>

</html>