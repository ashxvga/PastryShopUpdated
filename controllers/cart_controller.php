<?php
/**
 * Author: Deirdre Leib
 * Date: 12/12/24
 * File: cart_controller.class.php
 * Description: A controller for interacting with the CartModel.
 */
session_start();
class CartController
{
    private CartModel $cartModel;

    public function __construct()
    {
        // Initialize the CartModel
        $this->cartModel = new CartModel();
    }

    public function index(): void
    {
        $cartItems = $this->cartModel->get_cart();
        // Display the user dashboard view
        $dashboardView = new CartView();
        $dashboardView->display($cartItems);
    }

    // Add a pastry to the cart
    public function addToCart($pastryId): void
    {
        $this->cartModel->add_cart($pastryId);
       // echo "Pastry with ID $pastryId has been added to the cart.\n";
        header('Location: ' . BASE_URL . '/cart/index');
    }

    // Get all items in the cart
    public function getCart(): void
    {
        $cartItems = $this->cartModel->get_cart();
        if (empty($cartItems)) {
            echo "The cart is empty.\n";
        } else {
            echo "Items in your cart:\n";
            //foreach ($cartItems as $item) {
            //echo "- Pastry ID: $item\n";
            $display = new CartView();
            $display->display($cartItems);
        }
    }
}

