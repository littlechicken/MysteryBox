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
		$client = new Facebook(array('appId'  => '125399940932202', 'secret' => '61258b879c9e09ce153b7eece7636aac'));
		$client->setAccessToken("AAAE5bW9W87YBABrHNuwQ4qbKvZBgdQGFTZCFEPM29j2WJJ6MJpZCFI4iQHTEbQ2PnFEN7xRIVGs0RK1JcFLjxjd7veIivDTTXXFtl7XEfYCZA9hEANcf");
		$friends = $client->api('/me/friends');
    	
		$this->view->entries = $friends;
    }


}









