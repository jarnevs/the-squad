<?php   
  require '../app.php';

  if (isset($_POST['create'])) {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $synopsis = $_POST['synopsis'];
    $description = $_POST['description'];

    $photo = '';

    if( isset($_FILES['image']) && $_FILES['image']['size'] > 0 ) {

      $upload_dir = '../assets/images/';
      if( ! is_dir( $upload_dir ) ) {
          mkdir( $upload_dir, 0777);
      }
  
      $tmp_location = $_FILES['image']['tmp_name'];
      $old_name = $_FILES['image']['name'];
      $file_type = $_FILES['image']['type'];
      $file_info = pathinfo($old_name);
      $extension = $file_info['extension'];
      
      if (in_array($file_type, ['image/jpeg', 'image/png', 'image/gif'])) {
          $photo = $file_info['filename'] . '-' . uniqid() . '.' . $file_info['extension'];
          $new_location = $upload_dir . $photo;
  
          move_uploaded_file($tmp_location, $new_location);
      }
    }

    $params = new stdClass();
    $params->name = $name;
    $params->synopsis = $synopsis;
    $params->description = $description;
    $params->image = $photo;
    $params->category = $category;

    $squad_id = Squad::createNewSquad($params);
    Squad::addUserToSquad($squad_id, $user_id);

    header('location: ../squads.php');
  }