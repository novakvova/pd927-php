<?php require_once "connection_database.php"; ?>
<?php require_once "guidv4.php" ?>
<?php
$id = null;
$name = "";
$image = "";
$file_loading_error = [];
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET["id"];
    $command = $dbh->prepare("SELECT id, name, image FROM animals WHERE id = :id");
    $command->bindParam(':id', $id);
    $command->execute();
    $row = $command->fetch(PDO::FETCH_ASSOC);
    $name = $row['name'];
    $image = $row['image'];
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $image = $_POST['image'];
    $id = $_POST['id'];
    $errors = [];
    if (empty($name)) {
        $errors["name"] = "Name is required";
    } else if (empty((basename($_FILES["fileToUpload"]["name"])))) {
        $stmt = $dbh->prepare("UPDATE animals SET name = :name, image = :image WHERE animals.id = :id;");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':image', $image);
        $stmt->execute();
        header("Location: index.php");
    } else {
        $target_dir = "uploads/";
        $ext = pathinfo(basename($_FILES["fileToUpload"]["name"]), PATHINFO_EXTENSION);
        $target_file = $target_dir . guidv4() . "." . $ext;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                array_push($file_loading_error, "File is not an image.");
                $uploadOk = 0;
            }
        }

// Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            array_push($file_loading_error, "Sorry, your file is too large.");
            $uploadOk = 0;
        }

// Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            array_push($file_loading_error, "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
            $uploadOk = 0;
        }

// Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            array_push($file_loading_error, "Sorry, your file was not uploaded.");
// if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $stmt = $dbh->prepare("UPDATE animals SET name = :name, image = :image WHERE animals.id = :id;");
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':image', $target_file);
                $stmt->execute();
                header("Location: index.php");
                exit;
            } else {
                array_push($file_loading_error, "Sorry, there was an error uploading your file.");
            }
        }


    }
}
?>


<?php include "_head.php"; ?>

<script>
    function updateAnimal() {
        $(`#name_error`).attr("hidden", true);
        var name = document.forms[`editAnimal`][`name`];
        if (name.value == '') {
            $(`#name_error`).attr("hidden", false);
            event.preventDefault()
        }
    }
</script>

<div class="container">
    <div class="p-3">
        <h2>Edit animal</h2>
        <form name="editAnimal" onsubmit="return updateAnimal();" method="post" enctype="multipart/form-data">
            <?php
            if ($id != null)
                echo "<input name='id' value='$id' hidden>"
            ?>
            <div class="form-group">
                <label for="exampleInputEmail1">Animal: </label>
                <?php
                echo "<input type='text' name='name' class='form-control' id='exampleInputEmail1'
                           placeholder='Enter animal name' value={$name}>"
                ?>

                <?php
                if (isset($errors['name']))
                    echo "<small class='text-danger'>{$errors['name']}</small>"
                ?>
                <small class='text-danger' id="name_error" hidden>Name is required!</small>
            </div>
            <div class="form-group">
                <!--<label for="exampleInputPassword1">Image url: </label>-->
                <?php
                echo "<input type='text' name='image' class='form-control' id='exampleInputEmail1'
                           placeholder='Enter animal name' value={$image} hidden>"
                ?>

                <?php
                /*                if (isset($errors['image']))
                                    echo "<small class='text-danger'>{$errors['image']}</small>"
                                */ ?>

                <label for="exampleInputPassword1">Select image to upload:</label>
                <br>
                <!-- --><?php
                /*                echo "<input class='form-control' type='file' name='fileToUpload' id='fileToUpload'>"
                                */ ?>
                <input type="file" id="fileToUpload" name='fileToUpload' style="display:none">
                <a href="#" onclick="openFileOption();return;">
                    <img style="width: 450px; height: 450px; " id="blah"
                         src="https://app.hhhtm.com/resources/assets/img/upload_img.jpg" alt="your image"/>
                </a>
                <br>

                <script>
                    blah = document.getElementById("blah")
                    blah.src = "<?php echo $image; ?>"
                </script>


                <?php
                foreach ($file_loading_error as &$value) {
                    echo "<small class='text-danger'>$value</small><br>";
                }
                ?>

                <small class='text-danger' id="image_error" hidden>Image is required!</small>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Save changes</button>
        </form>
    </div>
</div>

<script>

    fileToUpload = document.getElementsByName("fileToUpload")[0]
    blah = document.getElementById("blah")
    fileToUpload.onchange = function () {
        const [file] = fileToUpload.files
        if (file) {
            blah.src = URL.createObjectURL(file)
        }
    }

    function openFileOption() {
        document.getElementById("fileToUpload").click();
    }


</script>

<?php include "_footer.php"; ?>
