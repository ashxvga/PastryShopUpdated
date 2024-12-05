<?php
/**
 * Author: Ashley Rodriguez Vega
 * Date: 11/30/24
 * File: pastry_logout.class.php
 * Description: This class handles user logout. It displays a message after the user has logged out
 */
class Logout extends IndexView {

    public function display(): void
    {
        parent::header();
        ?>
        <div>Login</div>
        <div>
            <p>You have been logged out.</p>
        </div>
        <!--can log in again or create account-->
        <div>
            <span>Already have an account? <a href="index.php?action=login">Login</a></span>
            <span>Don't have an account? <a href="index.php">Register</a></span>
        </div>

        <?php
        //calls the footer method in the parent class
        parent::footer();
    }

}