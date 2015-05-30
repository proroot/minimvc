<?php namespace Core;

use Core\Exception\Exception;

abstract class Controller
{
	protected $uRequest;

	protected $uResponse = '';

	public function __construct(Request $uRequest)
	{
		$this->uRequest = $uRequest;

		$this->execute();
	}

	public function execute()
	{
		$uAction = 'Action' . $this->uRequest->action();

		if ( ! method_exists($this, $uAction))
			throw new Exception('Не существует метод: :uMethod у контроллера: :uController', [
				':uMethod'     => $uAction,
				':uController' => $this->uRequest->controller()
			]);

		$this->before();

		$this->$uAction();

		$this->after();

		return $this->__toString();
	}

	public function before()
	{

	}

	public function after()
	{

	}

	public function __toString()
	{
		return (string) $this->uResponse;
	}
}