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

		$router->addRoute("id_route", new Zend_Controller_Router_Route("/:id",
				array("controller" => "box", "action" => "show", 'id' => -1),
				array('id' => '\d+')));
	}
}

