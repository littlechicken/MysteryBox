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
		$client = new Facebook(array('appId'  => '344617158898614', 'secret' => '6dc8ac871858b34798bc2488200e503d'));
		$client->setAccessToken("AAAE5bW9W87YBAPUru246fan33ZBx4aCF5PSmjm7xlt6HMAY8ZB6YubBzOleBiBDUuGcUbjsdC4B0VtWDdc8dEpZA1ims9cUw2wJplQByEbxZB0xfouWd");
		$friends = $client->api('/me/friends');
    	
		$this->view->entries = $friends;
    }


}









