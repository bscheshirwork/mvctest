<?php
namespace Bscheshir\Model;

use Bscheshir\Entity\Item;
use PDO;
/**
 * db table mapper of Item
 *
 * @author BSCheshir
 */
class ItemMapper 
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
     * Get all items entity from category
     *
     * @param  \Bscheshir\Entity\Category $category
     * @return \Bscheshir\Entity\Item
     */
	public function getFromCategory($category)
	{
		$sql = "SELECT product.* 
			FROM category 
			JOIN prodcat ON (category.id=prodcat.categoryId)
			JOIN product ON (product.id=prodcat.productId)
			WHERE category.alias = ? AND category.parents = ? ";
		$statement = $this->db->prepare($sql);
		$statement->execute(array($category->alias,$category->parents));
		$result = $statement->fetchAll(PDO::FETCH_CLASS,'\Bscheshir\Entity\Item');
		return $result;
	}
	
    /**
     * Get item entity (from category)
     *
     * @param  \Bscheshir\Entity\Category $category
     * @param  string $item
     * @return \Bscheshir\Entity\Item
     */
	public function get($category,$item)
	{
		$sql = "SELECT product.* 
			FROM category 
			JOIN prodcat ON (category.id=prodcat.categoryId)
			JOIN product ON (product.id=prodcat.productId)
			WHERE category.alias = ? AND category.parents = ? AND product.alias = ? ";
		$statement = $this->db->prepare($sql);
		$statement->execute(array($category->alias,$category->parents,$item));
		$result = $statement->fetchAll(PDO::FETCH_CLASS,'\Bscheshir\Entity\Item');
		return $result;
	}
}

?>
