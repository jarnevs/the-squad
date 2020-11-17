<?php
  require '../../app.php';

  if (isset($_POST['delete'])) {
    User::deleteById($_POST['user_id']);

    header('location: ../users.php');
  }