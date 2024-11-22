<?php 
class Redirect {
    public static function to($location) {
        header("Location: $location");
    }
}
function redirect($page){
    header('location:'.URLROOT.'/'.$page);
}
?>