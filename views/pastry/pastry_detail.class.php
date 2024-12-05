<?php
/**
 * Author: Kierra White
 * Date: 11/21/2024
 * File: pastry_detail.class.php
 * Description:
 */
class PastryDetail extends IndexView{
    public function display($pastry, $confirm =""):void{
        parent::displayHeader("Pastry Details");

        //retrieving the details
        $id = $pastry->getPastryId();
        $name = $pastry->getName();
        $price = $pastry->getPrice();
        $availability = $pastry->isInMenu();
        $description = $pastry->getDescription();
        $image = $pastry->getImagePath();

        if (strpos($image, "http://") === false AND strpos($image, "https://") === false) {
            $image = BASE_URL . '/' . PASTRY_IMG . $image;
        }
        ?>
        <div class="pastry-details-container">
        <h1>Pastry Details</h1>
        <div class="pastry-details">
            <div class='pastry-info'>
                <table>
                    <tr>
                        <td>
                            <div class="pastry-image">
                                <img src="<?= $image ?>" alt="<?= $name ?>" />
                            </div>

                        </td>
                        <td>
                            <p>Name:</p>
                            <p>Price:</p>
                            <p>Stock:</p>
                            <p>Description:</p>
                            <div>
                                <input class='whiteButtons' type="button" value=" Edit "
                                       onclick="window.location.href='<?= BASE_URL ?>/pastry/edit/<?= $id ?>'">
                            </div>

                        </td>
                        <td>
                            <p><?= $name ?></p>
                            <p><?= $price?></p>
                            <p><?= $availability?></p>
                            <p><?= $description?></p>
                            <div><input class='brownButtons' type="button" value=" Add To Cart "
                                        onclick="window.location.href='<?= BASE_URL ?>/pastry/addToCart/<?= $id ?>'">
                            </div>

                            <div><?= $confirm ?></div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        </div>
        <a class="brownButtons" href="<?= BASE_URL ?>/pastry/index" style="text-decoration: none; margin-left: 10px">Go to Menu</a>
        <?php
        //for the footer
        parent::displayFooter();

    }

}