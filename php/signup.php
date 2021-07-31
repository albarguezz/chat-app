<?php
session_start();
include_once("config.php");

$fname = mysqli_real_escape_string($conn, $_POST['fname']);
$lname = mysqli_real_escape_string($conn, $_POST['lname']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

if (!empty($fname) && !empty($lname) && !empty($email) && !empty($password)) {
   // Let's check user email is valid or not 
   if (filter_var($email, FILTER_VALIDATE_EMAIL)) { // if email is valid
      // Let's check that email already exit in the database or not
      $sql = mysqli_query($conn, "SELECT email FROM users WHERE email = '{$email}' ");
      if (mysqli_num_rows($sql) > 0) { // if email already exist
         echo "$email - This already exist!";
      } else {
         // let´s check user upload file or not
         if (isset($_FILES['image'])) { // if file is upload
            $img_name = $_FILES['image']['name']; // Getting user uploaded img name
            $img_type = $_FILES['image']['type'];
            $tmp_name = $_FILES['image']['tmp_name']; // This is a temporary name is used to save file in our folder

            // Let´s explode image and get the last extension like jpg png
            $img_explode = explode('.', $img_name);
            $img_ext = end($img_explode); // Here we get the extension of an user uploaded img file

            $extensions = ['png', 'jpeg', 'jpg']; // these are some valif img ext and we've store them in array
            if (in_array($img_ext, $extensions) === true) { // if user uploaded img ext is matched with any array extensions
               $time = time(); // this will return us current time ...
               // We need this time because when you uploading user img to in our folder we rename user file wth current tme
               // so all the img file will have a unique name

               //let's move the user uploaded img to our particular folder
               $new_img_name = $time . $img_name;
             
               $destination = __DIR__ ."/images/" . $new_img_name;
     
               // NO ENTRA POR AQUI - Solucion del if a false y tiene que ser true, Funciona en windows
               if (move_uploaded_file($tmp_name, $destination)) { // if user upload img move to our folder successfully
                        
                  $status = "Active now"; // Once user sgned up them his status will be active now 
                  $random_id = rand(time(), 10000000); // creating random id for user

                  $encrypt_pass = md5($password);
                  // Let's insert all users data inside table
                  $sql2 = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, password, img, status)
                                          VALUES ({$random_id}, '{$fname}', '{$lname}', '{$email}', '{$encrypt_pass}', '{$new_img_name}', '{$status}')");
                  if ($sql2) { // If these data inserted
                     $sql3 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                     if (mysqli_num_rows($sql3) > 0) {
                        $row = mysqli_fetch_assoc($sql3);
                        $_SESSION['unique_id'] = $row['unique_id']; // Using this session we used user unique_id in other php file
                        echo "success";
                     }
                  } else {
                     echo "Something went wrong!";
                  }
               }else {
                  echo "Error moviendo archivos";
               }
            } else {
               echo "Please select an Image file - jpeg, jpg, png!";
            }
         } else {
            echo "Please select an Image file!";
         }
      }
   } else {
      echo "$email - This is not a valid email!";
   }
} else {
   echo "All input field are requiered!";
}
