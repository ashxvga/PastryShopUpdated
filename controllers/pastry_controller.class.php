<?php
/**
 * Author: Kierra White
 * Date: 11/21/2024
 * File: pastry_controller.class.php
 * Description:
 */

class PastryController{
    private PastryModel $pastry_model;

    //default constructor
    public function __construct(){
        //create an instance of the MovieModel class
        $this->pastry_model = PastryModel::getPastryModel();
    }
    public function detail($pastryId): void{
        //retrieve the specific pastry
        $pastry = $this->pastry_model->get_pastry_by_id($pastryId);

        if (!$pastry){
            //display an error
            $this->error("There was a problem displaying the pastry id ='" . $pastryId ."'");
        }
        //added this
        //display pastry details
        $view = new PastryDetail();
        $view->display($pastry);
    }

    public function index(): void{
        //retrieve all pastries and store them in an array
        $pastries = $this->pastry_model->get_all_pastries();
        if (!$pastries){
            //display an error
            $this->error("There was a problem displaying pastries.");
            return;
        }
        //display all pastries
        $view = new PastryIndex();
        $view->display($pastries);
    }

    //display a pastry in a form for editing
    public function edit($id): void {
        //retrieve the specific pastry
        $pastry = $this->pastry_model->get_pastry_by_id($id);

        if (!$pastry) {
            //display an error
            $this->error("There was a problem displaying the pastry id='" . $id . "'.");
            return;
        }

        $view = new PastryEdit();
        $view->display($pastry);
    }

    //update a pastry in the database
    public function updatePastry($id): void {
        //update the pastry
        $update = $this->pastry_model->update_pastry($id);
        if (!$update) {
            //handle errors
            $this->error("There was a problem updating the pastry id='" . $id . "'.");
            return;
        }

        //display the updated pastry details
        $confirm = "The pastry was successfully updated.";
        $pastry = $this->pastry_model->get_pastry_by_id($id);

        $view = new PastryDetail();
        $view->display($pastry, $confirm);
    }


    //update a category in the database
    public function updateCategory($id): void {
        //update the category
        $update = $this->pastry_model->update_category($id);
        if (!$update) {
            //handle errors
            $this->error("There was a problem updating the category id='" . $id . "'.");
            return;
        }

    }

    //delete pastry
    public function delete($id): void {
        // Attempt to delete the pastry
        $delete = $this->pastry_model->delete_pastry($id);

        if (!$delete) {
            // Handle errors and redirect
            $this->error("There was a problem deleting the pastry id='" . $id . "'.");
            return;
        }

        // Redirect or display success message
        header("Location: " . BASE_URL . "/pastry/index"); // Redirect to pastry list page
        exit();
    }

    public function getPastryModel(): PastryModel
    {
        return $this->pastry_model;
    }


    public function add(): void {
        $display = new PastryAdd();
        $display->display();
    }

    public function createPastry(): void {
        // Collect input data from POST
        $name = $_POST['name'] ?? null;
        $description = $_POST['description'] ?? null;
        $price = $_POST['price'] ?? null;
        $categoryId = $_POST['category_id'] ?? null;

        // Validate inputs
        if (empty($name) || empty($description) || empty($price) || empty($categoryId)) {
            $this->error("All fields are required to add a new pastry.");
            return;
        }

        // Attempt to add the pastry
        $added = $this->pastry_model->add_pastry($name, $description, (float)$price, (int)$categoryId );

        if (!$added) {
            // Handle errors
            $this->error("There was a problem adding the new pastry.");
            return;
        }

        // Confirmation message
        echo "The pastry was successfully added.";
    }


    //search pastries
    public function search(): void {
        //retrieve query terms from search form
        $query_terms = trim($_GET['query'] ?? "");

        //if search term is empty, list all pastries
        if ($query_terms === "") {
            $this->index();
            return;
        }

        //search the database for matching pastries
        $pastries = $this->pastry_model->search_pastries($query_terms);

        if ($pastries === 0) {
            //handle no results found
            $this->error("No results found for the search term '$query_terms'.");
            return;
        } elseif (!$pastries) {
            //handle an error during the search
            $this->error("An error has occurred.");
            return;
        }

        //display matched pastries
        $search = new PastrySearch();
        $search->display($query_terms, $pastries);
    }

    //autosuggestion for search terms
    public function suggest($terms): void {
        //retrieve query terms
        $query_terms = urldecode(trim($terms));
        $pastries = $this->pastry_model->search_pastries($query_terms);

        //retrieve all pastry names and store them in an array
        $names = array();
        if ($pastries) {
            foreach ($pastries as $pastry) {
                $names[] = $pastry->getName();
            }
        }

        echo json_encode($names);
    }
    //handle an error
    public function error($message):void{
        //create an object of the Error class
        $error = new PastryError();
        //display the error page
        $error->display($message);

    }


}
