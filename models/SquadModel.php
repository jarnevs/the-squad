<?php
  class Squad extends BaseModel {
    protected $table = 'squad';
    protected $pk = 'squad_id';

    public static function getSquadsWithLimitAndOrder (int $limit, string $order) {
      global $db;

      $sql = 'SELECT * FROM `squad` ORDER BY `squad_id` ' . $order . ' LIMIT :limit';
      $pdo_statement = $db->prepare($sql);
      $pdo_statement->bindParam(':limit', $limit, PDO::PARAM_INT);
      $pdo_statement->execute();
      return $pdo_statement->fetchAll();
    }

    public static function getSquadsUser(int $userId) {
      global $db;

      $sql = 'SELECT `squad`.* FROM `squad` INNER JOIN `squad_has_user` ON `squad`.`squad_id` = `squad_has_user`.`squad_id` WHERE `squad_has_user`.`user_id` = :user_id ORDER BY `squad`.`name`';
      $pdo_statement = $db->prepare($sql);
      $pdo_statement->execute([
        ':user_id' => $userId,
      ]);
      return $pdo_statement->fetchAll();
    }

    public static function addUserToSquad(int $squad_id, int $user_id) {
      global $db;

      $sql = 'INSERT INTO `squad_has_user` (`squad_id`, `user_id`)
              VALUES (:squad_id, :user_id)';
      $pdo_statement = $db->prepare($sql);
      $pdo_statement->bindParam(':squad_id', $squad_id, PDO::PARAM_INT);
      $pdo_statement->bindParam(':user_id', $user_id , PDO::PARAM_INT);
      $pdo_statement->execute();
    }

    public static function getJoinableSquadsForUser(int $user_id) {
      global $db;

      $sql = 'SELECT DISTINCT `squad`.* FROM `squad` LEFT JOIN `squad_has_user` ON `squad`.`squad_id` = `squad_has_user`.`squad_id` WHERE `squad`.`squad_id` NOT IN (SELECT `squad_id` FROM `squad_has_user` WHERE `user_id` = :user_id) ORDER BY `squad`.`name` ASC ';
      $pdo_statement = $db->prepare($sql);
      $pdo_statement->execute([
        ':user_id' => $user_id
      ]);
      return $pdo_statement->fetchAll();
    }

    public static function createNewSquad($params) {
      global $db;

      $sql = 'INSERT INTO `squad` (`name`, `synopsis`, `description`, `image`, `category_id`)
            VALUES (:name, :synopsis, :description, :image, :category_id)';
      $pdo_statement = $db->prepare($sql);
      $pdo_statement->bindParam(':name', $params->name);
      $pdo_statement->bindParam(':synopsis', $params->synopsis);
      $pdo_statement->bindParam(':description', $params->description);
      $pdo_statement->bindParam(':image', $params->image);
      $pdo_statement->bindParam(':category_id', $params->category , PDO::PARAM_INT);
      $pdo_statement->execute();
      return $db->lastInsertId();
    }

    public static function deleteUsersFromSquad(int $squad_id) {
      global $db;

      $sql = 'DELETE FROM `squad_has_user` WHERE `squad_id` = :squad_id';
      $pdo_statement = $db->prepare($sql);
      $pdo_statement->bindParam(':squad_id', $squad_id , PDO::PARAM_INT);
      $pdo_statement->execute();
    }
  }