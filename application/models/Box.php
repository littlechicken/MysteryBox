<?php 
class Application_Model_Box
{
    protected $_id;
    
    private $_deviceId;
    private $_messageTitle;
    private $_messageBody;
    private $_riddleQuestion;
    private $_riddleAnswer;
    private $_unlockDate;
    
    private $_fileName;
    private $_fileContent;    
 
    public function parseXml($data){
    	$box = simplexml_load_string($data);
    
    	$this->_deviceId = (string)$box->deviceId;
    	$this->_messageTitle = (string)$box->messageTitle;
    	$this->_messageBody = (string)$box->messageBody;
    	$this->_riddleQuestion = (string)$box->riddleQuestion;
    	$this->_riddleAnswer = (string)$box->riddleAnswer;
    	$this->_unlockDate = (string)$box->unlockDate;
    	$this->_fileName = (string)$box->file->attributes()->name;
    	$this->_fileContent = (string)$box->file;
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
    
    public function setFileContent($value) {
    	$this->_fileContent = $value;
    	return $this;
    }
    
    public function getFileContent() {
    	return $this->_fileContent;
    }    

    public function setId($id)
    {
        $this->_id = (int) $id;
        return $this;
    }
 
    public function getId()
    {
        return $this->_id;
    }
    
    //------------------------------------

    public function getDataBaseFormatUnlockDate() {
    	$date = new Zend_Date();
    	$date->set($this->_unlockDate, 'dd-MM-YY HH:mm:ss');
    	$result = $date->toString('YYYY-MM-dd HH:mm:ss');
    	return $result;    	
    }
}