<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    <link rel="stylesheet" href="css/table.css">

</head>

<body id="body">
    <?php
    require("admin_navbar.php");

    $sql = "SELECT * FROM category";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


    if (isset($_SESSION["msg"])) {
        $msg = $_SESSION["msg"];
        echo '<script>window.onload = function() {alert(" ' . $msg . ' ")};</script>';
        unset($_SESSION["msg"]);
    }
    ?>
    <h2>Categories Table</h2>
    <div class="table-wrapper">
        <table class="fl-table">
            <thead>
                <tr>
                    <th>Category ID</th>
                    <th>Category name</th>
                    <th>Category description</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($result)) {
                    foreach ($result as $row) {
                        echo "<tr>";
                        echo "<td>" . $row["id_category"] . "</td>";
                        echo "<td>" . $row["name_category"] . "</td>";
                        echo "<td>" . $row["description_category"] . "</td>";
                        echo "<td><a id='edit' href='controlers/edit_category.php?id_category=" . $row['id_category'] . "'><img src='imgs/pen.png'></a></td>";
                ?>

                        <td>
                            <form action='controlers/delete_category.php' method='post' onsubmit='return confirmDelete()'>
                                <input type='hidden' name='id_category' value='<?php if (isset($row["id_category"])) echo $row["id_category"] ?>'>
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
                        return confirm("Are you sure you want de delete this Category ?")
                    }
                </script>
            <tbody>
        </table>
    </div>
    <div class="add">
        <a class="button" href="controlers/add_category.php">Add category
            <div class="arrow-wrapper">
                <div class="arrow"></div>
            </div>
        </a>
    </div>
    <script src="scripts/add_button.js"></script>
</body>

</html>