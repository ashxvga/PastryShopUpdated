<?php
/**
 * Author: Kierra White
 *Date: 12/4/24
 *File: cart_model.class.php
 *Description: This class handles interaction with the user table in the database
 */
class CartModel {
  private array $cart;
  public function __construct() {
        $this->cart = [];
  }
  
  //Add a pastry to the cart
  public function add_cart ($pastryId): void {
    $this->cart[] = $pastryId;
  }

  //Get all items
  public function get_cart (): array {
    return $this->cart;
  }
  
