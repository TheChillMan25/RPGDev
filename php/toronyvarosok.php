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
  <title>Fajok | Toronyvárosok</title>
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
        <img class="faj-img" src="../img/assets/nations/karaenn.png" alt="Den Karadenn" />
      </div>
      <div class="faj-txt">
        <p class="nep-nev">Den Karadenn</p>
        <hr />
        <p class="leiras">
          A Nyugat vasökle, az északi hegységekben található kifogyhatatlan
          fém és szén lelőhelyek az ipar igazi felhőkbe tornyosodó óriásává
          tette ezt az amúgy kis népet. A földterület szűkösségét terraformáló
          gépekkel, a kevés harcra képes kezet pedig sokszorosan
          kiegyensúlyozzák a pusztító fegyvereikkel. Egyes források szerint az
          automa faj megalkotója is karadenni származású volt. Kinézetre
          soványak, akár alul tápláltnak is tűnhetnek és a hamu szürke bőrük
          beolvad a városaik szerkezeteibe és kőfalaiba. Rövid, egyenes haj és
          kevés testszőrzet jellemzi őket, az izomzatuk kétszer olyan sűrű
          mint bármelyik másik fajnak ami a könnyű szerkezetükkel párosítva
          emiatt tökéletes mászókká teszi őket. A kultúrájuk több forradalom
          után elszakadt az ősi szokásoktól melyeknek csak a lenyomatai
          maradtak meg a mindennapjaik árnyékában. Ilyen a címerükön látható
          óriás szétnyitott, köröm nélküli keze, az ujjakon a karadenni
          pillérek jeleivel. A ruhákat és épületeket geometriai formákkal és
          ismétlődő mintákkal díszítik. Ahogy minden fogaskeréknek meg van a
          maga feladata, úgy a mintáknak is. Minden ismétlés, minden szimbólum
          és minta egy komplex egyenlet kis része amiben nincs helye az
          egyszerű szépségnek.
        </p>
      </div>
    </div>
    <div class="faj-container">
      <div class="faj-img-container">
        <img class="faj-img" src="../img/assets/nations/chameren.png" alt="Cha'Me'Rén" />
      </div>
      <div class="faj-txt">
        <p class="nep-nev">Cha'Me'Rén</p>
        <hr />
        <p class="leiras">
          Manapság átkozás és szitokszó ha valakit kamérnak neveznek, hiszen a
          népük egyet jelent a kétszínűséggel és megbízhatatlansággal.
          Alakváltók, arccserélők hírében vannak bármerre is járjanak. Ezek a
          vádak persze nem alaptalanok, hiszen képesek megváltoztatni az egész
          kinézetüket a testalaktól a legkisebb anyajegyig. Az erősebb mágiájú
          kamérok képesek akár más állatok alakját is felvenni.
          Csecsemőkoruktól kezdve az arcuk folytonos akár pillanatról
          pillanatra történő drasztikus változásokon megy át ami a serdülőkor
          végéig tart. Ezt az „arcuk megtalálásának” nevezik. Mivel az
          alakváltásuk érzelmi alapú, emiatt nagyban függ a mentális
          állapotuktól hogy milyen könnyen tudják befolyásolni a kinézetüket.
          Ha az arc amit viselnek nem egyezik a belső személyiségükkel csak
          lényeges erőfeszítések mellett tudják fenntartani azt. Mivel a
          kinézetük folyamatosan változik ezért a ruháikon és a maszkjaikon
          keresztül fejezik ki magukat. A ruháik a különböző kasztoktól
          függően lehetnek teljesen monokróm és mintátlan köpönyegek vagy
          szinte már cirkuszinak tűnően díszített és túlzottak. A maszkok
          viszont mindig megegyeznek változataikban. A szürke mae’sk ahonnan a
          maszk kifejezés is eredt, egy mágiával átitatott, képlékeny anyag.
          Tapintásra egyszerre szilárd és mégis mintha bármelyik pillanatban
          átfolyna az ujjaid között. A maszkon lévő arc kifejezése változik a
          viselője érzéseivel. A maszkokat úgy tervezik hogy lehetetlen legyen
          befolyásolni őket, hiszen a viselőjének a lelkével vannak
          összekötve.
        </p>
      </div>
    </div>
    <div class="faj-container">
      <div class="faj-img-container">
        <img class="faj-img" src="../img/assets/nations/altiora.png" alt="Doma Altiora" />
      </div>
      <div class="faj-txt">
        <p class="nep-nev">Doma Altiora</p>
        <hr />
        <p class="leiras">
          Nyugat szépeinek is nevezik őket a karcsú alkatuk és színtelen,
          szinte átlátszó hajuk miatt ami visszaveri a nap sugarait. Az
          öltözékeik egy központi fehér köpönyegből állnak aminek a szövetébe
          különböző hullámokra hasonlító minták vannak szőve a státuszuktól
          függően. A főmágusok és urak köpenyei ezüst Holdhullámos (más néven
          Holthullámos) vagy arany Naphullámos díszvarratai beragyogják az
          utcákat ahogy visszatükröződnek az üvegekről és tükrökről.
          Napsütötte bőrüket színes tetoválások borítják és ünnepek idején
          virágok százait tűzik magukra. A fő vallásukat két ágra lehet
          bontani, a Napkelti és Holdkelti ágra. Bár ez a különbség okozott
          konfliktusokat az évek alatt a két vallási ág harmóniában él egymás
          mellett. A Napkeltiek, a virágok, az újjászületés és ébredés
          ünneplői a száraz évszakban, majd a nedves évszak bekövetkeztével a
          korhadó, kiszárított virágokat a Holdkeltiek veszik át az elmúlás és
          pihenés nevében. Tudják a világ szükséges kettősségét és helyet
          engednek megnyilvánulásainak. A személyiségük erősen tükrözi ezt a
          kettőséget, hiszen befogadnak mindenkit aki menedéket kér náluk
          viszont cserébe megkövetelik a szokásaik és törvényeik tiszteletben
          tartását. Bármit csinálnak azt a végletekig csinálják, ha ünnepelnek
          akkor úgy ünnepelnek mintha nem lenne holnap, ha gyászolnak akkor
          még az óceánt is csendre parancsolják.
        </p>
      </div>
    </div>
  </div>
  <script src="../js/menus.js"></script>
</body>

</html>