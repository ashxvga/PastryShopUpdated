<?php
/**
 * Author: Kierra White
 * Date: 11/21/2024
 * File: pastry_index_view.class.php
 * Description:
 */
class PastryIndexView extends IndexView{
    public static function displayHeader($name): void{
        parent::displayHeader($name)
    ?>
        <script>
            var media = "pastry";
        </script>
        <!--create the search bar -->
        <div id="searchbar">
            <form method="get" action="<?= BASE_URL ?>/pastry/search">
                <input type="text" name="query-terms" id="searchtextbox" placeholder="Search pastry by name" autocomplete="off" onkeyup="handleKeyUp(event)">
                <input type="submit" value="Go" />
            </form>
            <div id="suggestionDiv"></div>
        </div>


        <?php
    }

    public static function displayFooter(): void
    {
        parent::displayFooter();
    }

}