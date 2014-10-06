<?php
namespace Bscheshir\Service;

use Bscheshir\Service\ServiceManager;
use PDO;
/**
 * db Connection
 *
 * @author BSCheshir
 */
class dbConnection
{
    /**
     * @var PDO
     */
	protected $db = null;
	
    /**
     * estabilishment connection
     *
     * @return dbConnection
     */
	public function __construct() 
	{
		$sm=ServiceManager::getInstance();
		
		$cf=$sm('Bscheshir\Service\Config')->database;
		
		try {
			$opt = array(
				PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
			);			
			if($cf['adapter']=='pdo_mysql'){
				//extract($cf['params']);//а можно и так
				$host=$cf['params']['host'];
				$dbname=$cf['params']['dbname'];
				$username=$cf['params']['username'];
				$password=$cf['params']['password'];
				
				# MySQL через PDO_MYSQL  
				$this->db = new \PDO("mysql:host=$host;dbname=$dbname;charset=UTF8", $username, $password, $opt);
			}
		}  
		catch(PDOException $e) {  
			echo $e->getMessage();  
		}
		
		return $this;
	}
	
    /**
     * Get db handler
     *
     * @return PDO
     */
	public function __invoke()
	{
		return $this->db;
	}
}

