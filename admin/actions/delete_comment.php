<?php 
  require '../../app.php';

  if (isset($_POST['delete'])) {
    $post_id = (int) $_POST['post_id'];
    $parent_post_id = (int) $_POST['parent_post_id'];
    $squad_id = (int) $_POST['squad_id'];

    Post::deleteById($post_id);

    header('location: ../post-detail.php?squad_id=' . $squad_id . '&post_id=' . $parent_post_id);
  }