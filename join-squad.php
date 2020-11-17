<?php
  require 'app.php';
  $home = false;
  $my_squads = false;
  $squads = [];

  if (isset($_POST['join'])) {
    $sql = Squad::addUserToSquad($_POST['squad_id'], $user_id);
    header('location: squads.php');
  }

  $categories = Category::getAll();
  $squads = Squad::getJoinableSquadsForUser($user_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Join Squad - The Squad</title>
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
                    <button class="button-create button-create--background button-create--full">Create a squad</button>
                </div>
                <div class="pop-up-create">
                    <form class="form" method="POST" action="actions/add_squad.php" enctype="multipart/form-data">
                        <div class="form-field">
                            <label class="form-field__label" for="name">Name</label>
                            <input class="form-field__input" type="text" name="name" id="name" placeholder="Name">
                        </div>
                        <div class="form-field">
                            <label class="form-field__label" for="category">Category</label>
                            <select class="form-field__input form-field__input--right" name="category" id="category">
                                <option disabled selected>Category</option>
                                <?php foreach ($categories as $category): ?>
                                  <option value="<?= $category['category_id'] ?>"><?= $category['name'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-field">
                            <label class="form-field__label" for="synopsis">Synopsis</label>
                            <textarea class="form-field__input form-field__input--textarea" type="text" name="synopsis" id="synopsis" placeholder="Synopsis"></textarea>
                        </div>
                        <div class="form-field">
                            <label class="form-field__label" for="description">Description</label>
                            <textarea class="form-field__input form-field__input--textarea" type="text" name="description" id="description" placeholder="Description"></textarea>
                        </div>
                        <div class="form-field">
                            <input class="form-field__input" type="file" name="image" id="image">
                        </div>
                        <div class="form-field">
                            <input class="form-field__button form-field__button--background" type="submit" name="create" id="create" value="Create">
                            <input class="form-field__button form-field__button--background form-field__button--grey" type="button" name="cancel-create" id="cancel-create" value="Cancel">
                        </div>
                    </form>
                </div>
            </div>
            <div class="row cards">
                <div class="col-12">
                    <h2>Join a squad</h2>
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