<?php
/**
 * Function outputting the header of the favorites table for the view favorites PHP
 */
    function outputHeader(){
        echo "<tr>";
        echo "<th>Title</th>";
        echo "<th>Artist</th>";
        echo "<th>Year</th>";
        echo "<th>Genre</th>";
        echo "<th>Popularity</th>";
        echo "<th></th>";
        echo "<th></th>";
        echo "</tr>";
    }

    /**
 * outputFavorites function.
 *
 * Outputs a table list of the songs, the aritst name, year, genre and popularity.
 * Also allows the user to remove or view details of the song. 
 */
    function favoritesList($fav_id, $search){
        foreach($fav_id as $fav){?>
            <tr>
                <td><a href='single-song.php?id=<?=$f['song_id']?>'><?=$fav['title']?></a></td>
                <td><?=$fav['artist_name']?></td>
                <td><?=$fav['year']?></td>
                <td><?=$fav['genre_name']?></td>
                <td><?=$fav['popularity']?></td>
                <td><a href='removeFavorites.inc.php?id=<?=$fav['song_id']?>&<?=$search?>'><button class="rm">remove</button></a></td>
                <td><a href='singleSongPage.php?id=<?=$fav['song_id']?>'><button class="view">view</button></a></td>
            </tr>
        <?php }   
    }
?>
