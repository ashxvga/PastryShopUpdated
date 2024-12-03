<?php
/**
 * Author: Kierra White
 * Date: 11/15/24
 * File: pastry.class.php
 * Description: This class represents a Pastry
 */
class Pastry{
    private int $pastryId, $categoryId, $stockQuantity;
    private string $name;
    private ?string $description, $imagePath;
    private float $price;
    private bool $in_menu;

//Constructor
    public function __construct ($categoryId, $name, $description, $imagePath,
                                 $price, $in_menu){
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->categoryId = $categoryId;
        $this->in_menu = $in_menu;
        $this->imagePath = $imagePath;
    }

//Get pastry ID
    public function getPastryId(): int {
        return $this->pastryId;
    }
    //Get name
    public function getName(): string {
        return $this->name;
    }
    //Get description
    public function getDescription(): ?string {
        return $this->description;
    }
    //Get price
    public function getPrice(): float {
        return $this->price;
    }
    //Get Category ID
    public function getCategoryId(): int {
        return $this->categoryId;
    }

    public function getStockQuantity(): int
    {
        return $this->stockQuantity;
    }

    //Get Availability
    public function isInMenu(): bool {
        return $this->in_menu;
    }
    //Get image Path
    public function getImagePath(): ?string {
        return $this->imagePath;
    }
    //Get Stock Quantity

    //Set name
    // public function setName(string $name): void {
    //     $this->name = $name;
    // }
    //Set Description
    // public function setDescription(?string $description): void {
    //     $this->description = $description;
    //}
    //Set Price
    //public function setPrice(float $price): void {
    //  $this->price = $price;
    //}
    //Set Category ID
    //public function setCategoryId(int $categoryId): void {
    //  $this->categoryId = $categoryId;
    //}
    //Set Availability
    //public function setInMenu(bool $in_menu): void {
    //  $this->in_menu = $in_menu;
    //}
    //Set Image Path
    //public function setImagePath(?string $imagePath): void {
    //  $this->imagePath = $imagePath;
    //}
    //Set Stock Quantity
    //public function setStockQuantity(int $stockQuantity): void {
    //  $this->stockQuantity = $stockQuantity;
    //}

    public function setPastryID(int $id) {
        $this->pastryId = $id;
    }


}








