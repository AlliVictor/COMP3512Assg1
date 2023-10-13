<?php
function searchResults($songs, $name, $search){
        echo "<table>";
        echo "<tr>";
        echo "<th>Title</th>";
        echo "<th>Artist</th>";
        echo "<th>Year</th>";
        echo "<th>Genre</th>";
        echo "<th>Popularity</th>";
        echo "<th>Add</th>";
        echo "<th>View</th>";
       
        echo "</tr>";
        foreach ($songs as $s) { ?>
            <tr>
                <td class='song-title'>
                    <a href='singleSongPage.php?id=<?=$s['song_id']?>'>
                        <?php
                        if (strlen($s['title']) > 25) {
                            echo substr($s['title'], 0, 25) . "&hellip;";
                        } else {
                            echo $s['title'];
                        }
                        ?>
                    </a>
                </td>
                <td><?=$s['artist_name']?></td>
                <td><?=$s['year']?></td>
                <td><?=$s['genre_name']?></td>
                <td><?=$s['popularity']?></td>
                <td><a href='includes/addFavorites.inc.php?id=<?=$s['song_id']?>&name=<?=$name?>&<?=$name?>=<?=$search?>' ><button class='button'>Add</button></a></td>
                <td><a href='./singleSongPage.php?id=<?=$s['song_id']?>' ><button class='button'>View</button></a></td>
            </tr>
        <?php }
        echo "</table>";
    } 

    // Outputs the genre of the songs selected
    function genreList($songs){
        foreach($songs as $sList){
            echo "<option value='".$sList['genre_id']."'>".$sList['genre_name']."</option>";
        }
    }

    // Outputs the aritst of the songs selected
    function artistList($artist){
        foreach($artist as $a){
            echo "<option value='".$a['artist_id']."'>".$a['artist_name']."</option>";
        }
    }
?>