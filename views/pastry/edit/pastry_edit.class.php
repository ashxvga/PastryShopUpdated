<?php
/**
 * Author: Ashley Rodriguez Vega
 * Date: 12/3/24
 * File: pastry_edit.class.php
 * Description:
 */
class PastryEdit extends PastryIndexView {

    public function display($pastry): void
    {
        //display page header
        parent::displayHeader("Edit Pastry");

        //retrieving the details
        $id = $pastry->getPastryId();
        $name = $pastry->getName();
        $price = $pastry->getPrice();
        $availability = $pastry->isInMenu();
        $description = $pastry->getDescription();
        $image = $pastry->getImagePath();
        ?>

        <h1 style="margin-left: 5px">Edit Pastry Details</h1>

        <!-- display pastry details in a form -->
        <form class="new-media"  action='<?= BASE_URL . "/pastry/update/" . $id ?>' method="post" style="border: 1px solid #bbb; margin-top: 10px; padding: 10px;">
            <input type="hidden" name="id" value="<?= $id ?>">
            <p>Name:
                <input name="name" type="text" value="<?= $name ?>" required autofocus>
            </p>
            <p>Price:
                <input name="price" type="text" value="<?= $price ?>" required="">
            </p>
            <p>Stock:
                <input name="stock" type="text" value="<?= $availability ?>" required="">
            </p>
            <p>Image url:
                <input name="image" type="text" required value="<?= $image ?>"></p>
            <p>Description:
                <br>
                <textarea name="description" rows="5" cols="50"><?= $description ?></textarea></p>
            <input class='whiteButtons' type="button" value="Cancel" onclick='window.location.href = "<?= BASE_URL . "/pastry/detail/" . $id ?>"'>
            <input type="submit" name="action" value="Update Pastry">

        </form>
        <?php
        //display page footer
        parent::displayFooter();
    }
}
