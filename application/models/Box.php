<?php 
class Application_Model_Box
{
    protected $_id;
    
    protected $_deviceId;
    protected $_messageTitle;
    protected $_messageBody;
    protected $_riddleQuestion;
    protected $_riddleAnswer;
    protected $_unlockDate;
    
    protected $_fileName;
    protected $_amazonFileName;
    protected $_fileContent;    
 
    protected $_fileType;
    
    public function parseXml($xml){    	
    	$this->_id = (string)$xml->boxId;
    	$this->_deviceId = (string)$xml->deviceId;
    	$this->_messageTitle = (string)$xml->messageTitle;
    	$this->_messageBody = (string)$xml->messageBody;
    	$this->_riddleQuestion = (string)$xml->riddleQuestion;
    	$this->_riddleAnswer = (string)$xml->riddleAnswer;
    	$this->_unlockDate = (string)$xml->unlockDate;
    	$this->_fileName = (string)$xml->file->attributes()->name;
    	$this->_amazonFileName = uniqid("", true);
    	$this->_fileContent = (string)$xml->file;
    }
        
    public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
    
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid box property');
        }
        $this->$method($value);
    }
 
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid box property');
        }
        return $this->$method();
    }
 
    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    public function setDeviceId($value) {
    	$this->_deviceId = (string)$value;
    	return $this;
    }
    
    public function getDeviceId() {
    	return $this->_deviceId;
    }

    public function setMessageTitle($value) {
    	$this->_messageTitle = (string)$value;
    	return $this;
    }
    
    public function getMessageTitle() {
    	return $this->_messageTitle;
    }

    public function setMessageBody($value) {
    	$this->_messageBody = (string)$value;
    	return $this;
    }
    
    public function getMessageBody() {
    	return $this->_messageBody;
    }
        
    public function setRiddleQuestion($value) {
    	$this->_riddleQuestion = $value;
    	return $this;
    }
    
    public function getRiddleQuestion() {
    	return $this->_riddleQuestion;
    }
        
    public function setRiddleAnswer($value) {
    	$this->_riddleAnswer = $value;
    	return $this;
    }
    
    public function getRiddleAnswer() {
    	return $this->_riddleAnswer;
    }
        
    public function setUnlockDate($value) {
    	$this->_unlockDate = $value;
    	return $this;
    }
    
    public function getUnlockDate() {
    	return $this->_unlockDate;
    }
        
    public function setFileName($value) {
    	$this->_fileName = $value;
    	return $this;
    }
    
    public function getFileName() {
    	return $this->_fileName;
    }

    public function setFileType($value) {
    	$this->_fileType = $value;
    	return $this;
    }
    
    public function getFileType() {
    	return $this->_fileType;
    }
    
    public function setAmazonFileName($value) {
    	$this->_amazonFileName = $value;
    	return $this;
    }
    
    public function getAmazonFileName() {
    	return $this->_amazonFileName;
    }
    
    public function getAmazonFullFileName() {
    	$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/cloud.ini', 'amazon');
    	$s3 = new Zend_Service_Amazon_S3($config->accessKey, $config->secretKey);
    	$rootBucket = $config->rootBucket;
    	     	
    	$amazonFilePath = "https://" . $rootBucket . '.s3.amazonaws.com/' . $this->_amazonFileName;
    	
    	return $amazonFilePath;
    }
        
    public function setFileContent($value) {
    	$this->_fileContent = $value;
    	return $this;
    }
    
    public function getFileContent() {
    	return $this->_fileContent;
    }    

    public function setId($id)
    {
        $this->_id = (string) $id;
        return $this;
    }
 
    public function getId()
    {
        return $this->_id;
    }
    
    //------------------------------------

    public function copyOf($box) {    	
    	if ($this->_deviceId == null) $this->_deviceId = $box->getDeviceId();
    	if ($this->_messageTitle == null) $this->_messageTitle = $box->getMessageTitle();
    	if ($this->_messageBody == null) $this->_messageBody = $box->getMessageBody();
    	if ($this->_riddleQuestion == null) $this->_riddleQuestion = $box->getRiddleQuestion();
    	if ($this->_riddleAnswer == null) $this->_riddleAnswer = $box->getRiddleAnswer();
    	if ($this->_unlockDate == null) $this->_unlockDate = $box->getUnlockDate();
    	if ($this->_fileName == null) $this->_fileName = $box->getFileName();
    	if ($this->_fileType == null) $this->_fileType = $box->getFileType();
    	if ($this->_amazonFileName == null) $this->_amazonFileName = $box->getAmazonFileName();
    }
    
    public function isNotEmpty() {
    	return ($this->_id != null);
    }

    public function isEmpty() {
    	return ($this->_id == null);
    }
        
    public function getDataBaseFormatUnlockDate() {
    	$date = new Zend_Date();
    	$date->set($this->_unlockDate, 'dd-MM-YYYY HH:mm:ss');
    	$result = $date->toString('YYYY-MM-dd HH:mm:ss');
    	return $result;    	
    }
    
    public function getNormalFormatUnlockDate() {
    	$date = new Zend_Date();
    	$date->set($this->_unlockDate, 'YYYY-MM-dd HH:mm:ss');
    	$result = $date->toString('dd-MM-YYYY HH:mm:ss');
    	return $result;
    }
}