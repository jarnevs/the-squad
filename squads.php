<?php
  require 'app.php';
  $home = true;
  $my_squads = true;
  
  $squads = Squad::getSquadsUser($user_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Squads - The Squad</title>
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
                            <li class="main-nav__item"><a class="main-nav__link" href="squads.php">Squads</a></li>
                            <?php if ($user->is_admin): ?><li class="main-nav__item"><a class="main-nav__link" href="./admin">Admin</a></li><?php endif ?>
                            <li class="main-nav__item"><a class="main-nav__link" href="logout.php">Logout</a></li>
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
                    <a href="join-squad.php" class="button-create button-create--background button-create--full">Join more squads</a>
                </div>
            </div>
            <div class="row cards">
                <div class="col-12">
                    <h2>My squads</h2>
                </div>
                <?php 
                  if (count($squads) > 0) {
                    foreach($squads as $squad) {
                      include 'views/card.php';
                    } 
                  } else {
                    echo '<p>No squads yet</p>';
                  }
                ?>
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
</body>
</html>