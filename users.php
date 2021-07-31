<?php
session_start();
include_once "php/config.php";
if (!isset($_SESSION['unique_id'])) {
   header('location: login.php');
}
?>

<?php require_once('header.php');
?>

<body>
   <div class="wrapper">
      <section class="users">
         <!-- Start Header User -->
         <header>
            <div class="content">
               <?php

                  $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");

                  if (mysqli_num_rows($sql) > 0) {
                     $row = mysqli_fetch_assoc($sql);
                  }
               ?>


               <img src="php/images/<?php echo $row['img'] ?>" alt="">
               <div class="details">
                  <span><?php echo $row['fname'] . " " . $row['lname'];
                        ?></span>
                  <p><?php echo $row['status'] ?></p>
               </div>
            </div>
            <a href="php/logout.php?logout_id=<?php echo $row['unique_id'] ?>" class="logout">Logout</a>
         </header>
         <!-- End Header User -->

         <!-- Start Search -->
         <div class="search">
            <span class="text">Select an user to start chat</span>
            <input type="text" placeholder="Enter name to search">
            <button><i class="fas fa-search"></i></button>
         </div>
         <!-- End Search -->

         <!--  Users List -->
         <div class="users-list">
         </div>
         <!-- End Users List -->

      </section>
   </div>

   <!-- Scripts -->
   <script src="js/users.js"></script>

</body>

</html>