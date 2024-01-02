<?php 
class Database{
	private $dbhost = 'localhost';
	private $dbname = 'db_lr';
	private $dbuser = 'root';
	private $dbpass = '';
	public $pdo;

	public function __construct(){
		if (!isset($this->pdo)) {
			try {
				$link = new PDO("mysql:host=".$this->dbhost."; dbname=".$this->dbname, $this->dbuser, $this->dbpass);
				$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$link->exec("SET CHARACTER SET utf8");
				$this->pdo = $link;
			} catch (PDOException $e) {
				die("Faild to connection Database".$e->getMessage());
			}
		}
	}
}