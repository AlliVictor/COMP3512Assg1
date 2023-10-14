<?php
// this displays the time and rounds the value down to nearest integer
    function display($sec){
        
        $minutes = floor($sec/60);
        $ss = $sec%60;
        echo "$minutes:$ss";
       
    }
?>