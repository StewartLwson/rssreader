<?php // class that handles a user's session after login
class Session {

    // checks if sessions exists for given user
    public static function exists($name) {
        return (isset($_SESSION[$name])) ? true : false;
    }

    // creates session for given user
    public static function put($name, $value) {
        return $_SESSION[$name] = $value;
    }

    // gets session for given user
    public static function get($name) {
        return $_SESSION[$name];
    }

    // deletes session of given user
    public static function delete($name) {
        if(self::exists($name)) {
            unset($_SESSION[$name]);
        }
    }
}