<?php

namespace Dextop\Notifier\Handlers;

use Illuminate\Support\Facades\Config;

/**
 * Handle Notifier related config details
 */
class ConfigHandler
{
	/**
	 * When config is loaded from file then it will be store in this variable
	 * 
	 * @var type array
	 */
	protected $config;
	
	/**
	 * Config file path
	 * 
	 * @var type string
	 */
	protected $configPath = 'vendor.dextop.notifier.notification';
	
	/**
	 * Construct
	 * 
	 * @param Config $config
	 */
	public function __construct(Config $config)
	{
		$this->config = $config::get($this->configPath);
	}
	
	/**
	 * Get Configuration
	 * 
	 * @return type array
	 */
	public function getConfig()
	{
		return $this->config;
	}
}
