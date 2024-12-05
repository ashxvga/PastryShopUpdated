<?php
/**
 * Author: Kierra White
 * Date: 11/21/2024
 * File: welcome_index.class.php
 * Description:
 */
class WelcomeIndex extends IndexView {

    public function display(): void
    {
        //display page header
        parent::displayHeader("Pastry Home");

        ?>
        <section id = "homePageIntro">
            <img src="<?= BASE_URL ?>/www/img/homePageIntro.jpg" title="Intro Picture"/>

        <div>
            <h1>Welcome to Our MVC Website</h1>
            <p>This project is an MVC-based concept for a pastry shop, focusing on organization and functionality.</p>
        </div>
        </section>

        <?php
        //display page footer
        parent::displayFooter();

    }
}
