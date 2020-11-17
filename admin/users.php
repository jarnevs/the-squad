<?php
  require '../app.php';
  
  $users = User::getAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - The Squad</title>
  <script src="https://kit.fontawesome.com/9a8699aa96.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="../css/bootstrap-grid.css">
  <link rel="stylesheet" href="../css/main.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6">
                    <h1 class="logo"><a href="#"><img src="../assets/logo/logo.svg" alt=""></a></h1>
                </div>
                <div class="col-6">
                    <nav class="main-nav">
                        <ul class="main-nav__list">
                            <li class="main-nav__item"><a class="main-nav__link" href="../squads.php">Squads</a></li>
                            <?php if ($user->is_admin): ?><li class="main-nav__item"><a class="main-nav__link" href="index.php">Admin</a></li><?php endif ?>
                            <li class="main-nav__item"><a class="main-nav__link" href="../logout.php">Logout</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="container">
          <div class="row">
            <div class="col-12">
                <nav class="admin-nav">
                    <ul class="admin-nav__list">
                        <li class="admin-nav__item"><a class="admin-nav__link" href="index.php">Squads</a></li>
                        <li class="admin-nav__item"><a class="admin-nav__link" href="users.php">Users</a></li>
                        <li class="admin-nav__item"><a class="admin-nav__link" href="tags.php">Tags</a></li>
                    </ul>
                </nav>
              </div>
            </div>
            <div class="row messages">
                <div class="col-12">
                    <h2>User control</h2>
                </div>
                <div class="col-12">
                  <?php foreach($users as $user): ?>
                  <div class="user">
                    <h3 class="user__username"><?= $user['username']  ?></h3>
                    <?php 
                      // $user['is_admin'] = (bool) $user['is_admin'];
                      if (!$user['is_admin']): 
                    ?>
                    <div class="user__buttons">
                      <form action="actions/update_admin.php" method="POST">
                        <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                        <input class="form-field__button form-field__button--background button-join--user" type="submit" name="update" id="update" value="Make admin">
                      </form>
                      <form action="actions/delete_user.php" method="POST">
                        <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                        <input class="form-field__button form-field__button--background button-join--grey button-join--user" type="submit" name="delete" id="delete" value="Delete">
                      </form>
                    </div>
                    <?php endif ?>
                    <?php if ($user['user_id'] === $user_id): ?>
                      <p>This user is you</p>
                    <?php endif ?>
                    <?php if ($user['is_admin']): ?>
                      <p>This user is admin</p>
                    <?php endif ?>
                  </div>
                  <?php endforeach ?>
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