<?php   
    require_once 'includes/dbClasses.inc.php';
    require_once 'includes/config.inc.assignment.php';
    require_once 'includes/singleSongPage.inc.php';

    try{
        $conn = DatabaseHelper::createConnection(array(DBCONNSTRING,DBUSER,DBPASS));
        $songGetter = new SongsDB($conn);

        if( !empty($_GET['id']) ){
            $song = $songGetter->getSong($_GET['id']);
        }
    }
    catch (Exception $e){ die($e->getMessage());}   
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" href="css/homePage.css" rel="stylesheet">
    <link type="text/css" href="css/singleSongPage.css" rel="stylesheet">

    <title><?=$song[0]['title']?><?=$song[0]['artist_name']?></title>
    
</head>

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

    <h2>Song Info</h2>

<main class="body">
    <?php
        foreach($song as $songName){
            echo " <b> Song: </b> ".$songName['title']."<br>";
            echo "<br>";
            echo "<b> Artist: </b> ". $songName['artist_name']."<br>";
            echo "<br>";
            echo "<b> Artist type: </b> ". $songName['type_name']."<br>";
            echo "<b> Genre: </b> ". $songName['genre_name']."<br>";
            echo "<b> Year: </b> ". $songName['year']."<br>";
            echo "<b> Duration: </b> "; 
            display($songName['duration']);
            echo "<b> minutes </b>". "<br>";

                } 
                echo "<br>";
            echo "<p><b>Analysis Data</b></p>";
            echo "<br>";
            foreach($song as $songName){ ?>
                <li><?= '<b> BPM: </b>' . $songName['bpm'];?></li>
                <li><?= '<b> Energy: </b>  ' . $songName['energy'];?></li>
                <li><?= '<b> Danceability: </b>  ' . $songName['danceability'];?></li>
                <li><?= '<b> Liveness: </b>  ' . $songName['liveness'];?></li>
                <li><?= '<b> Valence: </b>' . $songName['valence'];?></li>
                <li><?= '<b> Acousticness: </b>  ' . $songName['acousticness'];?></li>
                <li><?= '<b> Speechiness: </b> ' . $songName['speechiness'];?></li>
                <li><?= '<b> Popularity: </b> ' . $songName['popularity'];?></li>
    <?php }
           
        ?>

    <footer>
        <p>COMP 3512</p>
        <p>&copy;Victor Alli, Marc Labso</p>
        <a href="https://github.com/AlliVictor/COMP3512Assg1">Github Repository</a>
    </footer>
</html>
</main>