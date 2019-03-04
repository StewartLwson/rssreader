<?php // Classes for accessing the config
class Config {
    public static function get($path = null) {
        if($path) { // Checks if a path has been given
            $config = $GLOBALS['config']; // Config is set to the global variable given by init
            $path = explode('/', $path); // Given path is turned into an array based on the /s

            // TODO: Tighter validation on given path
            foreach($path as $bit) { // Path array is looped through
                if(isset($config[$bit])) { // Checks if config exists
                    $config = $config[$bit]; // Resets config deeper into the array to loop through individuals pieces
                }
            }

            return $config; // Returns config
        }

        return false; // Returns config if not path given
    }
}
?>