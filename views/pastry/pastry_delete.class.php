<?php
/**
 * Author: Ashley Rodriguez Vega
 * Date: 12/5/24
 * File: pastry_delete.class.php
 * Description:
 */
class PastryDeleteView extends IndexView {

    public function display($message): void
    {

        //display page header
        parent::displayHeader("Delete Pastry");
        ?>

        <div id="main-header">Delete</div>
        <hr>
        <table style="width: 100%; border: none">
            <tr>
                <td style="text-align: left; vertical-align: top;">
                    <h3> The pastry was successfully deleted</h3>
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