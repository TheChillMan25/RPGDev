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
  <title>Fajok | Mesterséges fajok</title>
  <link rel="icon" href="../img/icon.png" />
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="../css/fajok-leirasok.css" />
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
              echo '<a class="navbar-link" href="profile.php">' . $user['username'] . '</a>
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
    <div class="faj-container">
      <div class="faj-img-container">
        <img class="faj-img" src="../img/novenyszerzet.png" alt="Növényszerzetek" />
      </div>
      <div class="faj-txt">
        <p class="nep-nev">Növényszerzetek</p>
        <hr />
        <p class="leiras">
          A természet előbb utóbb mindent visszafogad magába. de mit tesz ez a
          mindent elpusztító, mindent alkotó anyatermészet azokkal a mágikus
          tárgyakkal aminek a pengéjén nem fog a rozsda, aminek a fája nem
          korhad és nem nő. Ezek az elszórt lélekdarabok az évek során magukba
          szívták a birtokosuk személyiségét; minden megtett utat, minden
          féltve őrzött emléket, minden örömöt és kínt. Nem, nem fulladhatnak
          a földbe mint egy holmi parasztszerszám. Más sors vár rájuk, hiszen
          a természet mindent visszafogad magába. Átitatja a növényeket, a
          mohákat, a gyökerek, levelek, és gallyakat amik átölelik ezeket az
          elfeledett eszközöket. Napok, hónapok vagy évek de új élet születik
          kérges karral és sövény hajjal. Növényszerzet születik.
        </p>
      </div>
    </div>
    <div class="faj-container">
      <div class="faj-img-container">
        <img class="faj-img" src="../img/automa.jpg" alt="Rügysze" />
      </div>
      <div class="faj-txt">
        <p class="nep-nev">Rügysze</p>
        <hr />
        <p class="leiras">
          A rügysze, vagy más nevükön rügyesek a növényszerzetek leggyakoribb
          alfaja. Azokon a mezőkön és napsütötte erdőkben születnek amik már
          szinte teljesen elfelejtették a régi háborúk vérontását és az utazók
          lábnyomait. A környezetüktől függően hasonlíthatnak hatalmas
          virágokra vagy kis lomb födte bokrokra, szépségük miatt sokszor
          tévesztik össze őket álruhás tündérekkel. Gyermeki kíváncsisággal
          fürkészik a világot és imádják más lények társaságát. Mesterei a
          rejtőzködésnek és akár napokig követik észrevétlenül a náluk
          megforduló utazókat. A fellelhető leírásokban néha virágszirmokból
          szétágazó koronával, máskor sziromruhában írják le őket egy különös
          tárggyal a mellkasuk közepén vagy egyéb testrészükön.
        </p>
      </div>
    </div>
    <div class="faj-container">
      <div class="faj-img-container">
        <img class="faj-img" src="../img/abominus.png" alt="Kérgelábak" />
      </div>
      <div class="faj-txt">
        <p class="nep-nev">Kérgelábak</p>
        <hr />
        <p class="leiras">
          A kéreglábak, más neveiken röcsögők vagy egyszerűen kérgesek bár
          ritkábbak mint rokonaik, még is ők rendelkeznek a legtöbb hírnévvel
          és gyerekmesék gyakori szereplői. Néha évtizedekbe is telhet amire
          egy kérgeláb megszületik, cserébe képesek akár több száz, talán több
          ezer évig is élni. A legnagyobb dokumentált kérgeláb Öreg Csök, egy
          több mint száz méteres tölgyfa akinek az ereklyéjét senki sem
          láthatta, de a szóbeszéd szerint egy áradás előtti nagy hatalmú
          mágusé lehetett. Nyugodt és megfontolt lények, nem szeretik a
          hirtelen változásokat és legtöbbször egész életüket ugyanabban az
          erdőben élik le. A kérgük szívósabb bármelyik fánál így ha sikerül
          kiérdemelned egy kérgeláb dühét egy egyszerű fejsze nem fog
          megmenteni. A lombkoronájuk változik az évszakokkal és ha nem
          mozdulnak meg képesek teljesen beleolvadni mozdulatlan társaik közé.
        </p>
      </div>
    </div>
    <div class="faj-container">
      <div class="faj-img-container">
        <img class="faj-img" src="../img/abominus.png" alt="Kalaposok" />
      </div>
      <div class="faj-txt">
        <p class="nep-nev">Kalaposok</p>
        <hr />
        <p class="leiras">
          A mocsarak, öreg erdők és barlangok mélyén, a Nap égető tekintetétől
          védve burjánzanak a gombák csalogató méregzöld pompájukban. A
          kalaposok ezeknek a gombáknak a rokonai, egy ősi életforma és ősi
          hatalom egyesülésének termékei. A nevüket a fejükön lévő gomba
          kalapról kapták amiknek a belsejében a spórák helyett a lemezek
          csábító feromonokat, méregfelhőt, foszforeszkáló kristályszemcséket
          termelnek, bármit ami segít nekik a túlélésben. A kalaposak nem
          látják olyan gyerekszemmel a világot mint a rügyesek és nem
          fontolják meg minden lépésüket mint a kérgesek. Nem szeretik az
          emberek társaságát és ha tehetik messziről elkerülik őket. A puha,
          legtöbbször hófehér húsuk képes órák alatt teljesen visszanőni. A
          ritka hihető beszámolók a kalaposokról azt állítják hogy bár
          másokkal nem szívesen közösködnek, imádják fajtársaik társaságát és
          akár önzetlenek is tudnak lenni ha a közösségük túlélését elősegíti.
          Szeretik a praktikus ruhákat amiket elfeledett csataterekről és
          gyár-erődök környékről gyűjtenek össze.
        </p>
      </div>
    </div>
  </div>
  <script src="../js/menus.js"></script>
</body>

</html>