<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = "localhost";
$user = "root";
$password = "";
$dbname = "RPG_DB";

$conn = new mysqli($host, $user, $password);
if ($conn->connect_error) {
  echo "An error occurred.\n";
  die("Error in connection: " . $conn->error);
} else {
  echo "Connected to the database.\n";
}

if ($conn->query("USE RPG_DB"))
  echo "Using RPG_DB\n";


//--CREATE TABLES--//

if (
  $conn->query("CREATE TABLE Items(
  id INT(4) AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(30),
  description VARCHAR (255)
  );"
  )
)
  echo "Created Items table\n";
else
  echo "Table Items creation failed " . $conn->error;

if (
  $conn->query("CREATE TABLE Weapons(
    id INT(4) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30),
    dice VARCHAR(10),
    description VARCHAR (255),
    properties VARCHAR (100)
    );"
  )
)
  echo "Created Weapons table\n";
else
  echo "Table Weapons creation failed " . $conn->error;

if (
  $conn->query("CREATE TABLE Armour(
      id INT(4) AUTO_INCREMENT PRIMARY KEY,
      name VARCHAR(30),
      value INT(3),
      description VARCHAR (255),
      dex_mod INT(1));"
  )
)
  echo "Created Armour table\n";
else
  echo "Table Armour creation failed " . $conn->error;

if (
  $conn->query("CREATE TABLE Paths(
      id INT(1) AUTO_INCREMENT PRIMARY KEY,
      group_id INT(1) not null,
      name VARCHAR(30),
      description VARCHAR (255));"
  )
)
  echo "Created Paths table\n";
else
  echo "Table Paths creation failed " . $conn->error;

if (
  $conn->query("CREATE TABLE PathGroups(
id INT(1) AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(30),
description VARCHAR (255));"
  )
)
  echo "Created PathGroups table\n";
else
  echo "Table PathGroups creation failed " . $conn->error;

if (
  $conn->query("CREATE TABLE Nations(
      id INT(4) AUTO_INCREMENT PRIMARY KEY,
      name VARCHAR(30),
      description VARCHAR (255));"
  )
)
  echo "Created Nations table\n";
else
  echo "Table Nations creation failed " . $conn->error;


if (
  $conn->query("CREATE TABLE Skills(
          id INT(4) AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        description VARCHAR(100)
        );"
  )
)
  echo "Created Skills table\n";
else
  echo "Table Skills creation failed " . $conn->error;

if (
  $conn->query("CREATE TABLE Characters(
    id INT(10) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(10) NOT NULL,
    name VARCHAR(30),
    nation_id INT(4),
    path_id INT(4),
    path_level INT(4),
    stats_id INT(4),
    skills_id INT(4),
    equipment_id INT(4),
    inventory_id INT(4)
    );"
  )
)
  echo "Created Character table\n";
else
  echo "Table Character creation failed " . $conn->error;

if (
  $conn->query("CREATE TABLE Inventory(
      id INT(4) AUTO_INCREMENT PRIMARY KEY,
      character_id INT(4) NOT NULL,
      item_1_id INT(4),
      item_2_id INT(4),
      item_3_id INT(4),
      item_4_id INT(4),
      item_5_id INT(4),
      item_6_id INT(4),
      item_7_id INT(4),
      item_8_id INT(4),
      item_9_id INT(4),
      item_10_id INT(4),
      FOREIGN KEY (character_id) REFERENCES Characters(id) ON DELETE CASCADE ON UPDATE CASCADE
      );"
  )
)
  echo "Created Inventory table\n";
else
  echo "Table Inventory creation failed " . $conn->error;

if (
  $conn->query("CREATE TABLE Equipment(
        id INT(4) AUTO_INCREMENT PRIMARY KEY,
      character_id INT(4) NOT NULL,
      left_hand INT(4),
      right_hand INT(4),
      armour INT(4),
      FOREIGN KEY (character_id) REFERENCES Characters(id) ON DELETE CASCADE ON UPDATE CASCADE
      );"
  )
)
  echo "Created Equipment table\n";
else
  echo "Table Equipment creation failed " . $conn->error;

if (
  $conn->query("CREATE TABLE CharacterSkills(
          id INT(4) AUTO_INCREMENT PRIMARY KEY,
        character_id INT(4) NOT NULL,
        skill_1_lvl INT(4),
        skill_2_lvl INT(4),
        skill_3_lvl INT(4),
        skill_4_lvl INT(4),
        skill_5_lvl INT(4),
        skill_6_lvl INT(4),
        skill_7_lvl INT(4),
        skill_8_lvl INT(4),
        skill_9_lvl INT(4),
        skill_10_lvl INT(4),
        FOREIGN KEY (character_id) REFERENCES `Characters`(id) ON DELETE CASCADE ON UPDATE CASCADE
        );"
  )
)
  echo "Created CharacterSkills table\n";
else
  echo "Table CharacterSkills creation failed " . $conn->error;


if (
  $conn->query("CREATE TABLE `Stats`(
        id INT(4) AUTO_INCREMENT PRIMARY KEY,
      character_id INT(4) NOT NULL,
      health INT(4),
      sanity INT(4),
      strength INT(4),
      dexterity INT(4),
      endurance INT(4),
      intelligence INT(4),
      charisma INT(4),
      willpower INT(4),
      FOREIGN KEY (character_id) REFERENCES Characters(id) ON DELETE CASCADE ON UPDATE CASCADE
      );"
  )
)
  echo "Created Stats table\n";
else
  echo "Table Stats creation failed " . $conn->error;

if (
  $conn->query("INSERT INTO PathGroups (name) VALUES
('Erő útja'),
('Ügyesség útja'),
('Kitartás útja'),
('Ész útja'),
('Fortély útja'),
('Akaraterő útja');")
)
  echo "Inserted PathGroups table\n";
else
  echo "Table PathGroups insert failed " . $conn->error;

if (
  $conn->query("INSERT INTO Paths (name, group_id) VALUES
('Katona', 1),
('Zsoldos', 1),
('Munkás', 1),
('Kovács', 1),
('Bérgyilkos', 2),
('Tolvaj', 2),
('Kézműves', 2),
('Rúnavéső', 2),
('Vadász', 3),
('Örző', 3),
('Kereskedő', 3),
('Gyűjtögető', 3),
('Szakács', 4),
('Vegyész', 4),
('Orvos', 4),
('Feltaláló', 4),
('Zenész', 5),
('Színész', 5),
('Művész', 5),
('Bűvész', 5),
('Pap', 6),
('Inkvizítor', 6),
('Gyógyító', 6),
('Vezeklő', 6);")
)
  echo "Inserted Paths table\n";
else
  echo "Table Paths insert failed " . $conn->error;

if (
  $conn->query("INSERT INTO Nations (name) VALUES
  ('Folyóköz'),
  ('Magasföld'),
  ('Holtág'),
  ('Denn Karadenn'),
  ('Cha Me Rén'),
  ('Doma Altiora'),
  ('Édd'),
  ('Vadin'),
  ('Monor'),
  ('Rügysze'),
  ('Kérgeláb'),
  ('Kalapos'),
  ('Au-1. Feltaláló'),
  ('Au-2. Utód'),
  ('Au-Cust. Örző'),
  ('Abominus'),
  ('Vámpír');")
)
  echo "Inserted Nations table\n";
else
  echo "Table Nations insert failed " . $conn->error;

if (
  $conn->query("INSERT INTO Weapons (name, dice, properties) VALUES
    ('Tőr', '1d4', 'Concealable, Piercing, Throwable'),
    ('Ostor', '1d4', 'Reach, Concealable, Sweep'),
    ('Kard', '1d6', 'Piercing, Slashing'),
    ('Hosszúkard', '1d6', 'Bulky, Piercing, Slashing, Reach'),
    ('Rapír', '1d6', 'Piercing, Counter'),
    ('Szablya', '1d6', 'Slashing, Sweep'),
    ('Fejsze', '1d6', 'Slashing, Throwable'),
    ('Csatabárd', '1d8', 'Bulky, Slashing, Brutal'),
    ('Buzogány', '1d6', 'Bludgeoning, Sweep'),
    ('Lándzsa', '1d6', 'Reach, Piercing, Throwable'),
    ('Acél öklök', '2d4', 'Bludgeoning, Counter'),
    ('Kalapács', '1d6', 'Bludgeoning, Throwable'),
    ('Pöröly', '1d8', 'Bulky, Bludgeoning'),
    ('Fokos', '1d6', 'Bludgeoning, Slashing, Reach'),
    ('Íj', '1d10', 'Reload, Bulky, Range 10'),
    ('Számszeríj', '1d10', 'Reload, Bulky, Range 10'),
    ('Pisztoly', '1d12', 'Reload, Concealable, Piercing, Range 5'),
    ('Karabély', '1d12', 'Reload, Bulky, Piercing, Range 15'),
    ('Kézi ágyú', '3d6', 'Reload, Bulky, Blast, Range 10'),
    ('Kézi balliszta', '1d20', 'Reload, Bulky, Brutal, Range 15');")
)
  echo "Inserted Nations table\n";
else
  echo "Table Nations insert failed " . $conn->error;

if (
  $conn->query("INSERT INTO Armour (name, value, dex_mod) VALUES
    ('Ruha', 1, 0),
    ('Könnyű páncél', 2, 0),
    ('Nehéz páncél', 3, -1),
    ('Sétáló erőd', 5, -2);")
)
  echo "Inserted Nations table\n";
else
  echo "Table Nations insert failed " . $conn->error;

/* if (
 $conn->query(
   "ALTER TABLE Users ADD status VARCHAR(5);"
 )
)
 echo "Altered Users table\n";
else
 echo "Table Users alter failed " . $conn->error;

if (
 $conn->query(
   "UPDATE Users SET status='user' WHERE status IS NULL;"
 )
)
 echo "Updated Users table\n";
else
 echo "Table Users update failed " . $conn->error;  */

if (
  $conn->query("INSERT INTO Items (name, description) VALUES 
('Selyem', 'Egy selyem szövetdarab'),
('Nyíl', 'Egyetlen nyíl, obszidián heggyel'),
('Bronz szobor', 'Egy bronz szobor egy griffről'),
('Zafírokkal teli láda', 'Egy erős láda tele zafírokkal'),
('Rothadó hús', 'Egy rothadó vadkan húsdarab'),
('Üvegedény szentelt vízzel', 'Egy nagy üvegedény szentelt vízzel'),
('Törött kard', 'Egy törött acél kard'),
('Tiszta ruhakészlet', 'Egy szépen összehajtott, tiszta ruhakészlet'),
('Arany gyűrű', 'Egy arany gyűrű rubinnal'),
('Hamis okmány', 'Egy hamisított okmány'),
('Kék köpeny', 'Egy szakadt kék köpeny'),
('Kenyér és sajt', 'Egy darab kenyér és sajt, ruhába csomagolva'),
('Jáde', 'Egy marék jáde'),
('Sörös hordó', 'Egy kis fából készült hordó tele sörrel'),
('Bőr kötésű könyv', 'Egy kis bőr kötésű könyv'),
('Rejtett üzenetes pergamen', 'Egy üres pergamen, rejtett üzenettel'),
('Kő edény hamuval', 'Egy nagy kő edény hamuval'),
('Kerámia korong', 'Egy kerámia korong, melynek felületére egyetlen rúna van karcolva'),
('Selyem zsák dohánnyal', 'Egy kis selyem zsák dohánnyal'),
('Bőrzsák levendulával', 'Egy bőrzsák szárított levendulával'),
('Ezüst érme', 'Egy ezüst érme, rajta Nap szimbólummal'),
('Zöld üvegszem', 'Egy zöld üvegszem'),
('Megégett fahasáb', 'Egy megégett fa hasáb'),
('Kalandor naplója', 'Egy kalandor bőr kötésű naplója'),
('Üveg bor', 'Egy üveg bor'),
('Piros ing', 'Egy piros ing'),
('Fa evőeszközkészlet', 'Egy fa evőeszközkészlet'),
('Vékony vas pálca', 'Egy vékony vas pálca'),
('Pergamen nevekkel', 'Egy pergamen egy listával, amely neveket tartalmaz'),
('Fehér kréta', 'Egy marék fehér kréta'),
('Réz kulcs', 'Egy réz kulcs'),
('Kerámiadarabos bőrzsák', 'Egy bőrzsák, tele éles kerámiadarabokkal'),
('Rajzolt térkép', 'Egy durván megrajzolt térkép a környékről'),
('Kötélköteg', 'Egy kusza köteg kötél'),
('Nagy darab szén', 'Egy nagy darab szén'),
('Mézes flaska', 'Egy üveges flaskában méz'),
('Megszentelt szimbólum', 'Egy megszentelt szimbólum egy ismeretlen istenhez'),
('Réz festmény', 'Egy torzított réz festmény egy sárkányról'),
('Vámpírvér', 'Egy üvegviolában vámpír vér'),
('Horgos zsineg', 'Egy vékony zsineg horgokkal'),
('Kék gyertya', 'Egy kék gyertya'),
('Réz szemüveg', 'Egy mocskos réz szemüveg'),
('Acél zár', 'Egy acél zár'),
('Dobókocka', 'Egy piros húszoldalú dobókocka'),
('Bőr hátizsák', 'Egy barna bőr hátizsák'),
('Fekete kardöv', 'Egy fekete bőr kardöv'),
('Játékkártyák', 'Egy készlet játékkártya'),
('Összegyűrt pergamen', 'Egy összegyűrt pergamen, amelyen egy centi nagyságú négyzetek találhatók'),
('Farkasos csempe', 'Egy kerámia csempe egy farkas ábrázolásával'),
('Hatujjú kesztyű', 'Egy ezüst kesztyű/harci kesztyű, hat ujjal'),
('Kő maszk', 'Egy kő maszk'),
('Bányászkalapács', 'Egy acél bányászkalapács és lapát'),
('Halott patkányok', 'Egy zsák halott patkányokkal'),
('Márvány napóra', 'Egy márvány napóra'),
('Ismeretlen varázslat', 'Egy papírdarab egy ismeretlen varázslatról'),
('Farkasbőr öv', 'Egy öv egy farkas bőréből'),
('Fogakkal teli tartály', 'Egy réz tartály, amely emberi fogakat tart'),
('Réz fa', 'Egy bőrzsák egy réz fával'),
('Csontcsomó', 'Egy kis csontokból készült csomó'),
('Rozsdás bilincs', 'Egy rozsdás bilincs készlet'),
('Fa olajtartó', 'Egy fa olajtartó'),
('Tigrisfog', 'Egy tigris fog'),
('Elefántcsont kockák', 'Egy készlet elefántcsont játékkockából'),
('Zárnyitó készlet', 'Egy zárnyitó készlet'),
('Nagy drágakő', 'Egy nagy ragyogó drágakő'),
('Réz tolómérce', 'Egy pár réz tolómérce'),
('Fa furulya', 'Egy fa furulya'),
('Kő mozsár', 'Egy kő mozsár és törő'),
('Zöld sav', 'Egy üvegviolában zöld sav'),
('Sárga homok', 'Egy marék durva, sárga homok'),
('Viasz tartály', 'Egy viasz tartály'),
('Ezüst szemüvegkeret', 'Egy pár ezüst szemüvegkeret'),
('Lánc', 'Egy darab lánc'),
('Görbe kés', 'Egy görbe réz kés vérrel borítva'),
('Elefántcsont sakkbábu', 'Egyetlen elefántcsont sakkbábú'),
('Lezárt kerámia edény', 'Egy kerámia edény, viaszal lezárva'),
('Lila üvegszilánk', 'Egy nagy darab lila üvegszilánk'),
('Kék tinta', 'Egy kristályos üvegvialában kék tinta'),
('Arany harang', 'Egy arany harang'),
('Ezüst tükör', 'Egy ezüst tükör'),
('Sárkánypörkölt recept', 'Egy recept sárkány pörköltről'),
('Főnix toll', 'Egyetlen piros főnix toll'),
('Kőtábla', 'Egy kis kőtábla, amely pusztító tüzet ábrázol'),
('Zöld varázskocka', 'Egy tizenkét oldalas zöld kocka, amelyen varázslatos szimbólumok vannak'),
('Lenvászon kötés', 'Egy lenvászon kötés'),
('Szikladarab', 'Egy szikladarab'),
('Élező kő', 'Egy kopott élező kő'),
('Homokóra', 'Egy kis homokórácska, tele fekete homokkal'),
('Szürke köpeny', 'Egy szürke kapucnis köpeny'),
('Vasszöges bőrzsák', 'Egy bőrzsák, tele apró vas szögekkel'),
('Ellenméreg', 'Egy üveg ellenméreg'),
('Fahéj tartály', 'Egy fa tartály, tele fahéjjal'),
('Ezüst tű', 'Egy hosszú, vékony ezüst tű'),
('Arany gyűrű', 'Egy díszítetlen arany gyűrű'),
('Acél dróthuzal', 'Egy vékony acél dróthuzal'),
('Régi jegyzet', 'Egy régi, megsárgult és olvashatatlan jegyzet'),
('Fa pipa', 'Egy fából készült pipa'),
('Platina edény', 'Egy platina edény, tele arany rudakkal'),
('Lila festék', 'Egy üvegviolában lila festék'),
('Réz távcső', 'Egy törött réz távcső');
")
)
  echo "Inserted Items table\n";
else
  echo "Table Item insert failed\n" . $conn->error;

if (
  $conn->query("INSERT INTO Skills (name, description) VALUES
    ('Észrevétel', 'A karakter gyorsan észreveszi a rejtett csapdákat vagy elrejtett kincseket'),
    ('Fegyverhasználat', 'Magasan képzett egy adott típusú fegyver használatában, például kardok, íjak vagy varázslópálcák'),
    ('Gyógyítás', 'Képes gyógynövényekből és egyéb anyagokból gyógyító bájitalokat készíteni'),
    ('Navigáció', 'Kitűnő tájékozódási képességgel rendelkezik, és könnyen megtalálja az utat az ismeretlen terepen'),
    ('Alkímia', 'Tudományos ismeretekkel rendelkezik a különféle anyagok kombinálásáról, hogy varázslatos főzeteket hozzon létre'),
    ('Tolvajlás', 'Szakértő a zárak feltörésében és az értékes tárgyak lopásában anélkül, hogy észrevennék'),
    ('Tárgyismeret', 'Képes azonosítani a varázstárgyak tulajdonságait és azok használatát'),
    ('Diplomácia', 'Kiváló kommunikációs képességekkel rendelkezik, és képes más karaktereket meggyőzni vagy tárgyalni velük'),
    ('Álcázás', 'Könnyedén képes elrejtőzni vagy más karaktereket megtéveszteni'),
    ('Varázslatok ismerete', 'Kiterjedt ismeretekkel rendelkezik különféle varázslatokról, amelyekkel támadni, védekezni vagy gyógyítani lehet');")
)
  echo "Inserted Skills table\n";
else
  echo "Table Skills insert failed " . $conn->error;

$conn->close();
?>