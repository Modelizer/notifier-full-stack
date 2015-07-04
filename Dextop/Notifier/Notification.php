<?php

namespace Dextop\Notifier;

use Dextop\Notifier\Contracts\NotificationModelInterface;
use Dextop\Notifier\Contracts\BaseModelInterface;
use Dextop\Notifier\Handlers\ConfigHandler;
use Dextop\Notifier\Exceptions\InvalidModelNameException;

/**
 * Repository for notification
 */
class Notification
{
	/**
	 * Fields which will be stored on notification table
	 * 
	 * @var type array 
	 */
	protected $arguments;
	
	/**
	 * Model which will be use as morph many relationship
	 * 
	 * @var type BaseModelInterface object
	 */
	protected $model;
	
	/**
	 * Model Name
	 * 
	 * @var type string
	 */
	protected $modelName;
	
	/**
	 * Configuration for notifier
	 * 
	 * @var type array
	 */
	protected $config;

	public function __construct(ConfigHandler $configHandler,	 NotificationModelInterface $model)
	{
		$this->config	= $configHandler->getConfig();
		
		$this->model	= $model;
	}
	
	/**
	 * Setting argument to store in database
	 * 
	 * @param array $arguments
	 * @return \Dextop\Notifier\Repository\Notification
	 */
	public function setArguments(array $arguments)
	{
		$this->arguments = $arguments;
		
		return $this;
	}
	
	/**
	 * Set model
	 * 
	 * @param BaseModelInterface $model
	 */
	public function setModel(BaseModelInterface $model)
	{
		$this->model = $model;
	}
	
	/**
	 * Find Model by name and instancate it
	 * 
	 * @param type $modelName
	 * @return \Dextop\Notifier\Repository\Notification
	 * @throws InvalidModelNameException
	 */
	public function setModelByName($modelName)
	{
		if ($model = $this->config['modelMaps'][$modelName])
		{
			$this->setModel(new $model);
			
			return $this;
		}
		
		throw new InvalidModelNameException();
	}
	
	/**
	 * Get Arguments
	 * 
	 * @return type
	 */
	public function getArguments()
	{
		return $this->arguments;
	}
	
	/**
	 * Sending is nothing more then storing notification on server
	 * 
	 * @return type bool
	 */
	public function send()
	{
		if (is_null($this->model->id))
		{
			$this->model->id = $this->getArguments()['sender_id'];
		}
		
		return $this->model->notification()->create($this->getArguments());
	}
	
	public function get()
	{
		return $this->model->notification()->get();
	}
}
