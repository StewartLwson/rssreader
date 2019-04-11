<?php // class that handles the token that carries the user's session
class Token {
    // generates unique session from token name and a hashed unique id
    public static function generate() {
        return Session::put(Config::get('session/token_name'), md5(uniqid()));
    }

    // checks if session token exists
    public static function check($token) {
        $tokenName = Config::get("session/token_name");

        if(Session::exists($tokenName) && $token == Session::get($tokenName)) {
            Session::delete($tokenName);
            return true;
        }

        return false;
    }
}
?>