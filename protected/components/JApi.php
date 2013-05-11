<?php
class JApi extends CAction
{
	/**
	 * Holds the name of the requested action
	 * 
	 * @access private
	 * @var string name of function
	*/
	private $func;
	
	/**
	 * Hold the data returned by requested action
	 *
	 * @access private
	 * @var mixed data to be serialized and returned via json object
	*/
	private $returnData = NULL;
	
	/**
	 * Runs the requested action
	 *
	 * Finds requested action in controller, runs function, and sends result to client via JSON. If no action is passed
	 * it assums the action is index
	 *
	 * @access public
	 * @throws CHttpException when requested action was not found in the controller
	*/
	public function run()
	{
		if(!isset($_GET['action']) or is_null($_GET['action']) or $_GET['action']=='')
		{
			$_GET['action'] = 'index';
		}
		
		$this->makeFunc($_GET['action']);
		
		if(!method_exists($this->getController(),$this->func))
		{
			throw new CHttpException(404,'Action not found: '.$this->func);
		}
		
		
		$this->runFunc();
		$this->send();
	}
	
	/**
	 * Runs the reuested action
	 *
	 * Uses PHP's ReflectionMethod to run the requested action with params
	 *
	 * @access private
	 * @throws CHttpException when required params are missing from the request
	*/
	private function runFunc()
	{
		$method = new ReflectionMethod($this->getController(),$this->func);
		if($method->getNumberOfParameters()===0)
		{
			$this->returnData = $this->getController()->{$this->func}();
		}
		else
		{
			$ps=array();
			$params = $_GET;
			
			foreach($method->getParameters() as $i=>$param)
			{
				$name=$param->getName();
				if(isset($params[$name]))
				{
					if($param->isArray())
						$ps[]=is_array($params[$name]) ? $params[$name] : array($params[$name]);
					else if(!is_array($params[$name]))
						$ps[]=$params[$name];
					else
						throw new CHttpException(400,'Request Invalid');
				}
				else if($param->isDefaultValueAvailable())
					$ps[]=$param->getDefaultValue();
				else
					throw new CHttpException(400,'Request Invalid');
  			  }
  			  $this->returnData = $method->invokeArgs($this->getController(),$ps);
		}
	}
	
	/**
	 * Returns the function name needed to be run in the controller to respond to the request
	 *
	 * @access private
	*/
	private function makeFunc($action)
	{
		$this->func = 'japi'.ucfirst(strtolower($action));
	}
	
	/**
	 * Sends the result of the request to the client in JSON
	 *
	 * Sets header "Content-Type" to "application/json", encodes the result in json, then sends encoded result to client
	 *
	 * @access private
	*/
	private function send()
	{
		header('Content-Type: application/json');
		echo CJavaScript::jsonEncode($this->returnData);
	}
	
	
}
 
?>
