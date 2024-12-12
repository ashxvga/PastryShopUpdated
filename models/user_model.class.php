<?php
/**
 * Author: Kierra White
 *Date: 12/4/24
 *File: user_model.class.php
 *Description: This class handles interaction with the user table in the database
 */
class UserModel
{
    private Database $db; // Datbase Object
    private mysqli $dbConnection; // Database Connection Object
    private string $tblUsers; //table name

    //constructor
    public function __construct()
    {
        session_start(); // Start session handling
        $this->db = Database::getDatabase();
        $this->dbConnection = $this->db->getConnection();
        $this->tblUsers = $this->db->getUsersTable();
    }

    //Method to add user
    public function add_user(string $username, $password, $email, $firstName, $lastName, $role = 'customer'): bool
    {
        $username = $this->dbConnection->real_escape_string($username);
        $password = $this->dbConnection->real_escape_string($password);
        $email = $this->dbConnection->real_escape_string($email);
        $firstName = $this->dbConnection->real_escape_string($firstName);
        $lastName = $this->dbConnection->real_escape_string($lastName);
        $role = $this->dbConnection->real_escape_string($role);

        //Handle data length excpection. The min length of a password is 5
        if (strlen($password) < 5) {
            throw new DataLengthException ("Your password was invalid. The mininum length of a password is 5.");
        }

        //Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        //Check if username or email exists
        $check = "SELECT * FROM $this->tblUsers WHERE username = '$username' OR email = '$email'";
        $result = $this->dbConnection->query($check);
        if ($check && $check->num_rows > 0){
        throw new DatabaseException("Username or email already exists.");
    }
        
        //SQL INSERT statement
        $sql = " INSERT INTO $this->tblUsers (username, password_hash, email, first_name, last_name, role)
            VALUES ('$username', '$hashed_password', '$email', '$firstName', '$lastName', '$role')";
        
        if ($this->dbConnection->query($sql) === FALSE) {
            throw new DatabaseException("We are sorry, but we cannot create your accout at this moment. Please try again later.");
        }
        return "Your account has been successfully created.";
    }


    //Method to delete user
    public function delete_user(int $userId): bool
    {
        //Santize
        $userId = $this->dbConnection->real_escape_string($userId);

        //SQL DELETE STATEMENT
        $sql = "DELETE FROM $this->tblUsers WHERE user_id = $userId";

        // Execute the query and return the result
        return $this->dbConnection->query($sql) === true;

    }

    // Method to verify user
    public function verify_user($username, $password): bool
    {
        // Sanitize
        $username = $this->dbConnection->real_escape_string($username);
        //$password = $this->dbConnection->real_escape_string($password);

        // SQL SELECT statement
        $sql = "SELECT password_hash FROM $this->tblUsers WHERE username = '$username'";

        // Execute query
        $result = $this->dbConnection->query($sql);

        // Check if user exists
        if (!$result || $result->num_rows === 0) {
            throw new DatabaseExecutionException ("Invalid username or password.");
        }

        $row = $result->fetch_assoc();
        $hashed_password = $row['password_hash'];

        // Verify the password
        if (!password_verify($password, $hashed_password)) {
            throw new DatabaseExecutionException ("Invalid username or password.");
        }

        $_SESSION['user'] = $username;

        // Optionally, set a cookie for convenience
        setcookie("user", $username, time() + 3600, "/");
        return true;
    }


    //Method to log user out
    public function logout(): bool
    {
        // Destroy session data
        session_start(); // Ensure the session is active
        session_unset();
        session_destroy();

        // Clear the cookie
        setcookie("user", "", time() - 3600, "/");
        return true;
    }

    //Method to reset user's password
    public function reset_password($username, $password): bool
    {
        $username = $this->dbConnection->real_escape_string($username);
        //$password = $this->dbConnection-> real_escape_string(trim(htmlspecialchars($_POST, ['password_hash'])));;

        //Handle data length exception. The min length of a password is 5.
        if (strlen($password) < 5) {
            throw new DataLengthException("Your password is invalid. The mininum length of a password is 5.");
        }
        //Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        //SQL UPDATE statement
        $sql = "UPDATE $this->tblUsers SET password_hash = '$hashed_password' WHERE username = '$username'";
        //execute the query
        $query = $this->dbConnection->query($sql);

        //return false if no rows were affected
        if (!$query || $this->dbConnection->affected_rows == 0) {
            throw new DatabaseException("We are sorry, but we cannot reset your password at this moment. Please try again later.");
        }
        return "You have successfully reset your password.";
    }

    //Method to update user
    public function update_user(int $userId, string $username, $email, $firstName, $lastName): bool
    {
        if (!filter_has_var(INPUT_POST, 'username') ||
            !filter_has_var(INPUT_POST, 'email') ||
            !filter_has_var(INPUT_POST, 'firstName') ||
            !filter_has_var(INPUT_POST, 'lastName')) {
            return false;
        }
        $userId = $this->dbConnection->real_escape_string($userId);
        $username = $this->dbConnection->real_escape_string($username);
        $email = $this->dbConnection->real_escape_string($email);
        $firstName = $this->dbConnection->real_escape_string($firstName);
        $lastName = $this->dbConnection->real_escape_string($lastName);

        //SQL UPDATE statement
        $sql = "UPDATE $this->tblUsers 
      SET username = '$username', email = '$email', firstName = '$firstName' , lastName = '$lastName'
      WHERE user_id = $userId";

        return $this->dbConnection->query($sql) === true;
    }
}
