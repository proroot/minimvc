<?php namespace Core;

use Core\Exception\Exception;

class Route
{
	public static $uDefaultAction = 'index';

	private static $_uRoutes 	  = [];

	public static function set($uMethod, $uName, $uRoute)
	{
		if ( ! empty(self::$_uRoutes[$uName]))
		{
			throw new Exception('Данный маршрут: :uRoute существует', [
				':uRoute' => $uName
			]);
		}

        if ( ! is_callable($uRoute))
        {
            $uRoute = explode('@', $uRoute);

            if (empty($uRoute[0]))
            {
                throw new Exception('Не удалось определить контроллер');
            }
        }

		self::$_uRoutes[$uName] = new self;

		return ! is_callable($uRoute)
            ? self::$_uRoutes[$uName]
			    ->RM($uMethod)
			    ->controller($uRoute[0])
			    ->action( ! empty($uRoute[1]) ? $uRoute[1] : self::$uDefaultAction)
                
            : self::$_uRoutes[$uName]
                ->callback($uRoute);
	}

	public static function group($uCallback)
	{
		call_user_func($uCallback);
	}

	public static function all()
	{
		return self::$_uRoutes;
	}

	private $_uDefaults = [];

	public function getDefaults()
	{
		return $this->_uDefaults;
	}

	public function aHome()
	{
		$this->_uDefaults['uHome'] = true;

		return $this;
	}

	public function aError()
	{
		$this->_uDefaults['uError'] = true;

		return $this;
	}

	private function RM($uTypes)
	{
		$this->_uDefaults['RM'] = explode('|', $uTypes);

		return $this;
	}

    private function callback($uRoute)
    {
        $this->_uDefaults['uCallback'] = $uRoute;

        return $this;
    }

	private function controller($uController)
	{
		$this->_uDefaults['uController'] = $uController;

		return $this;
	}

	private function action($uAction)
	{
		$this->_uDefaults['uAction'] = $uAction;

		return $this;
	}
	
}
