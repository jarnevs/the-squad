<?php
  require '../app.php';

  print_r(isset($_POST['post']));

  if (isset($_POST['post'])) {
    $params = new stdClass();
    $params->message = $_POST['message'];
    $params->squad_id = $_POST['squad_id'];
    $params->user_id = $user_id;
    $params->post_id = $_POST['parent_post_id'];

    Post::addNewComment($params);

    header('location: ../post-detail.php?squad_id=' . $_POST['squad_id'] . '&post_id=' . $_POST['parent_post_id']);
  }