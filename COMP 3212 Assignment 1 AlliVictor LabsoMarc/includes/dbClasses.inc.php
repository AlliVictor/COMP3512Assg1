<?php
    // A class used to reduce repeat code when dealing with a database.
    // Refrence: from Lab14a.
    class DatabaseHelper{
    
        public static function createConnection($values = array()){
            $connString = $values[0];
            $user = $values[1];
            $pass = $values[2];

            // create new connection
            $pdo = new PDO($connString, $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            return $pdo;
        }

        // Runs the specified SQL query using the passed connection and
        // the passed array of parameters (null if none) 
        public static function runQuery($connection, $sql, $parameters){
            $statement = null;
        
            // if there are parameters then fdo a prepared statement
            if(isset($parameters)){
                // Ensure parameters are in an array
                if(!is_array($parameters)){
                    $parameters = array($parameters);
                }

                // Use a prepared statement if parameters
                $statement = $connection->prepare($sql);
                $executedOk = $statement->execute($parameters);

                if(!$executedOk) throw new PDOException;
            } else{
                // Execute a normal query
                $statement = $connection->query($sql);
                if(!$statement) throw new PDOException;
            }

            return $statement;
        }
    }

    /**
     * A class containing all functions that will be used to access the songs table from the database.
     */
    class SongsDB{
        private static $baseSQL = "SELECT song_id, bpm, energy, danceability, liveness, valence, acousticness, 
        speechiness, popularity, title, duration, artist_name, year, genre_name, popularity,type_name FROM 
        artists INNER JOIN songs ON songs.artist_id = artists.artist_id INNER JOIN genres ON 
        songs.genre_id = genres.genre_id INNER JOIN types ON artists.artist_type_id=types.type_id";

        public function __construct($connection){
            $this -> pdo = $connection;
        }

        // Returns all songs from the database and orders them by title.
        public function showAllSongs(){
            $sql = self::$baseSQL . " ORDER BY title";

            $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
            return $statement->fetchAll();
        }
        
        // Returns all songs that have a specified word or phrase in it and orders them by title.
        public function getAllSongsWithTitle($title){
            $sql = self::$baseSQL . " WHERE title LIKE ? ORDER BY title";

            $statement = DatabaseHelper::runQuery($this->pdo, $sql, Array('%' . $title . '%'));
            return $statement->fetchAll();
        }

        // Returns all songs for the specified artist name and orders them by title.
        public function getAllSongsWithArtist($artistName){
            $sql = self::$baseSQL . " WHERE artist_name=? ORDER BY title";

            $statement = DatabaseHelper::runQuery($this->pdo, $sql, Array($artistName));
            return $statement->fetchAll();
        }

        // Returns all songs with the specified genre name and orders them by title.
        public function getAllSongsWithGenre($genreName){
            $sql = self::$baseSQL . " WHERE genre_name=? ORDER BY title";

            $statement = DatabaseHelper::runQuery($this->pdo, $sql, Array($genreName));
            return $statement->fetchAll();
        }

        // Returns all songs before the specified year and orders them by year.
        public function getAllSongsWithBeforeYear($year){
            $sql = self::$baseSQL . " WHERE year<? ORDER BY year";

            $statement = DatabaseHelper::runQuery($this->pdo, $sql, Array($year));
            return $statement->fetchAll();
        }

        // Returns all songs after the specified year and orders them by year.
        public function getAllSongsWithAfterYear($year){
            $sql = self::$baseSQL . " WHERE year>? ORDER BY year";

            $statement = DatabaseHelper::runQuery($this->pdo, $sql, Array($year));
            return $statement->fetchAll();
        }

        // Returns all songs with lower popularity than the specified number and orders them by popularity.
        public function getAllSongsWithLowPopularity($popularity){
            $sql = self::$baseSQL . " WHERE popularity<? ORDER BY popularity";

            $statement = DatabaseHelper::runQuery($this->pdo, $sql, Array($popularity));
            return $statement->fetchAll();
        }

        // Returns all songs with higher popularity than the specified number and orders them by popularity.
        public function getAllSongsWithHighPopularity($popularity){
            $sql = self::$baseSQL . " WHERE popularity>? ORDER BY popularity";

            $statement = DatabaseHelper::runQuery($this->pdo, $sql, Array($popularity));
            return $statement->fetchAll();
        }

        // Returns the information on the specified song, using the songID.
        public function getSong($songID){
            $sql = self::$baseSQL . " WHERE song_id=?";

            $statement = DatabaseHelper::runQuery($this->pdo, $sql, Array($songID));
            return $statement->fetchAll();
        }

        // Returns the top 10 songs in the popularity catergory.
        public function getTop10Popularity(){
            $sql = self::$baseSQL . ' ORDER BY popularity DESC LIMIT 10';

            $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
            return $statement->fetchAll();
        }

        // Returns the top 10 One Hit Wonders songs.
        public function getTop10OneHits(){
            $sql = " SELECT song_id, artists.artist_name, title, popularity FROM 
            songs INNER JOIN artists ON songs.artist_id=artists.artist_id GROUP BY 
            artist_name HAVING COUNT(artist_name)=1 ORDER BY popularity DESC LIMIT 10";

            $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
            return $statement->fetchAll();
        }

        // Returns the top 10 longest acoustic that is at least greater than 40.
        public function getTop10LongestAcoustic(){
            $sql = "SELECT song_id, title, acousticness, duration, artist_name FROM 
            songs INNER JOIN artists ON songs.artist_id=artists.artist_id WHERE 
            acousticness>40 ORDER BY duration DESC LIMIT 10";

            $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
            return $statement->fetchAll();
        }

        // Returns the top 10 songs ideal for club music.
        public function getTop10AtTheClub(){
            $sql = "SELECT song_id, title, danceability, artist_name, 
            (danceability*1.6) + (energy*1.4) AS calc FROM songs INNER JOIN 
            artists ON songs.artist_id=artists.artist_id WHERE danceability>80 
            ORDER BY calc DESC LIMIT 10";

            $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
            return $statement->fetchAll();
        }

        // Returns the top 10 songs ideal for running.
        public function getTop10RunningSongs(){
            $sql = "SELECT song_id, title, bpm, artist_name, (energy*1.3) + (valence*1.6) 
            AS calc FROM songs INNER JOIN artists ON songs.artist_id=artists.artist_id WHERE 
            bpm BETWEEN 120 AND 125 ORDER BY calc DESC LIMIT 10";

            $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
            return $statement->fetchAll();
        }

        // Returns the top 10 songs for studying.
        public function getTop10Studying(){
            $sql = "SELECT song_id, title, bpm, artist_name, speechiness, 
            (acousticness*0.8) + (100-speechiness) + (100-valence) AS calc FROM 
            songs INNER JOIN artists ON songs.artist_id=artists.artist_id WHERE 
            (bpm BETWEEN 100 AND 115) AND (speechiness BETWEEN 1 AND 20) ORDER BY 
            calc DESC LIMIT 10";

            $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
            return $statement->fetchAll();
        }
    }

    /**
     * A class containing all functions that will be used to access the artists table from the database.
     */
    class ArtistsDB{
        private static $baseSQL = "SELECT artist_id, artist_name FROM artists";

        public function __construct($connection){
            $this -> pdo = $connection;
        }

        // Returns all the artists from the database and order them by artist_name.
        public function getAll(){
            $sql = self::$baseSQL . " ORDER BY artist_name";

            $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
            return $statement->fetchAll();
        }

        // Returns the specified artist using the artist_id.
        public function getArtist($artistID){
            $sql = self::$baseSQL . " WHERE artist_id=?";

            $statement = DatabaseHelper::runQuery($this->pdo, $sql, Array($artistID));
            return $statement->fetchAll();
        }

        // Returns the top 10 artists based on the number of songs they have in the database.
        public function getTop10Artists(){
            $sql = "SELECT artist_name AS name, COUNT(artists.artist_id) 
            AS num FROM artists INNER JOIN songs ON artists.artist_id=songs.artist_id 
            GROUP BY artists.artist_id ORDER BY num DESC LIMIT 10";

            $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
            return $statement->fetchAll();
        }
    }

    /**
     * A class containing all functions that will be used to access the genres table from the database.
     */
    class GenresDB{
        private static $baseSQL = "SELECT genre_id, genre_name FROM genres";

        public function __construct($connection){
            $this -> pdo = $connection;
        }

        // Returns all the genres from the database and orders them by genre_name.
        public function getAll(){
            $sql = self::$baseSQL . " ORDER BY genre_name";

            $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
            return $statement->fetchAll();
        }

        // Returns the specified genre using the genre_id.
        public function getGenre($genre_id){
            $sql = self::$baseSQL . " WHERE genre_id=?";

            $statement = DatabaseHelper::runQuery($this->pdo, $sql, Array($genre_id));
            return $statement->fetchAll();
        }

        // Returns the top 10 genres based on the number of songs per genre.
        public function getTop10Genres(){
            $sql = "SELECT COUNT(songs.genre_id) AS num, genre_name 
            AS name FROM songs INNER JOIN genres ON songs.genre_id = genres.genre_id 
            GROUP BY songs.genre_id ORDER BY num DESC LIMIT 10";

            $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
            return $statement->fetchAll();
        }
    }

    /**
     * A class containing all functions that will be used to access the types table from the database.
     */
    class TypesDB{
        private static $baseSQL = "SELECT type_id, type_name FROM types";

        public function __construct($connection){
            $this -> pdo = $connection;
        }

        // Returns all the types from the database and orders them by type_name.
        public function getAll(){
            $sql = self::$baseSQL . " ORDER BY type_name";

            $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
            return $statement->fetchAll();
        }
    }

    // Outputs the top 10 categories ordered from highest to lowest
    function outputTop10Category($category){
        echo "<ul>";
        foreach($category as $c){
            echo "<li><span>" . $c['name'] . "</span> with " . $c['num'] . " songs</li>";
            echo "<br>";
        }
        echo "</ul>";
    }

    //Outputs the top 10 songs
    function outputTop10Songs($song){
        echo "<ul>";
        foreach($song as $s){ 
            echo '<li><span><a href="singleSongPage.php?id=' . $s['song_id'] . '">' . $s['title'] . '</a></span> 
            by ' . $s['artist_name'] . '</li>';
            echo "<br>";
        }
        echo "</ul>";
    }
?>