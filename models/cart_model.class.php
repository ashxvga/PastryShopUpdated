<?php
/**
 * Author: Kierra White
 *Date: 12/4/24
 *File: cart_model.class.php
 *Description: This class handles interaction with the user table in the database
 */
class CartModel
{
    public function __construct()
    {
        session_start();
    }

    //Add a pastry to the cart
    public function add_cart($pastryId): void
    {
        session_start();
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Add pastry ID to the cart
        $_SESSION['cart'][] = $pastryId;
    }

    //Get all items
    public function get_cart(): array
    {
        session_start(); // Ensure session is started
        return $_SESSION['cart'] ?? []; // Return cart items, default empty array
    }
}
  
