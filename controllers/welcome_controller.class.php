<?php
/**
 * Author: Kierra White
 * Date: 11/21/2024
 * File: welcome_controller.class.php
 * Description:
 */

class WelcomeController {
    //put your code here
    public function index(): void
    {
        $view = new WelcomeIndex();
        $view->display();
    }
}