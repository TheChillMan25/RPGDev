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
    <div id="navbar-mobile">
      <a class="index-link" href="index.php"><img src="img/logo.png" alt="Index oldalra" /></a>
      <p id="m-author">Ágas és Bogas</p>
      <div id="mobile-menu">
        <?php
        if (checkLogin()) {
          echo '<div id=mobile-profile-menu class="logger-btn-mobile" style="cursor: pointer;">
                <img class="pfp" src="' . $user['pfp'] . '">
              </div>';
        } else {
          echo '<i class="fa-solid fa-bars fa-2xl" style="color: #fff"></i>';
        }
        ?>
        <div id="mobile-menu-container">
          <div id="mobile-link-container">
            <?php
            if (checkLogin()) {
              echo '<a class="navbar-link" href="php/profile.php">' . $user['username'] . '</a>
            <a class="navbar-link" href="php/create-character.php">Create your character</a>
            <a class="navbar-link" href="php/scripts/logout.php">Logout</a>
            <hr>';

            } else {
              echo '<a class="navbar-link" href="php/login.php">Login</a><hr class="nav-hr">';
            }
            ?>
            <a class="navbar-link" href="php/fajok.php">Fajok</a>
            <a class="navbar-link" href="php/szerepek.php">Szerepek</a>
            <a class="navbar-link" href="php/terkep.php">Térkép</a>
          </div>
        </div>
      </div>
    </div>
    <div id="navbar-desktop">
      <a class="index-link" href="index.php"><img src="img/logo.png" alt="Index oldalra" /></a>
      <a class="navbar-link" href="php/fajok.php">Fajok</a>
      <a class="navbar-link" href="php/szerepek.php">Szerepek</a>
      <a class="navbar-link" href="php/terkep.php">Térkép</a>
    </div>
    <?php
    if (checkLogin()) {
      echo '<p id="author" style="position: absolute; left: 50%; transform: translateX(-50%)">Ágas és Bogas</p>';
      echo '
        <div id=desktop-profile-menu class="logger-btn" style="cursor: pointer; margin-right: .5rem;">
          <span class="username">' . $user['username'] . '</span>
          <img class="pfp" src="' . $user['pfp'] . '">
        </div>
        <div id="profile-menu-container">
          <div id="profile-menu">
            <a class="profile-menu-link" href="php/profile.php">Profile</a>
            <a class="profile-menu-link" href="php/create-character.php">Character maker</a>
            <a class="profile-menu-link" href="php/scripts/logout.php">Logout</a>
          </div>
        </div>';
    } else {
      echo '<a class="logger-btn" href="php/login.php" style="color:#f2c488;">Login</a><p id="author">Ágas és Bogas</p>';
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