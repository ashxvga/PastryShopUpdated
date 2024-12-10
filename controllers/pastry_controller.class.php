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
    public function detail($pastryId): void {
        try {
            $pastry = $this->pastry_model->get_pastry_by_id($pastryId);
            if (!$pastry) {
                throw new DataMissingException("There was a problem displaying the pastry with id = '$pastryId'.");
            }

            // Display the pastry details
            $view = new PastryDetail();
            $view->display($pastry);

        } catch (DataMissingException $e) {
            $this->error($e->getMessage());
        }
    }

    public function index(): void {
        try {
            $pastries = $this->pastry_model->get_all_pastries();
            if (!$pastries) {
                throw new DatabaseExecutionException("There was a problem displaying the pastries.");
            }

            $view = new PastryIndex();
            $view->display($pastries);

        } catch (DatabaseExecutionException $e) {
            $this->error($e->getMessage());
        }
    }


    //display a pastry in a form for editing
    public function edit($id): void {
        try {
            $pastry = $this->pastry_model->get_pastry_by_id($id);
            if (!$pastry) {
                throw new DataMissingException("There was a problem displaying the pastry with id = '$id'.");
            }

            $view = new PastryEdit();
            $view->display($pastry);

        } catch (DataMissingException $e) {
            $this->error($e->getMessage());
        }
    }

    //update a pastry in the database
    public function updatePastry($id): void {
        try {
            $update = $this->pastry_model->update_pastry($id);
            if (!$update) {
                throw new DatabaseExecutionException("There was a problem updating the pastry with id = '$id'.");
            }

            // Display the updated pastry details
            $confirm = "The pastry was successfully updated.";
            $pastry = $this->pastry_model->get_pastry_by_id($id);
            $view = new PastryDetail();
            $view->display($pastry, $confirm);

        } catch (DatabaseExecutionException $e) {
            $this->error($e->getMessage());
        }
    }


    //update a category in the database
    public function updateCategory($id): void {
        try {
            $update = $this->pastry_model->update_category($id);
            if (!$update) {
                throw new DatabaseExecutionException("There was a problem updating the category with id = '$id'.");
            }

        } catch (DatabaseExecutionException $e) {
            $this->error($e->getMessage());
        }
    }
    //delete pastry
    public function delete($id): void {
        try {
            $delete = $this->pastry_model->delete_pastry($id);
            if (!$delete) {
                throw new DatabaseExecutionException("There was a problem deleting the pastry with id = '$id'.");
            }

            // Redirect or display success message
            header("Location: " . BASE_URL . "/pastry/index");
            exit();

        } catch (DatabaseExecutionException $e) {
            $this->error($e->getMessage());
        }
    }


    public function getPastryModel(): PastryModel
    {
        return $this->pastry_model;
    }


    public function add(): void {
        try {
            $display = new PastryAdd();
            $display->display();

        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function createPastry(): void {
        try {
            $name = $_POST['name'] ?? null;
            $description = $_POST['description'] ?? null;
            $price = $_POST['price'] ?? null;
            $categoryId = $_POST['category_id'] ?? null;

            if (empty($name) || empty($description) || empty($price) || empty($categoryId)) {
                throw new DataMissingException("All fields are required to add a new pastry.");
            }

            $added = $this->pastry_model->add_pastry($name, $description, (float)$price, (int)$categoryId);
            if (!$added) {
                throw new DatabaseExecutionException("There was a problem adding the new pastry.");
            }

            echo "The pastry was successfully added.";

        } catch (DataMissingException | DatabaseExecutionException $e) {
            $this->error($e->getMessage());
        }
    }

    //search pastries
    public function search(): void {
        try {
            $query_terms = trim($_GET['query'] ?? "");

            if ($query_terms === "") {
                $this->index();
                return;
            }

            $pastries = $this->pastry_model->search_pastries($query_terms);

            if ($pastries === 0) {
                throw new DataMissingException("No results found for the search term '$query_terms'.");
            } elseif (!$pastries) {
                throw new DatabaseExecutionException("An error has occurred during the search.");
            }

            $search = new PastrySearch();
            $search->display($query_terms, $pastries);

        } catch (DataMissingException | DatabaseExecutionException $e) {
            $this->error($e->getMessage());
        }
    }

    //autosuggestion for search terms
    public function suggest($terms): void {
        try {
            $query_terms = urldecode(trim($terms));
            $pastries = $this->pastry_model->search_pastries($query_terms);

            $names = array();
            if ($pastries) {
                foreach ($pastries as $pastry) {
                    $names[] = $pastry->getName();
                }
            }

            echo json_encode($names);

        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }

    //handle an error
    public function error($message):void{
        //create an object of the Error class
        $error = new PastryError();
        //display the error page
        $error->display($message);
    }

}
