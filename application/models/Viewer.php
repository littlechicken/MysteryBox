<?php
class Application_Model_Viewer
{
	protected $_id;
	protected $_boxId;
	protected $_isViewed;

	public function parseXml($xml){
		$this->_id = (string)$xml->viewerId;
		$this->_boxId = (string)$xml->boxId;
		$this->_isViewed = (boolean)$xml->isViewed;
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
			throw new Exception('Invalid viewer property');
		}
		$this->$method($value);
	}

	public function __get($name)
	{
		$method = 'get' . $name;
		if (('mapper' == $name) || !method_exists($this, $method)) {
			throw new Exception('Invalid viewer property');
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

	public function setBoxId($value) {
		$this->_boxId = (string)$value;
		return $this;
	}

	public function getBoxId() {
		return $this->_boxId;
	}

	public function setIsViewed($value) {
		$this->_isViewed = (boolean)$value;
		return $this;
	}

	public function getIsViewed() {
		return $this->_isViewed;
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
}