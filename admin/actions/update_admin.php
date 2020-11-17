<?php 
  require '../../app.php';


  if (isset($_POST['update'])) {
    User::updateAdmin($_POST['user_id']);

    header('location: ../users.php');
  }