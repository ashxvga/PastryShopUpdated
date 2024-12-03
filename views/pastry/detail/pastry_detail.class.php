<?php
/**
 * Author: Kierra White
 * Date: 11/21/2024
 * File: pastry_detail.class.php
 * Description:
 */
class PastryDetail extends PastryIndexView{
    public function display($pastry, $confirm =""):void{
        parent::displayHeader("Pastry Details");

        //retrieving the details
        $id = $pastry->getPastryId();
        $name = $pastry->getName();
        $description = $pastry->getDescription();
        $price = $pastry->getPrice();
        $availability = $pastry->isInMenu();
        $image = $pastry->getImagePath();

        if (strpos($image, "http://") === false AND strpos($image, "https://") === false) {
            $image = BASE_URL . '/' . PASTRY_IMG . $image;
        }
        ?>
        <div class="pastry-details-container">
        <h1>Pastry Details</h1>
        <div class="pastry-details">
        <table>
            <tr>
                <div class="pastry-image">
                <td>
                    <img src="<?= $image ?>" alt="<?= $name ?>" />
                </td>
                </div>
                <div class="pastry-info">
                <td>
                    <p>Name:</p>
                    <p>Price:</p>
                    <p>Availability:</p>
                    <p>Stock:</p>
                    <p>Description:</p>
                    <div>
                        <input type="button" value=" Edit "
                               onclick="window.location.href='<?= BASE_URL ?>/pastry/edit/<?= $id ?>'">
                    </div>
                    <div>
                        <input type="button" value=" Add To Cart "
                               onclick="window.location.href='<?= BASE_URL ?>/pastry/addToCart/<?= $id ?>'">
                    </div>
                </td>
                <td>
                    <p><?= $name ?></p>
                    <p><?= $price?></p>
                    <p><?= $availability?></p>
                    <p><?= $description?></p>
                    <div><?= $confirm ?></div>
                </td>
                </div>

            </tr>
        </table>
        </div>
        <a href="<?= BASE_URL ?>/pastry/index">Go to Menu</a>
        </div>
        <?php
        //for the footer
        parent::displayFooter();

    }

}