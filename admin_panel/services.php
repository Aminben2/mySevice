<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services</title>
    <link rel="stylesheet" href="css/table.css">
</head>

<body>
    <?php
    require("admin_navbar.php");
    $sql = "SELECT * FROM service";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_SESSION["msg"])) {
        $msg = $_SESSION["msg"];
        echo '<script>window.onload = function() {alert(" ' . $msg . ' ")};</script>';
        unset($_SESSION["msg"]);
    }
    ?>
    <h2>Services Table</h2>
    <div class="table-wrapper">
        <table class="fl-table">
            <thead>
                <tr>
                    <th>Service ID</th>
                    <th>Service name</th>
                    <th>Category</th>
                    <th>Parent Service</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($result)) {
                    foreach ($result as $row) {
                        echo "<tr>";
                        echo "<td>" . $row["id_service"] . "</td>";
                        echo "<td>" . $row["name_service"] . "</td>";
                        echo "<td>" . $row["id_category"] . "</td>";
                        if (empty($row["parent_service"])) echo "<td>Null</td>";
                        else echo "<td>" . $row["parent_service"] . "</td>";
                        echo "<td><a di='edit' href='controlers/edit_service.php?id_service=" . $row['id_service'] . "'><img src='imgs/pen.png'></a></td>";
                ?>
                        <td>
                            <form action='controlers/delete_service.php' method='post' onsubmit='return confirmDelete()'>
                                <input type='hidden' name='id_service' value='<?php if (isset($row["id_service"])) echo $row["id_service"] ?>'>
                                <button id="delete" type="submit"><img src="imgs/delete.png" alt=""></button>
                            </form>
                        </td>

                <?php
                        echo "</tr>";
                    }
                }
                ?>
                <script>
                    function confirmDelete() {
                        return confirm("Are you sure you want de delete this Service ?")
                    }
                </script>
            <tbody>
        </table>
    </div>
    <div class="add">
        <a class="button" href="controlers/add_service.php">Add Service
            <div class="arrow-wrapper">
                <div class="arrow"></div>
            </div>
        </a>
    </div>
</body>

</html>