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
    <link type="text/css" href="css/searchPage.css" rel="stylesheet">
    <link type="text/css" href="css/homePage.css" rel="stylesheet">

    <title><?=$song[0]['title']?><?=$song[0]['artist_name']?></title>
    
</head>

<header class="header">
    <h1>COMP 3512 - PHP Assignment</h1>
        <h3>Victor Alli, Marc Labso<h3>
        <hr>
        <nav>
            <ul>
                <li><img src="icons/home.PNG" alt= "home icon"/><a href="homePage.php">HOME</a></li>
                <li><img src="icons/fav.PNG" alt= "favorites icon"/><a href="favoritesPage.php">VIEW FAVORITES</a></li>
                <li><img src="icons/search.PNG" alt= "search icon"/><a href="searchPage.php">SEARCH</a></li>
                <li><img src="icons/browse.PNG" alt= "browse/search icon"/><a href="browse-searchResultsPage.php">BROWSE/SEARCH</a></li>
            </ul>
        </nav>
        <hr>
    </header>

    <h2>Song Info</h2>

<main class="body">
    <?php
        foreach($song as $songName){
            echo " <b> Song: ".$songName['title']. "</b>"."<br>";
            echo "<br>";
            echo "<b> Artist: ". $songName['artist_name']. "</b>"."<br>";
            echo "<br>";
            echo "Artist type: ". $songName['type_name']."<br>";
            echo "Genre: ". $songName['genre_name']."<br>";
            echo "Year: ". $songName['year']."<br>";
            echo "Duration: "; 
            display($songName['duration']);
            echo " minutes<br>";

                } 
                echo "<br>";
            echo "<p><b>Analysis Data</b></p>";
            echo "<br>";
            foreach($song as $songName){ ?>
                <li><?= 'BPM: ' . $songName['bpm'];?></li>
                <li><?= 'Energy: ' . $songName['energy'];?></li>
                <li><?= 'Liveness: ' . $songName['liveness'];?></li>
                <li><?= 'Danceability: ' . $songName['danceability'];?></li>
                <li><?= 'Valence: ' . $songName['valence'];?></li>
                <li><?= 'Acousticness: ' . $songName['acousticness'];?></li>
                <li><?= 'Popularity: ' . $songName['popularity'];?></li>
    <?php }
           
        ?>

<footer>
    <p>COMP 3512</p><p>&copy;Victor Alli, Marc Labso</p><a href="https://github.com/AlliVictor/COMP3512Assg1">Github Repository</a> 
    </footer>
</html>
</main>