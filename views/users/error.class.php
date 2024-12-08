<?php
/**
 * Author: Deirdre Leib
 * Date: 12/5/24
 * File: error.class.php
 * Description:
 */

class ErrorView extends IndexView
{

    public function display($message): void
    {
        parent::displayHeader("Error");
        echo "<p style='color: red;'>Error: $message</p>";
        parent::displayFooter();
    }
}
