<?php
/**
 * Author: Ashley Rodriguez Vega
 * Date: 11/30/24
 * File: pastry_login.class.php
 * Description:
 */
class Login extends IndexView {
    //displays the header
    public function display(): void{
        parent::displayHeader("Login Page");
        ?>
        <div>
            <form method="post" action="index.php?action=verify">
                <div><input type="text" name="username" required placeholder="Username"></div>
                <div><input type="password" name="password" required placeholder="Password"></div>
                <div><input type="submit" value="Login"></div>
            </form>
        </div>
        <div>
            <span style="float: left">Don't have an account? <a href="index.php?action=index">Register</a></span>
            <span style="float: right"></span>
        </div>
        <?php
        //display the footer
        parent::footer();
    }
}