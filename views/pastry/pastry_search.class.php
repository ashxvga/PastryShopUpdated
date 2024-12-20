<?php
/**
 * Author: Ashley Rodriguez Vega
 * Date: 12/3/24
 * File: pastry_search.class.php
 * Description:
 */
class PastrySearch extends IndexView {

    public function display($terms, $pastries): void
    {
        parent::displayHeader("Search Results");
        ?>
        <div> Search Results for <i><?= $terms ?></i></div>

        <!-- to display the results -->
        <div class="gridResults">
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

                    echo "<div class='pastry-details-container' ><div class='pastry-details'><div class='pastry-image'><p><a href='". BASE_URL. "/pastry/detail/$id'><img src='" . $image .
                        "'></div><div class='pastry-info'></a><span>$name<br>Price: $price<br>" . $description. "<br> InStock: $availability". "</span></p></div></div></div>";

                }
            }
            ?>
        </div>

        <a href="<?= BASE_URL ?>/pastry/index">Go to Menu</a>
        <?php
        parent::displayFooter();
    }
}
