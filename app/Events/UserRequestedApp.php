<?php

namespace Chunker\Base\Events;

use App\Events\Event;
use Chunker\Base\Models\User;

/**
 * Class UserRequestedApp - Событие при обращении пользователя к приложению
 *
 * @package Chunker\Base\Events
 */
class UserRequestedApp extends Event
{
	/** @var User $user Пользователь проходящий аутентификацию */
	public $user;


	public function __construct(User $user){
		$this->user = $user;
	}
}