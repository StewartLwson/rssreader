<?php  // Class for hashing of passwords

class Hash {
    public static function make($string, $salt = "") {
        return hash("sha256", $string . $salt); // ashes given password using SHA256 and a generated salt
    }

    public static function salt($length) {
        return random_bytes($length); // Generates salt using random bytes
    }

    public static function unique() {
        return self::make(uniqid());
    }
}
?>