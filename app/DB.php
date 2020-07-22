<?php

namespace app;
use PDO;
use PDOException;

class DB
{
	protected static $instance = null;
	public static $db_connection;

	function __construct()
	{
		if (self::$instance === null) {
			try {
				require('../config/database.php');cd
				self::$db_connection = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
				self::$db_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch (PDOException $e) {
				echo("ERROR: " . $e->getMessage());
			}
		}
		return self::$instance;
	}

}
