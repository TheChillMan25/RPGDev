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
  <title>Fajok | Gépszülöttek</title>
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
              <a class="profile-menu-link" href="create.php">Character maker</a>
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
        <img class="faj-img" src="../img/assets/nations/abominus.png" alt="Abominus" />
      </div>
      <div class="faj-txt">
        <p class="nep-nev">Abominus</p>
        <hr />
        <p class="leiras">
          Az emberi test csodálatos. Az abominus nem egy félrement kísérlet
          vagy sötét mágia szüleménye miatt létrejött faj, ha lehet egyáltalán
          fajnak nevezni őket. Nem, ők egy egyszerű piaci űr betöltése miatt
          születtek a világunkra amit a háborúk, éhínség és gyári balesetek
          keltettek, egy űr aminek a betöltése hús és vért igényelt. Az
          abominus alkotói a még parázsló csatatereket és feketébe borult
          kórházakat járják és emberi alkatrészeket gyűjtenek az
          alkotásaikhoz. Csontot forrasztanak, húst fonnak és bőrt szabnak.
          Egyes alkotásaik olyan jól sikerülnek hogy fel se tűnne először hogy
          több tucat ember részeiből épülnek fel, ha nem lennének ott a
          mágiával összeforrasztott varratok. Persze a lélek megépítése egy
          külön problémát dobott fel, hiszen a emberi testrészekben
          megmaradtak a gazdájuknak valamely darabja. Az első „sikeres”
          kísérletek instabilak voltak, lélekdarabok harcoltak az irányításért
          egy testben ami nem az övék volt, nem teljesen. Viszont a tudomány
          és a mágia fejlődésével rájöttek hogy ezeket a megmaradt energiákat
          ahelyett hogy elnyomnánk fel is használhatjuk hogy egy új lelket
          alkossunk a régiek személyiségjegyeivel. Egyes történetek szerint a
          húsműhely most egy isteni lény megalkotásával próbálkozik, amivel a
          fellázadt abominusokat irányítani tudnák, még nem lehet sokat tudni
          erről a kísérletről azon kívül hogy a neve Rebis. Abominusként érzed
          minden végtagodat mintha a sajátod lenne, alszol, eszel, érzel, és
          még is undorral néznek rád az emberek, halál utáni lényként.
          Istentelen vagy, több közöd van az Automákhoz mint az emberekhez.
          Háborúra vagy munkára alkottak de egy hibát nem tudtak kijavítani az
          alkotóid, a szabad akaratod. A jobb esetben minőségi „alkatrészeid”
          miatt gyorsabb és erősebb vagy mint sok halandó, de csak ha sikerül
          megtanulnod az új tested irányítását.
        </p>
      </div>
    </div>
    <div class="faj-container">
      <div class="faj-img-container">
        <img class="faj-img" src="../img/assets/nations/vampir.png" alt="Vámpírok" />
      </div>
      <div class="faj-txt">
        <p class="nep-nev">Vámpírok</p>
        <hr />
        <p class="leiras">
          érszívók, dögevők, ragadozók. Az ember embernek vámpírja. Ezeket a
          lényeket nem is lehet igazán külön fajnak mondani, helyesebb egy
          átoknak nevezni őket, a lélek betegségének a testre terjedése. Az
          éhínség ami feneketlenül tombol bennünk, a vágyaink amiket próbálunk
          bármi áron kielégíteni. Az első vámpírok irónikusan a nemesek közül
          kerültek ki, egy megrontott mágus átka vagy a fajunk természetes
          következő lépése, az elszenvedőinek nem volt esélye kideríteni a
          kórság igazi okát. Tudósok azzal magyarázzák a vámpirizmust hogy egy
          hiba miatt az érintettek szervezete nem tudja már feldolgozni a sima
          táplálékokban található mágiát, emiatt a lelkük éhezik még ha a
          testük nem is. A vér viszont, a vérben lévő mágia nyers és
          energiával dús, nem hiába sok kísérlet és szertartás központi eleme.
          Az állatok vére sem rossz, de csak a megvonás tüneteit tudod vele
          távol tartani. Ha kielégíted az étvágyad és embervért iszol;
          erősebbnek, gyorsabbnak és okosabbnak fogod érezni magad mint
          valaha. A tátongó üresség a lelked mélyén egy pillanatra megtelik
          forró, vörös mámorral majd az érzés elszáll egy még nagyobb űrt maga
          után hagyva. Ha újra és újra kielégíted a szomjad a tested elkezd
          egyre inkább az új életmódodhoz alkalmazkodni, erősebb, nagyobb
          agyarak, meghosszabbodott karmos kezek és elnyúlt, halk léptű lábak.
          Persze ezeket egy ideig tökéletesen bírod titkolni a többi ember
          elől, hiszen milyen ragadozó az ami felfedi magát a prédái előtt? A
          szemeid tökéletesen látnak a teljes sötétségben is, de a lámpásnál
          nagyobb fényforrások megvakítanak. Ha az átok elég mélyre marja
          magát a testedben, bekövetkezik az átváltozás. Levedled az emberi
          álcádat és teljesen átadod magad az éhségnek, éjjelente portyázod a
          falvakat és városokat, a penge hosszúságú karmaiddal védtelen
          embereket gyilkolsz és begyűjtöd a kincseiket.
        </p>
      </div>
    </div>
    <div class="faj-container">
      <div class="faj-img-container">
        <img class="faj-img" src="../img/assets/nations/eloholt.png" alt="Vámpírok" />
      </div>
      <div class="faj-txt">
        <p class="nep-nev">Élőholtak</p>
        <hr />
        <p class="leiras"></p>
      </div>
    </div>
    <div class="faj-container">
      <div class="faj-img-container">
        <img class="faj-img" src="../img/assets/nations/teriantrop.png" alt="Vámpírok" />
      </div>
      <div class="faj-txt">
        <p class="nep-nev">Teriantrópok</p>
        <hr />
        <p class="leiras">
        </p>
      </div>
    </div>
  </div>
  <script src="../js/menus.js"></script>
</body>

</html>