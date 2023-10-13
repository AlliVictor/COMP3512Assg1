<?php
    require_once 'includes/config.inc.assignment.php';
    require_once 'includes/dbClasses.inc.php';
    require_once 'includes/browse-searchResult.inc.php';

    try{
        $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
        $songsGetter = new SongsDB($conn);
        $artistGetter = new ArtistsDB($conn);
        $genreGetter = new GenresDB($conn);

        $name="";

        if( !empty($_GET['title']) ){
            $songs = $songsGetter->getAllSongsWithTitle($_GET['title']);
            $message = "Showing all songs with '" . $_GET['title'] . "' in Title";
            $name = "title";
        }
        else if( !empty($_GET['artistList']) && $_GET['artistList'] > 0){
            $artist_data = $artistGetter->getArtist($_GET['artistList']);
            $songs = $songsGetter->getAllSongsWithArtist($artist_data[0]['artist_name']);
            $message = "Showing all songs by " . $artist_data[0]['artist_name'];
            $name = "artistList";
        }
        else if( !empty($_GET['genreList']) && $_GET['genreList'] > 0 ){
            $genre_data = $genreGetter->getGenre($_GET['genreList']);
            $songs = $songsGetter->getAllSongsWithGenre($genre_data[0]['genre_name']);
            $message = "Showing all " . $genre_data[0]['genre_name'] . " songs in Genre";
            $name = "genreList";
        }
        else if( !empty($_GET['year-before-value']) ){
            $songs = $songsGetter->getAllSongsWithBeforeYear($_GET['year-before-value']);
            $message = "Showing all songs before the year " . $_GET['year-before-value'];
            $name = "year-before-value";
        }
        else if( !empty($_GET['year-after-value']) ){
            $songs = $songsGetter->getAllSongsWithAfterYear($_GET['year-after-value']);
            $message = "Showing all songs after the year " . $_GET['year-after-value'];
            $name = "year-after-value";
        }
        else if( !empty($_GET['pop-less-value']) ){
            $songs = $songsGetter->getAllSongsWithLowPopularity($_GET['pop-less-value']);
            $message = "Showing all songs with popularity less than " . $_GET['pop-less-value'];
            $name = "pop-less-value";
        }
        else if( !empty($_GET['pop-greater-value']) ){
            $songs = $songsGetter->getAllSongsWithHighPopularity($_GET['pop-greater-value']);
            $message = "Showing all songs with popularity greater than " . $_GET['pop-greater-value'];
            $name = "pop-greater-value";
        }
        else{
            $songs = $songsGetter->showAllSongs();
            $message = "";
        }
        // get query strings
        $search = isset($_GET[$name]) ? $_GET[$name] : '';
    } catch(Exception $e){
        die($e->getMessage());
    }
?>

<!DOCTYPE html>
<html lang=en>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" href="css/browse-searchResults.css" rel="stylesheet">
    <link type="text/css" href="css/main.css" rel="stylesheet">

    <title>Browse/Search</title>
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

    <h2>Browse / Search Results</h2>
    <a href='browse-searchResultsPage.php' class= 'search-button'>Show All</a>

    <main class="body">
        <h3><?php echo $message; ?></h3>
        
        <article>
            <section>
                <?php
                /*
                * outputs the songs that contains the requirements the user is seraching for
                */
                    searchResults($songs, $name, $search);
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