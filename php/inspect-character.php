<?php
include("scripts/manager.php");
session_start();
if (checkLogin()) {
    $conn = connectToDB();
    $user = getUserData($conn, $_SESSION["username"]);
    if (!isset($_POST['id']))
        header('Location: profile.php');
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
    <link rel="icon" href="../img/assets/icons/icon.png" />
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/inspect.css" />
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
        <div id="header" class="container">
            <span id="name"><?php echo $character['name'] ?></span>
            <div id="header-container">
                <span id="nation"><?php echo getCharacterNation($conn, $character['nation_id']) ?></span>
                <span id="path"><?php echo getCharacterPath($conn, $character['path_id']) ?>
                    <?php echo $character['path_level'] ?></span>
            </div>
        </div>
        <div id="body" class="container">
            <div id="stats">
                <div id="sanity" class="main-stat-container">
                    <span class="title">Ész</span>
                    <div class="value" data-value="<?php echo $character['sanity'] ?>">
                        <?php echo $character['sanity'] ?>
                    </div>
                    <div class="btn-container">
                        <form action="inspect-character.php"><input type="hidden" name="heal" id="heal"><button
                                type="submit"><i class="fa-solid fa-heart fa-2xl" style="color: #00d103;"></i></button>
                        </form>
                        <form action="inspect-character.php"><input type="hidden" name="damage" id="damage"><button
                                type="submit"><i class="fa-solid fa-heart fa-2xl" style="color: #ff0000;"></i></button>
                        </form>
                    </div>
                </div>
                <div id="strength" class="stat"><span class="title">Erő</span>
                    <div class="value-mod-container">
                        <div class="mod" data-value="<?php calculateModifier($character['strength']) ?>">
                            <?php echo calculateModifier($character['strength']) ?>
                        </div>
                        <span class="value"><?php echo $character['strength'] ?></span>
                    </div>
                </div>
                <div id="dexterity" class="stat"><span class="title">Ügyesség</span>
                    <div class="value-mod-container">
                        <div class="mod" data-value="<?php calculateModifier($character['dexterity']) ?>">
                            <?php echo calculateModifier($character['dexterity']) ?>
                        </div>
                        <span class="value"><?php echo $character['dexterity'] ?></span>
                    </div>
                </div>
                <div id="endurance" class="stat"><span class="title">Kitartás</span>
                    <div class="value-mod-container">
                        <div class="mod" data-value="<?php calculateModifier($character['endurance']) ?>">
                            <?php echo calculateModifier($character['endurance']) ?>
                        </div>
                        <span class="value"><?php echo $character['endurance'] ?></span>
                    </div>
                </div>
                <div id="intelligence" class="stat"><span class="title">Ész</span>
                    <div class="value-mod-container">
                        <div class="mod" data-value="<?php calculateModifier($character['intelligence']) ?>">
                            <?php echo calculateModifier($character['intelligence']) ?>
                        </div>
                        <span class="value"><?php echo $character['intelligence'] ?></span>
                    </div>
                </div>
                <div id="charisma" class="stat"><span class="title">Fortély</span>
                    <div class="value-mod-container">
                        <div class="mod" data-value="<?php calculateModifier($character['charisma']) ?>">
                            <?php echo calculateModifier($character['charisma']) ?>
                        </div>
                        <span class="value"><?php echo $character['charisma'] ?></span>
                    </div>
                </div>
                <div id="willpower" class="stat"><span class="title">Akaraterő</span>
                    <div class="value-mod-container">
                        <div class="mod" data-value="<?php calculateModifier($character['willpower']) ?>">
                            <?php echo calculateModifier($character['willpower']) ?>
                        </div>
                        <span class="value"><?php echo $character['willpower'] ?></span>
                    </div>
                </div>
                <div id="health" class="main-stat-container">
                    <span class="title">Életerő</span>
                    <div class="value" data-value="<?php echo $character['health'] ?>">
                        <?php echo $character['health'] ?>
                    </div>
                    <div class="btn-container">
                        <form action="inspect-character.php"><input type="hidden" name="heal" id="heal"><button
                                type="submit"><i class="fa-solid fa-heart fa-2xl" style="color: #00d103;"></i></button>
                        </form>
                        <form action="inspect-character.php"><input type="hidden" name="damage" id="damage"><button
                                type="submit"><i class="fa-solid fa-heart fa-2xl" style="color: #ff0000;"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            <div id="other">
                <div id="knowledge">
                    <span class="title">Ismeretek</span>
                    <?php
                    for ($i = 1; $i <= 10; $i++) {
                        echo '<span class="knowledge">' . ucfirst($character['knowledge_' . $i] ?? '') . '<span class="knowledge_lvl">' . $character['knowledge_lvl_' . $i] . '</span></span>';
                    }
                    ?>
                </div>
                <div id="equipment">
                    <div id="weapons">
                        <span class="title">Fegyverek</span>
                        <div id="hands">
                            <span class="hand">
                                Bal kéz
                                <span
                                    style="padding: .5rem; font-size: large; color: whitesmoke; line-height: 1.8rem; background-color: #444; border: .2rem solid #333; border-radius: .5rem"><?php echo ucfirst($character['left_hand']) ?></span>
                            </span><span class="hand">
                                Jobb kéz
                                <span
                                    style="padding: .5rem; font-size: large; color: whitesmoke; line-height: 1.8rem; background-color: #444; border: .2rem solid #333; border-radius: .5rem"><?php echo ucfirst($character['right_hand']) ?></span>
                            </span>
                        </div>
                    </div>
                    <div id="armour">
                        <span class="title">Páncél</span>
                    </div>
                </div>
                <div id="inventory">
                    <span class="title">Tárgyak</span>
                    <?php
                    for ($i = 1; $i <= 10; $i++) {
                        echo '<span class="item">' . $character['item_' . $i] . '</span>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/menus.js"></script>
</body>

</html>