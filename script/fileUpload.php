<?php

include ("includes/config.php");
    if (isset($_FILES["photo"])) { 
    $errors     = array();
    $maxsize    = 2097152;
    $acceptable = array(
        'application/pdf',
        'image/jpeg',
        'image/jpg',
        'image/gif',
        'image/png'
    );
    
    if(($_FILES['photo']['size'] >= $maxsize) || ($_FILES["photo"]["size"] == 0)) {
        $errors[] = 'File too large. File must be less than 2 megabytes.';
    }

    if((!in_array($_FILES['photo']['type'], $acceptable)) && (!empty($_FILES["photo"]["type"]))) {
        $errors[] = 'Invalid file type. Only PDF, JPG, GIF and PNG types are accepted.';
    }

    if(count($errors) === 0) {
    $file_name	 = $_FILES["photo"]["name"]; 
    $file_tmp_name = $_FILES["photo"]["tmp_name"];
    $targetDir = "../pictures/poster";
    $targetFile = $targetDir.$_FILES['photo']['name'];

    if(move_uploaded_file($file_tmp_name, "$targetDir/$file_name")){
        echo "file uploaded succeeded";

        $result = mysqli_query( $conn,$_POST['sql']);
        echo $_POST['sql'];
        // if ($result) { 
        //     header("location: ../../index.php");
        // }

    } else { 
        echo "File upload Failed";
        }
    } else {
        foreach($errors as $error) {
            echo '<script>alert("'.$error.'");</script>';
        }

        die(); //Ensure no more processing is done
    }
}

?>