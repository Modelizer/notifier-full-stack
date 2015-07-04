<?php

namespace Dextop\Notifier;

use Illuminate\Database\Eloquent\Model;
use Dextop\Notifier\Contracts\BaseModelInterface;
use App;

/**
 * Base Eloquent class for notifier
 */
abstract class BaseEloquent extends Model implements BaseModelInterface
{
	/**
	 * Configuration for Notifier
	 *
	 * @var type object
	 */
	private $configHandler;
	
	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
		
		$this->configHandler = App::make('Dextop\Notifier\Handlers\ConfigHandler');
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function notification()
	{
		return $this->morphMany($this->getNotificationModelName(),  "notifiable");
	}
	
	private function getNotificationModelName()
	{	
		return $this->configHandler->getConfig()['notificationModel'];
	}
}