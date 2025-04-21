<?php
    // time Zone
    date_default_timezone_set('Asia/colombo');

    function converttimetoreadableformat($time){
        $time_ago= strtotime($time);
        $current_time = time();
        $time_difference = $current_time - $time_ago;    
        $seconds = $time_difference;
        $minutes = round($seconds / 60);
        $hours = round($seconds / 3600);
        $days = round($seconds / 86400);
        $weeks = round($seconds / 604800);
        $months = round($seconds / 2600640);
        $years = round($seconds / 31553280);
        // Seconds
        if($seconds <= 0) {
            return "Not published yet";
        }
        elseif($seconds <= 60){
            return "just now";
        }
        //Minutes
        else if($minutes <=60){
            if($minutes==1){
                return "one minute ago";
            }
            else{
                return "$minutes minutes ago";
            }
        }
        //Hours
        else if($hours <=24){
            if($hours==1){
                return "one hour ago";
            }
            else{
                return "$hours hours ago";
            }
        }
        //Days
        else if($days <= 7){
            if($days==1){
                return "yesterday";
            }
            else{
                return "$days days ago";
            }
        }
        //Weeks
        else if($weeks <= 4.3){
            if($weeks==1){
                return "one week ago";
            }
            else{
                return "$weeks weeks ago";
            }
        }
        //Months
        else if($months <=12){
            if($months==1){
                return "one month ago"; 
            }
            else{
                return "$months months ago";
            }
        }
        //Years
        else{
            if($years==1){
                return "one year ago";
            }
            else{
                return "$years years ago";
            }
        }
    }

    function converttimetodays($seconds){
        
        $minutes = round($seconds / 60);
        $hours = round($seconds / 3600);
        $days = round($seconds / 86400);
        $weeks = round($seconds / 604800);
        $months = round($seconds / 2600640);
        $years = round($seconds / 31553280);

        //Minutes
        if($minutes <=60){
            if($minutes<=30){
                return "Less than 30 minutes remaining";
            }
            elseif ($minutes<=60){
                return "$minutes minutes remaining";
            }
        }
        //Hours
        else if($hours <=24){
            if($hours==1){
                return "1 hour remaining";
            }
            else{
                return "$hours hours remaining";
            }
        }
        //Days
        else if($days <= 60){
            if($days==1){
                return "1 day remaining";
            }
            else{
                return "$days days remaining";
            }
        }
        // For longer periods
        else {
            return "more than 60 days remaining";
        }
    }

    function waitForTime($seconds){
        
        $minutes = round($seconds / 60);
        $hours = round($seconds / 3600);
        $days = round($seconds / 86400);
        $weeks = round($seconds / 604800);
        $months = round($seconds / 2600640);
        $years = round($seconds / 31553280);
        
        //Minutes
        if($minutes <=60){
            if($minutes<=30){
                return "less than 30 minutes";
            }
            elseif($minutes<=60){
                return "$minutes minutes";
            }
        }
        //Hours
        else if($hours <=24){
            if($hours==1){
                return "1 hour";
            }
            else{
                return "$hours hours";
            }
        }
        //Days
        else if($days <= 60){
            if($days==1){
                return "1 day";
            }
            else{
                return "$days days";
            }
        }
        // For longer periods
        else {
            return "more than 60 days";
        }
    }

?>