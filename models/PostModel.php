<?php
  class Post extends BaseModel {
    protected $table = 'posts';
    protected $pk = 'post_id';

    public static function getPostsWithFilterAndOrder ($limit, string $order, $filter, int $squad_id) {
      global $db;

      $sql = 'SELECT DISTINCT `posts`.*
              FROM `posts` LEFT JOIN `post_has_tag` ON `posts`.`post_id` = `post_has_tag`.`post_id` 
              WHERE (`posts`.`squad_id` = :squad_id) AND (`posts`.`parent_post_id` IS NULL)' . $filter->query . $order . ' LIMIT :offset, :limit';
      $pdo_statement = $db->prepare($sql);
      $pdo_statement->bindParam(':squad_id', $squad_id, PDO::PARAM_INT);
      $pdo_statement->bindParam(':offset', $limit->offset, PDO::PARAM_INT);
      $pdo_statement->bindParam(':limit', $limit->amount, PDO::PARAM_INT);
      if ($filter->query !== '') {
        $pdo_statement->bindParam(':search', $filter->param);
      }
      $pdo_statement->execute();
      return $pdo_statement->fetchAll();
    }

    public static function countPosts($filter, int $squad_id) {
      global $db;

      $sql = 'SELECT COUNT(DISTINCT `posts`.`post_id`) AS `post_count`
              FROM `posts` LEFT JOIN `post_has_tag` ON `posts`.`post_id` = `post_has_tag`.`post_id` 
              WHERE (`posts`.`squad_id` = :squad_id) AND (`posts`.`parent_post_id` IS NULL)' . $filter->query;
      $pdo_statement = $db->prepare($sql);
      $pdo_statement->bindParam(':squad_id', $squad_id, PDO::PARAM_INT);
      if ($filter->query !== '') {
        $pdo_statement->bindParam(':search', $filter->param);
      }
      $pdo_statement->execute();
      return $pdo_statement->fetchColumn();
    }

    public static function countComments(int $post_id) {
      global $db;

      $sql = 'SELECT COUNT(*) as `comment_count` FROM `posts` WHERE `parent_post_id` = :post_id';
      $pdo_statement = $db->prepare($sql);
      $pdo_statement->execute([
        ':post_id' => $post_id,
      ]);
      return $pdo_statement->fetchColumn();
    }

    public static function getComments(int $post_id) {
      global $db;

      $sql = 'SELECT * FROM `posts` INNER JOIN `user` ON `posts`.`creator_user_id` = `user`.`user_id` WHERE `posts`.`parent_post_id` = :post_id ORDER BY `created_on` DESC';
      $pdo_statement = $db->prepare($sql);
      $pdo_statement->execute([
        ':post_id' => $post_id,
      ]);
      return $pdo_statement->fetchAll();
    }

    public static function getPost(int $post_id) {
      global $db;

      $sql = 'SELECT * FROM `posts` LEFT JOIN `user` ON `posts`.`creator_user_id` = `user`.`user_id` WHERE `posts`.`post_id` = :post_id';
      $pdo_statement = $db->prepare($sql);
      $pdo_statement->execute([
        ':post_id' => $post_id,
      ]);
      return $pdo_statement->fetchObject();
    }

    public static function updateLikes($likes, $post_id) {
      global $db;

      $sql = 'UPDATE `posts` SET likes = :likes WHERE `post_id` = :post_id';
      $pdo_statement = $db->prepare($sql);
      $pdo_statement->execute([
        ':likes' => $likes,
        ':post_id' => $post_id
      ]);
    }

    public static function addTagsToPost($post_id, $tagId) {
      global $db;

      $sql = 'INSERT INTO `post_has_tag` (`post_id`, `tag_id`) VALUES (:post_id, :tag_id)';
      $pdo_statement = $db->prepare($sql);
      $pdo_statement->execute([
        ':post_id' => $post_id,
        ':tag_id' => $tagId
      ]);
    }

    public static function createNewPost($params, $photoPart) {
      global $db;

      $sql = 'INSERT INTO `posts` (`title`, `message`, `likes`, `squad_id`, `creator_user_id`, `created_on`' . $photoPart->query . ')
              VALUES (:title, :message, 0, :squad_id, :user_id, CURRENT_TIMESTAMP' . $photoPart->param . ')';
      $pdo_statement = $db->prepare($sql);
      $pdo_statement->bindParam(':title', $params->title);
      $pdo_statement->bindParam(':message', $params->message);
      $pdo_statement->bindParam(':squad_id', $params->squad_id);
      $pdo_statement->bindParam(':user_id', $params->user_id);
      if ($photoPart->query !== '') {
        $pdo_statement->bindParam(':image', $params->photo);
      }
      $pdo_statement->execute();
      return $db->lastInsertId();
    }

    public static function addNewComment($params) {
      global $db;

      $sql = 'INSERT INTO `posts` (`message`, `squad_id`, `creator_user_id`, `parent_post_id`, `created_on`)
            VALUES (:message, :squad_id, :user_id, :parent_post_id, CURRENT_TIMESTAMP)';
      $pdo_statement = $db->prepare($sql);
      $pdo_statement->bindParam(':message', $params->message);
      $pdo_statement->bindParam(':squad_id', $params->squad_id);
      $pdo_statement->bindParam(':user_id', $params->user_id);
      $pdo_statement->bindParam(':parent_post_id', $params->post_id);
      $pdo_statement->execute();
    }

    public static function deletePostsFromSquad(int $squad_id) {
      global $db;

      $sql = 'DELETE FROM `posts` WHERE `squad_id` = :squad_id';
      $pdo_statement = $db->prepare($sql);
      $pdo_statement->bindParam(':squad_id', $squad_id , PDO::PARAM_INT);
      $pdo_statement->execute();
    }

    public static function deleteComments(int $post_id) {
      global $db;

      $sql = 'DELETE FROM `posts` WHERE `parent_post_id` = :post_id';
      $pdo_statement = $db->prepare($sql);
      $pdo_statement->bindParam(':post_id', $post_id , PDO::PARAM_INT);
      $pdo_statement->execute();
    }

    public static function deleteTagsForPost(int $post_id) {
      global $db;

      $sql = 'DELETE FROM `post_has_tag` WHERE `post_id` = :post_id';
      $pdo_statement = $db->prepare($sql);
      $pdo_statement->bindParam(':post_id', $post_id , PDO::PARAM_INT);
      $pdo_statement->execute();
    }

    
  }