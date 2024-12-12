<?php
/**
 * Author: Ashley Rodriguez Vega
 * Date: 12/12/24
 * File: register.class.php
 * Description:
 */
class AddUserView extends IndexView {

    public function display(): void
    {
        parent::displayHeader("Login");

        ?>

        <h1>Login</h1>

        <form class="new-media"  action='<?= BASE_URL?>/user/add_user' method="post">
            <p>Username:
                <input type="text" name="username" required>
            </p>
            <p>Name:
                <input type="text" name="first_name" required>
            </p>
            <p>Last Name:
                <input type="text" name="last_name" required>
            </p>
            <p>Email:
                <input type="text" name="email" required>
            </p>
            <p>Password:
                <input type="password" name="password" required>
            </p>

            <input type="submit" name="action" value="Register">
        </form>

        <?php
        parent::displayFooter();
    }
}