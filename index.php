<?php
include 'php/manager.php';
session_start();
if(isset($_SESSION['loggedin'])){
  $conn = connectToDB();
  $user = getUserData($conn, $_SESSION['username']);
}
?>

<!DOCTYPE html>
<html lang="hu">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ágas és Bogas | Enciklopédia</title>
    <link rel="icon" href="img/icon.png" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/index.css" />
    <script
      src="https://kit.fontawesome.com/62786e1e62.js"
      crossorigin="anonymous"
    ></script>
  </head>
  <body>
    <div class="navbar">
      <div id="navbar-mobile">
        <a class="index-link" href="index.html"
          ><img src="img/logo.png" alt="Index oldalra"
        /></a>
        <p id="m-author">Ágas és Bogas</p>
        <div id="mobile-menu">
          <i class="fa-solid fa-bars fa-2xl" style="color: #fff"></i>
          <div id="mobile-menu-container">
            <div id="mobile-link-container">
              <a class="navbar-link" href="html/fajok.html">Fajok</a>
              <a class="navbar-link" href="html/szerepek.html">Szerepek</a>
              <a class="navbar-link" href="html/terkep.html">Térkép</a>
            </div>
          </div>
        </div>
      </div>
      <div id="navbar-desktop">
        <a class="index-link" href="index.html"
          ><img src="img/logo.png" alt="Index oldalra"
        /></a>
        <a class="navbar-link" href="html/fajok.html">Fajok</a>
        <a class="navbar-link" href="html/szerepek.html">Szerepek</a>
        <a class="navbar-link" href="html/terkep.html">Térkép</a>
      </div>
      <?php
      if(isset($_SESSION['loggedin'])){
        echo '<p id="author" style="position: absolute; left: 50%; transform: translateX(-50%)">Ágas és Bogas</p>';
        echo '<a id=desktop-profile-menu class="logger-btn" href="php/logout.php" style="height: 100%"><span class="username">'. $user['username'] .'</span><img class="pfp" src="'. $user['pfp'] .'"></a>';
      } else {
        echo '<a class="logger-btn" href="php/login.php">Login</a><p id="author">Ágas és Bogas</p>';
      }
      ?>
    </div>
    <div class="page">
      <div class="index-text">
        <p id="cim">Értelmes Fajok Enciklopédiája</p>
        <p id="text">
          Ezen az oldalon a Kalauz a Végtelen Világokhoz nevű szerepjáték
          játszható fajairól olvashatsz rövid leírást. A fajok listája bővülni
          fog a későbbi kiadásokban, egyelőre az emberi és ember alkotta fajok
          elérhetőek, de később a nem emberi és más világok fajaival is ki fog
          bővülni az enciklopédia.
        </p>
      </div>
    </div>
    <script src="js/mobile-navbar.js"></script>
  </body>
</html>
