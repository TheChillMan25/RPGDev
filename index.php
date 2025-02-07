<?php
include 'php/scripts/manager.php';
session_start();
if (checkLogin()) {
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
  <script src="https://kit.fontawesome.com/62786e1e62.js" crossorigin="anonymous"></script>
</head>

<body>
  <div class="navbar">
    <a class="index-link" href="index.php"><img src="img/assets/icons/logo.png" alt="Index oldalra" /></a>
    <div id="link-container">
      <a class="navbar-link" href="php/fajok.php">Fajok</a>
      <a class="navbar-link" href="php/szerepek.php">Szerepek</a>
      <a class="navbar-link" href="php/terkep.php">Térkép</a>
    </div>
    <p id="author">Ágas és Bogas</p>
    <?php
    if (checkLogin()) {
      echo '
        <div id=desktop-profile-menu class="logger-btn" style="cursor: pointer;">
          <span class="username">' . $user['username'] . '</span>
          <img class="pfp" src="' . $user['pfp'] . '">
        </div>
        <div id="profile-menu-container">
          <div id="profile-menu">
            <div id="profile-link-container" class="profile-container">
              <a class="profile-menu-link" href="php/profile.php">Profile</a>
              <a class="profile-menu-link" href="php/create.php">Character maker</a>
              <a class="profile-menu-link" href="php/scripts/logout.php">Logout</a>
            </div>
            <div id="m-link-container" class="profile-container">
              <hr class="nav-hr">
              <a class="profile-menu-link" href="php/fajok.php">Fajok</a>
              <a class="profile-menu-link" href="php/szerepek.php">Szerepek</a>
              <a class="profile-menu-link" href="php/terkep.php">Térkép</a>
            </div>
          </div>
        </div>';
    } else {
      echo '<a id="login" class="logger-btn" href="php/login.php" style="color:#f2c488;">Login</a>';
      echo '<button id="m-menu"
      style="color: whitesmoke; width:4rem; height:4rem; background-color:transparent; border: none; font-size: large"><i
        class="fa-solid fa-bars fa-2xl"></i></button>
        <div id="m-link-c" style="display: none; height: 100%; width:100%; position:absolute;
       top:0; right:0rem;  z-index: 10">
        <div id="m-link-m"
        style="position:absolute; top:4rem; right:0rem; width:13rem; padding: .5rem; flex-direction: column; background-color: #333; z-index: 12">
        <a class="profile-menu-link" href="php/login.php">Login</a>
        <hr class="nav-hr">
        <a class="profile-menu-link" href="php/fajok.php">Fajok</a>
        <a class="profile-menu-link" href="php/szerepek.php">Szerepek</a>
        <a class="profile-menu-link" href="php/terkep.php">Térkép</a>
        </div>
      </div>';
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
  <script src="js/menus.js"></script>
</body>

</html>