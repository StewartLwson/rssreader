<?php // Class for connecting to database
// Uses Singleton pattern to allow for one instance of connection
class DB {
   private static $_instance = null;
   private $_pdo,
           $_query,
           $_error = false,
           $_results,
           $_count = 0;

    private function __construct() {
        try {
            // Connect to database using PDO
            // Database info is retrieved from the config
            $this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') .
                                    ';dbname=' . Config::get('mysql/db'),
                                    Config::get('mysql/username'),
                                    Config::get('mysql/password'));
        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }

    // Initializes/gets the instance of connection
    public static function getInstance() {
        // Checks if instance is already active
        if(!isset(self::$_instance)) {
            self::$_instance = new DB();
        }
        return self::$_instance;
    }

    // Sends executes and SQL query to the database and error checks
    public function query($sql, $params = array()) {
        $this->_error = false;
        if($this->_query = $this->_pdo->prepare($sql)) { // Prepares SQL
            $x = 1;
            if(count($params)) { // Binds params if they exist
                foreach($params as $param) {
                    $this->_query->bindValue($x, $param);
                    $x++;
                }
            }

            if($this->_query->execute()) {
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            } else {
                $this->_error = true;
            }
        }

        return $this;
    }

    // Generic database action to be queried
    private function action($action, $table, $where = array()) {
        if(count($where) == 3) {
            $operators = array('=', ">", "<", ">=", "<="); // Acceptable operators

            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];

            if(in_array($operator, $operators)) {
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
                if(!$this->query($sql, array($value))->error()) {
                    return $this;
                }
            }
        }
        return false;
    }

    // CRUD API methods

    // Insert method for database
    public function insert($table, $fields) {
        if(count($fields)) {
            $keys = array_keys($fields);
            $values = null;
            $x = 1;

            foreach($fields as $field) {
                $values .= "?";
                if ($x < count($fields)) {
                    $values .= ', ';
                }
                $x++;
            }

        $sql = "INSERT INTO {$table}(`" . implode('`,`', $keys) . "`) VALUES ({$values})";
        }

        if(!$this->query($sql, $fields)->error()) {
            return true;
        }
        return false;
    }

    // Get method for database
    public function get($table, $where) {
        return $this->action("SELECT *", $table, $where);
    }

    // Update method for database
    public function update($table, $id, $fields) {
        $set = '';
        $x = 1;

        foreach($fields as $name => $value) {
            $set .= "{$name} = ?";
            if($x < count($fields)) {
                $set .= ', ';
            }
            $x++;
        }

        $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";

        if(!$this->query($sql, $fields)->error()) {
            return true;
        }

    }

    // Delete method for database
    public function delete($table, $where) {
        return $this->action("DELETE ", $table, $where);
    }

    // Return all results
    public function results() {
        return $this->_results;
    }

    // Return first result
    public function first_result() {
        return $this->results()[0];
    }

    // Return error
    public function error() {
        return $this->_error;
    }

    // Return resulting row count
    public function count() {
        return $this->_count;
    }
}
?>