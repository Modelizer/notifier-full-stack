<?php

namespace Dextop\Notifier;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Dextop\Notifier\Contracts\NotificationModelInterface;

class NotificationEloquent extends Eloquent implements NotificationModelInterface
{
	protected $fillable = [
		'sender_id',
		'recipient_id',
		'title',
		'message',
		'is_read'
	];
	
	public $table = 'notifications';
	
	public $timestamps = true;
}
