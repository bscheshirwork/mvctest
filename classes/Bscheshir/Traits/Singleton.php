<?php
namespace Bscheshir\Traits;

/**
 * traite of Singleton
 *
 * @author BSCheshir
 */
trait Singleton 
{
	//классическая, с статической переменной класса и поздним статическим связыванием
	private static $_instance = null;
	
	final static public function getInstance() {
		if(is_null(static::$_instance))
			static::$_instance = new static;
		return static::$_instance;
	}
	/*
	 * казуальная, ограничивающаяся областью видимости отдной функции
	 * статическая переменные функции не удаляется после завершения выполнения
	final static public function getInstance() {
		static $_instance;
		if(is_null($_instance))
			$_instance = new static;
		return $_instance;
	}
	*/
    final private function __construct() {
        static::init();
    }
    protected function init() {}
    final private function __wakeup() {}
    final private function __clone() {}
}
