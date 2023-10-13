<?php
    require_once 'includes/config.inc.assignment.php';
    require_once 'includes/dbClasses.inc.php';
    require_once 'includes/favorites.inc.php';

    session_start();

    if( ! isset($_SESSION["favorites"]) ){
        $_SESSION["favorites"] = [];
    }

    $favorites = $_SESSION["favorites"];

    $conn = DatabaseHelper::createConnection( array(DBCONNSTRING, DBUSER, DBPASS) );
    $songsGetter = new SongsDB($conn);

    // Filters the search results
    if( !empty($_GET["name"]) && !empty($_GET[$_GET["name"]]) )
        $str = "name=" . $_GET['name'] . "&" . $_GET['name'] . "=" . $_GET[$_GET['name']];
    else
        $str = "";
?>

<!DOCTYPE html>
<html lang=en>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" href="css/favorite.css" rel="stylesheet">
    <link type="text/css" href="css/main.css" rel="stylesheet">

    <title>View Favorites</title>
</head>

<body>
    <header class="header">
        <hr>
        <nav>
            <ul>
                <li><img src="imagesandicon/home.png" alt= "home icon" class="icon"/><a href="homePage.php">Home</a></li>
                <li><img src="imagesandicon/favorite.png" alt= "favorites icon" class="icon"/><a href="favoritesPage.php">Favorites</a></li>
                <li><img src="imagesandicon/search.png" alt= "search icon" class="icon"/><a href="searchPage.php">Search</a></li>
                <li><img src="imagesandicon/browse.png" alt= "browse icon" class="icon"/><a href="browse-searchResultsPage.php">Browse</a></li>
                <li><img src="imagesandicon/about.png" alt= "about us icon" class="icon"/><a href="aboutUs.html">About Us</a></li>
                <p class="desc">COMP 3512 - PHP Assignment &nbsp;&nbsp;&nbsp;&nbsp; Victor Alli, Marc Labso &nbsp;&nbsp;</p>
            </ul>
        </nav>
        <hr>
    </header>
    <h2>View Favorites</h2>
        <a href='includes/removeFavorites.inc.php?<?=$str?>' class= ' fav-button'>Remove All</a>
        <a href='browse-searchResultsPage.php?<?=$str?>' class= ' fav-button'>Return to Browse/Result Page</a>

    <main class="body">
        <article>
            <br>
            <br>
            <section>
                <?php
                    // Displays song already in favorites
                    if( !empty($_GET["text"]) ){
                        echo $_GET["text"]; 
                    }

                    echo "<table class='centre'>";
                    outputHeader();

                    // Outputs the favorite songs
                    foreach($favorites as $fav_id){
                        favoritesList($songsGetter->getSong($fav_id), $str);
                    }

                    echo "</table>";
                ?>
            </section>
        </article> 
        
    </main>

    <hr>
    <footer>
        <li>COMP 3512</li>
        <li>&copy;Victor Alli, Marc Labso</li>
        <li><a href="https://github.com/AlliVictor/COMP3512Assg1">Github Repository</a></li>
    </footer>
    <hr>
</body>
</html>