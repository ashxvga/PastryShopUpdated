<?php
/**
 * Author: Deirdre Leib
 * Date: 12/5/24
 * File: user_controller.class.php
 * Description: The user controller handles user-related actions.
 */

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
                header('Location: ' . BASE_URL . '/user/index');
                exit;
            }else {
                $this->error("Error: Unable to add the user. Username or email may already exist.");            }
        }catch (DataMissingException $e) {
            $this->error($e->getMessage());
        }catch (Exception $e){
            $this->error("An unexpected error occured: " . $e->getMessage());
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
        $user = $this->user_model->get_user_by_id($id);
        if (!$user) {
            $this->error("User not found.");
            return;
        }

        // Display the edit user view
        $editUserView = new EditUserView();
        $editUserView->display($user);
    }

    // Update a user
    public function update_user($id): void
    {
        $result = $this->user_model->update_user($id);
        if (!$result) {
            $this->error("Error: Unable to update the user.");
            return;
        }

        // Redirect to user dashboard or show success message
        header('Location: ' . BASE_URL . '/user/index');
        exit;
    }

    // Delete a user
    public function delete($id): void
    {
        $result = $this->user_model->delete_user($id);
        if (!$result) {
            $this->error("Error deleting user.");
            return;
        }

        // Redirect to user dashboard or show success message
        header('Location: ' . BASE_URL . '/user/index');
        exit;
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
                header('Location: ' . BASE_URL . '/user/index');
                exit;
            }else {
                $this->error("Login failed. Invalid username or password.");
            }
        }catch (DataMissingException $e) {
            $this->error($e->getMessage());
        }catch (Exception $e){
            $this->error("An unexpected error occured: " . $e->getMessage());
        }
    }


// Log the user out
    public function logout(): void
    {
        $result = $this->user_model->logout(); // Call the logout method of the model to destroy the session or authentication token

        if ($result) {
            // Redirect to login page after successful logout
            header('Location: ' . BASE_URL . '/user/login');
            exit; // Make sure the script stops after redirect
        } else {
            // If logout failed, show an error message
            $this->error("Error logging out.");
        }
    }

// Reset a user's password
    public function reset_password(): void
    {
        $result = $this->user_model->reset_password();
        if (!$result) {
            $this->error("Error resetting password. User may not exist.");
            return;
        }

        // Redirect to login page or show success message
        header('Location: ' . BASE_URL . '/user/login');
        exit;
    }

// Error handler
    public function error($message): void
    {
        // Display error message in a view
        $errorView = new ErrorView();
        $errorView->display($message);
    }

}
