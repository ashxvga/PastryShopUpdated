<?php
/**
 * Author: Deirdre Leib
 * Date: 12/5/24
 * File: delete.class.php
 * Description: Confirm user deletion
 */
class DeleteUserView extends IndexView {

    public function display($user): void
    {
        // Display page header
        parent::displayHeader("Delete User");

        // Retrieve user details
        $id = $user->getUserId();
        $username = $user->getUsername();
        ?>

        <h1 style="margin-left: 5px">Delete User</h1>

        <p>Are you sure you want to delete the user <strong><?= $username ?></strong>? This action cannot be undone.</p>

        <!-- Delete user confirmation -->
        <form action="<?= BASE_URL . '/user/delete/' . $id ?>" method="post">
            <input type="hidden" name="user_id" value="<?= $id ?>">
            <input class='whiteButtons' type="button" value="Cancel" onclick='window.location.href = "<?= BASE_URL . "/dashboard" ?>"'>
            <input type="submit" name="action" value="Delete User">
        </form>

        <?php
        // Display page footer
        parent::displayFooter();
    }
}
