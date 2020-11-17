<?php 
  require '../../app.php';

  if (isset($_POST['delete'])) {
    $post_id = (int) $_POST['post_id'];
    $squad_id = (int) $_POST['squad_id'];

    Post::deleteById($post_id);
    Post::deleteComments($post_id);
    Post::deleteTagsForPost($post_id);

    header('location: ../posts.php?squad_id=' . $squad_id);
  }