<?php
/**
 * Author: Deirdre Leib
 * Date: 12/12/24
 * File: cart_controller.class.php
 * Description: A controller for interacting with the CartModel.
 */
class CartController
{
    private CartModel $cartModel;

    public function __construct()
    {
        // Initialize the CartModel
        $this->cartModel = new CartModel();
    }

    // Add a pastry to the cart
    public function addToCart($pastryId): void
    {
        $this->cartModel->add_cart($pastryId);
        echo "Pastry with ID $pastryId has been added to the cart.\n";
    }

    // Get all items in the cart
    public function getCart(): void
    {
        $cartItems = $this->cartModel->get_cart();
        if (empty($cartItems)) {
            echo "The cart is empty.\n";
        } else {
            echo "Items in your cart:\n";
            foreach ($cartItems as $item) {
                echo "- Pastry ID: $item\n";
            }
        }
    }
}
