<?php

namespace Core;

use Core\Exception\Exception;

abstract class Controller
{
	public $uRequest;

	public $uResponse;

	public function __construct (Request $uRequest)
	{
		$this->uRequest = $uRequest;

		$uAction = 'Action' . $this->uRequest->Action();

		if ( ! method_exists ($this, $uAction))
			throw new Exception ('Не существует метод: :uMethod у контроллера: :uController', [
				':uMethod'     => $uAction,
				':uController' => $this->uRequest->Controller()
			]);

		$this->{$uAction}();
	}

	public function __toString()
	{
		return $this->uResponse;
	}
}