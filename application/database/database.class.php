
<?php
/**
 * Author: Kierra White
 * Date: 11/15/24
 * File: database.class.php
 * Description: the Database class sets the database details.
 */
class Database {
    private $param = array(
        'host' => 'localhost',
        'login' => 'phpuser',
        'password' => 'phpuser',
        'database' => 'pastryshop',
        'tblCategories' => 'categories',
        'tblPastries' => 'pastries',
        'tblUsers' => 'users',
        'tblInventoryLog' => 'inventory_log'
    );
    //Database Connection Object
    private mysqli $objDBConnection;
    static private ?Database $_instance = null;
    // Constructor
    private function __construct() {
        $this->objDBConnection = @new mysqli(
            $this->param['host'], $this->param['login'], $this->param['password'], $this->param['database']
        );

        if (mysqli_connect_errno() != 0) {
            $message = "Connecting to the database failed: " . mysqli_connect_error() . ".";
            include 'error.php';
            exit();
        }
    }
    // Static method to ensure there is only one Database instance
    static public function getDatabase(): Database {
        if (self::$_instance == null) {
            self::$_instance = new Database();
        }
        return self::$_instance;
    }

    // This function returns the database connection object
    public function getConnection(): mysqli {
        return $this->objDBConnection;
    }

    // Return the name of the table storing categories
    public function getCategoriesTable(): string {
        return $this->param['tblCategories'];
    }

    // Return the name of the table storing pastries
    public function getPastriesTable(): string {
        return $this->param['tblPastries'];
    }

    // Return the name of the table storing users
    public function getUsersTable(): string {
        return $this->param['tblUsers'];
    }

    // Return the name of the table storing inventory logs
    public function getInventoryLogTable(): string {
        return $this->param['tblInventoryLog'];
    }
}
?>