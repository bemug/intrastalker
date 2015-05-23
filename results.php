<?php
include_once 'db.php';
$con = mysqli_connect($ADDR, $USER, $PASS, $DB);
// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    die();
}

include_once 'parse.php';

if (isset($_GET["search"])) {
    $search = mysqli_real_escape_string($con, $_GET["search"]);


    /*
     * Be careful, we're only able to use a single sql query for obvious reasons
     * such as updating.
     */

//searching a room
    if (preg_match("/^[de][0-9]{3}/", $search)) {
        ?>
        <div class="alert alert-danger"><p>Désolé, la recherche de salle n'est pas encore implémentée.</p></div>
        <?php
    }

//searching a pc
    else if (preg_match("/^intrapc[0-9]{1,3}/", $search)) {
        $result = mysqli_query_or_die($con, "(select distinct user, locked from w "
                . "left outer join pc on pc.name=w.pc_name "
                . "where pc_name='" . $search . "') "
                . "UNION "
                . "(select distinct user, locked from w "
                . "right outer join pc on pc.name=w.pc_name "
                . "where name='" . $search . "')");
        if (mysqli_num_rows($result) == 0) {
            echo "<div class='alert alert-danger'><p>Le pc " . $search . " est <b>éteint</b>.</p></div>";
        } else {
            $row = mysqli_fetch_array($result);
            if (empty($row['user'])) {
                echo "<div class='alert alert-warning'><p>Personne n'est connecté sur " . $search . ".</p></div>";
            } else if (mysqli_num_rows($result) == 1) {
                echo "<div class='alert alert-success'><p>L'utilisateur <b>" . $row['user'] . "</b> est connecté sur " . $search;
                //TODO detect ssh (use connected_from)
                if ($row["locked"]) {
                    echo " <span class='glyphicon glyphicon-lock'></span>";
                }
                echo ".</p></div>"; //TODO room        
            } else {
                echo "<div class='alert alert-success'><p>Plusieurs personnes sont connectées sur " . $search;
                if ($row["locked"]) {
                    echo " <span class='glyphicon glyphicon-lock'></span>";
                }
                echo ".";
                echo "<ul>";
                do {
                    //TODO detect ssh
                    echo "<li><b>" . $row["user"] . "</li>";
                } while ($row = mysqli_fetch_array($result));
                echo "</ul>";
                echo "</div>";
            }
        }
    }

//searching a user
    else {
        $result = mysqli_query_or_die($con, "select distinct user, w.pc_name, locked from w "
                . "left outer join pc on pc.name=w.pc_name "
                . "where user='" . $search . "'");

        if (mysqli_num_rows($result) == 0) {
            //Do we even know him?
            $result = mysqli_query_or_die($con, "select * from user where name='" . $search . "'");
            if (mysqli_num_rows($result) == 0) {
                echo "<div class='alert alert-danger'><p>L'utilisateur " . $search . " n'existe pas.</p></div>";
            } else {
                echo "<div class='alert alert-warning'><p>L'utilisateur " . $search . " n'est pas connecté.</p></div>";
            }
        } else if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_array($result);
            echo "<div class='alert alert-success'><p>L'utilisateur " . $search . " est connecté sur <b>";
            echo $row['pc_name'] . "</b>";
            //TODO detect ssh (use connected_from)
            if ($row["locked"]) {
                echo " <span class='glyphicon glyphicon-lock'></span>";
            }
            echo ".</p></div>"; //TODO room
        } else {
            echo "<div class='alert alert-success'><p>L'utilisateur " . $search . " est connecté sur plusieurs pcs :";
            echo "<ul>";
            while ($row = mysqli_fetch_array($result)) {
                echo "<li><b>" . $row["pc_name"];
                //TODO detect ssh (use connected_from)
                if ($row["locked"]) {
                    echo " <span class='glyphicon glyphicon-lock'></span>";
                }
                echo "</li>";
            }
            echo "</ul>";
            echo "</div>";
        }
    }
} else if (isset($_GET["display"])) {
    $display = mysqli_real_escape_string($con, $_GET["display"]);
    if ($display === "pc") {
        $result = mysqli_query_or_die($con, "select name from pc where name != '' order by name desc"); //TODO remove hotfix
        if (mysqli_num_rows($result) == 0) {
            echo "<div class='alert alert-danger'><p>Aucun PC n'est allumé.</p></div>";
        } else {
            echo "<div class='alert alert-success'>Les PCs suivant sont allumés :";
            echo "<ul>";
            while ($row = mysqli_fetch_array($result)) {
                echo "<li>".$row['name']."</li>";
            }
            echo "</ul>";
            echo "</div>";
        }
    }
}

mysqli_close($con);
?>
