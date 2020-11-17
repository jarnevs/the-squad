<?php
  session_start();
  require 'config/config.php';
  require 'db/db.php';
  require 'models/BaseModel.php';
  require 'models/CategoryModel.php';
  require 'models/SquadModel.php';
  require 'models/PostModel.php';
  require 'models/TagModel.php';
  require 'models/UserModel.php';

  $user = '';
  $user_id = $_SESSION['user_id'] ?? 0;

  if ($user_id > 0) {
    $user = User::getById($user_id);
  }