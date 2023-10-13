<?php
    function outputHeader(){
        echo "<tr>";
        echo "<th>Title</th>";
        echo "<th>Artist</th>";
        echo "<th>Year</th>";
        echo "<th>Genre</th>";
        echo "<th>Popularity</th>";
        echo "<th>View</th>";
        echo "<th>Remove</th>";
        echo "</tr>";
    }

    // Outputs a table list of the songs, the aritst name, year, genre and popularity.
    // The user can also remove or view details of the song. 
    function favoritesList($fav_id, $search){
        foreach($fav_id as $fav){?>
            <tr>
                <td class='song-title'><a href='single-song.php?id=<?=$f['song_id']?>'><?=$fav['title']?></a></td>
                <td><?=$fav['artist_name']?></td>
                <td><?=$fav['year']?></td>
                <td><?=$fav['genre_name']?></td>
                <td><?=$fav['popularity']?></td>
                <td><a href='./singleSongPage.php?id=<?=$fav['song_id']?>'><button class="button">View</button></a></td>
                <td><a href='includes/removeFavorites.inc.php?id=<?=$fav['song_id']?>&<?=$search?>'><button class="button">Remove</button></a></td>
            </tr>
        <?php }   
    }
?>
