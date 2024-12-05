<?php
/**
 * Author: Kierra White
 * Date: 11/21/2024
 * File: pastry_index.class.php
 * Description:
 */
class PastryIndex extends IndexView{
    public function display($pastries):void
    {
        //display page header
        parent::displayHeader("List All Pastries");
        ?>
        <div>
            <?php
            if ($pastries === 0) {
                echo "No Pastry was found.<br><br><br><br><br>";
            } else {
                foreach ($pastries as $pastry) {
                    $id = $pastry->getPastryId();
                    $name = $pastry->getName();
                    $description = $pastry->getDescription();
                    $price = $pastry->getPrice();
                    $availability = $pastry->isInMenu();
                    $image = $pastry->getImagePath();
                    if (strpos($image, "http://") === false AND strpos($image, "https://") === false) {
                        $image = BASE_URL . "/" . PASTRY_IMG . $image;
                    }

                    echo "<div class='pastry-details-container' ><div class='pastry-details'><div class='pastry-image'><p><a href='", BASE_URL, "/pastry/detail/$id'><img src='" . $image .
                        "'></div><div class='pastry-info'></a><span>$name<br>Price: $price<br>" . $description. "<br> InStock: $availability". "</span></p></div></div></div>";

                }
            }
            ?>
        </div>
        <div class="addFeature">
            <a href="<?=BASE_URL?>/pastry/add">Add Pastry</a>
        </div>


        <?php
        //display page footer
        parent::displayFooter();
    }
}