<?php require_once "connection_database.php"; ?>
<?php require_once "guidv4.php" ?>
<?php
function base64_to_jpeg($base64_string, $output_file) {
    // open the output file for writing
    $ifp = fopen( $output_file, 'wb' );

    // split the string on commas
    // $data[ 0 ] == "data:image/png;base64"
    // $data[ 1 ] == <actual base64 string>
    $data = explode( ',', $base64_string );

    // we could add validation here with ensuring count( $data ) > 1
    fwrite( $ifp, base64_decode( $data[1] ) );

    // clean up the file resource
    fclose( $ifp );

    return $output_file;
}



$name = "";
$ext="";
$image_url = "";
$image = "https://app.hhhtm.com/resources/assets/img/upload_img.jpg";
$file_loading_error=[];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $image= $_POST["imageUpload"];
    /*$image_url = $_POST['image'];*/
    $errors = [];
    if (empty($name)) {
        $errors["name"] = "Name is required";
    }
    else{
        $target_dir = "uploads/";
        $ext = $_POST["fileExt"];
        $target_file = $target_dir.guidv4().".".$ext;
        $uploadOk = 1;


// Allow certain file formats
        if($ext != "jpg" && $ext != "png" && $ext != "jpeg"
            && $ext != "gif" ) {
            array_push($file_loading_error, "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
            $uploadOk = 0;
        }

// Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            array_push($file_loading_error, "Sorry, your file was not uploaded.");
// if everything is ok, try to upload file
        } else {
            if(base64_to_jpeg($image, $target_file)) {
                $stmt = $dbh->prepare("INSERT INTO animals (id, name, image) VALUES (NULL, :name, :image);");
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


    <script>
        function addAnimal() {
            // $(`#name_error`).attr("hidden",true);
            // var name = document.forms[`addAnimalForm`][`name`];
            // if (name.value=='') {
            //     $(`#name_error`).attr("hidden",false);
            //     event.preventDefault()
            // }
        }

    </script>

<?php include "_head.php"; ?>

<?php include "_cropper_modal.php" ?>

    <div class="container">
        <div class="p-3">
            <h2>Add new animal</h2>
            <form name="addAnimalForm" onsubmit="return addAnimal();" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="exampleInputEmail1">Animal: </label>
                    <?php
                        echo "<input type='text' name='name' class='form-control' id='exampleInputEmail1'
                           placeholder='Enter animal name' value={$name}>"
                    ?>
                    <small class='text-danger' id="name_error" hidden>Name is required!</small>
                    <?php
                        if(isset($errors['name']))
                            echo "<small class='text-danger'>{$errors['name']}</small>"
                    ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Select image to upload:</label>
                    <br>
                  <!--  --><?php
/*                        echo"<input class='form-control'  accept='image/*' type='file' name='fileToUpload' id='fileToUpload'>"
                    */?>

<!--                    <input  type="file" id="fileToUpload" name='fileToUpload' style="display:none">-->
                    <?php
                    echo "
                    <img style='width: 300px; height: 300px; border-radius: 50%;' id='blah'
                         src='{$image}' alt='your image' /> 
                         
                    <input type='hidden' value='{$image}' id='imageUpload' name='imageUpload'>
                    <input type='hidden' value='{$ext}' id='fileExt' name='fileExt'>";
                         ?>


                    <br>
                    <?php
                    foreach ($file_loading_error as &$value) {
                        echo "<small class='text-danger'>$value</small>";
                        }
                    ?>

                    <?php
/*                    echo "<input type='text' name='image' class='form-control' id='exampleInputEmail1'
                           placeholder='Enter animal name' value={$image_url}>"
                    */?>

                    <?php
                        if(isset($errors['image']))
                            echo "<small class='text-danger'>{$errors['image']}</small><br>"
                    ?>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Submit</button>
            </form>
        </div>
    </div>





<?php include "_footer.php"; ?>



<script src="/js/add.js"></script>
