<?php
/**
 * Author: Kierra White
 * Date: 11/21/2024
 * File: index_view.class.php
 * Description:
 */

//parent class of all the other view classes
class IndexView{
    //method to display the header
    static public function displayHeader($page_title): void{
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <title> <?php echo $page_title ?> </title>
            <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
            <link type='text/css' rel='stylesheet' href='<?= BASE_URL ?>/www/css/app_style.css' />
        <script>
            //creates the JavaScript variable for the base url
        var base_url = "<?= BASE_URL ?>";
        </script>
        </head>
        <body>
        <!-- nav bar-->
        <nav>
            <ul>
                <li><a href="<?=BASE_URL ?>/welcome/index">Home</a></li>
                <li><a href="<?= BASE_URL ?>/pastry/index">Menu</a></li>
                <li><a href="<?= BASE_URL ?>/pastry/login">Login</a></li>
                <li><a href="<?= BASE_URL ?>/pastry/register"> Register</a></li>
            </ul>
        </nav>

        <script>
            var media = "pastry";
        </script>
        <!--create the search bar -->
        <div id="searchbar">
            <form method="get" action="<?= BASE_URL ?>/pastry/search">
                <input type="text" name="query" id="searchtextbox" placeholder="Search pastry by name" autocomplete="off" onkeyup="handleKeyUp(event)">
                <input type="submit" value="Go" />
            </form>
            <div id="suggestionDiv"></div>
        </div>

        <?php
    }//end of the header

        //this displays the footer
        public static function displayFooter(): void
        {
        ?>
        <div id="footer">
            <br>
            <p>&copy; 2024 Pastry Project. All Rights Reserved. </p>

        </div>
            <script type="text/javascript" src="<?= BASE_URL ?>/www/js/ajax_autosuggestion.js"></script>
        </body>
</html>
<?php
        }


}