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
    <a class="index-link" href="../index.php"><img src="../img/logo.png" alt="Index oldalra" /></a>
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