<?php
if(isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
   print_r($_FILES['file']);
   $target_dir = "uploads/";
   $target_file = $target_dir . basename($_FILES['file']['name']);
   if(move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
    echo "The file ". basename($_FILES['file']['name']). " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }

   echo $response;
   exit;
}
else{
    echo 'File not found';
}
