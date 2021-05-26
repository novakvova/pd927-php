<?php require_once "connection_database.php"; ?>
<?php include "_head.php"; ?>

<a href="/add.php" class="btn btn-danger">Додати</a>
    <table>
        <thead>
        <tr>
            <th>id</th>
            <th>name</th>
            <th>image</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $command = $dbh->prepare("SELECT id, name, image FROM animals");
        $command->execute();
        while ($row = $command->fetch(PDO::FETCH_ASSOC))
        {
            echo "
            <tr>
                <td>{$row["id"]}</td>
                <td>{$row["name"]}</td>
                <td>{$row["image"]}</td>
            </tr>
            ";
        }
        ?>

        </tbody>
    </table>
<?php
include "_footer.php";
?>
