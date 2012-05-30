<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{	
	protected function _initDoctype()
	{
		$this->bootstrap('view');
		$view = $this->getResource('view');
		$view->doctype('XHTML1_STRICT');
	}

	protected function _initRouter()
	{
		$router = Zend_Controller_Front::getInstance()->getRouter();

		//$regex = new Zend_Controller_Router_Route_Regex('id(\d+)', array('module' => 'default', 'controller' => 'box', 'action' => 'show'));

		$route_static = new Zend_Controller_Router_Route(
				'/:id',
				array(
						'controller' => 'box',
						'action' => 'show',
						'id' => 'default'
				),
				array(
						'id' => 'id(\d+)'
				)
		);
		
		$router->addRoute('static', $route_static);
		
	}
}

