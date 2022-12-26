<?php
namespace app\models;
 if(isset($_POST['submit'])){

   $newFileName = $_POST['filename'];
   if(empty($_POST['filename'])){
     $newFileName = "gallery";
   } else {
     $newFileName = strtolower(str_replace(" ", "-", $newFileName));
   }

   $imageTitle = $_POST['filetitle'];
   $imageDesc = $_POST['filedesc'];

   $file = $_FILES['file'];
   $fileName = $file['name'];
   $fileType = $file['type'];
   $fileTempName = $file['tmp_name'];
   $fileError = $file['error'];
   $fileSize = $file['size'];

   $fileExt = explode(".",$fileName);
   $fileActualExt = strtolower(end($fileExt));

   $allowed = array("jpg", "jpeg", "png");

   if(in_array($fileActualExt, $allowed)){
     if($fileError === 0){
       if($fileSize < 20000000){
         $imageFullName = $newFileName.".".uniqid("",true).".".$fileActualExt;//uniq id...//more karakter than default with true with false kreate smaller uniq id//include file extention
         $fileDestination = "../img/index/".$imageFullName;

         include_once 'dbh.inc.php';

         if(empty($imageTitle) || empty($imageDesc)){
           header("Location : ../index.php?upload=empty");
           exit(); //ndalon skriptin
         } else {
           $sql = "SELECT * FROM gallery;";
           $stmt = mysqli_stmt_init($conn); //inicialize
           if (!mysqli_stmt_prepare($stmt,$sql)) {
             echo "SQL statement failed!";
           } else {
             mysqli_stmt_execute($stmt);
             $result = mysqli_stmt_get_result($stmt);
             $rowcount = mysqli_num_rows($result);
             $setImageOrder = $rowcount +1;

             $sql = "INSERT INTO gallery (titleGallery, descGallery, imgFullNameGallery, orderGallery)
                     VALUES (?, ?, ?, ?);";
             if (!mysqli_stmt_prepare($stmt,$sql)) {
                       echo "SQL statement failed!";
              } else {
                mysqli_stmt_bind_param($stmt,"ssss",$imageTitle, $imageDesc, $imageFullName, $setImageOrder);
                mysqli_stmt_execute($stmt);

                move_uploaded_file($fileTempName, $fileDestination);

                header("Location: ../index.php?uploadsuccess");
              }
           }
         }

       } else {
         echo "Your file size is too big!";
         exit();
       }
     } else {
       echo "You had and error!";
       exit();
     }
   } else {
     echo "You need to upload a proper file type!";
     exit ();
   }


 }
 ?>
