<?php
/**
 * Author: Deirdre Leib
 * Date: 12/5/24
 * File: edit_user.php
 * Description: Edit user details
 */

class EditUserView extends IndexView {

    public function display($user): void
    {
        parent::displayHeader("Edit User");

        $id = $user->getUserId();
        $username = $user->getUsername();
        $email = $user->getEmail();
        $firstName = $user->getFirstName();
        $lastName = $user->getLastName();
        $role = $user->getRole();
        ?>

        <h1>Edit User</h1>

        <form action="<?= BASE_URL . '/user/update_user/' . $id ?>" method="post">
            <input type="hidden" name="user_id" value="<?= $id ?>">
            <p>Username:
                <input name="username" type="text" value="<?= $username ?>" required>
            </p>
            <p>Email:
                <input name="email" type="email" value="<?= $email ?>" required>
            </p>
            <p>First Name:
                <input name="first_name" type="text" value="<?= $firstName ?>" required>
            </p>
            <p>Last Name:
                <input name="last_name" type="text" value="<?= $lastName ?>" required>
            </p>
            <p>Role:
                <input name="role" type="text" value="<?= $role ?>" required>
            </p>

            <input class="whiteButtons" type="button" value="Delete"
                   onclick="if(confirm('Are you sure you want to delete this user?')) window.location.href = '<?= BASE_URL . '/user/delete/' . $id ?>'">
            <input type="submit" value="Update User">
        </form>

        <?php
        parent::displayFooter();
    }
}
