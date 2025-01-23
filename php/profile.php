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
  <link rel="icon" href="../img/icon.png" />
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="../css/profile.css" />
  <script src="https://kit.fontawesome.com/62786e1e62.js" crossorigin="anonymous"></script>
</head>

<body>
  <div class="navbar">
    <div id="navbar-mobile">
      <a class="index-link" href="../index.php"><img src="../img/logo.png" alt="Index oldalra" /></a>
      <p id="m-author">Ágas és Bogas</p>
      <div id="mobile-menu">
        <?php
        echo '<div id=mobile-profile-menu class="logger-btn-mobile" style="cursor: pointer; margin-right: .5rem;">
                <img class="pfp" src="' . $user['pfp'] . '">
              </div>';
        ?>
        <div id="mobile-menu-container">
          <div id="mobile-link-container">
            <a class="navbar-link" href="profile.php">Profile</a>
            <a class="navbar-link" href="create-character.php">Create your character</a>
            <a class="navbar-link" href="scripts/logout.php">Logout</a>
            <hr>
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
            <a class="profile-menu-link" href="create-character.php">Create your character</a>
            <a class="profile-menu-link" href="scripts/logout.php">Logout</a>
          </div>
        </div>';
    ?>
  </div>
  <div class="page">
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
            <span class="value">' . $character['path'] . '</span>
            <span class="level value">' . $character['level'] . '</span>
          </div>
        </div>
        <div class="character-body character-data-container">
          <span class="race character-data">
            Nemzet:
            <span class="race-name value">' . $character['nation'] . '</span>
          </span>
          <div class="stats character-data">
            <span class="stat-title">Tulajdonságok</span>
            <div class="main-stats"><span class="main-stat-title">Életerő<span class="value">' . $character['health'] . '</span></span><span class="main-stat-title">Elme<span class="value">' . $character['sanity'] . '</span></span></div>
            <div class="stat-container">
              <span class="stat">Erő<div class="value-container"><span class="value">' . $character['strength'] . '</span><span class="value-modifier">' . $character['strength_mod'] . '</span></div></span>
              <span class="stat">Ügyesség<div class="value-container"><span class="value">' . $character['dexterity'] . '</span><span class="value-modifier">' . $character['dexterity_mod'] . '</span></div></span>
              <span class="stat">Kitartás<div class="value-container"><span class="value">' . $character['endurance'] . '</span><span class="value-modifier">' . $character['endurance_mod'] . '</span></div></span>
              <span class="stat">Akaraterő<div class="value-container"><span class="value">' . $character['intelligence'] . '</span><span class="value-modifier">' . $character['intelligence_mod'] . '</span></div></span>
              <span class="stat">Fortély<div class="value-container"><span class="value">' . $character['charisma'] . '</span><span class="value-modifier">' . $character['charisma_mod'] . '</span></div></span>
              <span class="stat">Akaraterő<div class="value-container"><span class="value">' . $character['willpower'] . '</span><span class="value-modifier">' . $character['willpower_mod'] . '</span></div></span>
            </div>
          </div>
          <div class="character-footer">
            <form action="inspect-character.php" method="post" style="display: flex; align-items: center;">
              <input type="hidden" name="id" value="' . $character['id'] . '">
              <button type="submit" class="character-link" style="cursor: pointer;">About</button>
            </form>
            <form action="scripts/delete-character.php" method="post" style="display: flex; align-items: center;">
              <input type="hidden" name="id" value="' . $character['id'] . '">
              <button type="submit" class="delete-character" style="cursor: pointer;"><i class="fa-solid fa-trash fa-2xl"></i></button>
            </form>
          </div>
        </div>
      </div>';
      }
      ?>
    </div>
    <a href="create-character.php" id="add-character">+</a>
  </div>
  <script src="../js/menus.js"></script>
</body>

</html>