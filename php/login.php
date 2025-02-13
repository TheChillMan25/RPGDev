<?php
include 'scripts/manager.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $conn = connectToDB();

  if (!$conn) {
    die("Connection failed.\n");
  }

  $username = isset($_POST['username']) ? trim($_POST['username']) : '';
  $password = isset($_POST['password']) ? $_POST['password'] : '';

  if (!checkExistingData($conn, 'username', $username)) {
    error("A felhasználó nem létezik!");
  } else if (!checkPsw($conn, $username, $password)) {
    error("Hibás jelszó!");
  } else {
    session_start();
    $_SESSION['username'] = $username;
    $_SESSION['loggedin'] = true;
    header("Location: ../index.php");
    exit();
  }
}
?>
<!DOCTYPE html>
<html lang="hu">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ágas és Bogas | Regisztráció</title>
  <link rel="icon" href="../img/assets/icons/icon.png" />
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="../css/login.css" />
  <script src="https://kit.fontawesome.com/62786e1e62.js" crossorigin="anonymous"></script>
</head>

<body>
  <span id="title">Bejelentkezés</span>
  <div id="container">
    <div id="form-container">
      <form action="login.php" method="post">
        <label for="username">Felhasználónév</label>
        <input type="text" name="username" id="username" placeholder="Username123" required />
        <label for="password">Jelszó</label>
        <input type="password" name="password" id="password" required />
        <input type="submit" class="button" value="Bejelentkezés" />
      </form>
    </div>
    <a href="register.php" id="to-index">Nincs még fiókom</a>
  </div>
  <script src="../js/menus.js"></script>
</body>

</html>