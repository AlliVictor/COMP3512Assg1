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
        <h1>COMP 3512 - PHP Assignment</h1>
        <h3>Victor Alli, Marc Labso<h3>
        <hr>
        <nav>
            <ul>
                <li><img src="imagesandicon/home.png" alt= "home icon"/><a href="homePage.php">Home</a></li>
                <li><img src="imagesandicon/favorite.png" alt= "favorites icon"/><a href="favoritesPage.php">Favorites</a></li>
                <li><img src="imagesandicon/search.png" alt= "search icon"/><a href="searchPage.php">Search</a></li>
                <li><img src="imagesandicon/browse.png" alt= "browse icon"/><a href="browse-searchResultsPage.php">Browse</a></li>
                <li><img src="imagesandicon/about.png" alt= "about us icon"/><a href="aboutUs.html">About Us</a></li>
            </ul>
        </nav>
        <hr>
    </header>

    <h2>View Favorites</h2>

    <main class="body">
        <a href='includes/removeFavorites.inc.php?<?=$str?>' class= 'favs button'>Remove All</a>

        <!--Returns to filtered search results-->
        <a href='browse-searchResultsPage.php?<?=$str?>' class= 'favs button'>Return to Browse/Result Page</a>

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

    <footer>
        <p>COMP 3512</p>
        <p>&copy;Victor Alli, Marc Labso</p>
        <a href="https://github.com/AlliVictor/COMP3512Assg1">Github Repository</a>
    </footer>
</body>
</html>