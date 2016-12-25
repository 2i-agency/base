<?php

namespace Chunker\Base\Events;

use App\Events\Event;
use Chunker\Base\Models\User;

/**
 * Class UserRequestedApp - Событие при совершении действий пользователем
 *
 * @package Chunker\Base\Events
 */
class UserRequestedApp extends Event
{
	/** @var User $user Пользователь, от имени которого происходит совершается действие */
	public $user;


	public function __construct(User $user){
		$this->user = $user;
	}
}