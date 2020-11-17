<?php
  require 'app.php';
  $error = '';

  if (isset($_POST['register'])) {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $repeat_password = $_POST['repeat_password'];

    $count_email = User::checkIfUserExists('`email`', $email);
    $count_username = User::checkIfUserExists('`username`', $username);

    var_dump($count_username);

    if ($count_email > 0) {
      $error = 'Email "' . $email .  '" already used';
    } else if ($count_username > 0) {
      $error = 'Username "' . $username .  '" already used';
    } else if ($password !== $repeat_password) {
      $error = 'Passwords do not match';
    } else {
      $password_hash = password_hash($password, PASSWORD_DEFAULT);

      $user_id = User::createNewUser($email, $username, $password_hash);
      $_SESSION['user_id'] = $user_id;

      header('location: join-squad.php');
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - The Squad</title>
  <script src="https://kit.fontawesome.com/9a8699aa96.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="css/bootstrap-grid.css">
  <link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6">
                    <h1 class="logo"><a href="#"><img src="./assets/logo/logo.svg" alt=""></a></h1>
                </div>
                <div class="col-6">
                    <nav class="main-nav">
                        <ul class="main-nav__list">
                            <li class="main-nav__item"><a class="main-nav__link" href="register.php">Register</a></li>
                            <li class="main-nav__item"><a class="main-nav__link" href="login.php">Login</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <main class="main">
        <div class="overlay overlay--hide"></div>
        <div class="container">
            <div class="row form-row">
                <div class="col-12">
                    <h2 class="register-title">Register</h2>
                </div>
                <div class="col-12">
                    <p class="danger"><?= $error ?></p>
                    <form class="form form-register" method="POST" action="">
                        <div class="form-field form-field--full">
                            <label class="form-field__label" for="name">Email</label>
                            <input class="form-field__input" type="email" name="email" id="email" placeholder="Email" required>
                        </div>
                        <div class="form-field form-field--full">
                            <label class="form-field__label" for="name">Username</label>
                            <input class="form-field__input" type="text" name="username" id="username" placeholder="Username" required>
                        </div>
                        <div class="form-field form-field--full">
                            <label class="form-field__label" for="name">Password</label>
                            <input class="form-field__input" type="password" name="password" id="password" placeholder="Password" required>
                        </div>
                        <div class="form-field form-field--full">
                            <label class="form-field__label" for="name">Repeat password</label>
                            <input class="form-field__input" type="password" name="repeat_password" id="repeat_password" placeholder="Repeat password" required>
                        </div>
                        <div class="form-field">
                            <input class="form-field__button form-field__button--background" type="submit" name="register" id="register" value="Register">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <p>&copy; 2020 - Jarne Van Steendam</p>
                </div>
            </div>
        </div>
    </footer>
    <script src="js/main.js"></script>
</body>
</html>
</body>
</html>