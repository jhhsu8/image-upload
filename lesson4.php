<?php
    require_once "./includes/variables.inc.php";

    // declare variables
    $display_form = true;
    $first_name = "";
    $last_name = "";
    $user_file = "";
    $error_message = "";
    $correct_image_type = false;
    $file_upload_size = false;
    
    //allowed mime types for image upload
    $mime_types = array("image/png", "image/jpg", "image/jpeg", "image/pjpeg", "image/gif");

    // check if submit button has submitted form data
    if (isset($_POST['submit'])) {
        
        //get submitted form data
        $first_name = trim($_POST['firstname']);
        $last_name = trim($_POST['lastname']);
        $user_file = $_FILES['userimage']['name'];
        $file_type = $_FILES['userimage']['type'];
        $file_size = $_FILES['userimage']['size'];
        $file_tmp_name = $_FILES['userimage']['tmp_name'];
        $upload_error = $_FILES['userimage']['error'];
        
        //check if file size is valid
        if ($file_size == 0 || $file_size > MAX_FILE_SIZE) {
            
            $file_upload_size = false;
            $error_message .= "<p>Invalid file size - maximum size is ".(MAX_FILE_SIZE / 1024)."kb.</p>";
            
        } else { 
            
            $file_upload_size = true;
        }
        
        //check if file type is valid
        if (!in_array($file_type, $mime_types)) {
        
            $correct_image_type = false;
            $error_message .= "<p>Invalid image format - it must be .png, .jpg, .jpeg, or .gif.</p>";
    
        } else {
            
            $correct_image_type = true;
        }
        
        //check if file upload information is valid
        if ($upload_error != 0 || !$file_upload_size || !$correct_image_type) {
            
            $error_message .= "<p>Please try uploading again.</p>";
            $display_form = true;
        
        } else {
        
            $display_form = false;
            $target_file = SITE_ROOT_PATH.USER_UPLOAD_DIR.$user_file;
            
            //move file to the uploads folder
            move_uploaded_file($file_tmp_name, $target_file)
                or die("File move failed");
        }
    }

    require_once("./includes/htmlhead.inc.php");
?>

    <body>
        <div id="bodycontainer">
            
<?php require_once("./includes/header.inc.php"); ?>
            
            <div id="content">
                
                <?php
                    if ($display_form) { // display entry form  
                ?>
                
                <h2>Entry Form</h2>
                <p>
                    The user is required to upload an image file. The maximum file size is 1000kb.<br>
                    The image format must be .png, .jpg, .jpeg, or .gif.
                </p>
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data" name="userform">
                    
                    <div id="error"><?= $error_message ?></div>
                        
                    <table>
                        <tr>
                            <td><label for="firstname">First Name:</label></td>
                            <td><input type="text" name="firstname" id="firstname" size="20" value="<?= $first_name ?>"></td>
                        </tr>
                        <tr>
                            <td><label for="lastname">Last Name:</label></td>
                            <td><input type="text" name="lastname" id="lastname" size="20" value="<?= $last_name ?>"></td>
                        </tr>
                        <tr>
                            <td><label for="userimage">Upload an Image:</label></td>
                            <td><input type="file" name="userimage" id="userimage"></td>
                        </tr>
                    </table>
                    <p><input type="submit" name="submit" id="submit" value="Submit"></p>
                </form>
            
                <?php
                    } else { // display form processing page
                ?>
            
                <h2>Thank You for Adding Your Name and Image!</h2>
                <p>User Name: <?= "$first_name $last_name" ?></p>
                <p>User Image:<br><img src="<?= USER_UPLOAD_DIR.$user_file ?>" alt="User Image"></p>
            
                <?php
                    }
                ?>
                
            </div>
            
<?php require_once("./includes/footer.inc.php"); ?>
            
        </div>
    </body>
</html>

<?php
    // close database connection
    mysqli_close($dbc);
?>