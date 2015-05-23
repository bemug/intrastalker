<?php
/* Cortesy of ColasV (https://github.com/ColasV) */
function isIntra($user,$mdp) {
    $url = "URl_TO_TRY_AUTHENT";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERPWD, $user.":".$mdp);
    $result = curl_exec($ch);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);
    if(curl_exec($ch) === false) {
        return false;
    } else {
        return true;
    }

    curl_close($ch);
}

include_once 'db.php';
$con = mysqli_connect($ADDR, $USER, $PASS, $DB);
// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    die();
}

$user = mysqli_real_escape_string($con, $_POST['login']);
$mdp = mysqli_real_escape_string($con, $_POST['password']);
  
if (isIntra($user, $mdp)) {
    session_start();
    $_SESSION['user'] = $user;
    header('Location: index.php');
}
else {
    header('Location: index.php?msg=logerror&user='.$user);
}

mysqli_close($link);

?>
