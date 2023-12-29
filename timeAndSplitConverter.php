<?php
//insert an into or double as seconds (up to one decimal)
//retruns in the format mins:secs.fracSec
//can be used for both splits and total piece time (in mins)
function formatTime($time){
    //multiply by 10 so the modulus doesn't get cut off
    $temp = $time*10;
    //modulus 600 to get the remaining secs
    $secs = $temp%600;
    //get the number of seconds remaining in a new var
    $mins = ($temp-$secs);
    //divide both by 10 to remove the previously applied *10
    $secs /=10;
    $mins/=10;
    //divide the mins var by 60 to get the number of full minutes to second
    $mins /= 60;
    //return the number as a string formatted
    if($secs < 10){
        return "".$mins.":0".$secs;
    }
    return "".$mins.":".$secs;
}


?>
