<?php 
  class User extends BaseModel {
    protected $table = 'user';
    protected $pk = 'user_id';

    public static function getUserByEmail( string $email) {
      global $db;

      $sql = 'SELECT * FROM `user` WHERE `email` = :email';
      $pdo_statement = $db->prepare($sql);
      $pdo_statement->execute([':email' => $email]);
      return $pdo_statement->fetchObject();
    }


    public static function createNewUser(string $email, string $username, string $password) {
      global $db;

      $sql = 'INSERT INTO `user` (email, username, password)
              VALUES(:email, :username, :password)';
      $pdo_statement = $db->prepare($sql);
      $pdo_statement->execute([
        ':email' => $email, 
        ':username' => $username, 
        ':password' => $password, 
      ]);
      return $db->lastInsertId();
    }

    public static function checkIfUserExists(string $column, string $param) {
      global $db;

      $sql = 'SELECT COUNT(*) FROM `user` WHERE ' . $column . ' = :param';
      $pdo_statement = $db->prepare($sql);
      $pdo_statement->execute([':param' => $param]);
      return $pdo_statement->fetchColumn();
    }

    public static function updateAdmin(int $id) {
      global $db;

      $sql = 'UPDATE `user` SET `is_admin` = 1 WHERE `user_id` = :id';
      $pdo_statement = $db->prepare($sql);
      $pdo_statement->execute([':id' => $id]);
    }
  }