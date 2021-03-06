<?php
 include_once ('functions_common.php');

  $link = connectToDB();

  if (session_status() == PHP_SESSION_NONE) {
      sec_session_start();
  }

  // Only redirect if we are not already on the login page
  if ($_SERVER['PHP_SELF'] !== '/login.php'){
    // If not logged in, redirect to login page
    if (login_check($link) == false) {
      $host = $_SERVER['HTTP_HOST'];
      $uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
      header("Location: http://$host$uri/login.php");
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <!-- All the shared stuff here, specific things in each viewfile -->

    <!-- Meta -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <!--Icon-->
    <link rel="icon" href="/design/Icon.png" type="image/x-icon"/>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="css/main.css" type="text/css">
    <link rel="stylesheet" href="css/responsive.css" type="text/css">
    <link rel="stylesheet" href="css/slideout.css" type="text/css">

    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700|Pirata+One' rel='stylesheet' type='text/css'>


    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/main.js"></script>
    <script type="text/javascript" src="js/sha512.js"></script>
    <script src="https://use.fontawesome.com/9b6ee04da3.js"></script>
    <script src="js/slideout.min.js"></script>
    <script src="js/snapmodal.js"></script>

    <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-60923531-2', 'auto');
    ga('send', 'pageview');
    </script>
