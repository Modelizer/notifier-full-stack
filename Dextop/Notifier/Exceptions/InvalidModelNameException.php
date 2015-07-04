<?php

namespace Dextop\Notifier\Exceptions;

use Exception;

class InvalidModelNameException extends Exception
{
	public function __construct($message = 'Model name dose not exist, check notifier config file or model name')
	{
		parent::__construct($message);
	}
}