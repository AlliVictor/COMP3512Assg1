<?php
    session_start();

    // Checks if session already exists, if not, initialize an empty array
    if( !isset($_SESSION["favorites"]) ){
        $_SESSION["favorites"] = [];
    }

    // Collect current favorites and resave the modified array to the session
    $favorites = $_SESSION["favorites"];

    if( !empty($_GET["name"]) && !empty($_GET[$_GET["name"]]) )
        $str = "name=" . $_GET['name'] . "&" . $_GET['name'] . "=" . $_GET[$_GET['name']];
    else
        $str = "";

    // Checks if the songs are already in favorites
    if( !array_search($_GET["id"], $favorites) ){
        $favorites[] = $_GET["id"];
        $_SESSION["favorites"] = $favorites;
        
        // Sends to favorites
        header("Location: ../favoritesPage.php?$str");
    } else{
        $message = "Song already in favorites";
        header("Location: ../favoritesPage.php?text=$message&$str");
    }
?>
