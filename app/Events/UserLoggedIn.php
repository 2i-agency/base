<?php

namespace Chunker\Base\Events;

use App\Events\Event;
use Chunker\Base\Models\User;

/**
 * Class UserLoggedIn - Класс события аутентификации пользователя
 *
 * @property
 *
 * @package Chunker\Base\Events
 */
class UserLoggedIn extends Event
{
	/** @var User $user Пользователь проходящий аутентификацию */
	public $user;
	/** @var bool $isFailed Флаг, указывающий на провал аутентификации */
	public $isFailed;


	public function __construct(User $user, $isFailed){
		$this->user = $user;
		$this->isFailed = $isFailed;
	}
}