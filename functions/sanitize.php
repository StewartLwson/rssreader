<?php // Sanitizes incoming/outcoming data
// Escape function for sanitizing HTML
function escape($string) {
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
}

?>