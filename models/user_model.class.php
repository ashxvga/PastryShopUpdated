<?php
/**
* Author: Kierra White
*Date: 12/4/24
*File: user_model.class.php
*Description: This class handles interaction with the user table in the database
*/
class UserModel{
  private Database $db; // Datbase Object
  private mysqli $dbConnection; // Database Connection Object
  private string $tblUsers; //table name

  //constructor
  public function __construct(){
    $this->db = Database::getDatabase();
    $this->dbConnection = $this->db->getConnection();
    $this->tblUsers = $this->db->getUsersTable();
  }
  //Method to add user
  public function add_user(): bool {
    $username = $this->dbConnection-> real_escape_string(trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING)));
    $password = $this->dbConnection-> real_escape_string(trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING)));
    $email = $this->dbConnection-> real_escape_string(trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL)));
    $firstName = $this->dbConnection-> real_escape_string(trim(filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING)));
    $lastName = $this->dbConnection-> real_escape_string(trim(filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING)));
    $role = $this->dbConnection-> real_escape_string(trim(filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING))) ?: 'customer';

    //Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    //Check if username or email exists
    $check = "SELECT * FROM $this->tblUsers WHERE username = '$username' OR email = '$email'";
    $result = $this->dbConnection->query($check);
    
    //Return false
    if ($result && $result->num_rows > 0){
      return false;
    }
    
    //SQL INSERT statement
    $sql = " INSERT INTO $this->tblUsers (username, password_hash, email, first_name, last_name, role)
            VALUES ('$username', '$hashed_password', '$email', '$firstName', '$lastName', '$role')";
    
    return $this->dbConnection->query($sql) === true;
  }

  //Method to verify user
  public function verify_user(): bool {
    $username = $this->dbConnection-> real_escape_string(trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING)));
    $password = $this->dbConnection-> real_escape_string(trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING)));

    //SQL SELECT statement
    $sql = "SELECT password_hash FROM $this->tblUsers WHERE username = '$username'";
    
    $result = $this->dbConnection->query($sql);
    
    //verify password; if password is valid, set a temporary cookie
    if($result && $result->num_rows > 0) {
      $row = $result->fetch_assoc();
      if (password_verify($password, $row['password_hash'])) {
        setcookie("user", $username, time() + 3600, "/");
        return true;
        }
     }
     return false;
  }
  //Method to log user out
  public function logout(): bool{
    //destroy session data
    setcookie("user", "", time() -3600, "/");
    return true;
    }
    
  //Method to reset user's password
  public function reset_password():bool{
    $username = $this->dbConnection-> real_escape_string(trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING)));
    $newPassword = $this->dbConnection-> real_escape_string(trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING)));

    //Hash the password
    $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);

    //SQL UPDATE statement
    $sql = "UPDATE $this->tblUsers SET password_hash = '$hashed_password' WHERE username = '$username'";
    return $this->dbConnection->query($sql) === true && $this->dbConnection->affected_rows >0;
  }

  //Need to update
  //Method to update user's role
  public function update_role ($userId, $role) : bool{
   // if (!filter_has_var(INPUT_POST, 'category_name')){
     //       return false;
       // }
    
    $sql = "UPDATE $this->tblUsers SET role = 'role' WHERE user_id = $userid";
    return $this->dbConnection->query($sql) === true
  }
                          
  
  
}
