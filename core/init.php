<?php // PHP to be run on every page
// Starts user session
session_start();

// Config data
$GLOBALS["config"] = array(
    // Config data for mysql database
    "mysql" => array(
        "host" => "127.0.0.1",
        "username" => "root",
        "password" => "toor",
        "db" => "ooplr"
    ),
    // Config data for cookies
    "remember" => array(
        "cookie_name" => "hash",
        "cookie_expiry" => 86400 // 1 day in seconds
    ),
    // Config data for sessions
    "session" => array(
        "session_name" => "user"
    )
);

// Function for requiring classes only when they are instantiated
spl_autoload_register(function($class) {
    require_once 'classes/' . $class . '.php';
});

require_once 'functions/sanitize.php';