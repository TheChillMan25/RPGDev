<?php
include 'scripts/manager.php';
session_start();

if (checkLogin()) {
  $conn = connectToDB();
  $user = getUserData($conn, $_SESSION['username']);
  $user_id = $user['id'];

  checkCharacterCount($conn, $user_id);

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    checkCharacterCount($conn, $user_id);

    $character_data = [];
    foreach ($_POST as $key => $value) {
      $character_data[$key] = $value;
    }

    $character_data['strength_mod'] = calculateModifier($character_data['strength']);
    $character_data['dexterity_mod'] = calculateModifier($character_data['dexterity']);
    $character_data['endurance_mod'] = calculateModifier($character_data['endurance']);
    $character_data['intelligence_mod'] = calculateModifier($character_data['intelligence']);
    $character_data['charisma_mod'] = calculateModifier($character_data['charisma']);
    $character_data['willpower_mod'] = calculateModifier($character_data['willpower']);

    if (!empty($character_data)) {
      // Oszlopnevek és értékek előkészítése az SQL lekérdezéshez
      $columns = array_keys($character_data);
      $values = array_values($character_data);

      // Oszlopnevek körülzárása backtick-ekkel
      $columns = array_map(function ($column) {
        return "`" . $column . "`";
      }, $columns);

      // Dinamikus SQL lekérdezés létrehozása
      $sql = "INSERT INTO CharacterData (user_id, " . implode(", ", $columns) . ") VALUES (?, " . str_repeat("?, ", count($values) - 1) . "?)";
      $stmt = $conn->prepare($sql);

      // Paraméterek csatolása
      $types = "i" . str_repeat("s", count($values));
      $stmt->bind_param($types, $user_id, ...$values);

      if ($stmt->execute() !== TRUE) {
        error("Error in data insertion.\n" . $stmt->error);
      } else {
        header("Location: profile.php");
        exit();
      }
      $conn->close();
    }
  }
} else {
  header("Location: login.php");
  exit();
}

function plusKnowledge($knowledge_count)
{
  $knowledge_count++;
}
?>
<!DOCTYPE html>
<html lang="hu">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ágas és Bogas | Karakter készítő</title>
  <link rel="icon" href="../img/icon.png" />
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="../css/create-character.css" />
  <script src="https://kit.fontawesome.com/62786e1e62.js" crossorigin="anonymous"></script>
</head>

<body>
  <div class="navbar">
    <div id="navbar-desktop">
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
        echo '<a class="logger-btn" href="login.php" style="color:#f2c488;">Login</a>';
      }
      ?>
    </div>
  </div>
  <div class="page">
    <div id="dr-container">
      <div id="dice-roller">
        <div id="dice-btn-c">
          <button id="d6" class="dice" data-value="6">d6</button>
          <button id="d10" class="dice" data-value="10">d10</button>
          <button id="d20" class="dice" data-value="20">d20</button>
          <button id="d100" class="dice" data-value="100">d100</button>
        </div>
        <label id="dr-label" for="double">Dupla<input type="checkbox" id="double" name="duble"></label>
        <div id="dcv-container">
          <span id="current-roll">X</span>
          <span id="rolls">X | X | X</span>
          <button id="empty-rolls"><i class="fa-solid fa-recycle fa-2xl"></i></button>
        </div>
      </div>
      <div id="drb-c"><button id="dice-roller-btn"><i class="fa-solid fa-dice fa-2xl"></i></button></div>
    </div>
    <form id="character-maker" action="create-character.php" method="post" enctype="multipart/form-data">
      <div id="header">
        <label for="name"><input type="text" name="name" id="name" placeholder="Karakter neve" required></label>
        <label for="nation" style="gap: 1rem">
          Nemzet
          <?php
          createSelection("nation", 16, $nations, "Válassz nemzetet", true);
          ?>
        </label>
        <!-- <label for="nation" style="gap: 1rem">
          Háttér
          <?php
          createSelection("background", 0);
          ?>
        </label> -->
      </div>
      <div id="body">
        <div id="stats">
          <div id="physical" class="stat-container">
            <label>Erő
              <?php
              createSelection("strength", 22);
              ?>
            </label>
            <label>Ügyesség
              <?php
              createSelection("dexterity", 22);
              max_value:
              ?>
            </label>
            <label>Kitartás
              <?php
              createSelection("endurance", 22);
              ?>
            </label>
          </div>
          <div id="inner" class="stat-container">
            <label>Ész
              <?php
              createSelection("intelligence", 22);
              ?>
            </label>
            <label>Fortély
              <?php
              createSelection("charisma", 22);
              ?>
            </label>
            <label>Akaraterő
              <?php
              createSelection("willpower", 22);
              ?>
            </label>
          </div>
        </div>
        <div id="health-sanity">
          <label for="health">
            Életerő
            <?php
            createSelection("health", 12);
            ?>
          </label>
          <label for="sanity">
            Elme
            <?php
            createSelection("sanity", 12);
            ?>
          </label>
        </div>
      </div>
      <div id="nation-path-container">
        <label for="path">
          Út
          <?php
          createOptgroupSelect("path", $paths, "Válassz utat", true);
          ?>
        </label>
        <label for="level">
          Szint
          <?php
          createSelection("level", 6);
          ?>
        </label>
      </div>
      <div id="character-info">
        <div id="knowledge" data-knowledge-count="<?php echo htmlspecialchars($knowledge_count); ?>" data-options="<?php
           foreach ($knowledge as $item) {
             echo htmlspecialchars('<option value="' . $item . '">' . $item . '</option>');
           }
           ?>" data-lvl-options="<?php
           for ($i = 0; $i <= 5; $i++) {
             echo htmlspecialchars('<option value="' . $i . '">' . $i . '</option>');
           }
           ?>">
          Imseretek
          <button id="add-knowledge">Ismeret hozzáadása</button>
        </div>
        <div id="inventory-container">
          <div id="hands">
            <label for="left_hand">
              Bal kéz
              <?php
              createSelection("left_hand", count($weapons) - 1, $weapons, "Válassz");
              ?>
            </label>
            <label for="right_hand">
              Jobb kéz
              <?php
              createSelection("right_hand", count($weapons) - 1, $weapons, "fegyvert");
              ?>
            </label>
          </div>
          <label for="armour">
            Páncél
            <?php createSelection("armour", count($armours) - 1, $armours, "Válassz páncélt"); ?>
          </label>
          <label id="inventory-txt">Inventory</label>
          <div id="inventory">
            <?php
            for ($i = 1; $i <= 10; $i++) {
              echo '
                <label class="inventory-slot" for="item-' . $i . '">
                  Tárgy ' . $i . '
                  <input type="text" name="item_' . $i . '" id="item-' . $i . '">
              ';
            }
            ?>
          </div>
        </div>
      </div>
      <button id="creabe-btn" type="submit">Karakter létrehozása</button>
    </form>
  </div>
  <script src="../js/menus.js"></script>
  <script src="../js/add-knowledge.js"></script>
  <script src="../js/dice-roller.js"></script>
</body>

</html>