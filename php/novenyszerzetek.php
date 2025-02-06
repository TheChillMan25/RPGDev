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
  <link rel="icon" href="../img/assets/icons/icon.png" />
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="../css/fajok-leirasok.css" />
  <script src="https://kit.fontawesome.com/62786e1e62.js" crossorigin="anonymous"></script>
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
    <div class="faj-container">
      <div class="faj-img-container">
        <img class="faj-img" src="../img/assets/nations/novenyszerzet.png" alt="Növényszerzetek" />
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