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
        session_start();
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
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/error/login_required');
            exit();
        }

        $this->cartModel->add_cart($pastryId);
        header('Location: ' . BASE_URL . '/cart/index');
        exit();
    }

    // Get all items in the cart
    public function getCart(): void
    {
        $cartItems = $this->cartModel->get_cart();
        $view = new CartView();
        $view->display($cartItems);
    }
}

