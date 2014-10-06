<?php
/**
 * BSCheshir
 *
 * controler for view product
 * @copyright Copyright (c) 2014 BSCheshir
 * @license   New BSD License
 */

namespace Bscheshir\Controller;

use Bscheshir\Entity\Item;
use Bscheshir\View\ViewModel;

class ItemController extends Controller
{
    /**
     * show item list
     *
     * @param  Category $category
     * @return ViewModel
     */	
    public function indexAction($category=false)
    {
		$content = array();
		$db=$this->sm->hasService('db')?
			$this->sm->getService('db'):
			$this->sm->setService('Bscheshir\Service\dbConnection',false,'db');
			
		//отобразить список товаров в категории
		$itemMap=new \Bscheshir\Model\ItemMapper($db());
		$content['category']=$category;
		$content['items']=$itemMap->getFromCategory($category);
		return new ViewModel($content);
		
	}
	
    /**
     * show item
     *
     * @param  Category $category
     * @param  Item $item
     * @return ViewModel
     */	
    public function showAction($category=false,$item=false)
    {
		$content = array();
		$db=$this->sm->hasService('db')?
			$this->sm->getService('db'):
			$this->sm->setService('Bscheshir\Service\dbConnection',false,'db');
		
		//отобразить данные по товару
		$itemMap=new \Bscheshir\Model\ItemMapper($db());
		$itemEntityList=$itemMap->get($category,$item);
		if (count($itemEntityList)==1){
			$content['category']=$category;
			$content['item']=array_shift($itemEntityList);
		}
		return new ViewModel($content);
	}
    
}
