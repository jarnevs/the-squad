<?php
  require '../../app.php';

  if (isset($_POST['delete'])) {
    $tag_id = $_POST['tag_id'];

    Tag::deleteById($tag_id);
    Tag::deleteTagFromPost($tag_id);

    header('location: ../tags.php');
  }