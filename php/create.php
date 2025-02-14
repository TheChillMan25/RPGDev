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

    if ($conn->query('INSERT INTO Characters (user_id) VALUES (' . $user['id'] . ')') !== true) {
      die('Passing user is failed! ' . $conn->error);
    } else {
      echo 'pass';
      $character_id = $conn->insert_id;
    }

    if (
      $conn->query('INSERT INTO `Stats` (character_id, 
    max_health, max_sanity, health, sanity, strength, dexterity, endurance, intelligence, 
    charisma, willpower) VALUES (' . $character_id . ',' . $_POST['health'] . ', ' . $_POST['sanity'] . ' , ' . $_POST['health'] . ', 
    ' . $_POST['sanity'] . ', ' . $_POST['strength'] . ', ' . $_POST['dexterity'] . ', 
    ' . $_POST['endurance'] . ', ' . $_POST['intelligence'] . ', ' . $_POST['charisma'] . ', 
    ' . $_POST['willpower'] . ')') !== true
    ) {
      die('Inserting stats failed ' . $conn->error);
    } else {
      echo 'pass';
      $stats_id = $conn->insert_id;
    }

    if (
      $conn->query('INSERT INTO CharacterSkills 
    (character_id, skill_1_lvl, skill_2_lvl, skill_3_lvl, skill_4_lvl, skill_5_lvl, 
    skill_6_lvl, skill_7_lvl, skill_8_lvl,skill_9_lvl,skill_10_lvl)
    VALUES (' . $character_id . ',' . $_POST['skill_1'] . ', ' . $_POST['skill_2'] . ', ' . $_POST['skill_3'] . ', ' . $_POST['skill_4'] . ', 
    ' . $_POST['skill_5'] . ' , ' . $_POST['skill_6'] . ', ' . $_POST['skill_7'] . ', ' . $_POST['skill_8'] . ', 
    ' . $_POST['skill_9'] . ', ' . $_POST['skill_10'] . ')') !== true
    ) {
      die('Inserting skills failed ' . $conn->error);
    } else {
      echo 'pass';
      $skills_id = $conn->insert_id;
    }

    if (
      $conn->query('INSERT INTO Equipment 
    (character_id, left_hand, right_hand, armour)
    VALUES (' . $character_id . ',' . $_POST['left_hand'] . ', ' . $_POST['right_hand'] . ', ' . $_POST['armour'] . ')') !== true
    ) {
      die('Inserting Equipment failed ' . $conn->error);
    } else {
      echo 'pass';
      $equipment_id = $conn->insert_id;
    }

    if (
      $conn->query('INSERT INTO Inventory 
    (character_id, item_1_id, item_2_id, item_3_id, item_4_id, item_5_id, 
    item_6_id, item_7_id, item_8_id,item_9_id,item_10_id)
    VALUES (' . $character_id . ',' . $_POST['item_1'] . ', ' . $_POST['item_2'] . ', ' . $_POST['item_3'] . ', ' . $_POST['item_4'] . ', 
    ' . $_POST['item_5'] . ' , ' . $_POST['item_6'] . ', ' . $_POST['item_7'] . ', ' . $_POST['item_8'] . ', 
    ' . $_POST['item_9'] . ', ' . $_POST['item_10'] . ')') !== true
    ) {
      die('Inserting items failed ' . $conn->error);
    } else {
      echo 'pass';
      $inventory_id = $conn->insert_id;
    }

    if (
      $conn->query("UPDATE Characters SET 
          name='" . $_POST['name'] . "', 
          nation_id=" . $_POST['nation'] . ", 
          path_id=" . $_POST['path'] . ", 
          path_level=" . $_POST['level'] . ", 
          stats_id=" . $stats_id . ", 
          skills_id=" . $skills_id . ", 
          background_id=" . $_POST['background'] . ", 
          equipment_id=" . $equipment_id . ", 
          inventory_id=" . $inventory_id . " 
          WHERE id=" . $character_id) !== true
    ) {
      die('Inserting CharacterData failed ' . $conn->error);
    } else {
      echo 'pass';
      header("Location: profile.php");
    }
  }
} else {
  header("Location: login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="hu">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ágas és Bogas | Karakter készítő</title>
  <link rel="icon" href="../img/assets/icons/icon.png" />
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="../css/create.css" />
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
    <div id="dr-container">
      <div id="dice-roller">
        <div id="dice-btn-c">
          <button id="d4" class="dice" data-value="4"><img src="../img/assets/dice/d4.png" alt="d4"></button>
          <button id="d6" class="dice" data-value="6"><img src="../img/assets/dice/d6.png" alt="d6"></button>
          <button id="d8" class="dice" data-value="8"><img src="../img/assets/dice/d8.png" alt="d8"></button>
          <button id="d10" class="dice" data-value="10"><img src="../img/assets/dice/d10.png" alt="d10"></button>
          <button id="d6" class="dice" data-value="12"><img src="../img/assets/dice/d12.png" alt="d12"></button>
          <button id="d20" class="dice" data-value="20"><img src="../img/assets/dice/d20.png" alt="d20"></button>
          <button id="d100" class="dice" data-value="100"><img src="../img/assets/dice/d100.png" alt="d100"></button>
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
    <form id="character-maker" action="create.php" method="post" enctype="multipart/form-data">
      <div id="header">
        <label for="name"><input type="text" name="name" id="name" placeholder="Karakter neve" required></label>
        <label for="nation" style="gap: 1rem">
          Nemzet
          <?php
          $nations = getTableData('Nations');
          echo '<select name="nation" id="nation" style="width: auto;" required>';
          echo '<option value="' . null . '">Válassz</option>';
          for ($i = 0; $i < sizeof($nations); $i++) {
            echo '<option name="' . $nations[$i]['name'] . '" id="' . $nations[$i]['name'] . '" value="' . $nations[$i]['id'] . '">' . ucfirst($nations[$i]['name']) . '</option>';
          }
          echo '</select>';
          ?>
        </label>
        <label for="background" style="gap: 1rem">
          Háttér
          <?php
          $backgrounds = getTableData('Backgrounds');
          echo '<select name="background" id="background" style="width: auto;" required>';
          echo '<option value="' . null . '">Válassz</option>';
          for ($i = 0; $i < sizeof($backgrounds); $i++) {
            echo '<option name="' . $backgrounds[$i]['name'] . '" id="' . $backgrounds[$i]['name'] . '" value="' . $backgrounds[$i]['id'] . '">' . ucfirst($backgrounds[$i]['name']) . '</option>';
          }
          echo '</select>';
          ?>
        </label>
      </div>
      <div id="body">
        <div id="stats">
          <div id="physical" class="stat-container">
            <label>Erő
              <?php
              createStatSelect("strength", 1, 22, true);
              ?>
            </label>
            <label>Ügyesség
              <?php
              createStatSelect("dexterity", 1, 22, true);
              max_value:
              ?>
            </label>
            <label>Kitartás
              <?php
              createStatSelect("endurance", 1, 22, true);
              ?>
            </label>
          </div>
          <div id="inner" class="stat-container">
            <label>Ész
              <?php
              createStatSelect("intelligence", 1, 22, true);
              ?>
            </label>
            <label>Fortély
              <?php
              createStatSelect("charisma", 1, 22, true);
              ?>
            </label>
            <label>Akaraterő
              <?php
              createStatSelect("willpower", 1, 22, true);
              ?>
            </label>
          </div>
        </div>
        <div id="health-sanity">
          <label for="health">
            Életerő
            <?php
            createStatSelect("health", 1, 12, true);
            ?>
          </label>
          <label for="sanity">
            Elme
            <?php
            createStatSelect("sanity", 1, 12, true);
            ?>
          </label>
        </div>
      </div>
      <div id="path-container">
        <label for="path">
          Út
          <?php
          $paths = getTableData("Paths");
          $pathGroups = getTableData("PathGroups");
          echo '<select name="path" id="path" style="width: auto;" required>';
          echo '<option value="' . null . '">Válassz utat</option>';
          for ($i = 0, $j = 0; $i < sizeof($paths); $i++) {
            if ($i % 4 == 0) {
              echo '<optgroup label="' . $pathGroups[$j]['name'] . '">';
              echo '<option name="' . $paths[$i]['name'] . '" id="' . $paths[$i]['name'] . '" value="' . $paths[$i]['id'] . '">' . ucfirst($paths[$i]['name']) . '</option>';
              echo '</optgroup>';
              $j++;
            } else
              echo '<option name="' . $paths[$i]['name'] . '" id="' . $paths[$i]['name'] . '" value="' . $paths[$i]['id'] . '">' . ucfirst($paths[$i]['name']) . '</option>';
          }
          echo '</select>';
          ?>
        </label>
        <label for="level">
          Szint
          <?php
          createStatSelect("level", 1, 6, true);
          ?>
        </label>
      </div>
      <div id="character-info">
        <div id="knowledge">
          Imseretek
          <?php
          $skills = getTableData("Skills");
          for ($i = 0; $i < sizeof($skills); $i++) {
            echo '<div class="skill-container"><label for="skill_' . $i + 1 . '" class="knowledge">' . $skills[$i]['name'] . '</label>';
            createStatSelect('skill_' . $i + 1, 0);
            echo '</div>';
          }
          ?>
        </div>
        <div id="inventory-container">
          <div id="hands">
            <label for="left_hand">
              Bal kéz
              <?php
              $weapons = getTableData('Weapons');
              echo '<select name="left_hand" id="left_hand" style="width: auto;">';
              echo '<option value="0">Fegyver</option>';
              for ($i = 0; $i < sizeof($weapons); $i++) {
                echo '<option name="' . $weapons[$i]['name'] . '" id="' . $weapons[$i]['name'] . '" value="' . $weapons[$i]['id'] . '">' . ucfirst($weapons[$i]['name']) . '</option>';
              }
              echo '</select>';
              ?>
            </label>
            <label for="right_hand">
              Jobb kéz
              <?php
              $weapons = getTableData('Weapons');
              echo '<select name="right_hand" id="right_hand" style="width: auto;">';
              echo '<option value="0">Fegyver</option>';
              for ($i = 0; $i < sizeof($weapons); $i++) {
                echo '<option name="' . $weapons[$i]['name'] . '" id="' . $weapons[$i]['name'] . '" value="' . $weapons[$i]['id'] . '">' . ucfirst($weapons[$i]['name']) . '</option>';
              }
              echo '</select>';
              ?>
            </label>
          </div>
          <label for="armour">
            Páncél
            <?php
            $armour = getTableData('Armour');
            echo '<select name="armour" id="armour" style="width: auto;">';
            echo '<option value="0">Páncél</option>';
            for ($i = 0; $i < sizeof($armour); $i++) {
              echo '<option name="' . $armour[$i]['name'] . '" id="' . $armour[$i]['name'] . '" value="' . $armour[$i]['id'] . '">' . ucfirst($armour[$i]['name']) . '</option>';
            }
            echo '</select>';
            ?>
          </label>
          <label id="inventory-txt">Tárgyak</label>
          <div id="inventory">
            <?php
            /* for ($i = 1; $i <= 10; $i++) {
              echo '
                <label class="inventory-slot" for="item-' . $i . '">
                  Tárgy ' . $i . '
                  <input type="text" name="item_' . $i . '" id="item-' . $i . '">
              ';
            } */

            $items = getTableData('Items');
            for ($i = 1; $i <= 10; $i++) {
              echo '
                <label class="inventory-slot" for="item_' . $i . '">
                  Tárgy ' . $i . '';
              echo '<select name="item_' . $i . '" id="item_' . $i . '" style="width: auto;">';
              echo '<option value="0"> </option>';
              for ($j = 0; $j < sizeof($items); $j++) {
                echo '<option name="' . $items[$j]['name'] . '" id="' . $items[$j]['name'] . '" value="' . $items[$j]['id'] . '">' . ucfirst($items[$j]['name']) . '</option>';
              }
              echo '</select>';
            }
            ?>
          </div>
        </div>
      </div>
      <button id="creabe-btn" type="submit">Karakter létrehozása</button>
    </form>
  </div>
  <script src="../js/menus.js"></script>
  <script src="../js/dice-roller.js"></script>
</body>

</html>