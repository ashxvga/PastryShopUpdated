<?php
/**
 * Author: Deirdre Leib
 * Date: 12/5/24
 * File: user_controller.class.php
 * Description: The user controller handles user-related actions.
 */

session_start();
require_once 'models/user_model.class.php';

class UserController
{

    private UserModel $user_model;

    // Default constructor
    public function __construct()
    {
        // Create an instance of the UserModel class
        $this->user_model = new UserModel();
    }

    // Index action to display a generic user dashboard
    public function index(): void
    {
        // Display the user dashboard view
        $dashboardView = new UserDashboardView();
        $dashboardView->display();
    }

    // Show the add user form
    public function add(): void
    {
        // Display the add user form view
        $addUserView = new AddUserView();
        $addUserView->display();
    }

    // Add a new user
    public function add_user(): void
    {
        try {
            if(empty ($_POST ['username']) || empty($_POST ['password']) || empty($_POST ['email']) || empty($_POST ['first_name']) || empty($_POST ['last_name'])) {
                throw new DataMissingException ("Required fields are missing");
            }
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            $firstName = $_POST['first_name'];
            $lastName = $_POST['last_name'];

            $result = $this->user_model->add_user($username, $password, $email, $firstName, $lastName);
            if ($result) {
                $_SESSION['logged_in'] = true;
                $_SESSION['user'] = [
                    'id' => $result['id'],
                    'username' => $username,
                    'email' => $email
                ];
                header('Location: ' . BASE_URL . '/user/index');
                exit;
            } else {
                $this->error("Error: Unable to add the user. Username or email may already exist.");
            }
        } catch (DataMissingException $e) {
            $this->error($e->getMessage());
        } catch (Exception $e) {
            $this->error("An unexpected error occurred: " . $e->getMessage());
        }
        //$result = $this->user_model->add_user();
        //if (!$result) {
          //  $this->error("Error: Unable to add the user. Username or email may already exist.");
            //return;
        //}

        // Redirect to user dashboard or show success message
        //header('Location: ' . BASE_URL . '/user/dashboard');
        //exit;
    }

    // Show the edit user form
    public function edit($id): void
    {
        try {
             $user = $this->user_model->get_user_by_id($id);
            if (!$user) {
                throw Exception ("User not found.");
            }
                // Display the edit user view
            $editUserView = new EditUserView();
            $editUserView->display($user);
            } catch (Exception $e) {
            $this->error("An unexpected error occurred: " . $e->getMessage());
        }
    }

        // Display the edit user view
      //  $editUserView = new EditUserView();
        //$editUserView->display($user);
    //}

    // Update a user
    public function update_user($id): void
    {
        try {
            
            $result = $this->user_model->update_user($id);
            if (!$result) {
                throw Exception ("Error: Unable to update the user.");
            }
            // Redirect to user dashboard or show success message
            header('Location: ' . BASE_URL . '/user/index');
            exit;} 
        catch (Exception $e) {
            $this->error("An unexpected error occurred: " . $e->getMessage());
        }
    }

    // Delete a user
    public function delete($id): void
    { try{
        $result = $this->user_model->delete_user($id);
        if (!$result) {
            throw Exception ("Error deleting user.");
        }
        // Redirect to user dashboard or show success message
        header('Location: ' . BASE_URL . '/user/index');
        exit;
    }  catch (Exception $e) {
            $this->error("An unexpected error occurred: " . $e->getMessage());
        }
    }

    // Show the login form
    public function login(): void
    {
        // Display the login view
        $loginView = new LoginView();
        $loginView->display();
    }

    // Verify user credentials and log them in
    public function login_user(): void {
        try {
            if(empty ($_POST ['username']) || empty($_POST ['password'])){
                throw new DataMissingException ("Username or password is missing");
            }
            $username = $_POST['username'];
            $password = $_POST['password'];

            $result = $this->user_model->verify_user($username, $password);
            if ($result) {
                $_SESSION['logged_in'] = true;
                $_SESSION['user'] = [
                    'id' => $result['id'],
                    'username' => $username,
                    'email' => $result['email']
                ];
                header('Location: ' . BASE_URL . '/user/index');
                exit;
            } else {
                $this->error("Login failed. Invalid username or password.");
            }
        } catch (DataMissingException $e) {
            $this->error($e->getMessage());
        } catch (Exception $e) {
            $this->error("An unexpected error occurred: " . $e->getMessage());
        }
    }



// Log the user out
    public function logout(): void
    { try{
        $result = $this->user_model->logout(); // Call the logout method of the model to destroy the session or authentication token
        if ($result) {
            // Redirect to login page after successful logout
            header('Location: ' . BASE_URL . '/user/login');
            exit; // Make sure the script stops after redirect
        } else {
            // If logout failed, show an error message
            throw Exception ("Error logging out.");
        }
         }  catch (Exception $e) {
            $this->error("An unexpected error occurred: " . $e->getMessage());
        }
    }

// Reset a user's password
    public function reset_password(): void
    { try{
        $result = $this->user_model->reset_password();
        if (!$result) {
            throw Exception ("Error resetting password. User may not exist.");
        }
        // Redirect to login page or show success message
        header('Location: ' . BASE_URL . '/user/login');
        exit;
     }  catch (Exception $e) {
            $this->error("An unexpected error occurred: " . $e->getMessage());
        }
    }

// Error handler
    public function error($message): void
    {
        // Display error message in a view
        $errorView = new ErrorView();
        $errorView->display($message);
    }

}
