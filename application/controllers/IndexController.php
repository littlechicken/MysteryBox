<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    	
    }

    public function pagesAction()
    {
    	$vmap = new Application_Model_ViewerMapper();
    	$v = new Application_Model_Viewer();
    	 
    	$map = new Application_Model_BoxMapper();
    	 
    	$entries   = array();
    	$viewers = $vmap->fetchAll();
    	
    	$this->view->entries = $viewers;
    }

    public function fbconAction()
    {
		$fb = new Facebook();
		
    }


}









