<?php
/**
 * Author: Ashley Rodriguez Vega
 * Date: 12/11/24
 * File: pastry_cart.class.php
 * Description:
 */
class CartView extends IndexView {
    public function display($cartItems): void {
        parent::displayHeader("Your Cart");

        ?>
        <div>
        <h1>Your Cart</h1>

            <?php
            if ($cartItems === 0) {
                echo "Your cart is empty.<br><br><br><br><br>";
            } else {
                foreach ($cartItems as $item) {
                    $id = $item->getPastryId();
                    $name = $item->getName();
                    $image = $item->getImagePath();
                    if (strpos($image, "http://") === false && strpos($image, "https://") === false) {
                        $image = BASE_URL . '/' . PASTRY_IMG . $image;
                    }
                    ?>
                    <table>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th></th>
                        </tr>
                        <tr>
                            <td><img src="<?= $image ?>" alt="<?= $name ?>" class=""></td>
                            <td><?= $name ?></td>
                            <td>
                                <input class="whiteButtons" type="button" value=" Remove "
                                       onclick="window.location.href='<?= BASE_URL ?>/pastry/remove/<?= $id ?>'">
                            </td>
                        </tr>
                    </table>
                    <?php
                }
            }
            ?>
            <a class="brownButtons" href="<?= BASE_URL ?>/pastry/index">Continue Shopping</a>
        </div>
        <?php

        parent::displayFooter();
    }
}