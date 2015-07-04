<?php

namespace Dextop\Notifier;

use Illuminate\Support\Facades\Auth;
use Dextop\Notifier\Notification;
use Dextop\Notifier\Contracts\BaseModelInterface;

/**
 * Notifier class which work as notification manager
 */
class Notifier 
{
	/**
	 * 
	 * @var type Auth
	 */
	protected $auth;
	
	/**
	 *
	 * @var type Notification
	 */
	protected $notification;
	
	/**
	 * Construct
	 * 
	 * @param Auth $auth
	 * @param Notification $notification
	 */
	public function __construct(Auth $auth, Notification $notification)
	{
		$this->auth = $auth;
		
		$this->notification = $notification;
	}
	
	/**
	 * Model should be extended to BaseModel
	 * Note: So that notification method exist on it
	 * 
	 * @param BaseModelInterface $model
	 * @return \Dextop\Notifier\Notifier
	 */
	public function setModel(BaseModelInterface $model)
	{
		$this->notification = $this->notification->setModel($model);
		
		return $this;
	}
	
	/**
	 * Use that model which is related to notification
	 * Eg: When new user is created then User model is related to notification
	 * 
	 * @param type $modelName		string
	 * @return \Dextop\Notifier\Notifier
	 */
	public function uses($modelName)
	{
		$this->notification = $this->notification->setModelByName($modelName);
		
		return $this;
	}
	
	/**
	 * When new user is registered then notify admin
	 * 
	 * @param type $user User Eloquent object
	 * @return type
	 */
	public function newUserRegistered($user)
	{
		$recipient	= 1;
		$title		= 'New Registration';
		$message	= ucfirst($user->name) . ' has registered.';
		$sender	= $user->id;
		
		return $this->uses('User')->notify($recipient, $title, $message, $sender);
	}
	
	/**
	 * Send notification to user
	 * 
	 * @param type $recipientId int		User to whom notification will be send
	 * @param type $title	  string	Title of notification
	 * @param type $message	  string	Message of notifaction
	 * @param type $senderId	  int		Sender Id
	 */
	public function notify($recipientId, $title, $message, $senderId = null)
	{
		$senderId = ( ! $senderId) ?: $this->auth->user()->id;
		
		return $this->notification
				->setArguments([
					'recipient_id'	=> $recipientId,
					'title'			=> $title,
					'message'		=> $message,
					'sender_id'		=> $senderId
				])
				->send();
	}
	
	public function show()
	{
		return $this->uses('User')->notification->get()->toArray();
	}
	
}
