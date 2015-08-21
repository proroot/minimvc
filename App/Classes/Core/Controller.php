<?php namespace Core;

use Core\Exception\Exception;

abstract class Controller
{
	protected $_uRequest;
	
	private   $_uResponse;

	public function __construct(Request $uRequest)
	{
		$this->_uRequest = $uRequest;

		$this->execute();
	}

	public function execute()
	{
		$uAction = $this->_uRequest->action();

		if ( ! method_exists($this, $uAction))
		{
			throw new Exception('Не существует метод: :uMethod у контроллера: :uController', [
				':uMethod'     => $uAction,
				':uController' => $this->_uRequest->controller()
			]);
		}

		$uResponse = '';

		$uResponse .= $this->before();

		$uResponse .= $this->$uAction();

		$uResponse .= $this->after();

		$this->_uResponse = $uResponse;
	}

	public function before()
	{

	}

	public function after()
	{

	}

	public function __toString()
	{
		return (string) $this->_uResponse;
	}
	
}
