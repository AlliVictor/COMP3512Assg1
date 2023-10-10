<?php
    function display($sec){
        
        $minutes = floor($sec/60);
        $ss = $sec%60;
        echo "$minutes:$ss";
       
    }
?>