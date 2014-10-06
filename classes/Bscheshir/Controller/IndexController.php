<?php
/**
 * BSCheshir
 *
 * controler for view catalog collection
 * @copyright Copyright (c) 2014 BSCheshir
 * @license   New BSD License
 */

namespace Bscheshir\Controller;

use Bscheshir\Entity\Category;
use Bscheshir\Entity\Item;
use Bscheshir\View\ViewModel;

class IndexController extends Controller
{
    /**
     * show catalog
     *
     * @param string current path
     * @return ViewModel
     */	
    public function indexAction($category=false)
    {
		$content = array();
		
		$db=$this->sm->hasService('db')?
			$this->sm->getService('db'):
			$this->sm->setService('Bscheshir\Service\dbConnection',false,'db');
			
		$catMap=new \Bscheshir\Model\CategoryMapper($db());
		
		$bcPart=$catMap->parsePath($category);
		$bcEntity=$catMap->getBreadcrumbs($category);
		
		//Показать "меню категорий"
		$rtPath=  array_keys($bcEntity);
		array_unshift($rtPath,'/');
		$mnEntity=$catMap->getRoot($rtPath);
		$renderer= new \Bscheshir\View\Renderer();
		$content['categoryList']=$renderer->render(VIEW_PATH.'/categories.phtml',  array('items'=>$mnEntity));
		
		//отрисовка "дочерних" отображений. Упрощение
		if (count($bcEntity)==0)
		{
			$content['content']='';
		}
		elseif (count($bcEntity)==count($bcPart)-1)
		{
			$categoryEntity=$bcEntity[array_pop(array_keys($bcEntity))];
			$item=array_pop($bcPart);
			
			//Последний элемент - товар. Показать данные по товару
			$controller=new \Bscheshir\Controller\ItemController;
			$viewModel=$controller('show',$categoryEntity,$item);
			
			//частичная отрисовка
			$renderer= new \Bscheshir\View\Renderer();
			if(isset($viewModel->item))
			{
				$content['content']=$renderer->render(VIEW_PATH.'/item.phtml',$viewModel());
				$fakeBcItem=new Category;
				$fakeBcItem->parents=$viewModel->category->parents.$viewModel->category->alias.'/';
				$fakeBcItem->alias=$viewModel->item->alias;
				$fakeBcItem->name=$viewModel->item->name;
				$bcEntity[]=$fakeBcItem;
			}
			else
			{
				header($_SERVER['SERVER_PROTOCOL']." 404 Not Found");
				$content['content']=$renderer->render(VIEW_PATH.'/error.phtml',Array('message'=>'Ошибка 404'));
			}
		}
		elseif(count($bcEntity)==count($bcPart))
		{
			//последний элемент - категория. 
			//Показать товары в категории.
			$categoryEntity=$bcEntity[array_pop(array_keys($bcEntity))];
				
			$controller=new \Bscheshir\Controller\ItemController;
			$viewModel=$controller('index',$categoryEntity);
			//Частичная отрисовка
			$renderer= new \Bscheshir\View\Renderer();
			$content['content']=$renderer->render(VIEW_PATH.'/items.phtml',$viewModel());
			
		}
		else
		{
			header($_SERVER['SERVER_PROTOCOL']." 404 Not Found");
			//Ошибка
			$renderer= new \Bscheshir\View\Renderer();
			$content['content']=$renderer->render(VIEW_PATH.'/error.phtml',Array('message'=>'Ошибка 404'));
		}
		
		//Отрисовка Breadcrumbs
		$renderer= new \Bscheshir\View\Renderer();
		$content['breadcrumbs']=$renderer->render(VIEW_PATH.'/breadcrumbs.phtml',  array('items'=>$bcEntity));
		
		return new ViewModel($content);
    }
    
}
