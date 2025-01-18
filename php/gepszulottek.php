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
        <img class="faj-img" src="../img/folyokoz.jpg" alt="Automa" />
      </div>
      <div class="faj-txt">
        <p class="nep-nev">Automa</p>
        <hr />
        <p class="leiras">
          A fogaskerekek életedben először nekifeszülnek egymásnak és fény
          gyúl a hideg fém vázban ami az új tested, a mellkasodban érzed ahogy
          az egymáshoz drótozott rúnák ezrei feldolgozzák a világot
          körülötted. Látsz szemek nélkül, érzed a hideg levegőt ahogy átfúj
          minden kis résen és repedésen. Egyedül ébredtél egy rég elhagyatott
          műhely utolsó, félkész darabjaként? Vagy talán az első pillanatodtól
          kezdve az új, vértelen családod mutatta számodra az utat?
          Gépszülöttként, vagy ahogy az Alkotó nevezett titeket, Automaként a
          legújabb jövevények vagytok a világban. Egy évszázadig titkolt,
          beteljesületlen mestermű másolata. Egy életért küzdő lélek talált
          benned új, erősebb formára, vagy talán egy teljesen új lélek
          született benned? Csak azt tudod biztosan amit a vázadba véstek,
          ahogy egy ember az állati ösztöneit. A halandók megvetnek és
          csodálnak téged. A te dolgod hogy a nézeteikben megerősítsed vagy
          megcáfold őket és helyet követelj az egyre gyorsabban növekvő
          népednek.
        </p>
      </div>
    </div>
    <div class="faj-container">
      <div class="faj-img-container">
        <img class="faj-img" src="../img/magafol.png" alt="Automa model 1 - Fenntartók" />
      </div>
      <div class="faj-txt">
        <p class="nep-nev">Automa model 1 - Fenntartók</p>
        <hr />
        <p class="leiras">
          Az első generáció; fenntartók, tanítók és az új gépszülöttek
          megalkotói. Az Alkotótól fennmaradt leírások és tervrajzok
          segítségével nemcsak képesek megjavítani és gyarapítani a népüket,
          hanem új, tovább fejlesztett modellekkel állnak szembe a
          természettel ami megtagadja őket. Primitív, improvizált tartozékok
          alkotják a vázukat amik az évtizedek alatt egymáshoz forrtak. A Nagy
          Műhely fenntartói egy az Alkotó által megérintett tárgyat hordanak a
          vázuk belsejében. Az újabb generációk az alkotóik és mentorjaik
          egy-egy darabját őrzik maguknál a hódolat jeléül.
        </p>
      </div>
    </div>
    <div class="faj-container">
      <div class="faj-img-container">
        <img class="faj-img" src="../img/holtag.png" alt="Automa model 2.0 - Utódok" />
      </div>
      <div class="faj-txt">
        <p class="nep-nev">Automa model 2.0 - Utódok</p>
        <hr />
        <p class="leiras">
          Az utódok kinézetre olyan tökéletesen hasonlítanak az emberre, hogy
          képesek a városokban is észrevétlenül elvegyülni, szerszámok és
          durva nyersanyagok helyett a Nagy Műhely legújabb alkatrészei, több
          tucat fogaskerék és drótkötél irányítja a mozdulataidat.
        </p>
      </div>
    </div>
    <div class="faj-container">
      <div class="faj-img-container">
        <img class="faj-img" src="../img/holtag.png" alt="Automa custodi 0.5 - Örzők" />
      </div>
      <div class="faj-txt">
        <p class="nep-nev">Automa custodi 0.5 - Örzők</p>
        <hr />
        <p class="leiras">
          A fejlődés a természetünk része, viszont nem mindig önkéntes. A
          világ kegyetlensége kegyetlen megoldásokat hoz magával. Az Automa
          Custodi a legújabb modell ami az összes alap funkciót csak mint
          szükségesség tudja teljesíteni, a gyengébb motor funkciókért cserébe
          a custodi megtestesíti a hús és vér félelmet ami a megalkotásukhoz
          vezetett. Egy gyilkológép aminek nem kell se alvás se evés, akin nem
          fog se fegyver se mágikus penge. Egy custodi képes hordákat
          elpusztítani és ha minden egye fogaskerék is eltörik benne újra
          építik őket napok alatt.
        </p>
      </div>
    </div>
  </div>
  <script src="../js/menus.js"></script>
</body>

</html>