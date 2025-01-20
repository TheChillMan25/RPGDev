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
  <title>Fajok | Folyóköz</title>
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
              echo '<a class="navbar-link" href="profile.php">Profile</a>
            <a class="navbar-link" href="create-character.php">Create your character</a>
            <a class="navbar-link" href="scripts/logout.php">Logout</a>
            <hr style="background-color: #f2c488; width: 70%; height: 0.5rem; border: none;">';

            } else {
              echo '<a class="navbar-link" href="login.php">Login</a><hr>';
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
        <img class="faj-img" src="../img/folyokoz.jpg" alt="Folyóköziek" />
      </div>
      <div class="faj-txt">
        <p class="nep-nev">Folyóköziek</p>
        <hr />
        <p class="leiras">
          A folyóköziek talán a legjobban fennmaradt emlékei annak hogy őseink
          hogyan néztek ki az áradás előtt. Elsőre egyszerű gazdák és
          kézműveseknek tűnhetnek de a kinézet ebben a világban sokszor
          megtévesztő. Az évszázadok megpróbáltatásai ellenére megvédték a
          földjeik a szörnyek és ellenséges népek behatolásaitól. Hadseregek
          törtek ketté a határváraik falán amit még a királyság darabokra
          esése se változtatott meg. A mellkasukban kettő szív dobog, a
          mondásuk szerint egy a családért és egy a hazájukért, de ennek a
          mondásnak egy sokkal konkrétabb háttere van, a két darab, tükrözött
          szív. Kinézetre mind magasságban mind erőben átlagosnak mondhatók. A
          viseletükben sokszor meghatározóak a fehér, fekete, piros és zöld
          színek. Alkalmazkodó nép lévén a világ összes útján meg lehet
          találni őket.
        </p>
      </div>
    </div>
    <div class="faj-container">
      <div class="faj-img-container">
        <img class="faj-img" src="../img/magafol.png" alt="Magasföldiek" />
      </div>
      <div class="faj-txt">
        <p class="nep-nev">Magasföldiek</p>
        <hr />
        <p class="leiras">
          A folyóköziek legközelebbi rokonai, a magasföldiek, mint ahogy a
          nevük is elárulja, a Folyóközt körülvevő hegységek őrzői, főleg az
          északi tájékon elterülő lépcsős felvidékeken jellemzőek. Kinézetre
          sokkal robusztusabbak és szőrösebbek mint alvidéki testvéreik. Sok
          férfi meghaladja a 3 méteres magasságot is. Lehet hogy soványabbak
          mint az alföldi testvéreik de a meghosszabbodott karjaikkal képesek
          elképesztő erőt kifejteni. Kiváló fafaragók és vadászok, egy
          történet szerint egy magasföldi lefejezett egy medvét a fejszéjével
          az erdő másik végéből egy fogadás miatt. Ennek ellenére nyugodt
          természetűek, kikezdhetetlen türelemmel rendelkeznek és szeretik a
          kalandoktól mentes, lassú folyású életük. Ha viszont valami
          megzavarja ezt a lassú folyást, ezrével zúdulnak le a hegyvidékekből
          baltával a kézben, egy-egy lépéssel több métereket megtéve. A
          hajszínük és szőrzetük alapból vöröses, de a színe enyhén változik
          az évszakokkal hogy jobban beolvadjanak a lombozatba. A ruházatuk
          főleg szőrmékből és kemény bőrvértekből áll, pár vadászon akár egész
          medveprémek vagy igazán ritka esetekben busóprémet is lehet látni és
          kizárólag fekete, vastag szövésű ingeket hordanak, soha nem fehéret.
        </p>
      </div>
    </div>
    <div class="faj-container">
      <div class="faj-img-container">
        <img class="faj-img" src="../img/holtag.png" alt="Holtágiak" />
      </div>
      <div class="faj-txt">
        <p class="nep-nev">Holtágiak</p>
        <hr />
        <p class="leiras">
          A fővárost körül ölelő tónak a déli elfolyásából lápok és mocsarak
          labirintusa született. Az itt élő népek gyorsan alkalmazkodtak a
          környezetükhöz ami nem várt változásokat hozott a kinézetükhöz. A
          három Folyóközben őshonos népből ők a legkülönlegesebb kinézetűek; a
          bőrük zöldes, a hajuk pedig fekete vagy sötétbarna és víz lepergető.
          Alapból maguknak való, idegenkerülő népség de a kíváncsiságuk
          sokszor még is kicsalogatja őket a lápok mélyéről. Nagyon erős
          lábaik vannak amikkel képesek nádszigetek vagy fák között is ugrálni
          és még a sűrű lápban is úszni. Bár kevés híres harcossal vagy
          kalandorral büszkélkedhetnek, a mágiához való természet adta
          tehetségük vitathatatlan. A lápokban található mérgező anyagok miatt
          a torkukban védőréteg alakult ki a savak ellen és a gyomruk képes a
          leghalálosabb mérgeket is feldolgozni, ezen kívül egy gyakorta
          kihasznált mellékhatása a részegség érzete fogyasztás után. A
          ruházatuk alsó rétegei hozzá simulnak a testükhöz, amíg a külső
          rétegeket fagyöngyökkel és más vízen úszó vagy üreges ékszerekkel
          díszítik.
        </p>
      </div>
    </div>
  </div>
  <script src="../js/menus.js"></script>
</body>

</html>