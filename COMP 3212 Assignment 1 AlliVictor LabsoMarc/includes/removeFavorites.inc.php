<?php
// this removes a song in favorites page
    session_start();

    if( !empty($_GET['id']) ){
        // Remove the single song and resave it to the session
        $favorites = $_SESSION["favorites"];
        unset($favorites[array_search($_GET["id"], $favorites)]);
        $_SESSION["favorites"] = $favorites;
    } else{
        // Clear all favorites from session
        $_SESSION["favorites"] = [];
    }

    if( !empty($_GET["name"]) && !empty($_GET[$_GET["name"]]) )
        $str = "name=" . $_GET['name'] . "&" . $_GET['name'] . "=" . $_GET[$_GET['name']];
    else
        $str = "";

    // Sends to favorites
    header("Location: ../favoritesPage.php?$str");
?>