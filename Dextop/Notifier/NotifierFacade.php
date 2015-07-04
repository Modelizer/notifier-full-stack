<?php

namespace Dextop\Notifier;

use Illuminate\Support\Facades\Facade;

class NotifierFacade extends Facade {
	
	public static function getFacadeAccessor() { return 'notifier'; }
	
}