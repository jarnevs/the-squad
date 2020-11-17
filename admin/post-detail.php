<?php
  require '../app.php';

  $squad_id = $_GET['squad_id'] ?? 0;
  $post_id = $_GET['post_id'] ?? 0;

  if (isset($_POST['add_like'])) {
    Post::updateLikes($_POST['likes'], $post_id);
  }

  $squad = Squad::getById($squad_id);
  $post = Post::getPost($post_id);
  $post->comment_count = Post::countComments($post_id);
  $post->tags = Tag::getTagsForPost($post_id);
  $post->comments = Post::getComments($post_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $squad->name ?> - The Squad</title>
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
        </div>
        <div class="posts-banner">
            <div class="posts-banner__image">
                <img src="../assets/images/<?= $squad->image ?>" alt="">
            </div>
            <div class="posts-banner__overlay"></div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="bigger posts-title"><?= $squad->name ?></h2>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card-message">
                        <div class="card-message__head">
                            <h3><?= $post->title ?></h3>
                            <p class="card-message__publish-info"><?= $post->username ?? '[USER DELETED]' ?> - <?= $post->created_on ?></p>
                        </div>
                        <?php if ($post->message !== null): ?>
                        <div class="card-message__content">
                            <p><?= $post->message ?></p>
                        </div>
                        <?php endif ?>
                        <?php if($post->image !== null): ?>
                        <div class="card-message__image">
                            <img src="../assets/images/<?= $post->image ?>" alt="">
                        </div>
                        <?php endif ?>
                        <div class="card-message__tags">
                            <?php foreach($post->tags as $tag): ?>
                            <span class="card-message__tag" href="#"><?= $tag['name'] ?></span>
                            <?php endforeach ?>
                        </div>
                        <div class="card-message__rating">
                            <div class="card-message__likes">
                                <i class="fas fa-heart"></i>
                                <span><?= $post->likes ?></span>
                            </div>
                            <div class="card-message__comment">
                                <i class="fas fa-comment"></i>
                                <span><?= $post->comment_count ?></span>
                            </div>
                        </div>
                        <div class="card-message__comments">
                            <div class="comments">
                                <?php foreach($post->comments as $comment): ?>
                                <div class="comment">
                                    <div class="comment__content">
                                        <p class="comment__text"><?= $comment['message'] ?></p>
                                        <p class="comment__publish-info"><?= $comment['username'] ?> - <?= $comment['created_on'] ?></p>
                                    </div>
                                    <form action="actions/delete_comment.php" method="POST">
                                      <input type="hidden" name="squad_id" value="<?= $comment['squad_id'] ?>">
                                      <input type="hidden" name="post_id" value="<?= $comment['post_id'] ?>">
                                      <input type="hidden" name="parent_post_id" value="<?= $comment['parent_post_id'] ?>">
                                      <input class="form-field__button form-field__button--background button-join--small" type="submit" name="delete" id="delete" value="Delete">
                                    </form>
                                </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
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
</body>
</html>