<?php
include 'scripts/manager.php';
session_start();
if (checkLogin()) {
  $conn = connectToDB();

  $user = getUserData($conn, $_SESSION['username']);
  $nations = ['Folyóköz', 'Magasföld', 'Holtág', 'Denn Karadenn', 'Cha Me Rén', 'Doma Altiora', 'Édd', 'Vadin', 'Monor', 'Rügysze', 'Kérgeláb', 'Kalapos', 'Au-1. Fenntartó', 'AU-2 Utód', 'Au-Cust. Örző', 'Abominus', 'Vámpír'];
  $paths['Erő útja'] = ['Katona', 'Zsoldos', 'Dolgozó', 'Kovács'];
  $paths['Ügyesség útja'] = ['Bérgyilkos', 'Tolvaj', 'Kézműves', 'Rúnavéső'];
  $paths['Kitartás útja'] = ['Vadász', 'Őrző', 'Kereskedő', 'Gyűjtő'];
  $paths['Ész útja'] = ['Szakács', 'Vegyész', 'Orvos', 'Feltaláló'];
  $paths['Fortély útja'] = ['Zenész', 'Színész', 'Művész', 'Bűvész'];
  $paths['Akaraterő útja'] = ['Pap', 'Inkvizítor', 'Gyógyító', 'Vezeklő'];

  /* $nations = ["Riverland", "Highland", "Backwater", "Denn Karadenn", "Cha Me Rén", "Doma Altiora", "Édd", "Vadin", "Monor", "Budlander", "Barkfoot", "Hatman", "Au-1. Sustainer", "AU-2. Successor", "Au-Cust. Guardian", "Abominus", "Vampire"];
  $paths['Path of power'] = ['Soldier', 'Mercenary', 'Worker', 'Blacksmith'];
  $paths['The way of virtue'] = ['Assassin', 'Thief', 'Craftsman', 'Rune Cutter'];
  $paths['Path of perseverance'] = ['Hunter', 'Guardian', 'Mechant', 'Collector'];
  $paths['Way of the mind'] = ['Cook', 'Chemist', 'Doctor', 'Inventor'];
  $paths['Way of cunning'] = ['Musician', 'Actor', 'Artist', 'Magician'];
  $paths['Path of Willpower'] = ['Priest', 'Inquisitor', 'Healer', 'Penitent']; */
} else {
  header("Location: ../index.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="hu">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ágas és Bogas | Karakter készítő</title>
  <link rel="icon" href="../img/icon.png" />
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="../css/create-character.css" />
  <script src="https://kit.fontawesome.com/62786e1e62.js" crossorigin="anonymous"></script>
</head>

<body>
  <div class="navbar">
    <div id="navbar-mobile">
      <a class="index-link" href="../index.php"><img src="../img/logo.png" alt="Index oldalra" /></a>
      <p id="m-author">Ágas és Bogas</p>
      <div id="mobile-menu">
        <i class="fa-solid fa-bars fa-2xl" style="color: #fff"></i>
        <div id="mobile-menu-container">
          <div id="mobile-link-container">
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
    ?>
  </div>
  <div class="page">
    <form id="character-maker" action="create-character.php" method="post" enctype="multipart/form-data">
      <div id="header">
        <label for="name"><input type="text" name="name" id="name" placeholder="Karakter neve"></label>
        <label for="nation" style="gap: 1rem">
          Nemzet
          <?php
          createSelection("nation", 16, $nations);
          ?>
        </label>
        <!-- <label for="nation" style="gap: 1rem">
          Háttér
          <?php
          createSelection("background", 0);
          ?>
        </label> -->
      </div>
      <div id="body">
        <div id="stats">
          <div id="physical" class="stat-container">
            <label>Erő
              <?php
              createSelection("strength", 22);
              ?>
            </label>
            <label>Ügyesség
              <?php
              createSelection("dexterity", 22);
              max_value:
              ?>
            </label>
            <label>Kitartás
              <?php
              createSelection("endurance", 22);
              ?>
            </label>
          </div>
          <div id="inner" class="stat-container">
            <label>Ész
              <?php
              createSelection("intelligence", 22);
              ?>
            </label>
            <label>Fortély
              <?php
              createSelection("chrasima", 22);
              ?>
            </label>
            <label>Akaraterő
              <?php
              createSelection("willpower", 22);
              ?>
            </label>
          </div>
        </div>
        <div id="health-path-lvl">
          <label for="health">
            Életerő
            <?php
            createSelection("health", 12);
            ?>
          </label>
          <label for="path">
            Út
            <?php
            createOptgroupSelect("path", $paths);
            ?>
          </label>
          <label for="level">
            Szint
            <?php
            createSelection("level", 6);
            ?>
          </label>
        </div>
      </div>
      <div id="character-info">

      </div>
    </form>
  </div>
  <script src="../js/menus.js"></script>
</body>

</html>