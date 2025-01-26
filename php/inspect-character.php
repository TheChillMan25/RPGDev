<?php
include("scripts/manager.php");
session_start();
if (checkLogin()) {
    $conn = connectToDB();
    $user = getUserData($conn, $_SESSION["username"]);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $character = getCharacterData($conn, $_POST['id']);
    }
} else {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ágas és Bogas | Karakter</title>
    <link rel="icon" href="../img/icon.png" />
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/inspect.css" />
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
        <div id="sidebar">
            <div class="sidebar-container">
                <button class="sidebar-btn">
                    <i class="fa-solid fa-address-card fa-2xl"></i>
                </button>
            </div>
            <div class="sidebar-container">
                <a class="sidebar-btn" href="terkep.php">
                    <i class="fa-solid fa-map-location-dot fa-2xl"></i>
                </a>
            </div>
            <div class="sidebar-container">
                <button class="sidebar-btn">
                    <i class="fa-solid fa-briefcase fa-2xl"></i>
                </button>
            </div>
            <div id="edit" class="sidebar-container" action="" method="post">
                <button class="sidebar-btn">
                    <i class="fa-solid fa-book fa-2xl"></i>
                </button>
            </div>
            <form id="delete" class="sidebar-container" action="scripts/delete-character.php" method="post">
                <input type="hidden" name="id" id="id" value="<?php echo $character['id']; ?>" />
                <button class="sidebar-btn">
                    <i class="fa-solid fa-trash fa-2xl"></i>
                </button>
            </form>
        </div>
        <div id="content">
            <div id="character-header" class="container">
                <span id="name"><?php echo $character['name'] ?></span>
                <div class="nation-path-container">
                    <span id="nation"><?php echo $character['nation'] ?></span>
                    <div id="path-container">
                        <span class="path"><?php echo $character['path']; ?></span>
                        <span class="path-level">"<?php echo $character['level']; ?>"</span>
                    </div>
                </div>
                <div id="character-stats">
                    <span id="stat-txt">Tulajdonságok</span>
                    <div class="stat">
                        Erő
                        <div class="value-container">
                            <span class="value">
                                <?php echo $character['strength'] ?>
                            </span>
                            <span class="modifier">
                                <?php echo $character['strength_mod'] ?>
                            </span>
                        </div>
                    </div>
                    <div class="stat">
                        Ügyesség
                        <div class="value-container">
                            <span class="value">
                                <?php echo $character['dexterity'] ?>
                            </span>
                            <span class="modifier">
                                <?php echo $character['dexterity_mod'] ?>
                            </span>
                        </div>
                    </div>
                    <div class="stat">
                        Kitartás
                        <div class="value-container">
                            <span class="value">
                                <?php echo $character['endurance'] ?>
                            </span>
                            <span class="modifier">
                                <?php echo $character['endurance_mod'] ?>
                            </span>
                        </div>
                    </div>
                    <div class="stat">
                        Ész
                        <div class="value-container">
                            <span class="value">
                                <?php echo $character['intelligence'] ?>
                            </span>
                            <span class="modifier">
                                <?php echo $character['intelligence_mod'] ?>
                            </span>
                        </div>
                    </div>
                    <div class="stat">
                        Fortély
                        <div class="value-container">
                            <span class="value">
                                <?php echo $character['charisma'] ?>
                            </span>
                            <span class="modifier">
                                <?php echo $character['charisma_mod'] ?>
                            </span>
                        </div>
                    </div>
                    <div class="stat">
                        Akaraterő
                        <div class="value-container">
                            <span class="value">
                                <?php echo $character['willpower'] ?>
                            </span>
                            <span class="modifier">
                                <?php echo $character['willpower_mod'] ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div id="character-body">
                <div id="character-knowledge" class="container">
                    <span class="knowledge">Ismeretek</span>
                    <div id="knowledge-container">
                        <?php
                        $j = 1;
                        for ($i = 20; $i < 30; $i++) {
                            if (empty(!$character['knowledge_' . $j])) {
                                echo '<span class="knowledge">' . $character['knowledge_' . $j] . '<span class="knowledge_lvl">' . $character['knowledge_lvl_' . $j] . '</span></span>';
                            }
                            $j++;
                        }
                        ?>
                    </div>
                </div>
                <div id="character-inventory" class="container">
                    <span class="weapons">
                        Fegyverek
                        <div id="weapons">
                            <span id="left"><?php echo $character['left_hand'] ?></span>
                            <span id="right"><?php echo $character['right_hand'] ?></span>
                        </div>
                    </span>
                    <span id="armour">
                        Páncél
                        <span><?php echo strtolower($character['armour']) ?></span>
                    </span>
                    <div id="inventory">
                        <?php
                        foreach ($character as $key => $value) {
                            if (str_contains($key, 'item')) {
                                echo '<span class="item">' . $value . '</span>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/menus.js"></script>
</body>

</html>