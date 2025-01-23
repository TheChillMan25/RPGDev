<?php
include 'scripts/manager.php';
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
  <title>Ágas és Bogas | Fajok</title>
  <link rel="icon" href="../img/icon.png" />
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="../css/faj-menu.css" />
  <script src="https://kit.fontawesome.com/62786e1e62.js" crossorigin="anonymous"></script>
</head>

<body>
  <div class="navbar">
    <div id="navbar-mobile">
      <a class="index-link" href="../index.php"><img src="../img/logo.png" alt="Index oldalra" /></a>
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
              echo '<a class="navbar-link" href="profile.php">Profile</a>
            <a class="navbar-link" href="create-character.php">Create your character</a>
            <a class="navbar-link" href="scripts/logout.php">Logout</a>
            <hr style="background-color: #f2c488; width: 70%; height: 0.5rem; border: none;">';

            } else {
              echo '<a class="navbar-link" href="login.php">Login</a><hr style="background-color: #f2c488; width: 70%; height: 0.5rem; border: none;">';
            }
            ?>
            <a class="navbar-link" href="fajok.php">Fajok</a>
            <a class="navbar-link" href="szerepek.php">Szerepek</a>
            <a class="navbar-link" href="terkep.php">Térkép</a>
          </div>
        </div>
      </div>
    </div>
    <div id="navbar-desktop">
      <a class="index-link" href="../index.php"><img src="../img/logo.png" alt="Index oldalra" /></a>
      <a class="navbar-link" href="fajok.php">Fajok</a>
      <a class="navbar-link" href="szerepek.php">Szerepek</a>
      <a class="navbar-link" href="terkep.php">Térkép</a>
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
            <a class="profile-menu-link" href="profile.php">Profile</a>
            <a class="profile-menu-link" href="create-character.php">Character maker</a>
            <a class="profile-menu-link" href="scripts/logout.php">Logout</a>
          </div>
        </div>';
    } else {
      echo '<a class="logger-btn" href="login.php">Login</a><p id="author">Ágas és Bogas</p>';
    }
    ?>
  </div>
  <div class="page">
    <div id="folyokoz" class="faj-container">
      <a href="folyokoz.php">
        <div class="faj-header">
          <img class="faj-img" src="../img/folyokoz_tmp.jpg" alt="Folyóköz" />
        </div>
        <div class="faj-footer">
          <span class="cim">Folyóköz</span>
          <!--<hr />-->
        </div>
      </a>
    </div>
    <div id="toronyvarosok" class="faj-container">
      <a href="toronyvarosok.php">
        <div class="faj-header">
          <img class="faj-img" src="../img/folyokoz_tmp.jpg" alt="Toronyvárosok" />
        </div>
        <div class="faj-footer">
          <span class="cim">Toronyvárosok</span>
          <!--<hr />-->
        </div>
      </a>
    </div>
    <div id="kelet_nepe" class="faj-container">
      <a href="kelet_nepe.php">
        <div class="faj-header">
          <img class="faj-img" src="../img/folyokoz_tmp.jpg" alt="Kelet Népe" />
        </div>
        <div class="faj-footer">
          <span class="cim">Kelet Népe</span>
          <!--<hr />-->
        </div>
      </a>
    </div>
    <div id="novenyszerzetek" class="faj-container">
      <a href="novenyszerzetek.php">
        <div class="faj-header">
          <img class="faj-img" src="../img/folyokoz_tmp.jpg" alt="Növényszerzetek fajok" />
        </div>
        <div class="faj-footer">
          <span class="cim">Növényszerzetek</span>
          <!--<hr />-->
        </div>
      </a>
    </div>
    <div id="gepszulottek" class="faj-container">
      <a href="gepszulottek.php">
        <div class="faj-header">
          <img class="faj-img" src="../img/folyokoz_tmp.jpg" alt="Gépszülöttek" />
        </div>
        <div class="faj-footer">
          <span class="cim">Gépszülöttek</span>
          <!--<hr />-->
        </div>
      </a>
    </div>
    <div id="atkozottak" class="faj-container">
      <a href="atkozottak.php">
        <div class="faj-header">
          <img class="faj-img" src="../img/folyokoz_tmp.jpg" alt="Átkozottak" />
        </div>
        <div class="faj-footer">
          <span class="cim">Átkozottak</span>
          <!--<hr />-->
        </div>
      </a>
    </div>
  </div>
  <script src="../js/menus.js"></script>
</body>

</html>