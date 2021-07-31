<?php
session_start();
include_once("config.php");

$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

if (!empty($email) && !empty($password)) {
   // let's check users entered email & password matched to de daatabase any table row emaiol and password
   $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");

   if (mysqli_num_rows($sql) > 0) { // if users credentials matched

      $row = mysqli_fetch_assoc($sql);
      $user_pass = md5($password);
      $enc_pass = $row['password'];
      if ($user_pass === $enc_pass) {
         $status = "Active now";
         
         // updatin user status to active now if user login success
         $sql2 = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = {$row['unique_id']}");

         if ($sql2) {
            $_SESSION['unique_id'] = $row['unique_id']; // Using this session we used user unique_id in other php file
            echo "success";
         } else {
            echo "Something went wrong. Please try again!";
         }
      } else {
         echo "Email or password is incorrect!";
      }

   } else {
              
      echo "$email - This email not Exist!";
   }
} else {
   echo "All input files are required!";
}
