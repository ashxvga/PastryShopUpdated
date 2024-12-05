<?php
/**
 * Author: Ashley Rodriguez Vega
 * Date: 12/5/24
 * File: pastry_add.class.php
 * Description:
 */
class PastryAdd extends IndexView {

    public function display(): void
    {
        //display page header
        parent::displayHeader("Add Pastry");
        ?>

        <h1 style="margin-left: 5px">Add Pastry </h1>

        <!-- display pastry details needed in a form -->
        <form class="new-media"  action='<?= BASE_URL?>/pastry/createPastry' method="post" style="border: 1px solid #bbb; margin-top: 10px; padding: 10px;">
            <p>Name:
                <input type="text" name="name" required placeholder="name">
            </p>
            <p>Price:
                <input type="text" name="price" required placeholder="price">
            </p>
            <!-- for the category, needs to get checked -->
            <p>Image url:
                <input type="text" name="image_path" required placeholder="image url" >
            </p>
            <p>Category ID:
                <input type="text" name="category_id" required placeholder="ID">
            </p>
            <p>In Menu:
                <input type="text" name="in_menu" required placeholder="ID">
            </p>
            <label> </label>
            <p>Description:
                <br>
                <textarea type="text" name="description" required placeholder="description"></textarea></p>
            <input class='whiteButtons' type="button" value="Cancel" onclick='window.location.href = "<?= BASE_URL . "/pastry/index/"?>"'>
            <input type="submit" name="action" value="Add Pastry">


        </form>
        <?php
        //display page footer
        parent::displayFooter();
    }
}