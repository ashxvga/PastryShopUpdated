<?php
/**
 * Author: Kierra White
 * Date: 11/21/2024
 * File: pastry_error.class.php
 * Description:
 */

class PastryError extends PastryIndexView {

    public function display($message): void
    {

        //display page header
        parent::displayHeader("Error");
        ?>

        <div id="main-header">Error</div>
        <hr>
        <table style="width: 100%; border: none">
            <tr>
                <td style="vertical-align: middle; text-align: center; width:100px">
                    <img src='<?= BASE_URL ?>/www/img/errorIcon.jpg' style="width: 80px; border: none"/>
                </td>
                <td style="text-align: left; vertical-align: top;">
                    <h3> Sorry, but an error has occurred.</h3>
                    <div style="color: red">
                        <?= urldecode($message) ?>
                    </div>
                    <br>
                </td>
            </tr>
        </table>
        <br><br><br><br><hr>
        <a href="<?= BASE_URL ?>/pastry/index">Back to Menu Page</a>
        <?php
        //display page footer
        parent::displayFooter();
    }
}
