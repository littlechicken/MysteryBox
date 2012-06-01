<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{	
	/*protected function _initDoctype()
	{
		$this->bootstrap('view');
		$view = $this->getResource('view');
		$view->doctype('XHTML1_STRICT');
	}*/

	protected function _initRouter()
	{
		$router = Zend_Controller_Front::getInstance()->getRouter();

		$router->addRoute("box_route", new Zend_Controller_Router_Route("/:viewerId/:boxId",
				array("controller" => "box", "action" => "show"),
				array('viewerId' => '.+', 'boxId' => '\d+')));
		
		/*$router->addRoute("box_route", new Zend_Controller_Router_Route("/:id",
		 array("controller" => "box", "action" => "show"),
				array('id' => '\d+')));
		*/
		/*$router->addRoute("page_route", new Zend_Controller_Router_Route("/:id",
				array("controller" => "page", "action" => "show"),
				array('boxId' => '\d+', 'viewerId' => '\s+')));*/		
	}
}

