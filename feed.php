<?php
    require_once 'core/init.php';
    // Instantiate DB & connect
    $db = DB::getInstance();

    $user = new User();

    // Instantiate rss object
    $rss = new RSS($db);

    $method = $_SERVER['REQUEST_METHOD'];

    if($method == "POST") {

        if (empty($_GET['link'])) {
            die("No RSS link was given.");
        }

        $rss_link = $_GET['link'];

        try {
            $rss->create(array(
                "user_id" => $user->data()->id,
                "rss_link" => $rss_link
            ));
        } catch(Exception $e) {
            die($e->getMessage());
        }
        echo "Added!";
    } else if ($method == "GET") {
        $result = $rss->read($user->data()->id);
        if($result->count()) {
            echo json_encode($result->results());
        } else {
            echo json_encode(
                array('message' => 'No feed found.')
            );
        }
    } else if ($method == "DELETE") {
        if (empty($_GET['id'])) {
            die("No RSS id was given.");
        }

        $feed_id = $_GET['id'];
        $result = $rss->delete($feed_id);
    }