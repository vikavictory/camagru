<?php

namespace app;
use PDO;
use PDOException;

class Model
{

    protected static function getDB()
    {
    	try {
    		require('config/database.php');
    		$db_connection = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    		$db_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    	} catch (PDOException $e) {
                echo("ERROR: " . $e->getMessage());
            }
        return $db_connection;
    }

}
