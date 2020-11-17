<?php
  require '../../app.php';

  if (isset($_POST['delete'])) {
    $squad_id = $_POST['squad_id'];

    Squad::deleteById($squad_id);
    Squad::deleteUsersFromSquad($squad_id);
    Post::deletePostsFromSquad($squad_id);

    header('location: ../index.php');
  }