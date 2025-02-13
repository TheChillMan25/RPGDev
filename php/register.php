<?php
include 'scripts/manager.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $conn = connectToDB();

  if (!$conn) {
    die("Connection failed.\n");
  }

  $username = isset($_POST['username']) ? $_POST['username'] : '';
  $email = isset($_POST['email']) ? $_POST['email'] : '';
  $password = isset($_POST['password']) ? $_POST['password'] : '';

  //Adatok ellenőrzése
  if (checkExistingData($conn, 'username', $username)) {
    error("A felhasználónév már foglalt!");
  } else if (strlen($username) > 16) {
    error("A felhasználónév maximum 16 karakter lehet!");
  } else if (strlen($password) < 8) {
    error("A jelszó minimum 8 karakter hosszú kell legyen!");
  } else if ($password !== $_POST['c-password']) {
    error("A két jelszó nem egyezik!");
  } else if (checkExistingData($conn, 'email', $email)) {
    error("Az email cím már foglalt!");
  } else {
    insertUserData($conn, $username, $email, $password);
    header("Location: login.php");
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
  <link rel="stylesheet" href="../css/regisztracio.css" />
  <script src="https://kit.fontawesome.com/62786e1e62.js" crossorigin="anonymous"></script>
</head>

<body>
  <span id="title">Regisztráció</span>
  <div id="container">
    <div id="form-container">
      <form action="register.php" method="post">
        <label for="username">Felhasználónév</label>
        <input type="text" name="username" id="username" placeholder="Maximum 16 karakter" required />
        <label for="email">Email cím</label>
        <input type="email" name="email" id="email" placeholder="user@example.com" required />
        <label for="password">Jelszó</label>
        <input type="password" name="password" id="password" required />
        <label for="c-password">Jelszó megerősítése</label>
        <input type="password" name="c-password" id="c-password" required />
        <input type="submit" class="button" value="Regisztráció" />
      </form>
    </div>
    <a href="login.php" id="to-index">Van már fiókom</a>
  </div>
</body>

</html>