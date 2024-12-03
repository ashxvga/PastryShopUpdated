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
    //handle an error
    public function error($message):void{
        //create an object of the Error class
        $error = new PastryError();

        //display the error page
        $error->display($message);

    }

}