<?php namespace Dextop\Notifier;

use Illuminate\Support\ServiceProvider;

class NotifierServiceProvider extends ServiceProvider 
{

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerModel();
		
		$this->registerNotifier();
	}
	
	public function registerModel()
	{
		$this->app->bind('Dextop\Notifier\Contracts\NotificationModelInterface', 'Dextop\Notifier\NotificationEloquent');
	}
	
	public function registerNotifier()
	{
		$this->app->bind('notifier', function($app)
		{
			return $app->make('Dextop\Notifier\Notifier');
		});
	}

}
