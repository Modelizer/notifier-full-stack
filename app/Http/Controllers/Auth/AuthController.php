<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Dextop\Notifier\Notifier;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers
	{
		postRegister as traitPostRegister;
	}
	
	protected $notifier;
	
	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  Guard  $auth
	 * @param  Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar, Notifier $notifier)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;
		$this->notifier   = $notifier;
		
		$this->redirectTo = 'dashboard';

		$this->middleware('guest', ['except' => 'getLogout']);
	}
	
	public function postRegister(Request $request)
	{
		try
		{
			$redirect = $this->traitPostRegister($request);
			
			// Notify admin user has register successfully
			$this->notifier->newUserRegistered($this->auth->user());
			
			return $redirect;
		}
		catch ( Exception $ex )
		{
			throw $ex;
		}
	}

}
