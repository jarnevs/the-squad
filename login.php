<?php
  require 'app.php';
  $error = '';

  if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = User::getUserByEmail($email);

    if (isset($user->email)) {
      if(password_verify($password, $user->password)) {
        $_SESSION['user_id'] = $user->user_id;
        header('location: squads.php');

      } else {
        $error = 'Email and/or password is wrong';
      }
    } else {
      $error = 'Email and/or password is wrong';
    }    
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - The Squad</title>
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
                    <h2 class="register-title">Login</h2>
                </div>
                <div class="col-12">
                    <p class="danger"><?= $error ?></p>
                    <form class="form form-register" method="POST" action="">
                        <div class="form-field form-field--full">
                            <label class="form-field__label" for="name">Email</label>
                            <input class="form-field__input" type="email" name="email" id="email" placeholder="Email" required>
                        </div>
                        <div class="form-field form-field--full">
                            <label class="form-field__label" for="name">Password</label>
                            <input class="form-field__input" type="password" name="password" id="password" placeholder="Password" required>
                        </div>
                        <div class="form-field">
                            <input class="form-field__button form-field__button--background" type="submit" name="login" id="login" value="Login">
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