<?php 
  require 'app.php';
  $home = true;
  $my_squads = false;

  $squads = Squad::getSquadsWithLimitAndOrder(6, 'DESC');
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home - The Squad</title>
  <script src="https://kit.fontawesome.com/9a8699aa96.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="css/bootstrap-grid.css">
  <link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6 col-md-6">
                    <h1 class="logo"><a href="#"><img src="./assets/logo/logo.svg" alt=""></a></h1>
                </div>
                <div class="col-6 col-md-6">
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
    <main>
        <div class="home-banner">
            <div class="overlay-home"></div>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="home-banner__container">
                            <div class="home-head">
                                <h2 class="bigger">Join now and talk with<br>your friends</h2>
                                <div class="home-head__buttons">
                                    <a href="register.php" class="home-head__button home-head__button--background">Join now</a>
                                    <a href="login.php" class="home-head__button">Sign in</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row cards">
                <div class="col-12">
                    <h2>Recently added squads</h2>
                </div>
                <?php 
                foreach($squads as $squad) {
                  include 'views/card.php';
                } 
                ?>
            </div>
        </div>
    </main>
    <footer>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                    <p>&copy; 2020 - Jarne Van Steendam</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>