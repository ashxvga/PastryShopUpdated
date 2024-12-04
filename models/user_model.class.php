<?php
/**
* Author: Kierra White
*Date: 12/4/24
*File: user_model.class.php
*Description: This class handles interaction with the user table in the database
*/
class UserModel{
  private Database $db;
  private mysqli $dbConnection;
  private string $tblUsers;

  //constructor
  public function __construct(){
    $this->db = Database::getDatabase();
    $this->dbConnection =
  }
  
}
