<?php
require_once 'core/init.php';
if(Session::exists("home")) {
    echo '<p>' . Session::flash("success") . '</p>';
}
?>