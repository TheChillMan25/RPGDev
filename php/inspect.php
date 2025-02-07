<?php
include("scripts/manager.php");
session_start();

if (checkLogin()) {
    $conn = connectToDB();
    $user = getUserData($conn, $_SESSION["username"]);

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
        $_SESSION['character_id'] = $_POST['id'];
    }

    $character_id = $_SESSION['character_id'] ?? null;

    if ($character_id) {
        $character = getCharacterData($conn, $character_id);

        if (isset($_POST['sanity_action']) || isset($_POST['health_action'])) {
            $health = $character['health'];
            $sanity = $character['sanity'];
            $amount = intval($_POST['amount']);

            if (isset($_POST['sanity_action'])) {
                if ($_POST['sanity_action'] == 'heal') {
                    if ($sanity + $amount > $character['max_sanity']) {
                        $sanity = $character['max_sanity'];
                    } else {
                        $sanity += $amount;
                    }
                } else if ($_POST['sanity_action'] == 'damage') {
                    if ($sanity - $amount <= 0) {
                        $sanity = 0;
                    } else {
                        $sanity -= $amount;
                    }
                }
            }

            if (isset($_POST['health_action'])) {
                if ($_POST['health_action'] == 'heal') {
                    if ($health + $amount > $character['max_health']) {
                        $health = $character['max_health'];
                    } else {
                        $health += $amount;
                    }
                } else if ($_POST['health_action'] == 'damage') {
                    if ($health - $amount <= 0) {
                        $health = 0;
                    } else {
                        $health -= $amount;
                    }
                }
            }

            $stmt = $conn->prepare('UPDATE Stats SET health = ?, sanity = ? WHERE character_id = ?');
            $stmt->bind_param('iii', $health, $sanity, $character_id);

            if ($stmt->execute() === TRUE) {
                $stmt->close();
                header('Location: inspect.php');
                exit();
            } else {
                die('Could not update main stat! ' . $conn->error);
            }
        }
    } else {
        header('Location: profile.php');
        exit();
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
        <div id="header" class="container">
            <span id="name"><?php echo $character['name'] ?></span>
            <div id="header-container">
                <span id="nation"><?php echo getCharacterNation($conn, $character['nation_id']) ?></span>
                <span id="path"><?php echo getPath($conn, $character['path_id']) ?>
                    <?php echo $character['path_level'] ?></span>
            </div>
        </div>
        <div id="body" class="container">
            <div id="stats">
                <div id="sanity" class="main-stat-container">
                    <span class="title">Elme</span>
                    <div class="value">
                        <?php echo $character['sanity'] . '/' . $character['max_sanity'] ?>
                    </div>
                    <form action="inspect.php" method="post" id="sanity-form" class="form">
                        <button type="submit" name="sanity_action" value="heal" class="heal main-stat-btn"><i
                                class="fa-solid fa-heart fa-2xl"></i></button>
                        <input type="number" name="amount" id="amount" min="0" value="0">
                        <input type="hidden" name="character_id" value="<?php echo $character['id'] ?>">
                        <button type="submit" name="sanity_action" value="damage" class="damage main-stat-btn"><i
                                class="fa-solid fa-heart-crack fa-2xl"></i>
                        </button>
                    </form>
                </div>
                <div id="strength" class="stat" data-value="<?php calculateModifier($character['strength']) ?>"><span
                        class="title">Erő</span>
                    <div class="value-mod-container">
                        <span class="value"><?php echo $character['strength'] ?></span>
                        <div class="mod">
                            <?php echo calculateModifier($character['strength']) ?>
                        </div>
                    </div>
                </div>
                <div id="dexterity" class="stat" data-value="<?php calculateModifier($character['dexterity']) ?>"><span
                        class="title">Ügyesség</span>
                    <div class="value-mod-container">
                        <span class="value"><?php echo $character['dexterity'] ?></span>
                        <div class="mod">
                            <?php echo calculateModifier($character['dexterity']) ?>
                        </div>
                    </div>
                </div>
                <div id="endurance" class="stat" data-value="<?php calculateModifier($character['endurance']) ?>"><span
                        class="title">Kitartás</span>
                    <div class="value-mod-container">
                        <span class="value"><?php echo $character['endurance'] ?></span>
                        <div class="mod">
                            <?php echo calculateModifier($character['endurance']) ?>
                        </div>
                    </div>
                </div>
                <div id="intelligence" class="stat" data-value="<?php calculateModifier($character['intelligence']) ?>">
                    <span class="title">Ész</span>
                    <div class="value-mod-container">
                        <span class="value"><?php echo $character['intelligence'] ?></span>
                        <div class="mod">
                            <?php echo calculateModifier($character['intelligence']) ?>
                        </div>
                    </div>
                </div>
                <div id="charisma" class="stat" data-value="<?php calculateModifier($character['charisma']) ?>"><span
                        class="title">Fortély</span>
                    <div class="value-mod-container">
                        <span class="value"><?php echo $character['charisma'] ?></span>
                        <div class="mod">
                            <?php echo calculateModifier($character['charisma']) ?>
                        </div>
                    </div>
                </div>
                <div id="willpower" class="stat" data-value="<?php calculateModifier($character['willpower']) ?>"><span
                        class="title">Akaraterő</span>
                    <div class="value-mod-container">
                        <span class="value"><?php echo $character['willpower'] ?></span>
                        <div class="mod">
                            <?php echo calculateModifier($character['willpower']) ?>
                        </div>
                    </div>
                </div>
                <div id="health" class="main-stat-container">
                    <span class="title">Életerő</span>
                    <div class="value">
                        <?php echo $character['health'] . '/' . $character['max_health'] ?>
                    </div>
                    <form action="inspect.php" method="post" id="health-form" class="form">
                        <button type="submit" name="health_action" value="heal" class="heal main-stat-btn"><i
                                class="fa-solid fa-heart fa-2xl"></i></button>
                        <input type="number" name="amount" id="amount" min="0" value="0">
                        <input type="hidden" name="character_id" value="<?php echo $character['id'] ?>">
                        <button type="submit" name="health_action" value="damage" class="damage main-stat-btn"><i
                                class="fa-solid fa-heart-crack fa-2xl"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div id="other">
                <div id="knowledge" class="body-container">
                    <span class="title" style="font-size: x-large">Ismeretek</span>
                    <div id="knowledge-container" class="body-item-container">
                        <?php
                        $skills = getSkills($conn);
                        for ($i = 1; $i <= 10; $i++) {
                            echo '<span class="body-container-item knowledge">' . $skills[$i - 1]['name'] . '<span class="knowledge_lvl" style="color: whitesmoke">' . $character['skill_' . $i . '_lvl'] . '</span></span>';
                        }
                        ?>
                    </div>
                </div>
                <div id="equipment">
                    <div id="weapons">
                        <span class="title" style="font-size:x-large">Fegyverek</span>
                        <div id="hands">
                            <span class="hand">
                                Bal kéz
                                <span class="weapon">
                                    <?php
                                    $left_hand = getGear($conn, "Weapons", $character['left_hand']);
                                    echo ucfirst($left_hand['name']);
                                    ?>
                                </span>
                            </span><span class="hand">
                                Jobb kéz
                                <span class="weapon">
                                    <?php
                                    $right_hand = getGear($conn, "Weapons", $character['right_hand']);
                                    echo ucfirst($right_hand['name']);
                                    ?>
                                </span>
                            </span>
                        </div>
                    </div>
                    <div id="armour">
                        <span class="title" style="font-size: x-large">Páncél</span>
                        <span class="shield">
                            <?php
                            $armour = getGear($conn, "Armour", $character['armour']);
                            /* foreach ($armour as $key => $value) {
                                echo $key . ' - ' . $value . '<br>';
                            } */
                            ?>
                            <span class="title"
                                style="color:whitesmoke; font-size: larger"><?php echo $armour['name'] ?></span>
                            <div class="value-mod-container" style="gap: 2rem">
                                <div class="value" style="font-size:larger"><?php echo $armour['value'] ?></div>
                                <div class="mod" style="width: 4rem; height: 3rem;">
                                    <?php echo $armour['dex_mod'] ?>
                                </div>
                            </div>
                        </span>
                    </div>
                </div>
                <div id="inventory" class="body-container">
                    <span class="title" style="font-size: x-large">Tárgyak</span>
                    <div id="item-container" class="body-item-container">
                        <?php
                        for ($i = 1; $i <= 10; $i++) {
                            $item = getGear($conn, "Items", $character['item_' . $i . '_id']);
                            echo '<span class="body-container-item item">
                        ' . $item['name'] . '
                        <!--<span class="item-desc" style="display: none">' . $item['description'] . '</span>-->
                        </span>';
                        }
                        ?>
                    </div>
                    <!-- <span class="item-desc"></span> -->
                </div>
            </div>
        </div>
    </div>
    <script src="../js/menus.js"></script>
</body>

</html>