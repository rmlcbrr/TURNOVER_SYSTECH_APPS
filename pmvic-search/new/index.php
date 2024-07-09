<?php include('route.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" />
    <link rel="icon" href="./assets/logo.jpg" type="image/x-icon" sizes="16x16 32x32 48x48">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./assets/custom.js"></script>
    <link rel="stylesheet" href="./assets/custom.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  
    <?php
  $now = time();
  if($now > $_SESSION['expire']){
    session_destroy();
    include('login.php');
  }else{
  	include('nav.php');
    include('search.php');
  }
  
   // if (isset($_SESSION['loggedin'])) {
    //    include('nav.php');
     //   include('search.php');
    //} else {
        
   // }
    ?>
</body>
<!-- Cloudflare Web Analytics --><script defer src='https://static.cloudflareinsights.com/beacon.min.js' data-cf-beacon='{"token": "f14cb926c4b945d587def04d46756628"}'></script><!-- End Cloudflare Web Analytics -->
</html>