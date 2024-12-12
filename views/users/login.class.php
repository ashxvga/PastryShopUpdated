<?php
/**
 * Author: Deirdre Leib
 * Date: 12/5/24
 * File: login.class.php
 * Description:
 */

class LoginView extends IndexView {

    public function display(): void
    {
        parent::displayHeader("Login");

        ?>

        <h1>Login</h1>

        <form class="new-media"  action='<?= BASE_URL?>/user/login_user' method="post">
            <p>Username:
                <input type="text" name="username" required>
            </p>
            <p>Password:
                <input type="password" name="password" required>
            </p>

            <input type="submit" name="action" value="Login">
        </form>

        <?php
        parent::displayFooter();
    }
}
