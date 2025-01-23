<?php
include 'scripts/manager.php';
session_start();
if (checkLogin()) {
  $conn = connectToDB();
  $user = getUserData($conn, $_SESSION['username']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ágas és Bogas | Szerepek</title>
  <link rel="icon" href="../img/icon.png" />
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="../css/szerepek.css" />
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
    <div id="szerep-lista-m">
      <div id="szerep-lista">
        <i class="fa-solid fa-caret-right fa-2xl" style="color: #ffffff"></i>
        <div id="lista-toggle"></div>
      </div>
    </div>
    <div id="link-container">
      <ul id="class-list">
        <li class="klan">
          <a href="#" id="vadaszok-klanja" class="cim click"><span>Vadászok klánja</span></a>
          <hr />
          <ul class="subclasses">
            <li class="class">
              <a href="#" id="fajzatolok" class="click">Fajzatölők</a>
            </li>
            <li class="class">
              <a href="#" id="boszorkanyvadaszok" class="click">Megvetett boszorkányvadászok</a>
            </li>
            <li class="class">
              <a href="#" id="homokjarok" class="click">Homokjárók</a>
            </li>
          </ul>
          <br />
          <a href="#" id="rendek" class="cim click"><span>Rendek</span></a>
          <hr />
          <ul class="subclasses">
            <li class="class">
              <a href="#" id="korus" class="click">A kórus</a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
    <div id="leiras-container">
      <div id="klanok-leiras" class="leiras" style="display: flex">
        <h2>Klánok és Rendek</h2>
        <p>
          Az áradás megtörte az emberek által évezredek alatt felállított
          világrendet és a felszínre mosta az emberi létezés alap reakcióit.
          Sokan próbálták megérteni az áradás okát, könyvtárakba és műhelyekbe
          gyűjtötték a fennmaradt tudást, remélve hogy a káoszba meglátják az
          ősi rendet. Mások ellen álltak a világ sodrásának, vakul tagadták a
          mágikus lények jelenlétét, majd amikor azt már lehetetlen volt
          figyelmen kívül hagyni, az emberségüket. Viszont az idő elteltével
          olyanok is megjelentek akik szépséget láttak az új világban,
          reményt, varázslatot. Az embereknek kellett valami ami összetartja
          őket, valami ami célt ad a létezésüknek. Klánok alakultak ki a világ
          minden pontján. Ezek a szövetségek összetételük és struktúrájukat
          tekintve annyira változatosak mint a népek maguk. Lehet hogy két
          vadász klánba tartozó emberben csak a klánba tartozásuk a közös de
          az egyiküknek pedig erős kötelékük van a mágusok klánjának egyik
          tagjával. Bár igaz hogy sok klán rendelkezik hierarchiával,
          központtal és vezetőkkel inkább az egyes emberek világnézetét
          testesítik meg.
        </p>
      </div>
      <div id="vadaszok-klanja-leiras" class="leiras">
        <h2>Vadászok klánja</h2>
        <p>
          A vadászok klánja talán az egyetlen ok ami miatt az emberi fajt nem
          irtották ki teljesen. Először még nem volt a szörnyek és állatok,
          sőt egyes emberfajok irtására specializálódott klánokra szükség, de
          ahogy fejlődtek egyre okosabbak és halálosabbak lettek az addig
          békésnek és ártalmatlannak számító lények. Ami a töréspontot
          jelentette, hogy megjelentek lények amik az ember természetes
          ragadozóinak próbálták kikiáltani magukat. Ekkor, szinte egyidejűleg
          szerveződtek össze a környező közösségekből a gyilkolás mesterei,
          akik képesek elmenni az emberi morálok határáig azért hogy elvegyék
          a célpontjuk, a prédájuk utolsó lélegzetét.
        </p>
      </div>
      <div id="fajzatolok-leiras" class="leiras">
        <h2>Fajzatölők</h2>
        <p>
          Ahhoz hogy megértsük mit is csinál egy fajzatölő, meg kell érteni
          mit nevezünk fajzatnak. Fajzatok azok az egykoron értelmes lények
          akik átkok, mágia vagy egyéb befolyás hatására elvesztették az
          emberségüket. Keleten például megjelenésük óta irtják a busókat, az
          ördögfajzatokat. Amikor megölik a legelső busójuk a kiüresedett
          szőrméjükből köpönyeget csinálnak és a lény famaszkjának egy
          darabját a ruhájukra varrják. Minden fajzatölőről meg lehet mondani
          hogy mi a kedvelt célpontja hiszen sokszor a legjobb fegyver ezek
          ellen a lények ellen ők maguk.
        </p>
        <h3>A vadászatok dicsősége</h3>
        <p>
          A fajzatölők büszkék a munkájukra és a feladatukra úgy tekintenek
          mint az ember és az emberség fennmaradásáért való harcra. A
          páncélzatuk díszes fémlemezekből, vésett láncokból és fonott
          szőrmékből is állhat. A zsákmányuk trófeáit ráakasztják a
          felszereléseikre ezzel megemlékezve a legyőzött ellenfélre. Egy jó
          fajzatölőnek a szakterületét a külsőjéről meg lehet állapítani. Hogy
          mit vadászik és hányat ölt meg belőle, hogy honnan származik a
          fajzat és hogy mekkora. Szeretik az egyszerűbb de a tökéletességig
          élezett fegyvereket amik képesek a vastag bőrön és az acélnál is
          keményebb csonton is átrágni. A fegyvereiknek illeszkednie kell a
          prédájukhoz emiatt sok fegyvernemet elsajátítanak. Viszont soha nem
          szabad elfeledni, aki fajzatokat vadászik az is épp oly könnyen
          fajzattá válhat.
        </p>
      </div>
      <div id="boszorkanyvadaszok-leiras" class="leiras">
        <h2>Megvetett boszorkányvadászok</h2>
        <p>
          Az első mágusokról szóló feljegyzések mind alsó osztálybéli nőket
          mutatnak be akik valamilyen tragédia vagy trauma nyomán új
          képességekre tettek szert. Ezek a nők csupán kisebb gyógyításra vagy
          esőfelhők elfújására voltak képesek. Az áradás és az azzal
          felszabaduló mágiával viszont a mágusok egy új generációja jött
          létre amit a boszorkányvadászatok feléledése követett, hiszen akik
          hatalmat kaptak egy ilyen katasztrófából azok biztosan elősegítették
          a bekövetkezését. A pusztulást követő első évszázad a mágusok
          vérével lett kifestve, mindenki akiben jelen volt a teremtés
          szikrája halált érdemelt egy bűnért amihez nem volt semmi közük. A
          boszorkányvadászok a nevükkel ellentétben nem csak mágusnőket és nem
          vakon mészárolnak mindenkit aki képes puszta kézzel szikrát
          csiholni. Mágusokra szükség van a világban, viszont amikor egy mágus
          túl messzire megy vagy fajzattá válik mindenki a vadászokhoz fordul.
          A mágia egyetemi gyakorlásának kezdetével a klánt felszámolták és
          azok központjait lerombolták, tagjaikat kivégezték, az üldözőből
          üldözött lett. Manapság a többi vadászklánhoz képest kevesen vannak,
          és a megmaradt vadászok közül is sokan elvonultak a világtól. A
          tanításaikat elégették vagy elrejtették, egyet kivéve. Az hogy
          egyáltalán fennmaradtak az egyedül az óvintézkedéseknek köszönhető
          amiket pont az ilyen esetek elkerülése ellen vezettek be. A többi
          klánnak nem kellett aggódniuk hogy a prédájuk felkeresi őket, hogy
          beolvad közéjük és megöli őket álmukban vagy elátkozza a
          családjukat. Igen, az összes dokumentumban megtalálható klánbirtokot
          és bázist porig romboltak, de ugyan mennyi bázisuk van amit nem
          ismer könyv és nem látnak még a mágiától átitatott szemek sem?
        </p>
        <h3>Észrevétlen és ésszerű</h3>
        <p>
          Az első vadászok nehéz páncélt és több réteg láncinget viseltek,
          aztán miután a saját páncéljuk összeroppantotta őket mint egy prés
          rájöttek hogy a mágia ellen az egyszerű páncélzat hatástalan. A
          feloszlatásuk óta ritka hogy bárki is egyenruhát használjon,
          helyette a ruha egyes részeit átalakították és a saját vadászati
          stílusukhoz igazították. Az alap egyenruha fekete és szigorúan
          mintátlan, a minták a mágia eltorzító erejének szimbólumai. A köpeny
          alatt láncinget vagy bőr páncélt hordanak. A klán pecsétje minden
          fegyverükön és ruhadarabjukon megtalálható.
        </p>
        <h3>A boszorkányvadász doktrína</h3>
        <p>
          A klán fő dokumentuma. E szerint élj és ha kell érte halj. A lapok
          tartalmazzák a különböző eljárásokat és recepteket amelyre szükség
          van egy vadászathoz. Ezek a könyvek mesterről tanítványra szállnak,
          minden generációval kiegészítve és kijavítva. Válaszd ki az első
          törvényt és egy receptet. Minden alkalommal amikor megszegsz egy
          törvényt kapsz törvényenként 1 mentális sebet. Minden 5. szinten
          válassz 2 új szabályt és 1 új receptet.
        </p>
        <ol>
          <li class="doktrina">
            Kötelességed a rontó mágusok felkeresése és megölése.
          </li>
          <li class="doktrina">
            Először mindig az átlag embert védd a mágussal szemben ha még nem
            is ártó.
          </li>
          <li class="doktrina">
            Nem léphetsz szerelmi vagy baráti kötelékbe mágussal csak
            ideiglenes szövetséget köthetsz velük.
          </li>
          <li class="doktrina">
            Ha egy aktív átokkal találkozol kötelességed feloldozni azt
            bármibe is kerüljön.
          </li>
          <li class="doktrina">
            Kötelességed segíteni mágusvadász társaidnak.
          </li>
          <li class="doktrina">
            Az elátkozott állatokat el kell pusztítani.
          </li>
          <li class="doktrina">
            Aki egy ártó mágust segít ugyanolyan bűnös mint a mágus maga és
            ugyanúgy kell kezelni.
          </li>
          <li class="doktrina">
            A boszorkányok tárgyait és főzeteit el kell pusztítani az
            élőhelyükkel együtt.
          </li>
          <li class="doktrina">A Mágia bármely nyomát ki kell vizsgálni.</li>
          <li class="doktrina">
            A megtorlás joga. Ha egy mágus egy embert bármilyen módon árt
            jogod van a helyében eljárni.
          </li>
          <li class="doktrina">
            Ha bárki segítséget kér tőled egy mágus megölésére segítened kell.
          </li>
          <li class="doktrina">
            Ha valaki jogtalanul megöl egy nem ártó mágust azt meg kell
            büntetned.
          </li>
          <li class="doktrina">
            Tanulmányozd és használd fel az ellenfeled mágiáját ellene.
          </li>
          <li class="doktrina">
            Ha egy ártó mágusnak utódja van, ha nem érte el a 24. holdat (12.
            esztendőt) akkor add át a közösségének, egy segítő mágusnak vagy
            vedd a szárnyaid alá. Más esetben ártó mágusként kell kezelned és
            büntetned.
          </li>
          <li class="doktrina">
            Ha nem tudsz végezni a mágussal el kell zárnod hogy senkinek ne
            árthasson.
          </li>
          <li class="doktrina">
            Ha megölsz vagy megsértesz jogtalanul egy segítő mágust szabadulj
            meg az egyik felszerelésedtől és a fegyvereidtől fizetségként.
          </li>
          <li class="doktrina">
            Ha hallod a hívást csatlakoznod kell a vadászathoz.
          </li>
          <li class="doktrina">
            Soha nem adhatod ki a klánunk titkait, legyen az recept, tárgy
            vagy búvóhely.
          </li>
          <li class="doktrina">
            A fajzatok nem a mi feladatunk kivéve ha az mágus vagy mágus által
            előhívott.
          </li>
          <li class="doktrina">
            Ha egy mágus vagy azoknak a gyülekezete veszélyezteti egy
            területnek a népét kötelességed vadászatot hirdetni.
          </li>
        </ol>
      </div>
      <div id="homokjarok-leiras" class="leiras">
        <h2>Homokjárók</h2>
        <p>
          Az üvegsivatag sok rémséget ismer magának, viszont a kristályerdők
          délibábjai meg sem közelítik a föld alatti alagútrendszerekből
          összeálló városokat amiket az árnylakók építenek. Ezek a bogárszer
          lények az éjszaka leple alatt feljárnak a fennmaradt falvakba
          fosztogatni és mészárolni, homokcsapdákat építenek amikbe ha
          belezuhansz imádkozz hogy még az esésben meghalsz. A homokjárók
          gólyalábakon, hosszú faékeken állva vándorolnak a sivatagban és ha
          belefutnak egy ilyen fészekbe a közeli klántagokkal nekiállnak az
          irtásnak. Elzárják a be és kijáratokat és vadásztól függő
          módszerekkel kifüstölik őket. Vannak akik mágikus füstöt használnak
          ami duplázza magát minden pillanatban de a napfényt érve elfoszlik.
          Volt példa arra hogy egy egész folyót átirányítottak hogy
          belefolyassák az eddig legnagyobb fészekbe amit valaha találtak. A
          homokjárók vadászai a dögök kitinpáncéljából csinálnak maguknak
          páncélzatot és felszerelést.
        </p>
        <h3>Az új élet kiirtói</h3>
        <p>
          Az új élet kifejezést először a növényszerzetekre használták mint az
          első mesterséges faj.
        </p>
      </div>
      <div id="rendek-leiras" class="leiras">
        <h2>Rendek</h2>
        <p>
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugit
          repellendus necessitatibus, maxime alias commodi enim nemo veniam
          quaerat at sint vel cupiditate dolorem reiciendis natus dolorum hic
          iusto non velit. Quos enim in, unde ratione suscipit beatae, magni
          repellendus omnis atque eaque debitis rerum. Nulla placeat harum
          quos recusandae, eveniet est saepe, esse non expedita quas quia
          quibusdam labore officiis. Est minus, dolores architecto, modi
          deserunt dignissimos provident libero animi eius deleniti fuga rem,
          debitis unde dolor tempora nemo maiores iste et tenetur repudiandae
          neque sed ratione ullam. Voluptate, reiciendis! Adipisci quibusdam
          maiores sunt sapiente repellat quaerat quasi cum modi officiis
          culpa, ex est ut natus incidunt. Distinctio expedita dolorem,
          deleniti iure dolore ut modi quaerat est quae perferendis eligendi.
          Saepe eaque beatae dignissimos doloribus alias quaerat laborum, cum
          praesentium laboriosam numquam et consequuntur assumenda ex
          voluptate? Totam dolores ipsa at ratione consequuntur dolor ad
          expedita voluptates nulla. Commodi, placeat? Illum, libero impedit?
          Blanditiis, laboriosam eum? Animi sint, veniam laudantium soluta
          corporis obcaecati magni rem dolorem impedit dolores asperiores
          vero. Magnam expedita tempore perferendis quod ipsa deserunt quidem
          molestiae quas. Natus minus praesentium laborum, expedita, officiis
          fugit fuga enim maiores ea omnis quibusdam. Est vitae voluptatum
          atque fugiat culpa fugit suscipit aut eius consequatur architecto
          reiciendis, dolorem in assumenda sit.
        </p>
      </div>
      <div id="korus-leiras" class="leiras">
        <h2>A kórus</h2>
        <p>
          Nevezték őket már szektának, egyháznak, iskolának vagy egyszerű
          színháznak, de valahogy egy név sem tudja magába foglalni igazán az
          igazi jelentésük. A kórus tagjai hisznek abban hogy a közös hang, a
          lelkek együttes rezonálása képes akár az áradást is visszatartani.
          Ennek a közösségnek a tagjai egyenként lehet nem jelentenek akkora
          veszélyt mint közösen, hiba alábecsülni a magányos hang hatalmát a
          sötétben, és az új lángokat amiket feléleszt. Nincs hatalom, legyen
          az úri vagy isteni ami elnémíthatja a kórust. A templomaikat átjárja
          az örök dallam, maguk a kövek velük énekelik a századokat. Nem
          tudjuk honnan ered a hatalmuk, se azt hogy mire lennének képesek ha
          összegyűlnének egy cél érdekében. Azt viszont tudjuk hogy erőt
          adnak, reményt, tüzet. A Láthatatlan Lángoknak is nevezték őket
          egykoron, hiszen volt rá példa hogy a tanításaikkal ellentétben
          háborúba mentek. A csatában ahol részt vettek véres volt, annyira
          véres hogy a föld maga mocsaras lett a vértől. Az első kűrt szótól
          az utolsó torokvágásig szólt a hangjuk a vértől részeg katonák
          között, amikor a seregük vesztésre állt csak még erősebben és még
          erősebben szólt a hangjuk. Aztán eljött az utolsó hajnal. Három nap
          és három éjszaka vájódott a hús a csontról, és még is a beszámolók
          arról írnak hogy a kórust segítő lovagok újra erőre kaptak. Még a
          haldoklók és a sérültek is üvöltve feltámaszkodtak és újra és újra a
          frontvonalra vonultak. Az egyik katonának levágták az egész bal
          karját az utolsó nap reggelén és csak este találták meg ahogy sétált
          vissza a táborba, az arca sápadt mintha az összes vér kifojt volna
          belőle, de még akkor is dúdolgatott. Mielőtt elvesztette volna az
          eszméletét megkérdezték hogy lehetséges ez. Azt mondta hogy követte
          a hangot. Megkérdezték milyen hangot? Az énekhangot.
        </p>
      </div>
    </div>
  </div>
  <script src="../js/menus.js"></script>
  <script src="../js/klanok.js"></script>
</body>

</html>