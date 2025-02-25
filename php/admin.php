<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'scripts/manager.php';
$conn = connectToDB();

if (checkLogin()) {
  $user = getUserData($conn, $_SESSION['username']);
} else {
  header('Location: login.php');
}

if (!isAdmin($_SESSION['username']))
  header('Location: /index.php');

$users = getTableData("Users");
$nations = getTableData("Nations");
$backgrounds = getTableData("Backgrounds");
$pathgroups = getTableData("PathGroups");
$pathgroup_n = [];
foreach ($pathgroups as $pathgroup) {
  array_push($pathgroup_n, $pathgroup['name']);
}
$pathgroup_ids = [];
foreach ($pathgroups as $pathgroup) {
  array_push($pathgroup_ids, $pathgroup['id']);
}
$paths = getTableData("Paths");
$skills = getTableData("Skills");
$weapons = getTableData("Weapons");
$armours = getTableData('Armour');
$items = getTableData('Items');

if (!isset($_SESSION['active_menu']))
  $_SESSION['active_menu'] = 'user-menu';
if (!isset($_SESSION['USER_ID']))
  $_SESSION['USER_ID'] = 0;
if (!isset($_SESSION['NATION_ID']))
  $_SESSION['NATION_ID'] = 0;
if (!isset($_SESSION['BACKGROUND_ID']))
  $_SESSION['BACKGROUND_ID'] = 0;
if (!isset($_SESSION['PATHGROUP_ID']))
  $_SESSION['PATHGROUP_ID'] = 0;
if (!isset($_SESSION['PATH_ID']))
  $_SESSION['PATH_ID'] = 0;
if (!isset($_SESSION['SKILL_ID']))
  $_SESSION['SKILL_ID'] = 0;
if (!isset($_SESSION['WEAPON_ID']))
  $_SESSION['WEAPON_ID'] = 0;
if (!isset($_SESSION['ARMOUR_ID']))
  $_SESSION['ARMOUR_ID'] = 0;
if (!isset($_SESSION['ITEM_ID']))
  $_SESSION['ITEM_ID'] = 0;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  switch ($_POST['action']) {

    case 'show-nation':
      $_SESSION['active_menu'] = 'nation-menu';
      if ($_SESSION['NATION_ID'] !== $_POST['nation_id'])
        $_SESSION['NATION_ID'] = $_POST['nation_id'];
      else
        $_SESSION['NATION_ID'] = 0;
      break;

    case 'show-user':
      $_SESSION['active_menu'] = 'user-menu';
      if ($_SESSION['USER_ID'] !== $_POST['user_id'])
        $_SESSION['USER_ID'] = $_POST['user_id'];
      else
        $_SESSION['USER_ID'] = 0;
      break;

    case 'show-background':
      $_SESSION['active_menu'] = 'back-menu';
      if ($_SESSION['BACKGROUND_ID'] !== $_POST['background_id'])
        $_SESSION['BACKGROUND_ID'] = $_POST['background_id'];
      else
        $_SESSION['BACKGROUND_ID'] = 0;
      break;

    case 'show-path':
      $_SESSION['active_menu'] = 'path-menu';
      if (isset($_POST['path_id'])) {
        if ($_SESSION['PATH_ID'] !== $_POST['path_id'])
          $_SESSION['PATH_ID'] = $_POST['path_id'];
        else
          $_SESSION['PATH_ID'] = 0;
        $_SESSION['PATHGROUP_ID'] = 0;
      } else if (isset($_POST['pathgroup_id'])) {
        if ($_SESSION['PATHGROUP_ID'] !== $_POST['pathgroup_id'])
          $_SESSION['PATHGROUP_ID'] = $_POST['pathgroup_id'];
        else
          $_SESSION['PATHGROUP_ID'] = 0;
        $_SESSION['PATH_ID'] = 0;
      }
      break;

    case 'show-skills':
      $_SESSION['active_menu'] = 'skill-menu';
      if ($_SESSION['SKILL_ID'] !== $_POST['skill_id'])
        $_SESSION['SKILL_ID'] = $_POST['skill_id'];
      else
        $_SESSION['SKILL_ID'] = 0;
      break;

    case 'show-weapon':
      $_SESSION['active_menu'] = 'eq-inv-menu';
      if ($_SESSION['WEAPON_ID'] !== $_POST['weapon_id'])
        $_SESSION['WEAPON_ID'] = $_POST['weapon_id'];
      else
        $_SESSION['WEAPON_ID'] = 0;
      $_SESSION['ARMOUR_ID'] = 0;
      $_SESSION['ITEM_ID'] = 0;
      break;

    case 'show-armour':
      $_SESSION['active_menu'] = 'eq-inv-menu';
      if ($_SESSION['ARMOUR_ID'] !== $_POST['armour_id'])
        $_SESSION['ARMOUR_ID'] = $_POST['armour_id'];
      else
        $_SESSION['ARMOUR_ID'] = 0;
      $_SESSION['WEAPON_ID'] = 0;
      $_SESSION['ITEM_ID'] = 0;
      break;

    case 'show-item':
      $_SESSION['active_menu'] = 'eq-inv-menu';
      if ($_SESSION['ITEM_ID'] !== $_POST['item_id'])
        $_SESSION['ITEM_ID'] = $_POST['item_id'];
      else
        $_SESSION['ITEM_ID'] = 0;
      $_SESSION['ARMOUR_ID'] = 0;
      $_SESSION['WEAPON_ID'] = 0;
      break;

    default:
      break;
  }
  header('Location: ' . $_SERVER['PHP_SELF']);
  exit;
}
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
    <div id="active-menu" data-value="<?php echo $_SESSION['active_menu'] ?>"></div>
    <div id="hotbar">
      <div id="users-btn" class="hotbar-btn" data-menu="user-menu" data-text="Felhasználók"><i
          class="fa-solid fa-users fa-2xl"></i></div>
      <div id="nations-btn" class="hotbar-btn" data-menu="nation-menu" data-text="Népek"><i
          class="fa-solid fa-flag fa-2xl"></i></div>
      <div id="backgrounds-btn" class="hotbar-btn" data-menu="back-menu" data-text="Hátterek"><i
          class="fa-solid fa-book-open fa-2xl"></i></div>
      <div id="paths-btn" class="hotbar-btn" data-menu="path-menu" data-text="Utak"><i
          class="fa-solid fa-book-journal-whills fa-2xl"></i></div>
      <div id="skills-btn" class="hotbar-btn" data-menu="skill-menu" data-text="Ismeretek"><i
          class="fa-solid fa-graduation-cap fa-2xl"></i></div>
      <div id="equipment-inventory-btn" class="hotbar-btn" data-menu="eq-inv-menu" data-text="Felszerelések és Tárgyak">
        <i class="fa-solid fa-suitcase fa-2xl"></i>
      </div>
    </div>
    <div id="content">
      <div id="user-menu" class="menu">
        <div id="users" class="container">
          <table>
            <tr>
              <th>Profile Picture</th>
              <th>Username</th>
              <th>Email</th>
              <th>Actions</th>
            </tr>
            <?php
            foreach ($users as $user) {
              echo '<tr ' . ($_SESSION['USER_ID'] === $user['id'] ? 'style="background-color: #333"' : '') . '>';
              echo '<td><img class="pfp" src="' . $user['pfp'] . '" alt="' . $user['username'] . '_pfp"></td>';
              echo '<td>' . $user['username'] . '</td>';
              echo '<td>' . $user['email'] . '</td>';
              echo '<td>
              <form action="admin.php" method="post" style="display:flex;">
                <input type="hidden" name="user_id" value="' . $user['id'] . '">
                <button type="submit" name="action" value="show-user"><i class="fa-solid fa-gear fa-2xl"></i></button>
              </form>
            </td>';
              echo '</tr>';
            }
            ?>
          </table>
        </div>
        <div id="characters" class="container"
          style="display: <?php echo $_SESSION['USER_ID'] !== 0 ? 'flex' : 'none'; ?>; width: 40%;">
          <table>
            <tr>
              <th>Character name</th>
              <th>Actions</th>
              <!-- <th>
                      <form action="" method="post">Add character</form>
                    </th> -->
            </tr>
            <?php
            if (isset($_SESSION['USER_ID'])) {
              $characters = listCharacters($conn, $_SESSION['USER_ID']);
              foreach ($characters as $character) {
                echo '<tr>
                    <td>
                      ' . $character['name'] . '
                    </td>
                    <td style="display: flex; justify-content: center; align-items: center;">
                    <form action="inspect.php" method="post">
                        <input type="hidden" name="character_id" value="' . $character['id'] . '">
                        <button type="submit" style="cursor: pointer;"><i class="fa-solid fa-info fa-2xl"></i></button>
                      </form>
                      <form action="scripts/delete-character.php" method="post">
                        <input type="hidden" name="character_id" value="' . $character['id'] . '">
                        <button type="submit" style="cursor: pointer;"><i class="fa-solid fa-trash fa-2xl"></i></button>
                      </form>
                    </td>
                  </tr>';
              }
            } else {
              echo "Session USER_ID is not set.<br>";
            }
            ?>
          </table>
        </div>
      </div>
      <div id="nation-menu" class="menu">
        <div id="nations" class="container">
          <table>
            <tr>
              <th>Nation name</th>
              <th>Actions</th>
            </tr>
            <?php
            foreach ($nations as $nation) {
              echo '<tr ' . ($_SESSION['NATION_ID'] === $nation['id'] ? 'style="background-color: #333"' : '') . '>';
              echo '<td>' . $nation['name'] . '</td>';
              echo '<td style="display: flex">
                        <form action="admin.php" method="post">
                          <input type="hidden" name="nation_id" value="' . $nation['id'] . '">
                          <button type="submit" name="action" value="show-nation"><i class="fa-solid fa-gear fa-2xl"></i></button>
                        </form>
                        <form action="scripts/db_manage/delete_record.php" method="post">
                          <input type="hidden" name="id" value="' . $nation['id'] . '">
                          <button type="submit" name="action" value="delete-nation"><i class="fa-solid fa-trash fa-2xl"></i></button>
                        </form>
                      </td>';
              echo '</tr>';
            }
            ?>
          </table>
        </div>
        <div id="edit-nation" class="container"
          style="display: <?php echo $_SESSION['NATION_ID'] !== 0 ? 'flex' : 'none'; ?>">
          <?php
          if (isset($_SESSION['NATION_ID'])) {
            $nation = getRecord('Nations', $_SESSION['NATION_ID']);
            echo '<form action="scripts/db_manage/edit_records.php" method="post">
                      <input type="hidden" name="id" value="' . $nation['id'] . '">
                      <span class="title">Nép szerkesztése</span>
                      <label for="nation_edit_name">Nép neve<input type="text" name="nation_edit_name" id="nation_edit_name" value="' . $nation['name'] . '" required ></label>
                      <label for="nation_edit_desc" style="width: 90%;">Nép leírása<textarea name="nation_edit_desc" id="nation_edit_desc">' . $nation['description'] . '</textarea></label>
                      <button class="button" name="action" value="edit-nation" type="submit">Mentés</button>
                    </form>';
          }
          ?>
        </div>
        <div id="add-nation" class="container">
          <span class="title">Nép létrehozása</span>
          <form class="add-form" action="scripts/db_manage/add_record.php" method="post">
            <label for="nation-name">Nép neve
              <input type="text" name="nation-name" id="nation-name" maxlength="30" required></label>
            <label for="nation-desc" style="width: 90%;">Nép leírása
              <textarea name="nation-desc" id="nation-desc" maxlength="5000"></textarea></label>
            <button class="button" name="action" value="add-nation" type="submit">
              Mentés
            </button>
          </form>
        </div>
      </div>
      <div id="back-menu" class="menu">
        <div id="backgrounds" class="container">
          <table>
            <tr>
              <th>Background name</th>
              <th>Actions</th>
            </tr>
            <?php
            foreach ($backgrounds as $background) {
              echo '<tr ' . ($_SESSION['BACKGROUND_ID'] === $background['id'] ? 'style="background-color: #333"' : '') . '>';
              echo '<td>' . $background['name'] . '</td>';
              echo '<td style="display: flex">
                        <form action="admin.php" method="post">
                          <input type="hidden" name="background_id" value="' . $background['id'] . '">
                          <button type="submit" name="action" value="show-background"><i class="fa-solid fa-gear fa-2xl"></i></button>
                        </form>
                        <form action="scripts/db_manage/delete_record.php" method="post">
                          <input type="hidden" name="id" value="' . $background['id'] . '">
                          <button type="submit" name="action" value="delete-background"><i class="fa-solid fa-trash fa-2xl"></i></button>
                        </form>
                      </td>';
              echo '</tr>';
            }
            ?>
          </table>
        </div>
        <div id="edit-background" class="container"
          style="display: <?php echo $_SESSION['BACKGROUND_ID'] !== 0 ? 'flex' : 'none'; ?>">
          <?php
          if (isset($_SESSION['BACKGROUND_ID'])) {
            $background = getRecord('Backgrounds', $_SESSION['BACKGROUND_ID']);
            echo '<form action="scripts/db_manage/edit_records.php" method="post">
                      <input type="hidden" name="id" value="' . $background['id'] . '">
                      <span class="title">Háttér szerkesztése</span>
                      <label for="edit-background-name">Háttér neve<input type="text" name="edit-background-name" id="edit-background-name" value="' . $background['name'] . '" required ></label>
                      <label for="edit-background-desc" style="width: 90%;">Háttér leírása<textarea name="edit-background-desc" id="edit-background-desc">' . $background['description'] . '</textarea></label>
                      <button class="button" name="action" value="edit-background" type="submit">Mentés</button>
                    </form>';
          }
          ?>
        </div>
        <div id="add-background" class="container">
          <span class="title">Háttér létrehozása</span>
          <form class="add-form" action="scripts/db_manage/add_record.php" method="post">
            <label for="background-name">Háttér neve
              <input type="text" name="background-name" id="background-name" maxlength="30" required></label>
            <label for="background-desc" style="width: 90%;">Háttér leírása
              <textarea name="background-desc" id="background-desc" maxlength="5000"></textarea></label>
            <button class="button" name="action" value="add-background" type="submit">
              Mentés
            </button>
          </form>
        </div>
      </div>
      <div id="path-menu" class="menu">
        <div id="path-container" class="container">
          <div id="pathgroups" class="container">
            <table>
              <tr>
                <th>PathGroup name</th>
                <th>Actions</th>
              </tr>
              <?php
              foreach ($pathgroups as $pathgroup) {
                echo '<tr ' . ($_SESSION['PATHGROUP_ID'] === $pathgroup['id'] ? 'style="background-color: #333"' : '') . '>';
                echo '<td>' . $pathgroup['name'] . '</td>';
                echo '<td style="display: flex">
                        <form action="admin.php" method="post">
                          <input type="hidden" name="pathgroup_id" value="' . $pathgroup['id'] . '">
                          <button type="submit" name="action" value="show-path"><i class="fa-solid fa-gear fa-2xl"></i></button>
                        </form>
                        <form action="scripts/db_manage/delete_record.php" method="post">
                          <input type="hidden" name="id" value="' . $pathgroup['id'] . '">
                          <button type="submit" name="action" value="delete-pathgroup"><i class="fa-solid fa-trash fa-2xl"></i></button>
                        </form>
                      </td>';
                echo '</tr>';
              }
              ?>
            </table>
          </div>
          <div id="paths" class="container">
            <table>
              <tr>
                <th>Path name</th>
                <th>PathGroup</th>
                <th>Actions</th>
              </tr>
              <?php
              foreach ($paths as $path) {
                echo '<tr ' . ($_SESSION['PATH_ID'] === $path['id'] ? 'style="background-color: #333"' : '') . '>';
                echo '<td>' . $path['name'] . '</td>';
                echo '<td>' . getRecord('PathGroups', $path['group_id'])['name'] . '</td>';
                echo '<td style="display: flex">
                        <form action="admin.php" method="post">
                          <input type="hidden" name="path_id" value="' . $path['id'] . '">
                          <button type="submit" name="action" value="show-path"><i class="fa-solid fa-gear fa-2xl"></i></button>
                        </form>
                        <form action="scripts/db_manage/delete_record.php" method="post">
                          <input type="hidden" name="id" value="' . $path['id'] . '">
                          <button type="submit" name="action" value="delete-path"><i class="fa-solid fa-trash fa-2xl"></i></button>
                        </form>
                      </td>';
                echo '</tr>';
              }
              ?>
            </table>
          </div>
        </div>
        <div id="edit-path-container" class="container"
          style="display: <?php echo $_SESSION['PATHGROUP_ID'] !== 0 || $_SESSION['PATH_ID'] !== 0 ? 'flex' : 'none'; ?>">
          <?php if ($_SESSION['PATH_ID'] !== 0) {
            $path = getRecord('Paths', $_SESSION['PATH_ID']);
            echo '<form action="scripts/db_manage/edit_records.php" method="post">
                      <input type="hidden" name="id" value="' . $path['id'] . '">
                      <span class="title">Út szerkesztése</span>
                      <label for="edit-path-name">Út neve<input type="text" name="edit-path-name" id="edit-path-name" value="' . $path['name'] . '" required ></label>
                      <label for="edit-path-pathgroup">Csoport';
            createListSelect('edit-path-pathgroup', $pathgroup_n, $pathgroup_ids, true, getRecord('PathGroups', $path['group_id'])['name'], getRecord('PathGroups', $path['group_id'])['id']);
            echo '  </label>
                      <label for="edit-path-desc" style="width: 90%;">Út leírása<textarea name="edit-path-desc" id="edit-path-desc">' . $path['description'] . '</textarea></label>
                      <button class="button" name="action" value="edit-path" type="submit">Mentés</button>
                    </form>';
          } else if ($_SESSION['PATHGROUP_ID'] !== 0) {
            $group = getRecord('PathGroups', $_SESSION['PATHGROUP_ID']);
            echo '<form action="scripts/db_manage/edit_records.php" method="post">
                      <input type="hidden" name="id" value="' . $group['id'] . '">
                      <span class="title">Csoport szerkesztése</span>
                      <label for="edit-group-name">Csoport neve<input type="text" name="edit-group-name" id="edit-group-name" value="' . $group['name'] . '" required ></label>
                      <label for="edit-group-desc" style="width: 90%;">Csoport leírása<textarea name="edit-group-desc" id="edit-group-desc">' . $group['description'] . '</textarea></label>
                      <button class="button" name="action" value="edit-pathgroup" type="submit">Mentés</button>
                    </from>';
          }
          ?>
        </div>
        <div id="add-path" class="container" style="width: 50%;">
          <span class="title">Út/Csoport létrehozása</span>
          <form class="add-form" action="scripts/db_manage/add_record.php" method="post">
            <div id="type" style="display: flex; gap: 1rem;">
              <label for="path-type">Út<input type="radio" name="type" id="path-type" value="path" checked></label>
              <label for="group-type">Csoport<input type="radio" name="type" id="group-type" value="group"></label>
            </div>
            <label for="path-name">Út/Csoport neve
              <input type="text" name="path-name" id="path-name" maxlength="30" required></label>
            <?php createListSelect('pathgroup', $pathgroup_n, $pathgroup_ids) ?>
            <label for="path-desc" style="width: 90%;">Út/Csoport leírása
              <textarea name="path-desc" id="path-desc" maxlength="5000"></textarea></label>
            <button class="button" name="action" value="add-path" type="submit">
              Mentés
            </button>
          </form>
        </div>
      </div>
      <div id="skill-menu" class="menu">
        <div id="skills" class="container">
          <table>
            <tr>
              <th>Skill name</th>
              <th>Actions</th>
            </tr>
            <?php
            foreach ($skills as $skill) {
              echo '<tr ' . ($_SESSION['SKILL_ID'] === $skill['id'] ? 'style="background-color: #333"' : '') . '>';
              echo '<td>' . $skill['name'] . '</td>';
              echo '<td style="display: flex">
                        <form action="admin.php" method="post">
                          <input type="hidden" name="skill_id" value="' . $skill['id'] . '">
                          <button type="submit" name="action" value="show-skills"><i class="fa-solid fa-gear fa-2xl"></i></button>
                        </form>
                        <form action="scripts/db_manage/delete_record.php" method="post">
                          <input type="hidden" name="id" value="' . $skill['id'] . '">
                          <button type="submit" name="action" value="delete-skill"><i class="fa-solid fa-trash fa-2xl"></i></button>
                        </form>
                      </td>';
              echo '</tr>';
            }
            ?>
          </table>
        </div>
        <div id="edit-skill" class="container"
          style="display: <?php echo $_SESSION['SKILL_ID'] !== 0 ? 'flex' : 'none'; ?>">
          <?php
          if (isset($_SESSION['SKILL_ID'])) {
            $skill = getRecord('Skills', $_SESSION['SKILL_ID']);
            echo '<form action="scripts/db_manage/edit_records.php" method="post">
                      <span class="title">Ismeret szerkesztése</span>
                      <input type="hidden" name="id" value="' . $skill['id'] . '">
                      <label for="skill_edit_name">Ismeret neve<input type="text" name="skill_edit_name" id="skill_edit_name" value="' . $skill['name'] . '" required ></label>
                      <label for="skill_edit_desc" style="width: 90%;">Ismeret leírása<textarea name="skill_edit_desc" id="skill_edit_desc">' . $skill['description'] . '</textarea></label>
                      <button class="button" name="action" value="edit-skill" type="submit">Mentés</button>
                    </form>';
          }
          ?>
        </div>
        <div id="add-skill" class="container">
          <span class="title">Ismeret létrehozása</span>
          <form class="add-form" action="scripts/db_manage/add_record.php" method="post">
            <label for="skill-name">Ismeret neve
              <input type="text" name="skill-name" id="skill-name" maxlength="30" required></label>
            <label for="skill-desc" style="width: 90%;">Ismeret leírása
              <textarea name="skill-desc" id="skill-desc" maxlength="5000"></textarea></label>
            <button class="button" name="action" value="add-skill" type="submit">
              Mentés
            </button>
          </form>
        </div>
      </div>
      <div id="eq-inv-menu" class="menu">

        <div id="weapons" class="container"
          style=" display: <?php echo ($_SESSION['ARMOUR_ID'] === 0 && $_SESSION['ITEM_ID'] === 0) ? 'flex;' : 'none;' ?> width: auto">
          <table>
            <tr>
              <th>Weapon name</th>
              <th>Type</th>
              <th>Dice</th>
              <th>Properties</th>
              <th>Actions</th>
            </tr>
            <?php
            foreach ($weapons as $weapon) {
              echo '<tr ' . ($_SESSION['WEAPON_ID'] === $weapon['id'] ? 'style="background-color: #333"' : '') . '>';
              echo '<td>' . $weapon['name'] . '</td>
                      <td>' . $weapon['type'] . '</td>
                      <td>' . $weapon['dice'] . '</td>
                      <td>' . $weapon['properties'] . '</td>';
              echo '<td style="display: flex">
                        <form action="admin.php" method="post">
                          <input type="hidden" name="weapon_id" value="' . $weapon['id'] . '">
                          <button type="submit" name="action" value="show-weapon"><i class="fa-solid fa-gear fa-2xl"></i></button>
                        </form>
                        <form action="scripts/db_manage/delete_record.php" method="post">
                          <input type="hidden" name="id" value="' . $weapon['id'] . '">
                          <button type="submit" name="action" value="delete-weapon"><i class="fa-solid fa-trash fa-2xl"></i></button>
                        </form>
                      </td>';
              echo '</tr>';
            }
            ?>
          </table>
        </div>
        <div id="armour" class="container"
          style="<?php echo ($_SESSION['WEAPON_ID'] === 0 && $_SESSION['ITEM_ID'] === 0) ? 'display:flex;' : 'display:none;' ?>width: auto">
          <table>
            <tr>
              <th>Armour name</th>
              <th>Armour value</th>
              <th>Dexterity mod</th>
              <th>Actions</th>
            </tr>
            <?php
            foreach ($armours as $armour) {
              echo '<tr ' . ($_SESSION['ARMOUR_ID'] === $armour['id'] ? 'style="background-color: #333"' : '') . '>';
              echo '<td>' . $armour['name'] . '</td>
                      <td>' . $armour['value'] . '</td>
                      <td>' . $armour['dex_mod'] . '</td>';
              echo '<td style="display: flex">
                        <form action="admin.php" method="post">
                          <input type="hidden" name="armour_id" value="' . $armour['id'] . '">
                          <button type="submit" name="action" value="show-armour"><i class="fa-solid fa-gear fa-2xl"></i></button>
                        </form>
                        <form action="scripts/db_manage/delete_record.php" method="post">
                          <input type="hidden" name="id" value="' . $armour['id'] . '">
                          <button type="submit" name="action" value="delete-armour"><i class="fa-solid fa-trash fa-2xl"></i></button>
                        </form>
                      </td>';
              echo '</tr>';
            }
            ?>
          </table>
        </div>
        <div id="items" class="container"
          style="<?php echo ($_SESSION['ARMOUR_ID'] === 0 && $_SESSION['WEAPON_ID'] === 0) ? 'display:flex;' : 'display:none;' ?>width: auto">
          <table>
            <tr>
              <th>Item name</th>
              <th>Actions</th>
            </tr>
            <?php
            foreach ($items as $item) {
              echo '<tr ' . ($_SESSION['ITEM_ID'] === $item['id'] ? 'style="background-color: #333"' : '') . '>';
              echo '<td>' . $item['name'] . '</td>';
              echo '<td style="display: flex">
                        <form action="admin.php" method="post">
                          <input type="hidden" name="item_id" value="' . $item['id'] . '">
                          <button type="submit" name="action" value="show-item"><i class="fa-solid fa-gear fa-2xl"></i></button>
                        </form>
                        <form action="scripts/db_manage/delete_record.php" method="post">
                          <input type="hidden" name="id" value="' . $item['id'] . '">
                          <button type="submit" name="action" value="delete-item"><i class="fa-solid fa-trash fa-2xl"></i></button>
                        </form>
                      </td>';
              echo '</tr>';
            }
            ?>
          </table>
        </div>
        <div id="show-weapon" class="show"
          style="display: <?php echo $_SESSION['WEAPON_ID'] !== 0 ? 'flex' : 'none' ?>;">
          <div id="edit-weapon" class="container">
            <?php
            if (isset($_SESSION['WEAPON_ID'])) {
              $weapon = getRecord('Weapons', $_SESSION['WEAPON_ID']);
              $dice = getWeaponDiceData($weapon['dice']);
              echo '<form action="scripts/db_manage/edit_records.php" method="post">
                    <input type="hidden" name="id" value="' . $weapon['id'] . '">
                    <span class="title">Fegyver szerkesztése</span>
                    <label for="weapon-edit-name">Fegyver neve<input type="text" name="weapon-edit-name" id="weapon-edit-name" value="' . $weapon['name'] . '" required ></label>
                    <label for="weapon_edit_type">Fegyver típusa';
              createListSelect('weapon_edit_type', ['melee', 'ranged'], ['melee', 'ranged'], true, $weapon['type'], $weapon['type']);
              echo '</label>
                    <label for="edit-dice-num"><input type="number" name="edit-dice-num" id="edit-dice-num" value="' . $dice['dice_num'] . '" required ></label>
                    <label for="edit-dice-type">';
              createListSelect('edit-dice-type', ['d4', 'd6', 'd8', 'd10', 'd12', 'd20'], ['d4', 'd6', 'd8', 'd10', 'd12', 'd20'], true, $dice['dice_type'], $dice['dice_type']);
              echo '</label>
                    <label for="weapon_edit_properties">Fegyver tulajdonságok<input type="text" name="weapon_edit_properties" id="weapon_edit_properties" value="' . $weapon['properties'] . '" /></label>
                    <label for="weapon_edit_desc" style="width: 90%;">Fegyver leírása<textarea name="weapon_edit_desc" id="weapon_edit_desc">' . $weapon['description'] . '</textarea></label>
                    <button class="button" name="action" value="edit-weapon" type="submit">Mentés</button>
                  </form>';
            }
            ?>
          </div>
          <div id="add-weapon" class="container">
            <span class="title">Fegyver létrehozása</span>
            <form class="add-form" action="scripts/db_manage/add_record.php" method="post">
              <label for="weapon-name">Fegyver neve
                <input type="text" name="weapon-name" id="weapon-name" maxlength="30" required></label>
              <label for="weapon-type">Fegyver típusa
                <?php createListSelect('weapon-type', ['melee', 'ranged'], ['melee', 'ranged'], true, 'Fegyver típusa') ?></label>
              <div id="dice-data">
                <label for="dice-num">Kocka darab száma
                  <input type="number" name="dice-num" id="dice-num" min="1" required></label>
                <label for="dice-type">
                  <?php createListSelect('dice-type', ['d4', 'd6', 'd8', 'd10', 'd12', 'd20'], ['d4', 'd6', 'd8', 'd10', 'd12', 'd20'], true, 'Kocka típusa') ?></label>
              </div>
              <label for="weapon-properties">Fegyver tulajdonságai
                <input type="text" name="weapon-properties" id="weapon-properties" maxlength="100" /></label>
              <label for="weapon-desc" style="width: 90%;">Fegyver leírása
                <textarea name="weapon-desc" id="weapon-desc" maxlength="5000"></textarea></label>
              <button class="button" name="action" value="add-weapon" type="submit">
                Mentés
              </button>
            </form>
          </div>
        </div>
        <div id="show-armour" class="show"
          style="display: <?php echo $_SESSION['ARMOUR_ID'] !== 0 ? 'flex' : 'none' ?>;">
          <div id="edit-armour" class="container">
            <?php
            if (isset($_SESSION['ARMOUR_ID'])) {
              $armour = getRecord('Armour', $_SESSION['ARMOUR_ID']);
              echo '<form action="scripts/db_manage/edit_records.php" method="post">
                      <input type="hidden" name="id" value="' . $armour['id'] . '">
                      <span class="title">Páncél szerkesztése</span>
                      <label for="armour_edit_name">Páncél neve<input type="text" name="armour_edit_name" id="armour_edit_name" value="' . $armour['name'] . '" required></label>
                      <label for="armour_edit_value">Páncél értéke<input type="number" name="armour_edit_value" id="armour_edit_value" value="' . $armour['value'] . '" required></label>
                      <label for="armour_edit_dexmod">Páncél ügyesség módosító<input type="number" name="armour_edit_dexmod" id="armour_edit_dexmod" value="' . $armour['dex_mod'] . '" required></label>
                      <label for="armour_edit_desc" style="width: 90%;">Páncél leírása<textarea name="armour_edit_desc" id="armour_edit_desc">' . $armour['description'] . '</textarea></label>
                      <button class="button" name="action" value="edit-armour" type="submit">Mentés</button>
                    </form>';
            }
            ?>
          </div>
          <div id="add-armour" class="container">
            <span class="title">Páncél létrehozása</span>
            <form class="add-form" action="scripts/db_manage/add_record.php" method="post">
              <label for="armour-name">Páncél neve
                <input type="text" name="armour-name" id="armour-name" maxlength="30" required></label>
              <label for="armour-value">Páncél értéke
                <input type="number" name="armour-value" id="armour-value" min="0" required></label>
              <label for="armour-dexmod">Páncél ügyesség módosító
                <input type="number" name="armour-dexmod" id="armour-dexmod" required></label>
              <label for="armour-desc" style="width: 90%;">Páncél leírása
                <textarea name="armour-desc" id="armour-desc" maxlength="5000"></textarea></label>
              <button class="button" name="action" value="add-armour" type="submit">
                Mentés
              </button>
            </form>
          </div>
        </div>
        <div id="show-item" class="show" style="display: <?php echo $_SESSION['ITEM_ID'] !== 0 ? 'flex' : 'none' ?>;">
          <div id="edit_item" class="container">
            <?php
            if (isset($_SESSION['ITEM_ID'])) {
              $item = getRecord('Items', $_SESSION['ITEM_ID']);
              echo '<form action="scripts/db_manage/edit_records.php" method="post">
                      <input type="hidden" name="id" value="' . $item['id'] . '">
                      <span class="title">Tárgy szerkesztése</span>
                      <label for="item_edit_name">Tárgy neve<input type="text" name="item_edit_name" id="item_edit_name" value="' . $item['name'] . '" required></label>
                      <label for="item_edit_desc" style="width: 90%;">Tárgy leírása<textarea name="item_edit_desc" id="item_edit_desc">' . $item['description'] . '</textarea></label>
                      <button class="button" name="action" value="edit-item" type="submit">Mentés</button>
                    </form>';
            }
            ?>
          </div>
          <div id="add-item" class="container">
            <span class="title">Tárgy létrehozása</span>
            <form class="add-form" action="scripts/db_manage/add_record.php" method="post">
              <label for="item-name">Tárgy neve
                <input type="text" name="item-name" id="item-name" maxlength="30" required></label>
              <label for="item-desc" style="width: 90%;">Tárgy leírása
                <textarea name="item-desc" id="item-desc" maxlength="5000"></textarea></label>
              <button class="button" name="action" value="add-item" type="submit">
                Mentés
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../js/menus.js"></script>
  <script src="../js/admin.js"></script>
</body>

</html>