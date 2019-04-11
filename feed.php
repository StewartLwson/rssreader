<?php
    require_once 'core/init.php';
    // Instantiate DB & connect
    $db = DB::getInstance();

    $user = new User();

    // Instantiate rss object
    $rss = new RSS($db);

    $method = $_SERVER['REQUEST_METHOD']; // checks request type

    if($method == "POST") { // if post

        if (empty($_GET['link'])) { // if link isn't given
            die("No RSS link was given.");
        }

        $rss_link = $_GET['link']; // get link param

        try {
            $rss->create(array( // array to insert
                "user_id" => $user->data()->id, // user id
                "rss_link" => escape($rss_link) // escaped link
            ));
        } catch(Exception $e) {
            die($e->getMessage());
        }
        echo "Added!";
    } else if ($method == "GET") { // if get
        $result = $rss->read($user->data()->id); // find data associated with user
        if($result->count()) {
            echo json_encode($result->results()); // return json of results
        } else {
            echo json_encode(
                array('message' => 'No feed found.')
            );
        }
    } else if ($method == "DELETE") {
        if (empty($_GET['id'])) { // if id isn't fiven
            die("No RSS id was given.");
        }

        $feed_id = $_GET['id']; // get id param
        $feed_id = escape($feed_id); // escaped id
        $result = $rss->delete($feed_id); // delete id
    }