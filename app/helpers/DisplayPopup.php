<?php

class DisplayPopup
{
    public static function openPopup($url){
        echo "<script type='text/javascript'>window.open('$url', 'popup', 'width=600,height=400');</script>";
    }
    
}  

?>
