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
  <title>Fajok | Kelet Népe</title>
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
        <img class="faj-img" src="../img/folyokoz.jpg" alt="Éddek" />
      </div>
      <div class="faj-txt">
        <p class="nep-nev">Éddek</p>
        <hr />
        <p class="leiras">
          A kelet kezei; művészek, nyomolvasók, munkásemberek. A többi klánhoz
          képest szelídnek lehet mondani őket. Az otthonaik helyét a lehető
          legnagyobb titokban tartják, néha még a klánon belül sem tudnak
          egymás hollétéről. Persze a jelek amiket hagynak egymásnak, jelek
          amik a többi nép számára szinte láthatatlanok, segítséget nyújtanak
          ha vész idején szállást keresnek. A klán központjáról semmit sem
          tudunk azon kívül hogy léteznie kell, hiszen több említés is
          szerepel édd feljegyzésekben egy helyről „ahol összefonják a
          történeteket”. Természetükből adódóan konfliktuskerülők és inkább
          szeretnek megfigyelni és ha elkerülhetetlen, gyorsan és embertelen
          precizitással megoldani az említett konfliktusokat. Az átlagfeletti
          érzékeik miatt mintha egy másik világban élnének, látják a színek
          közötti színeket, a néma hangokat, egy tapintással képesek többet
          elmondani valamiről mint egy tudós a laboratóriumban. A ruhájuk
          kívülről beleolvad a környezetbe, sokszor növényeket és mohákat
          szőnek a hosszú köpenyeikre. A külső funkcionalitással ellentétben a
          ruháik belseje inkább hasonlít egy hedonista nemes festmény
          galériájára. Ékszerekkel, gyöngyökkel rakják ki, különböző
          fonásmintákkal díszítik és olyan festékeket használnak amiket még az
          altioriaknál sem fogsz találni. A köpenyek belsejében fonott kötelek
          tucatjai vannak amiket üzenéshez és szállításhoz használnak, lehet
          hogy egy kis erszényt akasztanak rá vagy egy gyöngy levelet
          (különböző ismétlésű gyöngyök és csomókból alkotott üzenet). Ez az
          amúgy is magának való nép az áradással még inkább elszigetelte magát
          a többi néptől, emiatt sokkal drasztikusabb változásokon mentek
          keresztül. Vadászathoz nem használnak kutyákat mert az érzékeik
          bármelyik állatnál erősebbek. Elképesztő magasságuk és sovány
          felépítésük miatt természetesen görnyedtek, a karjaik szinte olyan
          hosszúak mint a nyúl szerű lábaik, négykézlábon még a medvéket is
          lefutják. A nagy szemeikben pedig a fény folyamatos színekben
          játszik a szembogaruk körül. A füleik kicsit hegyesek és tudják
          mozgatni is őket, viszont a hangos zajokra érzékenyek. A bőrük
          enyhén kékes és az egyenes hajuk sokszor befonják, de csak ha
          párkapcsolatban vannak.
          <br />
          Túl erős zajok fájnak neki
        </p>
      </div>
    </div>
    <div class="faj-container">
      <div class="faj-img-container">
        <img class="faj-img" src="../img/magafol.png" alt="Vadinok" />
      </div>
      <div class="faj-txt">
        <p class="nep-nev">Vadinok</p>
        <hr />
        <p class="leiras">
          A sokszor vadaknak csúfolt vadinok okkal érdemelték ki ezt a nevet.
          Vadászok, néha a legemberibb ragadozónak is nevezik őket. Egy
          történet szerint egy vadin puszta kézzel lemészárolt egy busó
          démont, a földre szorította és letépte a maszkját, csak azért mert
          tetszett neki a prémje. Vadásznak és fosztogatnak, a száraz
          évszakban amikor az északi kúszó erdők leérnek a hegyek aljáig úgy
          ők is lejönnek a hegyekből és „learatják” a többi klán földjét. Az
          eszközeiket és a házaikhoz az alapanyagot a kúszóerdők vörös, tüskés
          fáiból növesztik formára majd kézzel cipelik magukkal.
          Legfelismerhetőbb része a páncéljuknak a sisakjuk. A hegyek oldalába
          vésett erőd műhelyeikben a nedves évszak alatt előre legyártják a
          majd a fosztogatáshoz szükséges fegyvereket és páncélokat. A sisak
          az egész fejet takarja és állati vagy fajzat fejre hasonlít, attól
          függően hogy mi volt az első sikeres vadászatának a trófeája.
          Majdnem olyan szélesek mint magasak, sokszor meghaladják a két
          métert. A fejüket sűrű, tüskés mén borítja a mellkasukig és erős,
          majdnem ragadozó szerű állkapcsuk van.
        </p>
      </div>
    </div>
    <div class="faj-container">
      <div class="faj-img-container">
        <img class="faj-img" src="../img/holtag.png" alt="Monorok" />
      </div>
      <div class="faj-txt">
        <p class="nep-nev">Monorok</p>
        <hr />
        <p class="leiras">
          Az iparosodás és a világpusztulás náluk kéz a kézben járt. A
          területük a keleti lápok és sztyeppék fodrozásain terült el, így
          őket érte legelőször az áradás pusztulása. Ők alkották meg a gátat,
          mint egy ultimátumot a világ ellen hogy visszaszerezhessék a
          földjeiket. A nyugati gyárosokkal és iparosokkal szemben őket nem
          érdekli a szépség, az esztétika, vagy hogy mennyire ártanak a
          földnek a gépeikkel. Szerintük amíg amit csinálnak megállítja az
          áradást és a népük megél még egy ciklust, addig nincs olyan ár amit
          nem képesek megfizetni. Az iparurak egész hegyoldalakat kopasztanak
          le faanyagért vagy területért és mocsarakat szipolyoznak le. A
          monorok által alkotott gépezetek az azokat borító rúnavésésről
          ismerhetők fel legkönnyebben. A kultúrájuk fő pillérje, ez a
          mesterség a régi időkben a sírjaik és emlékhelyeik megóvására
          szólgáltak. Távol tartották a könyörtelen telet, a jeges esőt ami
          elverné a termést, olyan keménnyé tette a földet hogy a fosztogató
          ásója bele törjön. Ugyanez a mesterség pusztító erővel ruházza fel a
          gőzóriásaikat és a különféle fegyvereket. Ezek a rúnák a megváltásuk
          és a kárhozatuk kulcsa volt, egyben az ok ami miatt ennyire
          sztoikusak a világgal szemben. Az első áradáskor a mágiával
          átitatott víz túltöltötte a rúnákat és a fél keleti tájék színtelen
          lángokba borult. A keletkezett lökéshullám hetekig visszatartotta a
          vizet a földjeikről, viszont súlyos következményekkel járt. Az
          emberi szervezet nem képes feldolgozni évszázadok megszilárdult
          mágiájának a hirtelen felszabadulását. A monoroknál a lökéshullám
          annyira meggyengítette a megfogható és megfoghatatlan részük közötti
          kapcsolatot hogy a szó szoros értelmében kilökte a lelküket a
          testükből. Nem tartoznak a lidércek közé de nem is mondhatók halandó
          embernek. Képesek látni az anyagi és anyagtalan világot. A
          meggyengült kötelék miatt képesek rúnákba és tárgyakba, de akár
          élőlényekbe is helyezni a lelkük egy darabját. Mint egy végtagnak a
          helye, érzik hogy hol van, akár hogy mi van vele az elég nagy
          hatalmú monorok még mozgatni is tudják ezeket a tárgyakat messziről.
          Egy monor bérgyilkos a kardjába ültette a lelkének egy jelentős
          részét és képes volt harcolni anélkül hogy egyáltalán odanézett
          volna. Ennek a mágiának a hatására elkoptatják önmagukat ha nem
          vigyáznak. Lassan elvesztik a kinézetük egyéniségét és a
          személyiségüket, ezzel együtt pedig az olyan halandó érzelmeket mint
          empátia, szerelem, vagy utálat. A szemük és a hajuk felnőttkorukra
          kifakul majd hófehérré tisztul. A bőrük feltöredezik és vérvonaltól
          függően ezüst, arany, de akár smaragd vagy rubint színű hegek
          keletkeznek. A többi népnek a lelkük egy fekete árnyékként jelenik
          meg ami erekhez hasonló, cérna vékony szálakkal fonódik a testükhöz
          mint egy bábjátékos. A monorok gyorsan rájöttek hogy az emberi lélek
          okkal van húsba páncélozva. Bár az árnyékukat a fizikai fegyverek
          nem sérthetik meg, így akár azután is életben tudnak maradni hogy a
          testük súlyos sérüléseket szenvedett el, a mágikus természetű
          csapások könnyedén elszakítják a köteléket a testüktől amitől
          lidércekké válnak, vagy akár el is pusztulhat a lelkük. Az öregebb
          monoroknál a kapcsolat a testük és lelkük között annyira
          elvékonyodhat hogy mágikus bilincsekkel tartják össze magukat.
        </p>
      </div>
    </div>
  </div>
  <script src="../js/menus.js"></script>
</body>

</html>