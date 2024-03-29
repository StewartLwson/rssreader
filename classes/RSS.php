<?php // class that handles API for user RSS feeds
    class RSS {
        private $_db,
                $_table = 'rss';

        public function __construct($db) {
            $this->_db = $db; // connects to db
        }

        // Get RSS feeds for user
        public function read($session_id) {
            $feed = $this->_db->get($this->_table, array("user_id", "=", $session_id));
            return $feed;
        }

        // Add RSS feed
        public function create($fields = array()) {
            if(!$this->_db->insert($this->_table, $fields)) {
                throw new Exception("There was a problem adding RSS to feed.");
            }
        }

        // Delete RSS feed
        public function delete($feed_id) {
            $this->_db->delete($this->_table, array("id", "=", $feed_id));
        }

    }