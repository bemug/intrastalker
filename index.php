<?php
    include 'ascii.html';
    session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Intrastalker</title>
    <link href="//netdna.bootstrapcdn.com/bootswatch/3.1.1/cosmo/bootstrap.min.css" rel="stylesheet">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

    <?php
    if (isset($_SESSION['user'])) {
        echo "</head>";
        echo "<body>";
        include_once 'nav.php'; ?>
        <div class="container">
        <?php
            include_once 'search.php';
            echo "<br/>";
            if( (isset($_GET['search']) && !empty($_GET['search']))
                    || (isset($_GET['display']) && !empty($_GET['display'])) ) {
                include_once 'results.php';
            } else {
                include_once 'welcome.php';
            }
        ?>
        <p class="text-right" style="color:lightgray"><small>Propulsé par ta mère</small></p>
        </div> <!-- container -->
        </body>
        <?php }
    else {
        include_once 'formlogin.php';
    } ?>

</html>
