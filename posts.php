git <?php
  require 'app.php';
  
  $temp_posts = [];

  $squad_id = $_GET['squad_id'] ?? 0;
  $search = $_GET['search'] ?? '';
  $page = $_GET['page'] ?? 1;
  $sort = $_GET['sort_on'] ?? '';

  $searchTerm = '%' . $search . '%';
  $offset = $page * 10 - 10;

  if ($squad_id !== 0) {
    $squad = Squad::getById($squad_id);

    $order = ' ORDER BY `created_on` DESC';
    if ($sort === 'likes') {
      $order = ' ORDER BY `likes` DESC';
    } else if ($sort === 'alphabetical') {
      $order = ' ORDER BY `title` ASC';
    }

    $filter = new stdClass();
    $filter->query = '';
    if ($search !== '') {
      $filter->query = ' AND `post_has_tag`.`tag_id` IN (SELECT `tag_id` FROM `tags` WHERE `name` LIKE :search)';
      $filter->param = $searchTerm;
    }

    $limit = new stdClass();
    $limit->offset = $offset;
    $limit->amount = 10;
    
    $posts = Post::getPostsWithFilterAndOrder($limit, $order, $filter, $squad_id);

    foreach ($posts as &$post) {
      $post['comment_count'] = Post::countComments($post['post_id']);
      $post['tags'] = Tag::getTagsForPost($post['post_id']);
      $post['user'] = User::getById($post['creator_user_id']);
    }

    $postCount = Post::countPosts($filter, $squad_id);
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $squad->name ?> - The Squad</title>
  <script src="https://kit.fontawesome.com/9a8699aa96.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="css/bootstrap-grid.css">
  <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6">
                    <h1 class="logo"><a href="#"><img src="assets/logo/logo.svg" alt=""></a></h1>
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
    <main>
        <div class="overlay overlay--hide"></div>
        <div class="posts-banner">
            <div class="posts-banner__image">
                <img src="assets/images/<?= $squad->image ?>" alt="">
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
            <div class="row form-row">
                <div class="col-12">
                    <button class="button-create button-create--background button-create--full button-create--lessmargin">New post</button>
                </div>
                <div class="pop-up-create">
                    <form class="form" method="POST" action="actions/add_post.php" enctype="multipart/form-data">
                        <input type="hidden" name="squad_id" value="<?= $squad_id ?>">
                        <div class="form-field form-field--full">
                            <label class="form-field__label" for="title">Title</label>
                            <input class="form-field__input" type="text" name="title" id="title" placeholder="Title">
                        </div>
                        <div class="form-field form-field--full">
                            <label class="form-field__label" for="message">Message</label>
                            <textarea class="form-field__input form-field__input--textarea" name="message" id="message" placeholder="Message"></textarea>
                        </div>
                        <div class="form-field">
                            <label class="form-field__label" for="tags">Tags</label>
                            <input class="form-field__input" type="text" name="tags" id="tags" placeholder="Tag1, tag2, ...">
                        </div>
                        <div class="form-field">
                            <input class="form-field__input form-field__input--extra" type="file" name="image" id="image">
                        </div>
                        <div class="form-field">
                            <input class="form-field__button form-field__button--background" type="submit" name="post" id="post" value="Post">
                            <input class="form-field__button form-field__button--background form-field__button--grey" type="button" name="cancel-create" id="cancel-create" value="Cancel">
                        </div>
                    </form>
                </div>
            </div>
            <div class="row messages">
                <div class="col-3">
                    <div class="filter">
                        <form class="form" method="GET" action="">
                            <input type="hidden" name="squad_id" value="<?= $squad_id ?>">
                            <div class="form-field form-field--full">
                                <label class="form-field__label form-field__label--filter" for="name">Sort</label>
                                <select class="form-field__input" name="sort_on" id="sort_on">
                                    <option <?= $sort === 'recent' ? 'selected' : '' ?> value="recent">Most recent</option>
                                    <option <?= $sort === 'likes' ? 'selected' : '' ?> value="likes">Most Likes</option>
                                    <option <?= $sort === 'alphabetical' ? 'selected' : '' ?> value="alphabetical">A to Z</option>
                                </select>
                            </div>
                            <input type="hidden" name="search" value="<?= $search ?>">
                            <div class="form-field">
                                <input class="form-field__button form-field__button--background form-field__button--full form-field__button--lessmargin" type="submit" id="sort" value="Sort">
                            </div>
                        </form>
                        <form class="form" method="GET" action="">
                            <input type="hidden" name="squad_id" value="<?= $squad_id ?>">
                            <input type="hidden" name="sort_on" value="<?= $sort ?>">
                            <div class="form-field form-field--full">
                                <label class="form-field__label form-field__label--filter" for="name">Filter</label>
                                <input class="form-field__input" type="text" name="search" id="search" placeholder="Search tags" value="<?= $search !== '' ? $search : '' ?>">
                            </div>
                            <div class="form-field">
                                <input class="form-field__button form-field__button--background form-field__button--full form-field__button--lessmargin" type="submit" id="search-btn" value="Search">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-9">
                    <div class="message-cards">
                      <?php 
                      foreach($posts as &$post) {
                        include 'views/card-message.php';
                      } 
                      ?>                        
                    </div>
                    <?php if ($postCount > 0): ?>
                      <div class="pagination">
                        <?php if($page > 1): ?>
                        <div class="pagination__arrow-next">
                            <a href="posts.php?squad_id=<?= $squad_id ?>&page=<?= $page - 1 ?><?= $sort !== '' ? '&sort_on=' . $sort : '' ?><?= $search !== '' ? '&search=' . $search : '' ?>"><i class="fas fa-caret-square-left"></i></a>
                        </div>
                        <?php endif ?>
                        <div class="pagination__numbers">
                            <?php 
                              $pageNumber = 0;
                              
                              for ($i = 0; $i < $postCount; $i+=10):
                                $pageNumber += 1;
                            ?>
                            <a href="posts.php?squad_id=<?= $squad_id ?>&page=<?= $pageNumber ?><?= $sort !== '' ? '&sort_on=' . $sort : '' ?><?= $search !== '' ? '&search=' . $search : '' ?>"><?= $pageNumber ?></a>
                            <?php
                              endfor
                            ?>
                        </div>
                        <?php if($page < $postCount / 10): ?>
                        <div class="pagination__arrow-next">
                            <a href="posts.php?squad_id=<?= $squad_id ?>&page=<?= $page + 1 ?><?= $sort !== '' ? '&sort_on=' . $sort : '' ?><?= $search !== '' ? '&search=' . $search : '' ?>"><i class="fas fa-caret-square-right"></i></a>
                        </div>
                        <?php endif ?>
                    </div>
                    <?php endif ?>
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