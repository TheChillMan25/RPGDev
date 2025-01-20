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
        </div>'; ?>
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
      <?php
      for ($i = 0; $i < 10; $i++) {
        echo '<div class="character">
              <div class="character-header character-data-container">
                <span class="name">Leo</span>
                <span class="level value">"3"</span>
              </div>
              <div class="character-footer character-data-container">
                <span class="race character-data">
                  Race: 
                  <span class="race-name value">Riverlands</span>
                </span>
                <div class="stats character-data">
                  <span class="stat-title">Stats</span>
                  <div class="stat-container">
                    <span class="stat">Strengt<span class="value">"3"</span></span>
                    <span class="stat">Dexterity<span class="value">"3"</span></span>
                    <span class="stat">Endurance<span class="value">"3"</span></span>
                    <span class="stat">Intelligence<span class="value">"3"</span></span>
                    <span class="stat">Charisma<span class="value">"3"</span></span>
                    <span class="stat">Willpower<span class="value">"3"</span></span>
                  </div>
                </div>
                <a class="charater-link" href="#">About</a>
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