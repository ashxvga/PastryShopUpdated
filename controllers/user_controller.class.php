<?php
/**
 * Author: Deirdre Leib
 * Date: 12/5/24
 * File: user_controller.class.php
 * Description: The user controller handles user-related actions.
 */

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
        // Display a welcome message or default view
        echo "Welcome to the User Dashboard!";
    }

    // Add a new user
    public function add(): void
    {
        $result = $this->user_model->add_user();
        if (!$result) {
            $this->error("Error: Unable to add the user. Username or email may already exist.");
            return;
        }

        echo "User added successfully!";
    }

    // Verify user credentials and log them in
    public function login(): void
    {
        $result = $this->user_model->verify_user();
        if (!$result) {
            $this->error("Login failed. Invalid username or password.");
            return;
        }

        echo "Login successful! Welcome.";
    }

    // Log the user out
    public function logout(): void
    {
        $result = $this->user_model->logout();
        if ($result) {
            echo "Logout successful!";
        } else {
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

        echo "Password reset successful!";
    }

    // Error handler
    public function error($message): void
    {
        echo "<p style='color: red;'>Error: $message</p>";
    }

    // Handle inaccessible methods
    public function __call($name, $arguments)
    {
        $this->error("Calling method '$name' caused errors. Route does not exist.");
    }
}
