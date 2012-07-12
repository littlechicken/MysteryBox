<?php

class BoxController extends Zend_Controller_Action
{

    public function indexAction()
    {
        $box = new Application_Model_BoxMapper();
        $this->view->entries = $box->fetchAll();
    }

    public function processFiles()
    {
    	$data = file_get_contents('php://input');
    	$this->processData($data);
   		/*$apt    = new Zend_File_Transfer_Adapter_Http();
   		$files  = $apt->getFileInfo();
   		foreach($files as $file => $fileInfo) {
   			if ($apt->isUploaded($file)) {
   				if ($apt->isValid($file)) {
   					if ($apt->receive($file)) {
   						$info = $apt->getFileInfo($file);
   						$tmp  = $info[$file]['tmp_name'];
   						$data = file_get_contents($tmp);
   						$this->processData($data);
   					}
   				}
   			}
   		}*/
    }

    public function processData($data)
    {
		$xml = simplexml_load_string($data);			
		$box	= new Application_Model_Box();
		
		print_r($xml);
		
		$box->parseXml($xml);									
		$mapper  = new Application_Model_BoxMapper();
		$mapper->save($box);
    }

    public function addAction()
    {
        $request = $this->getRequest();
 
        /*$test_data = "<box>
         					<boxId>1a3138d6-6b8d-4648-b818-4cc8e4debf8c</boxId>
        					<deviceId>000123</deviceId>
        					<messageTitle>The title</messageTitle>
        					<messageBody>The body</messageBody>
        					<riddleQuestion>The question</riddleQuestion>
        					<riddleAnswer>The answer</riddleAnswer>
        					<unlockDate>20-06-1985 17:21:15</unlockDate>
        					<file name='test.file'>asfdsafqete</file>
        				</box>";
        $this->processData($test_data);*/
        
        if ($this->getRequest()->isPost()) {
        	print_r($GLOBAL); 
           	$this->processFiles();
           	echo 'file was uploaded'; 
        }           	            	
    }

    public function changeAction()
    {
    	/*$test_data = "<changeBox>
    	 <oldBoxId>1a3138d6-6b8d-4648-b818-4cc8e4debf8c</oldBoxId>
    	 	<boxId>1a3138d6-6b8d-4648-b818-4cc8e4debf20</boxId>
    		<deviceId>000123</deviceId>
    		<messageTitle>New one title</messageTitle>
    		<riddleQuestion>The question blblblblblbl</riddleQuestion>
    		<unlockDate>20-06-1985 17:21:16</unlockDate>
    		<file name='test.file'></file>    			
    	</changeBox>";
    	 
    	$this->processChange($test_data);*/
    	    	
    	if ($this->getRequest()->isPost())
    		$this->processChangeQuery();
    	
    }

    public function processChangeQuery()
    {
    	$apt    = new Zend_File_Transfer_Adapter_Http();
    	$files  = $apt->getFileInfo();
    	foreach($files as $file => $fileInfo) {
    		if ($apt->isUploaded($file)) {
    			if ($apt->isValid($file)) {
    				if ($apt->receive($file)) {
    					$info = $apt->getFileInfo($file);
    					$tmp  = $info[$file]['tmp_name'];
    					$data = file_get_contents($tmp);
    					$this->processChange($data);
    				}
    			}
    		}
    	}
    
    }

    public function processChange($data)
    {
    	$xml = simplexml_load_string($data);
    	$newbox = new Application_Model_Box();
    	
    	$newbox->parseXml($xml);
    	$map  = new Application_Model_BoxMapper();

    	$oldBoxId = (string)$xml->oldBoxId;

    	$oldbox = new Application_Model_Box();
    	$map->find($oldBoxId, $oldbox);

    	$newbox->copyOf($oldbox);
    	
    	$map->save($newbox);
    }

    public function showAction()
    {
    	$boxId = $this->getRequest()->getParam('boxId');
    	$viewerId = $this->getRequest()->getParam('viewerId');
    	if ($boxId != null && strpos($boxId, '-')) {
    		$vmap = new Application_Model_ViewerMapper();
    			
    		$v = new Application_Model_Viewer();
    		$vmap->find($viewerId, $v);
    			
    		$box = new Application_Model_Box();
    		$map = new Application_Model_BoxMapper();
    		$map->find($v->getBoxId(), $box);
    		if ($box->isEmpty()) {
    			$this->_redirect('/box/notfound');
    		} else {
	    		$box->setTag($viewerId);
	    		$this->view->entry = $box;
    		}
    	} else {
    		$this->_redirect('/box/notfound');
    	}   	
    }

    public function getFileTypeFromAmazon($box)
    {
    	$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/cloud.ini', 'amazon');
    	$s3 = new Zend_Service_Amazon_S3($config->accessKey, $config->secretKey);
    	$rootBucket = $config->rootBucket;
    		
    	$amazonFileName = $box->getAmazonFileName();
    	$info = $s3->getInfo($rootBucket . DIRECTORY_SEPARATOR . $amazonFileName);
    		
    	$filetype = $info['type'];
    	$filetype = explode(DIRECTORY_SEPARATOR, $filetype);
    	$filetype = $filetype[0];
    	    	
    	return $filetype;
    }

    public function processRemoveQuery()
    {
    	$apt    = new Zend_File_Transfer_Adapter_Http();
    	$files  = $apt->getFileInfo();
    	foreach($files as $file => $fileInfo) {
    		if ($apt->isUploaded($file)) {
    			if ($apt->isValid($file)) {
    				if ($apt->receive($file)) {
    					$info = $apt->getFileInfo($file);
    					$tmp  = $info[$file]['tmp_name'];
    					$data = file_get_contents($tmp);
    					$this->processRemove($data);
    				}
    			}
    		}
    	}
    	 
    }

    public function processRemove($data)
    {
    	$xml = simplexml_load_string($data);
    	$boxId = (string)$xml->boxId;
    
    	$box = new Application_Model_Box();
    	$map = new Application_Model_BoxMapper();
    	$map->find($boxId, $box);
    
    	if ($box->isNotEmpty()) {
    		$viewed = 1;
    		
    		$vmap = new Application_Model_ViewerMapper();
    		$viewers = $vmap->fetchByBoxId($boxId);
    		foreach($viewers as $viewer) {
    			if ($viewer->getIsViewed())
    			{
    				$vmap->delete($viewer->getId());
    			} else {
    				$viewed = 0;
    			}
    		}
    		
    		if ($viewed == 1)
    		{
	    		if ($box->removeAmazonFile()) {
	    		
		    		$bmap = new Application_Model_BoxMapper();
		    		$bmap->delete($boxId);
	    		}
    		}	
    	}	
    }

    public function deleteAction()
    {
    	/*$test_data = "<deleteBox>
    		<boxId>1a3138d6-6b8d-4648-b818-4cc8e4debf8c</boxId>
    	</deleteBox>";
    	
    	$this->processRemove($test_data);*/
    	
    	if ($this->getRequest()->isPost())
    		$this->processRemoveQuery();    		    		 
    	
    }

    public function notfoundAction()
    {
        // action body
    }

    public function sendAction()
    {
    	$test_data = "<send>
    					 	<to>back.neomind@gmail.com</to>
    	 					<from>for_ever_@ukr.net</from>
    	 					<subj>test</subj>
    	 					<body>simple test</body>
    					</send>";
    	 
    	try
    	{
    		$this->processSend($test_data);
    	} catch (Exception $ex) {
    		print_r($ex);
    	}  

    	//if ($this->getRequest()->isPost())
    	//	$this->processSendQuery();
    }


    public function processSendQuery()
    {
    	$apt    = new Zend_File_Transfer_Adapter_Http();
    	$files  = $apt->getFileInfo();
    	foreach($files as $file => $fileInfo) {
    		if ($apt->isUploaded($file)) {
    			if ($apt->isValid($file)) {
    				if ($apt->receive($file)) {
    					$info = $apt->getFileInfo($file);
    					$tmp  = $info[$file]['tmp_name'];
    					$data = file_get_contents($tmp);
    					$this->processSend($data);
    				}
    			}
    		}
    	}
    }
    
    public function processSend($data)
    {
    	$xml = simplexml_load_string($data);
    	
    	$to = (string)$xml->to;
    	$from = (string)$xml->from;
    	$subj = (string)$xml->subj;
    	$text = (string)$xml->body;
    	
    	//$this->send($from, $to, $subj, $text);
    	//$this->send($from, $to, $subj, $text);
    	
    	
    	$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/sendgrid.ini', 'account');
    	
    	$sendgrid = new SendGrid($config->username, $config->password);
    	
    	$mail = new SendGrid\Mail();
    	
    	$mail->addTo($to)->
    	setFrom($from)->
    	setSubject($subj)->
    	setText($text);    

    	$sendgrid->web->send($mail);
    }
    
    /*public function send($from, $to, $subject, $text) {
    	$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/sendgrid.ini', 'account');

    	// Your SendGrid account credentials
    	$username = $config->username;
    	$password = $config->password;
    	
    	// Create new swift connection and authenticate
    	$transport = Swift_SmtpTransport::newInstance('smtp.sendgrid.net', 587);
    	$transport->setUsername($username);
    	$transport->setPassword($password);
    	
    	$swift = Swift_Mailer::newInstance($transport);
    	
    	// Create a message (subject)
    	$message = new Swift_Message($subject);
    	
    	// add SMTPAPI header to the message
    	$headers = $message->getHeaders();
    	$headers->addTextHeader('X-SMTPAPI', $hdr->asJSON());
    	
    	// attach the body of the email
    	$message->setFrom($from);
    	$message->setBody($html, 'text/html');
    	$message->setTo($to);
    	$message->addPart($text, 'text/plain');
    	
    	// send message
    	if ($recipients = $swift->send($message, $failures))
    	{
    		// This will let us know how many users received this message
    		// If we specify the names in the X-SMTPAPI header, then this will always be 1.
    		echo 'Message sent out to '.$recipients.' users';
    	}
    	// something went wrong =(
    	else
    	{
    		echo "Something went wrong - ";
    		print_r($failures);
    	}    	
    }
    
    public function send($from, $to, $subject, $message) {
    	$headers = 'From: ' . $from . "\r\n" .
    			'Reply-To: ' . $to . "\r\n" .
    			'X-Mailer: PHP/' . phpversion();
    	
    	mail($to, $subject, $message, $headers);    	
    }*/
}













