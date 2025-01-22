<?php
include 'scripts/manager.php';
session_start();

if (checkLogin()) {
  $conn = connectToDB();
  $user = getUserData($conn, $_SESSION['username']);
  $user_id = $user['id'];

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $character_data = [];
    foreach ($_POST as $key => $value) {
      $character_data[$key] = $value;
    }

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
  header("Location: ../index.php");
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
    ?>
  </div>
  <div class="page">
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
        <div id="health-path-lvl">
          <label for="health">
            Életerő
            <?php
            createSelection("health", 12);
            ?>
          </label>
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
          <a id="add-knowledge" href="#">Ismeret hozzáadása</a>
        </div>
        <div id="inventory-container">
          <div id="hands">
            <label for="weapons-left">
              Bal kéz
              <?php
              createSelection("left_hand", count($weapons) - 1, $weapons, "Válassz");
              ?>
            </label>
            <label for="weapons-right">
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
      <button type="submit">Karakter létrehozása</button>
    </form>
  </div>
  <script src="../js/menus.js"></script>
  <script src="../js/add-knowledge.js"></script>
</body>

</html>