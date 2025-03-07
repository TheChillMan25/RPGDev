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
  <title>Ágas és Bogas | Térkép</title>
  <link rel="icon" href="../img/assets/icons/icon.png" />
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="../css/terkep.css" />
  <script src="https://kit.fontawesome.com/62786e1e62.js" crossorigin="anonymous"></script>
</head>
</head>

<body>
  <div class="navbar">
    <a class="index-link" href="../index.php"><img src="../img/assets/icons/logo.png" alt="Index oldalra" /></a>
    <div id="link-container">
      <a class="navbar-link" href="fajok.php">Fajok</a>
      <a class="navbar-link" href="szerepek.php">Szerepek</a>
      <a class="navbar-link" href="terkep.php">Térkép</a>
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
              <a class="profile-menu-link" href="profile.php">Profile</a>
              <a class="profile-menu-link" href="create-character.php">Character maker</a>
              <a class="profile-menu-link" href="scripts/logout.php">Logout</a>
            </div>
            <div id="m-link-container" class="profile-container">
              <hr class="nav-hr">
              <a class="profile-menu-link" href="fajok.php">Fajok</a>
              <a class="profile-menu-link" href="szerepek.php">Szerepek</a>
              <a class="profile-menu-link" href="terkep.php">Térkép</a>
            </div>
          </div>
        </div>';
    } else {
      echo '<a id="login" class="logger-btn" href="login.php" style="color:#f2c488;">Login</a>';
      echo '<button id="m-menu"
      style="color: whitesmoke; width:4rem; height:4rem; background-color:transparent; border: none; font-size: large"><i
        class="fa-solid fa-bars fa-2xl"></i></button>
        <div id="m-link-c" style="display: none; height: 100%; width:100%; position:absolute;
       top:0; right:0rem;  z-index: 10">
        <div id="m-link-m"
        style="position:absolute; top:4rem; right:0rem; width:13rem; padding: .5rem; flex-direction: column; background-color: #333; z-index: 12">
        <a class="profile-menu-link" href="login.php">Login</a>
        <hr class="nav-hr">
        <a class="profile-menu-link" href="fajok.php">Fajok</a>
        <a class="profile-menu-link" href="szerepek.php">Szerepek</a>
        <a class="profile-menu-link" href="terkep.php">Térkép</a>
        </div>
      </div>';
    }
    ?>
  </div>
  <div class="page">
    <div id="infoText">
      A térképen a területekre kattintva el tudod olvasni azok leírását.
    </div>
    <div id="imageContainer">
      <img src="../img/tmp/map_test.jpg" usemap="#pelda-map" id="test-map-img" alt="Példa Térkép" />
      <map name="pelda-map">
        <area target="" alt="Elso terulet" title="Elso terulet" data-target="infoDiv" href="#"
          coords="191,295,286,444,301,543,239,566,273,653,383,688,344,807,391,905,498,883,539,934,625,846,747,931,802,800,790,741,844,678,837,575,800,490,702,317,671,366,590,288,498,270,461,320,405,346,354,349,337,320,286,324,245,326"
          shape="poly" />
        <area target="" alt="Masodik terulet" title="Masodik terulet" data-target="infoDiv2" href="#"
          coords="844,479,892,277,968,207,1049,221,1078,158,1004,165,954,140,958,114,1083,107,1102,135,1163,109,1095,11,1049,29,990,16,942,45,902,85,785,18,717,45,585,48,549,92,552,181,630,183,723,231,773,242,732,317,767,402"
          shape="poly" />
        <area target="" alt="Harmadik terulet" title="Harmadik terulet" data-target="infoDiv3" href="#"
          coords="895,600,908,669,934,678,944,711,924,732,901,730,888,756,895,796,862,817,839,774,869,739,883,691,879,621"
          shape="poly" />
        <area target="" alt="Negyedik terulet" title="Negyedik terulet" data-target="infoDiv4" href=""
          coords="1010,248,1130,341,1297,244,1515,307,1561,344,1565,444,1614,507,1702,558,1690,873,1643,861,1621,773,1521,765,1539,856,1497,894,1443,765,1398,756,1302,831,1281,805,1307,749,1183,739,1205,660,1173,643,988,685,925,615,903,322"
          shape="poly" />
      </map>
    </div>

    <div id="info-container">
      <div class="info" id="infoDiv">
        <p class="cim">Elso terulet</p>
        <img src="../img/assets/regions/nuygatitorony.png" alt="Folyóköz" />
        <div class="text-container">
          <hr />
          <p class="leiras">
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nesciunt
            non nulla sapiente dolore. Qui veritatis quis voluptas? Eaque
            veritatis ipsa, reprehenderit consequatur assumenda rerum iusto
            laboriosam dolorum eveniet fugiat hic?
          </p>
        </div>
      </div>

      <div class="info" id="infoDiv2">
        <p class="cim">Masodik terulet</p>
        <img src="../img/assets/regions/folyokoz.jpg" alt="Folyóköz" />
        <div class="text-container">
          <hr />
          <p class="leiras">
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nesciunt
            non nulla sapiente dolore. Qui veritatis quis voluptas? Eaque
            veritatis ipsa, reprehenderit consequatur assumenda rerum iusto
            laboriosam dolorum eveniet fugiat hic?
          </p>
        </div>
      </div>

      <div class="info" id="infoDiv3">
        <p class="cim">Harmadik terulet</p>
        <img src="../img/assets/regions/nuygatitorony.png" alt="Folyóköz" />
        <div class="text-container">
          <hr />
          <p class="leiras">
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nesciunt
            non nulla sapiente dolore. Qui veritatis quis voluptas? Eaque
            veritatis ipsa, reprehenderit consequatur assumenda rerum iusto
            laboriosam dolorum eveniet fugiat hic?
          </p>
        </div>
      </div>

      <div class="info" id="infoDiv4">
        <p class="cim">Negyedik terulet</p>
        <img src="../img/assets/regions/folyokoz.jpg" alt="Folyóköz" />
        <div class="text-container">
          <hr />
          <p class="leiras">
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nesciunt
            non nulla sapiente dolore. Qui veritatis quis voluptas? Eaque
            veritatis ipsa, reprehenderit consequatur assumenda rerum iusto
            laboriosam dolorum eveniet fugiat hic?
          </p>
        </div>
      </div>
    </div>
  </div>
  <script src="../js/menus.js"></script>
  <script src="../js/terkep.js"></script>
</body>

</html>