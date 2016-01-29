<?php

namespace Chunker\Base\Events;

use App\Events\Event;
use Chunker\Base\Models\User;

class UserLoggedIn extends Event
{
	public $user;
	public $isFailed;


	public function __construct(User $user, $isFailed)
	{
		$this->user = $user;
		$this->isFailed = $isFailed;
	}
}