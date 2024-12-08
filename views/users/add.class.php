<?php
/**
 * Author: Deirdre Leib
 * Date: 12/5/24
 * File: add_user.class.php
 * Description: Add a new user
 */

class AddUserView extends IndexView {

    public function display(): void
    {
        // Display page header
        parent::displayHeader("Add New User");

        ?>

        <h1>Add New User</h1>

        <form action="<?= BASE_URL . '/user/add_user' ?>" method="post">
            <p>Username:
                <input type="text" name="username" required>
            </p>
            <p>Password:
                <input type="password" name="password" required>
            </p>
            <p>Email:
                <input type="email" name="email" required>
            </p>
            <p>First Name:
                <input type="text" name="first_name" required>
            </p>
            <p>Last Name:
                <input type="text" name="last_name" required>
            </p>
            <p>Role:
                <input type="text" name="role" required>
            </p>

            <input type="submit" value="Add User">
        </form>

        <?php
        // Display page footer
        parent::displayFooter();
    }
}
