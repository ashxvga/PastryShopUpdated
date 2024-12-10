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
        try {
            // Display the user dashboard view
            $dashboardView = new UserDashboardView();
            $dashboardView->display();

        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }

    // Show the add user form
    public function add(): void
    {
        try {
            // Display the add user form view
            $addUserView = new AddUserView();
            $addUserView->display();

        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }

    // Add a new user
    public function add_user(): void
    {
        try {
            $result = $this->user_model->add_user();
            if (!$result) {
                throw new DatabaseExecutionException("Error: Unable to add the user. Username or email may already exist.");
            }

            // Redirect to user dashboard or show success message
            header('Location: ' . BASE_URL . '/user/dashboard');
            exit;

        } catch (DatabaseExecutionException $e) {
            $this->error($e->getMessage());
        }
    }

    // Show the edit user form
    public function edit($id): void
    {
        try {
            $user = $this->user_model->get_user_by_id($id);
            if (!$user) {
                throw new DataMissingException("User not found.");
            }

            $editUserView = new EditUserView();
            $editUserView->display($user);

        } catch (DataMissingException $e) {
            $this->error($e->getMessage());
        }
    }


    // Update a user
    public function update_user($id): void
    {
        try {
            $result = $this->user_model->update_user($id);
            if (!$result) {
                throw new DatabaseExecutionException("Error: Unable to update the user.");
            }

            // Redirect to user dashboard or show success message
            header('Location: ' . BASE_URL . '/user/dashboard');
            exit;

        } catch (DatabaseExecutionException $e) {
            $this->error($e->getMessage());
        }
    }

    // Delete a user
    public function delete($id): void
    {
        try {
            $result = $this->user_model->delete_user($id);
            if (!$result) {
                throw new DatabaseExecutionException("Error deleting user.");
            }

            header('Location: ' . BASE_URL . '/user/dashboard');
            exit;

        } catch (DatabaseExecutionException $e) {
            $this->error($e->getMessage());
        }
    }

    // Show the login form
    public function login(): void
    {
        try {
            // Display the login view
            $loginView = new LoginView();
            $loginView->display();

        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }

    // Verify user credentials and log them in
    public function login_user(): void
    {
        try {
            $result = $this->user_model->verify_user();
            if (!$result) {
                throw new DatabaseExecutionException("Login failed. Invalid username or password.");
            }

            header('Location: ' . BASE_URL . '/user/dashboard');
            exit;

        } catch (DatabaseExecutionException $e) {
            $this->error($e->getMessage());
        }
    }

    // Log the user out
    public function logout(): void
    {
        try {
            $result = $this->user_model->logout();
            if ($result) {
                header('Location: ' . BASE_URL . '/user/login');
                exit;
            } else {
                throw new DatabaseExecutionException("Error logging out.");
            }

        } catch (DatabaseExecutionException $e) {
            $this->error($e->getMessage());
        }
    }

    // Reset a user's password
    public function reset_password(): void
    {
        try {
            $result = $this->user_model->reset_password();
            if (!$result) {
                throw new DataMissingException("Error resetting password. User may not exist.");
            }

            header('Location: ' . BASE_URL . '/user/login');
            exit;

        } catch (DataMissingException $e) {
            $this->error($e->getMessage());
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
