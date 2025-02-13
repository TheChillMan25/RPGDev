  <?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  session_start();
  include 'scripts/manager.php';
  $conn = connectToDB();
  $users = getTableData($conn, "Users");
  $nations = getTableData($conn, "Nations");
  $backgrounds = getTableData($conn, "Backgrounds");
  $pathgroups = getTableData($conn, "PathGroups");
  $pathgroup_n = [];
  foreach ($pathgroups as $pathgroup) {
    array_push($pathgroup_n, $pathgroup['name']);
  }
  $paths = getTableData($conn, "Paths");

  if (!isset($_SESSION['active_menu'])) $_SESSION['active_menu'] = 'user-menu';
  if (!isset($_SESSION['USER_ID'])) $_SESSION['USER_ID'] = 0;
  if (!isset($_SESSION['NATION_ID'])) $_SESSION['NATION_ID'] = 0;
  if (!isset($_SESSION['BACKGROUND_ID'])) $_SESSION['BACKGROUND_ID'] = 0;
  if (!isset($_SESSION['PATHGROUP_ID'])) $_SESSION['PATHGROUP_ID'] = 0;
  if (!isset($_SESSION['PATH_ID'])) $_SESSION['PATH_ID'] = 0;

  if (checkLogin()) {
    $user = getUserData($conn, $_SESSION['username']);
  }
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
        if ($_SESSION['USER_ID'] !== $_POST['user_id']) $_SESSION['USER_ID'] = $_POST['user_id'];
        else
          $_SESSION['USER_ID'] = 0;
        break;

      case 'show-background':
        $_SESSION['active_menu'] = 'back-menu';
        if ($_SESSION['BACKGROUND_ID'] !== $_POST['background_id']) $_SESSION['BACKGROUND_ID'] = $_POST['background_id'];
        else
          $_SESSION['BACKGROUND_ID'] = 0;
        break;

      case 'show-path':
        $_SESSION['active_menu'] = 'path-menu';
        if (isset($_POST['path_id'])) {
          if ($_SESSION['PATH_ID'] !== $_POST['path_id']) $_SESSION['PATH_ID'] = $_POST['path_id'];
          else $_SESSION['PATH_ID'] = 0;
          $_SESSION['PATHGROUP_ID'] = 0;
        } else if (isset($_POST['pathgroup_id'])) {
          if ($_SESSION['PATHGROUP_ID'] !== $_POST['pathgroup_id']) $_SESSION['PATHGROUP_ID'] = $_POST['pathgroup_id'];
          else $_SESSION['PATHGROUP_ID'] = 0;
          $_SESSION['PATH_ID'] = 0;
        }
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
        <div id="users-btn" class="hotbar-btn" data-menu="user-menu" data-text="Felhasználók"><i class="fa-solid fa-users fa-2xl"></i></div>
        <div id="nations-btn" class="hotbar-btn" data-menu="nation-menu" data-text="Népek"><i class="fa-solid fa-flag fa-2xl"></i></div>
        <div id="backgrounds-btn" class="hotbar-btn" data-menu="back-menu" data-text="Hátterek"><i class="fa-solid fa-book-open fa-2xl"></i></div>
        <div id="paths-btn" class="hotbar-btn" data-menu="path-menu" data-text="Utak"><i class="fa-solid fa-book-journal-whills fa-2xl"></i></div>
        <div id="skills-btn" class="hotbar-btn" data-menu="skill-menu" data-text="Ismeretek"><i class="fa-solid fa-graduation-cap fa-2xl"></i></div>
        <div id="equipment-inventory-btn" class="hotbar-btn" data-menu="eq-inv-menu" data-text="Felszerelések és Tárgyak"><i class="fa-solid fa-suitcase fa-2xl"></i></div>
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
          <div id="characters" class="container" style="display: <?php echo $_SESSION['USER_ID'] !== 0 ? 'flex' : 'none'; ?>; width: 40%;">
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
                echo '<td>
                        <form action="admin.php" method="post">
                          <input type="hidden" name="nation_id" value="' . $nation['id'] . '">
                          <button type="submit" name="action" value="show-nation"><i class="fa-solid fa-gear fa-2xl"></i></button>
                        </form>
                      </td>';
                echo '</tr>';
              }
              ?>
            </table>
          </div>
          <div id="edit-nation" class="container" style="display: <?php echo $_SESSION['NATION_ID'] !== 0 ? 'flex' : 'none'; ?>">
            <?php
            if (isset($_SESSION['NATION_ID'])) {
              $nation = getNation($conn, $_SESSION['NATION_ID']);
              echo '<form action="admin.php" method="post">
                      <span class="title">Nép szerkesztése</span>
                      <label for="nation_edit_name">Nép neve<input type="text" name="nation_edit_name" id="nation_edit_name" value="' . $nation['name'] . '" ></label>
                      <label for="nation_edit_desc">Nép leírása<textarea name="nation_edit_desc" id="nation_edit_desc" value="' . $nation['description'] . '"></textarea></label>
                      <button class="button" name="action" value="edit-nation" type="submit">Mentés</button>
                    </form>';
            }
            ?>
          </div>
          <div id="add-nation" class="container">
            <span class="title">Nép létrehozása</span>
            <form class="add-form" action="add.php" method="post">
              <label for="nation-name">Nép neve
                <input type="text" name="nation-name" id="nation-name" maxlength="30"></label>
              <label for="nation-desc">Nép leírása
                <textarea name="nation-desc" id="nation-desc" maxlength="5000"></textarea>
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
                echo '<td>
                        <form action="admin.php" method="post">
                          <input type="hidden" name="background_id" value="' . $background['id'] . '">
                          <button type="submit" name="action" value="show-background"><i class="fa-solid fa-gear fa-2xl"></i></button>
                        </form>
                      </td>';
                echo '</tr>';
              }
              ?>
            </table>
          </div>
          <div id="edit-background" class="container" style="display: <?php echo $_SESSION['BACKGROUND_ID'] !== 0 ? 'flex' : 'none'; ?>">
            <?php
            if (isset($_SESSION['BACKGROUND_ID'])) {
              $background = getBackground($conn, $_SESSION['BACKGROUND_ID']);
              echo '<form action="admin.php" method="post">
                      <span class="title">Háttér szerkesztése</span>
                      <label for="edit-background-name">Háttér neve<input type="text" name="edit-background-name" id="edit-background-name" value="' . $background['name'] . '" ></label>
                      <label for="edit-background-desc">Háttér leírása<textarea name="edit-background-desc" id="edit-background-desc" value="' . $background['description'] . '"></textarea></label>
                      <button class="button" name="action" value="edit-background" type="submit">Mentés</button>
                    </form>';
            }
            ?>
          </div>
          <div id="add-background" class="container">
            <span class="title">Háttér létrehozása</span>
            <form class="add-form" action="add.php" method="post">
              <label for="background-name">Háttér neve
                <input type="text" name="background-name" id="background-name" maxlength="30"></label>
              <label for="background-desc">Háttér leírása
                <textarea name="background-desc" id="background-desc" maxlength="5000"></textarea>
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
                  echo '<td>
                        <form action="admin.php" method="post">
                          <input type="hidden" name="pathgroup_id" value="' . $pathgroup['id'] . '">
                          <button type="submit" name="action" value="show-path"><i class="fa-solid fa-gear fa-2xl"></i></button>
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
                  echo '<td>' . getPathGroup($path['group_id'])['name'] . '</td>';
                  echo '<td>
                        <form action="admin.php" method="post">
                          <input type="hidden" name="path_id" value="' . $path['id'] . '">
                          <button type="submit" name="action" value="show-path"><i class="fa-solid fa-gear fa-2xl"></i></button>
                        </form>
                      </td>';
                  echo '</tr>';
                }
                ?>
              </table>
            </div>
          </div>
          <div id="edit-path-container" class="container" style="display: <?php echo $_SESSION['PATHGROUP_ID'] !== 0 || $_SESSION['PATH_ID'] ? 'flex' : 'none'; ?>">
            <?php if ($_SESSION['PATH_ID'] !== 0) {
              $path = getPath($conn, $_SESSION['PATH_ID']);
              echo '<form action="admin.php" method="post">
                      <span class="title">Út szerkesztése</span>
                      <label for="edit-path-name">Út neve<input type="text" name="edit-path-name" id="edit-path-name" value="' . $path['name'] . '"></label>
                      <label for="edit-path-pathgroup">Csoport';
              createListSelect('edit-path-pathgroup', $pathgroup_n, true);
              echo '  </label>
                      <label for="edit-path-desc">Út leírása<textarea name="edit-path-desc" id="edit-path-desc" value="' . $path['description'] . '"></textarea></label>
                      <button class="button" name="action" value="edit-path" type="submit">Mentés</button>
                    </form>';
            } else if ($_SESSION['PATHGROUP_ID'] !== 0) {
              $group = getPathGroup($_SESSION['PATHGROUP_ID']);
              echo '<form action="admin.php" method="post">
                      <span class="title">Csoport szerkesztése</span>
                      <label for="edit-group-name">Csoport neve<input type="text" name="edit-group-name" id="edit-group-name" value="' . $group['name'] . '"></label>
                      <label for="edit-group-desc">Út leírása<textarea name="edit-group-desc" id="edit-group-desc" value="' . $group['description'] . '"></textarea></label>
                      <button class="button" name="action" value="edit-path" type="submit">Mentés</button>
                    </from>';
            }
            ?>
          </div>
          <div id="add-path" class="container" style="width: 50%;">
            <span class="title">Út/Csoport létrehozása</span>
            <form class="add-form" action="add.php" method="post">
              <div id="path-type" style="display: flex; gap: 1rem;">
                <label>Út<input type="radio" name="path-type" id="type-path" value="path" checked></label>
                <label>Csoport<input type="radio" name="path-type" id="type-pathgroup" value="pathgroup"></label>
              </div>
              <label for="nation-name">Út/Csoport neve
                <input type="text" name="nation-name" id="nation-name" maxlength="30"></label>
              <label for="nation-desc">Út/Csoport leírása
                <textarea name="nation-desc" id="nation-desc" maxlength="5000"></textarea>
                <button class="button" name="action" value="add-nation" type="submit">
                  Mentés
                </button>
            </form>
          </div>
        </div>
        <div id="skill-menu" class="menu"></div>
        <div id="eq-inv-menu" class="menu"></div>
      </div>
    </div>
    <script src="../js/menus.js"></script>
    <script src="../js/admin.js"></script>
  </body>

  </html>