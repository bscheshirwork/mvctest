<?php
namespace Bscheshir\Model;

use Bscheshir\Entity\Category;
use PDO;

/**
 * db table mapper of Category
 *
 * @author BSCheshir
 */
class CategoryMapper 
{
    /**
     * @var PDO
     */	
    protected $db;
	
    /**
     * Set PDO object
     *
     * @param  PDO $db
     */ 
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }
	
    /**
     * get all entity
     *
     * @return array of \Bscheshir\Entity\Category
     */
	public function getAll()
	{
		$sql = "SELECT * FROM category";
		$statement = $this->db->prepare($sql);
		$statement->execute();
		$result = $statement->fetchAll(PDO::FETCH_CLASS,'\Bscheshir\Entity\Category');
		return $result;
	}
	
    /**
     * get all of root layer entity (with current)
	 * sort by tree view
     *
     * @param  array of string $arr
     * @return array of \Bscheshir\Entity\Category
     */
	public function getRoot($arr)
	{
		$in  = str_repeat('?,', count($arr) - 1) . '?';
		$sql = "SELECT * FROM category WHERE parents IN ($in) ";
		$statement = $this->db->prepare($sql);
		$statement->execute($arr);
		$result=array();
		while ($entity = $statement->fetchObject('\Bscheshir\Entity\Category'))
			$result[$entity->parents.$entity->alias.'/']=$entity;
		ksort($result);
		return $result;
	}
	
    /**
     * get only direct parents
     *
     * @param  string 
     * @return array of \Bscheshir\Entity\Category
     */
	public function getBreadcrumbs($categoryPath) 
	{
		$arr=$this->parsePath($categoryPath);
		$params=array();
		foreach ($arr as $key=>$value) {
			$params[]=$value;
			$params[]=$key;
		}
		$sql = "SELECT * FROM category WHERE ".substr(str_repeat('(alias = ? and parents = ?) or ', count($arr)),0,-3);
		$statement = $this->db->prepare($sql);
		$statement->execute($params);
		$result=array();
		while ($entity = $statement->fetchObject('\Bscheshir\Entity\Category'))
			$result[$entity->parents.$entity->alias.'/']=$entity;
		ksort($result);
		return $result;
	}
	
    /**
     * get category map array
	 * path => current alias
     *
     * @param  string
     * @return array
     */
	public function parsePath($categoryPath)
	{
		$categoryArray = explode('/', $categoryPath);
		$parent='';
		$result=array();
		foreach ($categoryArray as $alias){
			$result[$parent.'/']=$alias;
			$parent.='/'.$alias;
		}
		return $result;
	}
}

?>
