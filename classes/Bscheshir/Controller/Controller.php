<?php
/**
 * BSCheshir
 *
 * controler 
 * @copyright Copyright (c) 2014 BSCheshir
 * @license   New BSD License
 */

namespace Bscheshir\Controller;

class Controller
{
    /**
     * @var \Bscheshir\Service\ServiceManager
     */
	protected $sm = null;
	
    /**
     * Set sm object
     *
     * @return Controller
     */	
	public function __construct() {
		$this->sm=  \Bscheshir\Service\ServiceManager::getInstance();
	}
	
    /**
     * exec action
     *
     * @param  string $action action 
     * @param  mixed first param
     * @param  mixed second param
     * @return Controller
     */
	public function __invoke($action='index',$category=false,$item=false) {
		$method=$action.'Action';
		return $this->$method($category,$item);
	}
	
}
