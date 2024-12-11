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
        $username = $this->dbConnection-> real_escape_string(trim(htmlspecialchars($_POST ['username'])));
        $password = $this->dbConnection-> real_escape_string(trim(htmlspecialchars($_POST, ['password_hash'])));
        $email = $this->dbConnection-> real_escape_string(trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL)));
        $firstName = $this->dbConnection-> real_escape_string(trim(htmlspecialchars($_POST, ['first_name'])));
        $lastName = $this->dbConnection-> real_escape_string(trim(htmlspecialchars($_POST, ['last_name'])));
        $role = $this->dbConnection-> real_escape_string(trim(htmlspecialchars($_POST, ['role'] ))) ?: 'customer';

        try {
            //Handle data missing exeception. All fields are required
            if (empty ($username) || empty ($password) || empty ($email) || empty ($firstName) ||empty ($lastName)){
                throw new DataMissingExeception ("Values were missing in one or more fields. All fields must be filled.");
            }
            //Handle data length excpection. The min length of a password is 5
            if (strlen($password) < 5){
                throw new DataLengthException ("Your password was invalid. The minium length of a password is 5.");
            }
            //Handle email format exeception.
            if (!Utilities::checkemail ($email)) {
                throw new EmailFormatException ("Your email format was invalid. The general format of an email address is user@example.com");
            }
            //Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            //Check if username or email exists
            $check = "SELECT * FROM $this->tblUsers WHERE username = '$username' OR email = '$email'";
            $result = $this->dbConnection->query($check);
            //SQL INSERT statement
            $sql = " INSERT INTO $this->tblUsers (username, password_hash, email, first_name, last_name, role)
            VALUES ('$username', '$hashed_password', '$email', '$firstName', '$lastName', '$role')";
            if ( $this->dbConnection->query($sql) === FALSE) {
                throw new DatabaseException("We are sorry, but we cann create your accout at this moment. Please try again later.");
            }

            return "Your account has been successfully created.";
        } catch (DataMissingException $e) {
            return $e->getMessage();
        } catch (DataLengthException $e) {
            return $e->getMessage();
        } catch (DatabaseException $e) {
            return $e->getMessage();
        } catch (EmailFormatException $e) {
            return $e->getMessage();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    //Method to delete user
    public function delete_user ($userId): bool {
        //Santize
        $userId = $this->dbConnection->real_escape_string(trim(filter_var($userId, FILTER_VALIDATE_INT)));

        //SQL DELETE STATEMENT
        $sql = "DELETE FROM $this->tblUsers WHERE user_id = $userId";

        // Execute the query and return the result
        return $this->dbConnection->query($sql) === true;

    }

    // Method to verify user
    public function verify_user($username, $password): bool {
        try {
            // Sanitize
            $username = $this->dbConnection->real_escape_string($username);
            //$password = $this->dbConnection->real_escape_string($password);

             // SQL SELECT statement
            $sql = "SELECT password_hash FROM $this->tblUsers WHERE username = '$username'";

            // Execute query
            $result = $this->dbConnection->query($sql);

            // Check if user exists
            if (!$result || $result->num_rows === 0) {
                throw new DatabaseExecutionException ("Invalid username or password."); }

            $row = $result->fetch_assoc();
            $hashed_password = $row['password_hash'];

            // Verify the password
            if (!password_verify($password, $hashed_password)) {
                throw new DatabaseExecutionException ("Invalid username or password."); }

            // Set cookie
            setcookie("user", $username, time() + 3600, "/");
            return true;
        } catch (DatabaseExecutionException  $e) {
            echo $e->getMessage();
            return false;
        } catch (Exception $e) {
            echo "An unexpected error occurred: " . $e->getMessage();
            return false;
    }
}

            
    //Method to log user out
    public function logout(): bool{
        //destroy session data
        setcookie("user", "", time() -3600, "/");
        return true;
        

    //Method to reset user's password
    public function reset_password():bool{
        $username = $this->dbConnection-> real_escape_string(trim(htmlspecialchars($_POST ['username'])));
        $password = $this->dbConnection-> real_escape_string(trim(htmlspecialchars($_POST, ['password_hash'])));;

        //Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        //SQL UPDATE statement
        $sql = "UPDATE $this->tblUsers SET password_hash = '$hashed_password' WHERE username = '$username'";
        return $this->dbConnection->query($sql) === true && $this->dbConnection->affected_rows >0;
    }

    //Method to update user
    public function update_user ($userId) : bool{
        if (!filter_has_var(INPUT_POST, 'username') ||
            !filter_has_var(INPUT_POST,'email') ||
            !filter_has_var(INPUT_POST,'firstName') ||
            !filter_has_var(INPUT_POST, 'lastName') )
        {
            return false;
        }
        $username = $this->dbConnection-> real_escape_string(trim(htmlspecialchars($_POST ['username'])));
        $email = $this->dbConnection-> real_escape_string(trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL)));
        $firstName = $this->dbConnection-> real_escape_string(trim(htmlspecialchars($_POST, ['first_name'])));
        $lastName = $this->dbConnection-> real_escape_string(trim(htmlspecialchars($_POST, ['last_name'])));

        //SQL UPDATE statement
        $sql = "UPDATE $this->tblUsers 
      SET username = '$username', email = '$email', firstName = '$firstName' , lastName = '$lastName'
      WHERE user_id = $userId";

        return $this->dbConnection->query($sql) === true;
    }



}
