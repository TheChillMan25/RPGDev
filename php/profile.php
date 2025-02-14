<?php
include 'scripts/manager.php';
session_start();

if (checkLogin()) {
  $conn = connectToDB();
  $user = getUserData($conn, $_SESSION['username']);

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $valid = true;

    // Handle file upload
    if (isset($_FILES['pfp']) && $_FILES['pfp']['error'] == 0) {
      $pfp_path = uploadProfilePicture($user, $_FILES['pfp']);
      if ($pfp_path === false) {
        $valid = false;
      }
    }

    if ($_POST['username'] !== $user['username']) {
      if (checkExistingData($conn, 'username', $_POST['username'])) {
        error("Ez a felhasználónév már foglalt!\n");
        $valid = false;
      } else if (strlen($_POST['username']) > 16) {
        error("Ez a felhasználónév túl hosszú!\n");
        $valid = false;
      }
    }

    if ($valid && ($_POST['username'] !== $user['username'] || $_POST['email'] !== $user['email'])) {
      if (updateUserData($conn, $_POST['username'], $_POST['email'])) {
        $_SESSION['username'] = $_POST['username'];
      }
    }

    // Update profile picture path in the database if it was uploaded
    if ($valid && isset($pfp_path)) {
      $sql = "UPDATE Users SET pfp = '$pfp_path' WHERE id = " . $user['id'];
      if ($conn->query($sql)) {
        $user['pfp'] = $pfp_path;
      } else {
        error("Failed to update profile picture in the database.");
      }
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
  }
} else {
  header("Location: ../index.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="hu">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ágas és Bogas | Profil</title>
  <link rel="icon" href="../img/assets/icons/icon.png" />
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="../css/profile.css" />
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
    <div id="btn-container">
      <button id="mpv-btn" class="m-btn"><i class="fa-solid fa-address-book fa-2xl"></i></button>
      <button id="mcv-btn" class="m-btn"><i class="fa-solid fa-people-group fa-2xl"></i></button>
    </div>
    <form id="profile-container" class="container" action="profile.php" method="post" enctype="multipart/form-data">

      <div id="pfp-container">
        <?php echo '<img class="pfp-img" src="' . $user['pfp'] . '" alt="Profile picture">' ?>
        <input type="file" id="uploadPFP" name=pfp>
      </div>
      <div id="data-container">
        <label for="username">
          Felhasználónév:
          <input id="username" name="username" class="edit-profile" type="text" value="<?php echo $user['username'] ?>">
        </label>
        <label for="email">
          Email cím:
          <input id="email" name="email" class="edit-profile" type="text" value="<?php echo $user['email'] ?>">
        </label>
        <input type="submit" name="save" id="save-btn" value="Save">
      </div>
    </form>

    <div id="character-container" class="container">
      <?php $characters = listCharacters($conn, $user['id']);
      foreach ($characters as $character) {
        echo '
        <div class="character">
        <div class="character-header character-data-container">
          <span class="name">' . $character['name'] . '</span>
          <div class="path">
            <span class="value">' . getRecord('Paths', $character['path_id'])['name'] . '</span>
            <span class="level value">' . $character['path_level'] . '</span>
          </div>
        </div>
        <div class="character-body character-data-container">
          <span class="race character-data">
            Nemzet:
            <span class="race-name value">' . getRecord('Nations', $character['nation_id'])['name'] . '</span>
          </span>
          <div class="stats character-data">
            <span class="stat-title">Tulajdonságok</span>
            <div class="main-stats"><span class="main-stat-title">Életerő<span class="value">' . $character['health'] . '</span></span><span class="main-stat-title">Elme<span class="value">' . $character['sanity'] . '</span></span></div>
            <div class="stat-container">
              <span class="stat">Erő<div class="value-container"><span class="value">' . $character['strength'] . '</span><span class="value-modifier">' . calculateModifier($character['strength']) . '</span></div></span>
              <span class="stat">Ügyesség<div class="value-container"><span class="value">' . $character['dexterity'] . '</span><span class="value-modifier">' . calculateModifier($character['dexterity']) . '</span></div></span>
              <span class="stat">Kitartás<div class="value-container"><span class="value">' . $character['endurance'] . '</span><span class="value-modifier">' . calculateModifier($character['endurance']) . '</span></div></span>
              <span class="stat">Akaraterő<div class="value-container"><span class="value">' . $character['intelligence'] . '</span><span class="value-modifier">' . calculateModifier($character['intelligence']) . '</span></div></span>
              <span class="stat">Fortély<div class="value-container"><span class="value">' . $character['charisma'] . '</span><span class="value-modifier">' . calculateModifier($character['charisma']) . '</span></div></span>
              <span class="stat">Akaraterő<div class="value-container"><span class="value">' . $character['willpower'] . '</span><span class="value-modifier">' . calculateModifier($character['willpower']) . '</span></div></span>
            </div>
          </div>
          <div class="character-footer">
            <form action="inspect.php" method="post" style="display: flex; align-items: center;">
              <input type="hidden" name="character_id" value="' . $character['id'] . '">
              <button type="submit" class="character-link" style="cursor: pointer;">View</button>
            </form>
            <form action="scripts/delete-character.php" method="post" style="display: flex; align-items: center;">
              <input type="hidden" name="character_id" value="' . $character['id'] . '">
              <button type="submit" class="delete-character" style="cursor: pointer;"><i class="fa-solid fa-trash fa-2xl"></i></button>
            </form>
          </div>
        </div>
      </div>';
      }
      ?>
    </div>
    <a href="create.php" id="add-character">+</a>
  </div>
  <script src="../js/menus.js"></script>
</body>

</html>