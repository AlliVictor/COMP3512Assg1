<?php
    require_once 'includes/dbClasses.inc.php';
    require_once 'includes/config.inc.assignment.php';

    try{
        $conn = DatabaseHelper::createConnection(array(DBCONNSTRING,DBUSER,DBPASS));
        $songGetter = new SongsDB($conn);
        $artistGetter = new ArtistsDB($conn);
        $genreGetter = new GenresDB($conn);
    }
    catch (Exception $e){ die($e->getMessage());}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" href="css/homePg.css" rel="stylesheet">
    <link type="text/css" href="css/main.css" rel="stylesheet">

    <title>Home | Song Bank</title>
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

    <h2>Top Music Categories</h2>

    <main class="body">
        <div class="mainbody">
            <div class="top-genre column"> 
                <h3>Top Genres</h3>
                <?php 
                    $genres = $genreGetter->getTop10Genres();
                    outputTop10Category($genres);
                ?>
            </div>
            
            <div class="top-artist column"> 
                <h3>Top Artists</h3>
                <?php 
                    $artists = $artistGetter->getTop10Artists();
                    outputTop10Category($artists);
                ?>
            </div>

            <div class="popular column"> 
                <h3>Most Popular Songs</h3>
                <?php 
                    $popular = $songGetter->getTop10Popularity();
                    outputTop10Songs($popular);
                ?>
            </div>

            <div class="one-hit column"> 
                <h3>One Hit Wonders</h3>
                <?php 
                    $oneHit = $songGetter->getTop10OneHits();
                    outputTop10Songs($oneHit);
                ?>
            </div>

            <div class="acoustic column"> 
            <h3>Longest Acoustic Songs</h3>
                <ul>
                    <?php
                        $longAcoustic = $songGetter->getTop10LongestAcoustic();
                        outputTop10Songs($longAcoustic);
                    ?>
            </ul>
            </div>

            <div class="club column"> 
                <h3>At The Club</h3>
                <?php 
                    $club = $songGetter->getTop10AtTheClub();
                    outputTop10Songs($club);
                ?>
            </div>

            <div class="running column"> 
                <h3>Running Songs</h3>
                <?php 
                    $run = $songGetter->getTop10RunningSongs();
                    outputTop10Songs($run);
                ?>
            </div>
            
            <div class="studying column"> 
                <h3>Studying</h3>
                <?php 
                    $study = $songGetter->getTop10Studying();
                    outputTop10Songs($study);
                ?>
            </div>
        </div>
    </div>

</br>
    
      
    <footer>
        <li>COMP 3512</li>
        <li>&copy;Victor Alli, Marc Labso</li>
        <li><a href="https://github.com/AlliVictor/COMP3512Assg1">Github Repository</a></li>
    </footer>
    
    
</body>
</html>