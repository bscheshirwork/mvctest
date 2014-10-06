<?php
namespace Bscheshir;

/**
 * Main class of Application
 *
 * @author BSCheshir
 */
use Bscheshir\Service\ServiceManager;

class Application
{
	use \Bscheshir\Traits\Singleton;
	
    final private function __construct() {}
    
    /**
     * prepare to run
	 * store self and config
     *
     * @param  mixed $config
     * @return Application
     */
	public static function init($config=null){
		$sm = ServiceManager::getInstance();
		$sm->setService(__CLASS__);
		$cf=$sm->setService('Bscheshir\Service\Config');
		
		if(is_string($config))
			$config=require($config);
		
		if(is_array($config))
			foreach($config as $key=>$value)
				$cf->$key=$value;
		
		return $sm(__CLASS__);
    }
    
    /**
     * exec web application
     *
     */
	public function run()
    {
		$sm = ServiceManager::getInstance();
		//получение параметров запроса
		//**********************************************************************

		// Получаем запрос, удаляя пробелы и слеши
		// в начале и конце строки
		$request = trim($_SERVER["REQUEST_URI"], '/');

		// Разбиваем запрос на части
		$urlParts = explode('/', $request);

		// Удаляем случайные пустые элементы, которые
		// появляются, если, например, в запросе будет
		// два слеша подряд (/news//04/01/1986/)
		$urlParts = array_filter($urlParts, 'trim');
		
		$baseUrl=$urlParts[0].'//'.$urlParts[2];

		//Роутинг Утрированная логика разбора чпу
		//**********************************************************************
		$action='index';
		//роутинг вида catalog/категория/подкатегория/.../товар
		if( isset($urlParts[3]) && $urlParts[3]=='catalog' )
		{
			$urlParts=array_slice($urlParts,3);
			$category=implode('/',$urlParts)?:false;
		}
		else
		{
			header( 'Location: /catalog', true, 307 ); // перебросить на главную страницу каталога с использованием 307 редиректа. или 303
		}
		
		$controller=new \Bscheshir\Controller\IndexController;
		
		$viewModel=$controller($action,$category);
		$viewModel->setVariable('baseUrl',$baseUrl);
			
			
		//Утрированная отрисовка
		$renderer= new \Bscheshir\View\Renderer();
		$toOut=$renderer->render(VIEW_PATH.'/layout.phtml',$viewModel());
		
		echo $toOut;
    }
    
}
