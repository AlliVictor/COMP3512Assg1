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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" href="css/singleSongPage.css" rel="stylesheet">
    <link type="text/css" href="css/main.css" rel="stylesheet">

    <title><?=$song[0]['title']?><?=$song[0]['artist_name']?></title>
    
</head>

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


    
<main class="body">

    <h2>Song Info</h2>
    <table class="song-table">
    <?php
       foreach($song as $songName){ ?>
        <tr>
           <td><b>Song:</b> <?= $songName['title']; ?></td>
           <td><b>Artist:</b> <?= $songName['artist_name']; ?></td>
           <td><b>Artist Type:</b> <?= $songName['type_name']; ?></td>
           <td><b>Genre:</b> <?= $songName['genre_name']; ?></td>
           <td><b>Year:</b> <?= $songName['year']; ?></td>
           <td><b>Duration:</b> <?= display($songName['duration']); ?></td>
       </tr>
     <?php  } ?>
    </table>
    <br>
    
    <br>
    <h2> Analysis Data</h2>
    <table class="analysis-table">
        <?php
        foreach($song as $songName){ ?>
            <tr>
                <td><b>BPM:</b> <?= $songName['bpm']; ?></td>
                <td><b>Energy:</b> <?= $songName['energy']; ?></td>
                <td><b>Danceability:</b> <?= $songName['danceability']; ?></td>
                <td><b>Liveness:</b> <?= $songName['liveness']; ?></td>
                <td><b>Valence:</b> <?= $songName['valence']; ?></td>
                <td><b>Acousticness:</b> <?= $songName['acousticness']; ?></td>
                <td><b>Speechiness:</b> <?= $songName['speechiness']; ?></td>
                <td><b>Popularity:</b> <?= $songName['popularity']; ?></td>
            </tr>
        <?php } ?>
    </table>

</main>

    <img src="imagesandicon/singlesong.gif" alt= "single song" class="single"/>
   <br>
    <footer>
        <li>COMP 3512</li>
        <li>&copy;Victor Alli, Marc Labso</li>
        <li><a href="https://github.com/AlliVictor/COMP3512Assg1">Github Repository</a></li>
    </footer>
</html>
</main>