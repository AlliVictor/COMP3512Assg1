<?php

include_once 'includes/dbClasses.inc.php';
require_once 'includes/config.inc.assignment.php';
require_once 'includes/browse-searchResult.inc.php';



try{
    $conn = DatabaseHelper::createConnection(array(DBCONNSTRING,DBUSER,DBPASS));
    $songGetter = new GenresDB($conn);
    $artistGetter = new ArtistsDB($conn);
    $song = $songGetter->getAll();
    $artist = $artistGetter->getAll();
}
catch (Exception $e){ die($e->getMessage());}   
?>





<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" href="css/searchPage.css" rel="stylesheet">

    <title>Song Search</title>
    
</head>

<body>
    
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

    <h1>Song Search</h1>
    <form action="browse-searchResultsPage.php" method="GET">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title"><br>

        <label>Artist:</label>
        <select name="artistList" title="artist">
        <option value='0'>Choose An Artist</option>
                    <?=artistList($artist);?>
        </select>

        <label>Genre:</label>
        <select name="genreList" title="genre">
        <option value='0'>Choose A Genre</option>
                    <?=genreList($song)?><br>
        </select>

        <label>Year:</label>
        <label for="year-before">Before
                        <input type="text" for="year-before" name="year-before-value" title="text-year-before">
                    </label>
                    <label for="year-after">After
                        <input type="text" for="year-after" name="year-after-value" title="text-year-after">
                    </label><br>

                    <label>Popularity</label>
                    <label for="pop-less">Less
                        <input type="text" for="pop-less" name="pop-less-value" title="text-popularity-less">
                    </label>
                    <label for="pop-greater">Greater
                        <input type="text" for="pop-greater" name="pop-greater-value" title="text-popularity-greater">
                    </label></br>

        <button type="submit">Search</button>
    </form>
</body>

</html>