<?php
/**
 * Author: Deirdre Leib
 * Date: 12/5/24
 * File: dashboard.class.php
 * Description:
 */

class UserDashboardView extends IndexView {

    public function display(): void
    {
        // Display page header
        parent::displayHeader("User Dashboard");

        echo "<h1>Welcome to the User Dashboard!</h1>";
        echo "<a href='" . BASE_URL . "/user/add'>Add New User</a>";
        echo "<br>";

        // Logout button with confirmation
        echo "<input class='whiteButtons' type='button' value='Logout'
              onclick='if(confirm(\"Are you sure you want to log out?\")) window.location.href = \"" . BASE_URL . "/user/logout\"'>";

        // Display page footer
        parent::displayFooter();
    }
}

