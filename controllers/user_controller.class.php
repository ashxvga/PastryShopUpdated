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
        session_start();
        // Create an instance of the UserModel class
        $this->user_model = new UserModel();
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
    public function login_user(): void
    {
        try {
            if (empty($_POST['username']) || empty($_POST['password'])) {
                throw new Exception("Username or password is missing");
            }

            $username = $_POST['username'];
            $password = $_POST['password'];

            $result = $this->user_model->verify_user($username, $password);

            if ($result) {
                $_SESSION['user'] = $result; // Save the user object in session
                $_SESSION['logged_in'] = true;

                header('Location: ' . BASE_URL . '/user/index');
                exit();
            } else {
                $this->error("Invalid username or password.");
            }
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }


// Log the user out
    public function logout(): void
    {
        session_start();
        session_unset();
        session_destroy();

        header('Location: ' . BASE_URL . '/user/login');
        exit();
    }

    public function requireLogin(): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/error/login_required');
            exit();
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

    // Index action to display a generic user dashboard
    public function index(): void
    {
        // Display the user dashboard view
        $this->requireLogin();
        $dashboardView = new UserDashboardView();
        $dashboardView->display();
    }

// Error handler
    public function error($message): void
    {
        // Display error message in a view
        $errorView = new ErrorView();
        $errorView->display($message);
    }

}
