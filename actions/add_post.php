<?php

require '../app.php';
if (isset($_POST['post'])) {
  $squad_id = $_POST['squad_id'];
  $title = $_POST['title'];
  $message = $_POST['message'];
  $tags = [];
  $post_id = 0;

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
  $params->title = $title;
  $params->message = $message;
  $params->squad_id = $squad_id;
  $params->user_id = $user_id;
  $params->photo = $photo;

  $photoPart = new stdClass();
  $photoPart->query = '';
  $photoPart->param = '';
  
  if ($photo !== '') {
    $photoPart->query = ', `image`';
    $photoPart->param = ', :image';
  }

  $post_id = Post::createNewPost($params, $photoPart);

  if (isset($_POST['tags']) && strlen($_POST['tags']) > 0) {
    $tags = explode(',', strtolower($_POST['tags']));

    foreach($tags as $tag) {
      $tagName = trim($tag);
      $tag = Tag::getTagByName($tagName);
      
      $tagId = 0;
      if (!$tag) {
        $tagId = Tag::createTag($tagName);
      } else {
        $tagId = $tag->tag_id;
      }

      Post::addTagsToPost($post_id, $tagId);
    }
  }
}

header('location: ../post-detail.php?squad_id=' . $_POST['squad_id'] . '&post_id=' . $post_id);
die();