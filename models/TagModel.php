<?php
  class Tag extends BaseModel {
    protected $table = 'tags';
    protected $pk = 'tag_id';

    public static function getTagsForPost (int $post_id) {
      global $db;

      $sql = 'SELECT `tags`.`name` FROM `post_has_tag` INNER JOIN `tags` ON `post_has_tag`.`tag_id` = `tags`.`tag_id` WHERE `post_has_tag`.`post_id` = :post_id';
      $pdo_statement = $db->prepare($sql);
      $pdo_statement->execute([
        ':post_id' => $post_id,
      ]);
      return $pdo_statement->fetchAll();
    }

    public static function getTagByName (string $tagName) {
      global $db;

      $sql = 'SELECT * FROM `tags` WHERE `name` = :name';
      $pdo_statement = $db->prepare($sql);
      $pdo_statement->execute([
        ':name' => $tagName
      ]);
      return $pdo_statement->fetchObject();
    }

    public static function createTag ($tagName) {
      global $db;

      $sql = 'INSERT INTO `tags` (`name`) VALUES (:name)';
      $pdo_statement = $db->prepare($sql);
      $pdo_statement->execute([
        ':name' => $tagName
      ]);
      return $db->lastInsertId(); 
    }

    public static function deleteTagFromPost(int $tag_id) {
      global $db;

      $sql = 'DELETE FROM `post_has_tag` WHERE `tag_id` = :tag_id';
      $pdo_statement = $db->prepare($sql);
      $pdo_statement->bindParam(':tag_id', $tag_id , PDO::PARAM_INT);
      $pdo_statement->execute();
    }
  }