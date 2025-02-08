<?php
include 'scripts/manager.php';
$conn = connectToDB();
$users = getTableData($conn, "Users");
$nations = getTableData($conn, table: "Nations");
$nations = getTableData($conn, table: "Backgrounds");
$weapons = getTableData($conn, table: "Weapons");
$armour = getTableData($conn, table: "Armour");
$nations = getTableData($conn, table: "Skills");
$nations = getTableData($conn, table: "Paths");
$nations = getTableData($conn, table: "PathGroups");

?>

<!DOCTYPE html>
<html lang="hu">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Fajok | Admin</title>
  <link rel="icon" href="../img/assets/icons/icon.png" />
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="../css/admin.css" />
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
    <div id="users" class="container">
      <?php
      echo '<table class="user-table">';
      echo '<tr>';
      echo '<th>Profile Picture</th>';
      echo '<th>Username</th>';
      echo '<th>Email</th>';
      echo '<th>Actions</th>';
      echo '</tr>';
      foreach ($users as $user) {
        echo '<tr>';
        echo '<td><img class="pfp" src="' . $user['pfp'] . '" alt="' . $user['username'] . '_pfp"></td>';
        echo '<td>' . $user['username'] . '</td>';
        echo '<td>' . $user['email'] . '</td>';
        echo '<td>
              <form action="manage_user.php" style="display:inline-block;">
            <input type="hidden" name="user_id" value="' . $user['id'] . '">
            <button type="submit" name="action" value="edit"><i class="fa-solid fa-gear fa-2xl"></i></button>
              </form>
              <form action="manage_user.php" style="display:inline-block;">
            <input type="hidden" name="user_id" value="' . $user['id'] . '">
            <button type="submit" name="action" value="delete"><i class="fa-solid fa-trash fa-2xl"></i></button>
              </form>
            </td>';
        echo '</tr>';
      }
      echo '</table>';
      ?>
    </div>
    <div id="other">

    </div>
  </div>
</body>

</html>