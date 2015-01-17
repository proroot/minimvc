<?php

namespace Core;

use Core\Exception\Exception;

abstract class Controller
{
	public $request;

	public $response;

	public function __construct (Request $request)
	{
		$this->request = $request;

		$action = 'Action' . $this->request->Action();

		if ( ! method_exists($this, $action))
			throw new Exception('Не существует метод: :method у контроллера: :controller', [
				':method'     => $action,
				':controller' => $this->request->Controller()
			]);

		$this->{$action}();
	}

	public function __toString ()
	{
		return $this->response;
	}
}