<?php

class Connection extends PDO {

    private $database = 'mysql:host=localhost; dbname=erp_parrot_varejo; charset=utf8;';
    private $user = 'root';
    private $password = '';
    public static $handle = null;

    function __construct() {
        try {
            if (self::$handle == null) {
                $connection_data = parent::__construct($this->database, $this->user, $this->password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
                self::$handle = $connection_data;
                return self::$handle;
            }
        } catch (PDOException $e) {
            echo 'Falha na conexão: ' . $e->getMessage();
            return false;
        }
    }

    function __destruct() {
        self::$handle = NULL;
    }

}

?>