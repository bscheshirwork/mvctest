<?php
namespace Bscheshir\Service;

/**
 * Storage of Services
 *
 * @author BSCheshir
 */
class ServiceManager 
{
	use \Bscheshir\Traits\Singleton;
	
    /**
     * @var array of store obj
     */
	private $__collection=array();
	
	/**
     * check service
     *
     * @param  string $name
     * @return Boolean
     */
	public function hasService($name)
	{
		return array_key_exists($name, $this->__collection);
	}
	
    /**
     * create service, send it to storage and get it
     *
     * @param  string $name name of class with namespace
     * @param  boolean $isSingleton create a new class on toch?
     * @param  string $alias name of class in storage
     * @return mixed 
     */
	public function setService($name,$isSingleton=TRUE,$alias=NULL)
	{
		if(is_null($alias))
			$alias=$name;
		if ($isSingleton)
			return $this->__collection[$alias]=$name::getInstance();
		else
			return $this->__collection[$alias]=new $name;
	}
	
    /**
     * Get object (create if not exist in storage)
     *
     * @param  string $name
     * @return mixed
     */
	public function getService($name)
	{
		if (array_key_exists($name, $this->__collection))
			return $this->__collection[$name];
		else 
			return $this->setService($name);
	}

    /**
     * Get object (create if not exist in storage)
     *
     * @param  string $name
     * @return mixed
     */
	public function __invoke($name) {
		return $this->getService($name);
	}
}
