<?php class Redirect { // class that handles redirects
    public static function to($location = null) { // redirects to specified location, default is null
        if($location) { // if location exists
            header('Location: ' . $location); // sets location header
            exit();
        }
    }
}