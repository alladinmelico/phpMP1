<?php

include ("includes/config.php");

echo "<pre>"; 
print_r($_FILES); 
echo "</pre>"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
	if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0) { 

    $file_name	 = $_FILES["photo"]["name"]; 
		$file_type	 = $_FILES["photo"]["type"]; 
		$file_size	 = $_FILES["photo"]["size"]; 
		$file_tmp_name = $_FILES["photo"]["tmp_name"]; 
		$file_error = $_FILES["photo"]["error"]; 
		
        $targetDir = "../pictures/profile";
        $targetFile = $targetDir.$_FILES['photo']['name'];
        
        if($file_size > 2097152){
           $errors[]='File size must be lower than 2 MB';
        }
        
        if (move_uploaded_file($file_tmp_name, "$targetDir/$file_name")) {
            echo "file uploaded succeeded";
          } else { 
            echo "file upload failed";
          }
     }
    $name= $_POST['strActorFullName'];
    $memo = $_POST['memActorNotes'];

    $sql = "INSERT INTO tblactors (strActorFullName,memActorNotes,picture) values ('$name','$memo','$file_name');";
    echo $sql;
    $result = mysqli_query( $conn,$sql);

    if ($result) {
        header("location: actor.php?search=#");
    }
}
?>